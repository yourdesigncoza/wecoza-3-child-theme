<?php
/**
 * ClassController.php
 *
 * Controller for handling class-related operations
 * Refactored to use Repository Pattern and Service Layer (WEC-90-1)
 */

namespace WeCoza\Controllers;

use WeCoza\Models\Assessment\ClassModel;
use WeCoza\Controllers\MainController;
use WeCoza\Controllers\ClassTypesController;
use WeCoza\Controllers\PublicHolidaysController;
use WeCoza\Services\Export\CalendarExportService;

// WordPress functions are in global namespace
// We'll access them directly with the global namespace prefix
// Example: \add_action() instead of add_action()

class ClassController {

    /**
     * Constructor
     */
    public function __construct() {
        // Register WordPress hooks
        \add_action('init', [$this, 'registerShortcodes']);
    }

    /**
     * Register all class-related shortcodes
     */
    public function registerShortcodes() {
        \add_shortcode('wecoza_capture_class', [$this, 'captureClassShortcode']);
        \add_shortcode('wecoza_display_classes', [$this, 'displayClassesShortcode']);
        \add_shortcode('wecoza_display_single_class', [$this, 'displaySingleClassShortcode']);
    }

    /**
     * Enqueue necessary scripts and styles
     */
    public function enqueueAssets() {
        // Bootstrap Icons ( Loaded in Functions.php )
        //\wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css');

        // Note: Custom CSS is now loaded globally from includes/css/ydcoza-styles.css

        // Custom scripts
        \wp_enqueue_script('wecoza-class-js', WECOZA_CHILD_URL . '/public/js/class-capture.js', ['jquery'], WECOZA_PLUGIN_VERSION, true);
        // \wp_enqueue_script('wecoza-calendar-init-js', WECOZA_CHILD_URL . '/public/js/class-calendar-init.js', ['jquery', 'wecoza-class-js'], WECOZA_PLUGIN_VERSION, true);
        \wp_enqueue_script('wecoza-class-schedule-form-js', WECOZA_CHILD_URL . '/public/js/class-schedule-form.js', ['jquery'], WECOZA_PLUGIN_VERSION, true);
        // \wp_enqueue_script('wecoza-calendar-export-js', WECOZA_CHILD_URL . '/public/js/calendar-export.js', ['jquery', 'wecoza-class-js'], WECOZA_PLUGIN_VERSION, true);
        \wp_enqueue_script('wecoza-class-types-js', WECOZA_CHILD_URL . '/assets/js/class-types.js', ['jquery', 'wecoza-class-js'], WECOZA_PLUGIN_VERSION, true);

        // Localize script with AJAX URL and nonce
        \wp_localize_script('wecoza-class-js', 'wecozaClass', [
            'ajaxUrl' => \admin_url('admin-ajax.php'),
            'nonce' => \wp_create_nonce('wecoza_class_nonce'),
            'siteAddresses' => MainController::getSiteAddresses(),
            'debug' => true,
            'conflictCheckEnabled' => true
        ]);

        // Add public holidays data to the calendar
        $holidaysController = PublicHolidaysController::getInstance();
        \wp_localize_script('wecoza-class-js', 'wecozaPublicHolidays', [
            'events' => $holidaysController->getHolidaysAsCalendarEvents()
        ]);

        // Calendar initialization is now handled by class-calendar-init.js
    }

    /**
     * Handle class capture shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function captureClassShortcode($atts) {
        // Process shortcode attributes
        $atts = \shortcode_atts([
            'redirect_url' => '',
        ], $atts);

        // Check for URL parameters to determine mode
        $mode = isset($_GET['mode']) ? sanitize_text_field($_GET['mode']) : 'create';
        $class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;



        // Handle different modes
        if ($mode === 'update') {
            // For testing: allow update mode without class_id to see all fields
            if ($class_id <= 0) {
                return $this->handleUpdateMode($atts, null); // Pass null for testing
            }
            return $this->handleUpdateMode($atts, $class_id);
        } else {
            return $this->handleCreateMode($atts);
        }
    }



    /**
     * Handle create mode logic
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    private function handleCreateMode($atts) {
        // Get data for the view
        $viewData = [
            'mode' => 'create',
            'class_data' => null,
            'clients' => MainController::getClients(),
            'sites' => MainController::getSites(),
            'agents' => MainController::getAgents(),
            'supervisors' => MainController::getSupervisors(),
            'learners' => MainController::getLearnersExam(),
            'setas' => MainController::getSeta(),
            'class_types' => MainController::getClassType(),
            'yes_no_options' => MainController::getYesNoOptions(),
            'class_notes_options' => MainController::getClassNotesOptions(),
            'redirect_url' => $atts['redirect_url']
        ];

        // Render the view
        return \WeCoza\view('components/class-capture-form', $viewData);
    }

    /**
     * Handle update mode logic
     *
     * @param array $atts Shortcode attributes
     * @param int|null $class_id Class ID to update (null for testing)
     * @return string HTML output
     */
    private function handleUpdateMode($atts, $class_id) {
        // Get the class data (null for testing mode)
        $class = null;
        if ($class_id !== null) {
            // Use direct model access
            $class = ClassModel::getById($class_id);
            if (!$class) {
                return '<div class="alert alert-danger">Error: Class not found.</div>';
            }
        }

        // Get data for the view
        $viewData = [
            'mode' => 'update',
            'class_data' => $class,
            'clients' => MainController::getClients(),
            'sites' => MainController::getSites(),
            'agents' => MainController::getAgents(),
            'supervisors' => MainController::getSupervisors(),
            'learners' => MainController::getLearnersExam(),
            'setas' => MainController::getSeta(),
            'class_types' => MainController::getClassType(),
            'yes_no_options' => MainController::getYesNoOptions(),
            'class_notes_options' => MainController::getClassNotesOptions(),
            'redirect_url' => $atts['redirect_url']
        ];

        // Render the view
        return \WeCoza\view('components/class-capture-form', $viewData);
    }



    /**
     * Handle AJAX request to save class data
     */
    public static function saveClassAjax() {
        error_log('=== CLASS SAVE AJAX START ===');
        error_log('POST data: ' . print_r($_POST, true));
        error_log('FILES data: ' . print_r($_FILES, true));

        // Create instance
        $instance = new self();

        // Check nonce
        if (!isset($_POST['nonce'])) {
            error_log('Nonce not set in POST data');
            $instance->sendJsonError('Security check failed.');
            return;
        }

        error_log('Nonce verification passed');

        // Process form data (including file uploads)
        $formData = self::processFormData($_POST, $_FILES);
        error_log('Processed form data: ' . print_r($formData, true));

        // Determine if this is create or update operation
        $isUpdate = isset($formData['id']) && !empty($formData['id']);
        $classId = $isUpdate ? intval($formData['id']) : null;

        error_log($isUpdate ? "Updating existing class with ID: {$classId}" : 'Creating new class');

        // Use direct model access for create or update
        try {
            if ($isUpdate) {
                // Load existing class and update it
                $class = ClassModel::getById($classId);
                if (!$class) {
                    error_log('Class not found for update: ' . $classId);
                    $instance->sendJsonError('Class not found for update.');
                    return;
                }

                // Update the class with new data
                $class = self::populateClassModel($class, $formData);
                $result = $class->update();
            } else {
                // Create new class instance and save it
                $class = new ClassModel();
                $class = self::populateClassModel($class, $formData);
                $result = $class->save();
            }

            if ($result) {
                error_log('Class saved successfully with ID: ' . $class->getId());
                $instance->sendJsonSuccess([
                    'message' => $isUpdate ? 'Class updated successfully.' : 'Class created successfully.',
                    'class_id' => $class->getId()
                ]);
            } else {
                error_log('Model operation failed');
                $instance->sendJsonError(
                    $isUpdate ? 'Failed to update class.' : 'Failed to create class.'
                );
            }
        } catch (\Exception $e) {
            error_log('Exception during class save: ' . $e->getMessage());
            $instance->sendJsonError('An error occurred while saving the class: ' . $e->getMessage());
        }
    }

    /**
     * Populate ClassModel instance with form data
     *
     * @param ClassModel $class Class model instance
     * @param array $formData Processed form data
     * @return ClassModel Populated class model
     */
    private static function populateClassModel($class, $formData) {
        // Set basic properties
        if (isset($formData['client_id'])) $class->setClientId($formData['client_id']);
        if (isset($formData['site_id'])) $class->setSiteId($formData['site_id']);
        if (isset($formData['site_address'])) $class->setClassAddressLine($formData['site_address']);
        if (isset($formData['class_type'])) $class->setClassType($formData['class_type']);
        if (isset($formData['class_subject'])) $class->setClassSubject($formData['class_subject']);
        if (isset($formData['class_code'])) $class->setClassCode($formData['class_code']);
        if (isset($formData['class_duration'])) $class->setClassDuration($formData['class_duration']);
        if (isset($formData['class_start_date'])) $class->setOriginalStartDate($formData['class_start_date']);
        if (isset($formData['seta_funded'])) $class->setSetaFunded($formData['seta_funded']);
        if (isset($formData['seta_id'])) $class->setSeta($formData['seta_id']);
        if (isset($formData['exam_class'])) $class->setExamClass($formData['exam_class']);
        if (isset($formData['exam_type'])) $class->setExamType($formData['exam_type']);
        if (isset($formData['qa_visit_dates'])) $class->setQaVisitDates($formData['qa_visit_dates']);
        if (isset($formData['qa_reports'])) $class->setQaReports($formData['qa_reports']);
        if (isset($formData['class_agent'])) $class->setClassAgent($formData['class_agent']);
        if (isset($formData['initial_class_agent'])) $class->setInitialClassAgent($formData['initial_class_agent']);
        if (isset($formData['initial_agent_start_date'])) $class->setInitialAgentStartDate($formData['initial_agent_start_date']);
        if (isset($formData['project_supervisor'])) $class->setProjectSupervisorId($formData['project_supervisor']);
        if (isset($formData['delivery_date'])) $class->setDeliveryDate($formData['delivery_date']);
        if (isset($formData['learner_ids'])) $class->setLearnerIds($formData['learner_ids']);
        if (isset($formData['backup_agent_ids'])) $class->setBackupAgentIds($formData['backup_agent_ids']);
        if (isset($formData['schedule_data'])) $class->setScheduleData($formData['schedule_data']);
        if (isset($formData['stop_restart_dates'])) $class->setStopRestartDates($formData['stop_restart_dates']);
        if (isset($formData['class_notes'])) $class->setClassNotesData($formData['class_notes']);

        return $class;
    }

    /**
     * Simple sanitization helper
     *
     * @param string|array $text Text to sanitize
     * @return string Sanitized text
     */
    private static function sanitizeText($text) {
        // Handle arrays by converting to JSON string
        if (is_array($text)) {
            error_log('sanitizeText received array: ' . print_r($text, true));
            return json_encode($text);
        }

        // Handle null values
        if ($text === null) {
            return '';
        }

        // Convert to string if not already
        $text = (string) $text;

        return trim(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
    }

    /**
     * Decode WordPress-escaped JSON data
     *
     * WordPress automatically applies addslashes() to POST data, which escapes JSON.
     * This function properly handles the unescaping and decoding.
     *
     * @param string $jsonString WordPress-escaped JSON string
     * @return array|null Decoded array or null if decoding fails
     */
    private static function decodeWordPressJson($jsonString) {
        if (empty($jsonString)) {
            return null;
        }

        // Step 1: Remove WordPress slashes
        $unescaped = stripslashes($jsonString);

        // Step 2: Decode HTML entities (handles &quot; -> ")
        $decoded = html_entity_decode($unescaped, ENT_QUOTES, 'UTF-8');

        // Step 3: Decode JSON
        $result = json_decode($decoded, true);

        // Return result only if JSON decoding was successful
        return (json_last_error() === JSON_ERROR_NONE) ? $result : null;
    }

    /**
     * Process form data
     *
     * @param array $data Raw form data
     * @param array $files Raw file data from $_FILES
     * @return array Processed data
     */
    private static function processFormData($data, $files = []) {
        $processed = [];

        // Basic fields - using snake_case field names that the model expects
        $processed['id'] = isset($data['class_id']) && $data['class_id'] !== 'auto-generated' ? intval($data['class_id']) : null;
        $processed['client_id'] = isset($data['client_id']) && !empty($data['client_id']) ? intval($data['client_id']) : null;
        $processed['site_id'] = isset($data['site_id']) && !is_array($data['site_id']) ? $data['site_id'] : null;
        $processed['site_address'] = isset($data['site_address']) && !is_array($data['site_address']) ? self::sanitizeText($data['site_address']) : null;
        $processed['class_type'] = isset($data['class_type']) && !is_array($data['class_type']) ? self::sanitizeText($data['class_type']) : null;
        $processed['class_subject'] = isset($data['class_subject']) && !is_array($data['class_subject']) ? self::sanitizeText($data['class_subject']) : null;
        $processed['class_code'] = isset($data['class_code']) && !is_array($data['class_code']) ? self::sanitizeText($data['class_code']) : null;
        $processed['class_duration'] = isset($data['class_duration']) && !is_array($data['class_duration']) ? intval($data['class_duration']) : null;
        $processed['class_start_date'] = isset($data['class_start_date']) && !is_array($data['class_start_date']) ? self::sanitizeText($data['class_start_date']) : null;
        $processed['seta_funded'] = isset($data['seta_funded']) && !is_array($data['seta_funded']) ? self::sanitizeText($data['seta_funded']) : null;
        $processed['seta_id'] = isset($data['seta_id']) && !is_array($data['seta_id']) ? self::sanitizeText($data['seta_id']) : null;
        $processed['exam_class'] = isset($data['exam_class']) && !is_array($data['exam_class']) ? self::sanitizeText($data['exam_class']) : null;
        $processed['exam_type'] = isset($data['exam_type']) && !is_array($data['exam_type']) ? self::sanitizeText($data['exam_type']) : null;
        // QA Visit Dates - handle as array and convert to JSON string for database
        error_log('=== QA VISIT DATES PROCESSING ===');
        error_log('Raw qa_visit_dates data: ' . print_r($data['qa_visit_dates'] ?? 'NOT SET', true));

        if (isset($data['qa_visit_dates']) && is_array($data['qa_visit_dates'])) {
            // Filter out empty dates and sanitize
            $qaVisitDates = array_filter(array_map([self::class, 'sanitizeText'], $data['qa_visit_dates']));
            $processed['qa_visit_dates'] = !empty($qaVisitDates) ? json_encode($qaVisitDates) : null;
        } else {
            $processed['qa_visit_dates'] = null;
        }

        error_log('Processed qa_visit_dates: ' . ($processed['qa_visit_dates'] ?? 'NULL'));

        // QA Reports - handle file uploads
        error_log('=== QA REPORTS PROCESSING ===');
        $processed['qa_reports'] = self::processQAReports($files);
        error_log('Processed qa_reports: ' . print_r($processed['qa_reports'], true));

        // Class Agent - map initial_class_agent to class_agent for the model
        error_log('=== CLASS AGENT PROCESSING ===');
        error_log('Raw initial_class_agent data: ' . print_r($data['initial_class_agent'] ?? 'NOT SET', true));
        $processed['class_agent'] = isset($data['initial_class_agent']) && !empty($data['initial_class_agent']) ? intval($data['initial_class_agent']) : null;
        $processed['initial_class_agent'] = isset($data['initial_class_agent']) && !empty($data['initial_class_agent']) ? intval($data['initial_class_agent']) : null;
        error_log('Processed class_agent: ' . ($processed['class_agent'] ?? 'NULL'));

        $processed['initial_agent_start_date'] = isset($data['initial_agent_start_date']) && !is_array($data['initial_agent_start_date']) ? self::sanitizeText($data['initial_agent_start_date']) : null;
        $processed['project_supervisor'] = isset($data['project_supervisor']) && !empty($data['project_supervisor']) ? intval($data['project_supervisor']) : null;
        $processed['delivery_date'] = isset($data['delivery_date']) && !is_array($data['delivery_date']) ? self::sanitizeText($data['delivery_date']) : null;

        // Array fields
        $processed['class_notes'] = isset($data['class_notes']) && is_array($data['class_notes']) ? array_map([self::class, 'sanitizeText'], $data['class_notes']) : [];

        // Handle learner data from the hidden field (class_learners_data) - WordPress escaping aware
        $processed['learner_ids'] = [];
        error_log('=== LEARNER DATA PROCESSING (WordPress Escaping Fix) ===');
        error_log('Raw class_learners_data: ' . (isset($data['class_learners_data']) ? $data['class_learners_data'] : 'NOT SET'));

        if (isset($data['class_learners_data']) && !empty($data['class_learners_data'])) {
            // Use the WordPress JSON decoder helper function
            $learnerData = self::decodeWordPressJson($data['class_learners_data']);

            if ($learnerData !== null && is_array($learnerData)) {
                $processed['learner_ids'] = array_map('intval', array_column($learnerData, 'id'));
                error_log('Successfully processed learner IDs: ' . print_r($processed['learner_ids'], true));
            } else {
                error_log('Failed to decode learner data using WordPress JSON decoder');
                error_log('Attempting fallback processing...');

                // Fallback: try manual processing
                $rawJson = stripslashes($data['class_learners_data']);
                $decodedJson = html_entity_decode($rawJson, ENT_QUOTES, 'UTF-8');
                $learnerData = json_decode($decodedJson, true);

                if (is_array($learnerData)) {
                    $processed['learner_ids'] = array_map('intval', array_column($learnerData, 'id'));
                    error_log('Fallback processing successful: ' . print_r($processed['learner_ids'], true));
                } else {
                    error_log('Fallback processing failed. JSON error: ' . json_last_error_msg());
                    // Final fallback: try to extract IDs from malformed JSON
                    if (preg_match_all('/"id":\s*(\d+)/', $decodedJson, $matches)) {
                        $processed['learner_ids'] = array_map('intval', $matches[1]);
                        error_log('Regex extraction successful: ' . print_r($processed['learner_ids'], true));
                    }
                }
            }
        } else {
            error_log('class_learners_data field is empty or not set');
        }

        // Debug backup agent processing - check both possible field names
        error_log('=== BACKUP AGENT PROCESSING ===');
        error_log('Raw backup_agent data: ' . print_r($data['backup_agent'] ?? 'NOT SET', true));
        error_log('Raw backup_agent_ids data: ' . print_r($data['backup_agent_ids'] ?? 'NOT SET', true));

        // Check both possible field names from the form
        if (isset($data['backup_agent_ids']) && is_array($data['backup_agent_ids'])) {
            $processed['backup_agent_ids'] = array_map('intval', array_filter($data['backup_agent_ids']));
        } elseif (isset($data['backup_agent']) && is_array($data['backup_agent'])) {
            $processed['backup_agent_ids'] = array_map('intval', array_filter($data['backup_agent']));
        } else {
            $processed['backup_agent_ids'] = [];
        }

        error_log('Processed backup_agent_ids: ' . print_r($processed['backup_agent_ids'], true));

        // Schedule data - handle WordPress auto-escaping
        $processed['schedule_data'] = [];
        error_log('=== SCHEDULE DATA PROCESSING (WordPress Escaping Fix) ===');

        // Handle new schedule form data
        if (isset($data['schedule_data']) && is_array($data['schedule_data'])) {
            // Deep copy and handle WordPress escaping for nested JSON strings
            $scheduleData = $data['schedule_data'];
            error_log('Raw schedule_data: ' . print_r($scheduleData, true));

            // Handle exception_dates if it's a JSON string (WordPress escaped)
            if (isset($scheduleData['exception_dates']) && is_string($scheduleData['exception_dates'])) {
                error_log('Processing exception_dates as WordPress-escaped JSON string');
                error_log('Original exception_dates: ' . $scheduleData['exception_dates']);

                $decoded = self::decodeWordPressJson($scheduleData['exception_dates']);
                if ($decoded !== null) {
                    $scheduleData['exception_dates'] = $decoded;
                    error_log('Successfully decoded exception_dates: ' . print_r($decoded, true));
                } else {
                    error_log('Failed to decode exception_dates JSON');
                    $scheduleData['exception_dates'] = [];
                }
            }

            // Handle holiday_overrides if it's a JSON string (WordPress escaped)
            if (isset($scheduleData['holiday_overrides']) && is_string($scheduleData['holiday_overrides'])) {
                error_log('Processing holiday_overrides as WordPress-escaped JSON string');
                error_log('Original holiday_overrides: ' . $scheduleData['holiday_overrides']);

                $decoded = self::decodeWordPressJson($scheduleData['holiday_overrides']);
                if ($decoded !== null) {
                    $scheduleData['holiday_overrides'] = $decoded;
                    error_log('Successfully decoded holiday_overrides: ' . print_r($decoded, true));
                } else {
                    error_log('Failed to decode holiday_overrides JSON');
                    $scheduleData['holiday_overrides'] = [];
                }
            }

            // Handle days if it's a JSON string (WordPress escaped)
            if (isset($scheduleData['days']) && is_string($scheduleData['days'])) {
                error_log('Processing days as WordPress-escaped JSON string');
                error_log('Original days: ' . $scheduleData['days']);

                $decoded = self::decodeWordPressJson($scheduleData['days']);
                if ($decoded !== null) {
                    $scheduleData['days'] = $decoded;
                    error_log('Successfully decoded days: ' . print_r($decoded, true));
                } else {
                    error_log('Failed to decode days JSON, keeping as string');
                    // Keep as string if decoding fails
                }
            }

            // Handle any other potential JSON string fields in schedule data
            $jsonFields = ['selected_days', 'class_times', 'schedule_notes'];
            foreach ($jsonFields as $field) {
                if (isset($scheduleData[$field]) && is_string($scheduleData[$field])) {
                    // Check if it looks like JSON (starts with [ or {)
                    $trimmed = trim($scheduleData[$field]);
                    if (($trimmed[0] === '[' || $trimmed[0] === '{') && strlen($trimmed) > 1) {
                        error_log("Processing {$field} as potential WordPress-escaped JSON string");
                        error_log("Original {$field}: " . $scheduleData[$field]);

                        $decoded = self::decodeWordPressJson($scheduleData[$field]);
                        if ($decoded !== null) {
                            $scheduleData[$field] = $decoded;
                            error_log("Successfully decoded {$field}: " . print_r($decoded, true));
                        } else {
                            error_log("Failed to decode {$field} JSON, keeping as string");
                        }
                    }
                }
            }

            // Store the cleaned schedule pattern data
            $processed['schedule_data'] = $scheduleData;
            error_log('Cleaned schedule_data: ' . print_r($processed['schedule_data'], true));

            // Generate schedule data based on pattern
            $generatedSchedule = self::generateScheduleData($scheduleData);
            if (!empty($generatedSchedule)) {
                $processed['schedule_data'] = array_merge($processed['schedule_data'], $generatedSchedule);
                error_log('Final schedule_data with generated events: ' . print_r($processed['schedule_data'], true));
            }
        }
        // Legacy format support
        else if (isset($data['schedule_day']) && is_array($data['schedule_day'])) {
            $count = count($data['schedule_day']);
            for ($i = 0; $i < $count; $i++) {
                $processed['schedule_data'][] = [
                    'day' => isset($data['schedule_day'][$i]) ? self::sanitizeText($data['schedule_day'][$i]) : '',
                    'date' => isset($data['schedule_date'][$i]) ? self::sanitizeText($data['schedule_date'][$i]) : '',
                    'start_time' => isset($data['start_time'][$i]) ? self::sanitizeText($data['start_time'][$i]) : '',
                    'end_time' => isset($data['end_time'][$i]) ? self::sanitizeText($data['end_time'][$i]) : '',
                    'notes' => isset($data['schedule_notes'][$i]) ? self::sanitizeText($data['schedule_notes'][$i]) : '',
                    'type' => isset($data['event_type'][$i]) ? self::sanitizeText($data['event_type'][$i]) : ''
                ];
            }
        }

        // Debug stop/restart dates processing
        error_log('=== STOP/RESTART DATES PROCESSING ===');
        error_log('Raw stop_dates data: ' . print_r($data['stop_dates'] ?? 'NOT SET', true));
        error_log('Raw restart_dates data: ' . print_r($data['restart_dates'] ?? 'NOT SET', true));

        // Stop/restart dates - combine into proper format for model
        $stopDates = isset($data['stop_dates']) && is_array($data['stop_dates']) ?
            array_map(function($date) { return self::sanitizeText($date); }, $data['stop_dates']) : [];
        $restartDates = isset($data['restart_dates']) && is_array($data['restart_dates']) ?
            array_map(function($date) { return self::sanitizeText($date); }, $data['restart_dates']) : [];

        error_log('Processed stopDates: ' . print_r($stopDates, true));
        error_log('Processed restartDates: ' . print_r($restartDates, true));

        // Combine stop and restart dates into the format expected by the model
        $processed['stop_restart_dates'] = [];
        for ($i = 0; $i < max(count($stopDates), count($restartDates)); $i++) {
            if (!empty($stopDates[$i]) || !empty($restartDates[$i])) {
                $processed['stop_restart_dates'][] = [
                    'stop_date' => $stopDates[$i] ?? null,
                    'restart_date' => $restartDates[$i] ?? null
                ];
            }
        }

        error_log('Final stop_restart_dates: ' . print_r($processed['stop_restart_dates'], true));

        return $processed;
    }

    /**
     * Process QA Reports file uploads
     *
     * @param array $files Raw file data from $_FILES
     * @return array Array of uploaded file information
     */
    private static function processQAReports($files) {
        $qaReports = [];

        // Check if qa_reports files were uploaded
        if (!isset($files['qa_reports']) || empty($files['qa_reports']['name'])) {
            error_log('No QA reports files uploaded');
            return $qaReports;
        }

        $qaFiles = $files['qa_reports'];
        error_log('QA Reports files data: ' . print_r($qaFiles, true));

        // Handle multiple file uploads
        $fileCount = is_array($qaFiles['name']) ? count($qaFiles['name']) : 1;

        // Use the FileUploadService
        $uploadService = new \WeCoza\Services\FileUpload\FileUploadService();

        for ($i = 0; $i < $fileCount; $i++) {
            // Extract individual file data
            $file = [
                'name' => is_array($qaFiles['name']) ? $qaFiles['name'][$i] : $qaFiles['name'],
                'type' => is_array($qaFiles['type']) ? $qaFiles['type'][$i] : $qaFiles['type'],
                'tmp_name' => is_array($qaFiles['tmp_name']) ? $qaFiles['tmp_name'][$i] : $qaFiles['tmp_name'],
                'error' => is_array($qaFiles['error']) ? $qaFiles['error'][$i] : $qaFiles['error'],
                'size' => is_array($qaFiles['size']) ? $qaFiles['size'][$i] : $qaFiles['size']
            ];

            // Skip empty files
            if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            error_log("Processing QA report file {$i}: " . $file['name']);

            // Upload the file
            $uploadResult = $uploadService->uploadFile(
                $file,
                'qa-reports', // subdirectory
                ['pdf' => 'application/pdf'], // only allow PDFs
                10485760 // 10MB max size
            );

            if ($uploadResult['success']) {
                $qaReports[] = [
                    'original_name' => $file['name'],
                    'file_path' => $uploadResult['file_path'],
                    'file_url' => $uploadResult['file_url'],
                    'upload_date' => current_time('mysql'),
                    'file_size' => $file['size']
                ];
                error_log("QA report uploaded successfully: " . $uploadResult['file_path']);
            } else {
                error_log("QA report upload failed: " . $uploadResult['message']);
                // You might want to handle this error differently
                // For now, we'll continue with other files
            }
        }

        return $qaReports;
    }

    /**
     * Convert processed data to validation format - DEPRECATED
     * Server-side validation has been removed. All validation is handled on the frontend.
     * This method is kept for backward compatibility but returns data as-is.
     *
     * @param array $data Processed form data
     * @return array Data returned as-is (no validation conversion needed)
     */
    private static function convertToValidationFormat($data) {
        // Server-side validation disabled - using frontend validation only
        // Return data as-is since no validation conversion is needed
        return $data;
    }

    /**
     * Helper function to send JSON success response
     *
     * @param mixed $data Data to send in the response
     */
    private function sendJsonSuccess($data) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        exit;
    }

    /**
     * Helper function to send JSON error response
     *
     * @param string $message Error message
     * @param array $errors Optional errors (deprecated - validation errors no longer used)
     */
    private function sendJsonError($message, $errors = null) {
        header('Content-Type: application/json');
        $response = [
            'success' => false,
            'message' => $message
        ];

        // Server-side validation disabled - errors parameter is ignored
        // All validation is handled on the frontend

        echo json_encode($response);
        exit;
    }

    /**
     * Handle AJAX request to get class subjects
     */
    public function getClassSubjectsAjax() {
        // Check if class type is provided
        if (!isset($_GET['class_type']) || empty($_GET['class_type'])) {
            $this->sendJsonError('Class type is required.');
            return;
        }

        $classType = $_GET['class_type'];

        // Get subjects for the selected class type
        $subjects = ClassTypesController::getClassSubjects($classType);

        if (empty($subjects)) {
            $this->sendJsonError('No subjects found for the selected class type.');
            return;
        }

        // Debug log
        error_log('Class subjects for ' . $classType . ': ' . print_r($subjects, true));

        // Ensure subjects is a properly formatted indexed array
        if (empty($subjects)) {
            $subjects = [];
        } else if (!is_array($subjects)) {
            // Convert to array if not already an array
            $subjects = [$subjects];
        }

        // Additional debug log after processing
        error_log('Processed subjects array: ' . print_r($subjects, true));

        // Send the response with the subjects array
        $this->sendJsonSuccess($subjects);
    }







    /**
     * Generate schedule data based on pattern
     *
     * @param array $scheduleData Schedule pattern data
     * @return array Generated schedule data
     */
    private static function generateScheduleData($scheduleData) {
        $result = [];

        // Extract schedule pattern data
        $pattern = isset($scheduleData['pattern']) ? $scheduleData['pattern'] : '';
        $days = isset($scheduleData['days']) ? $scheduleData['days'] : [];
        $day = isset($scheduleData['day']) ? $scheduleData['day'] : '';
        $dayOfMonth = isset($scheduleData['day_of_month']) ? $scheduleData['day_of_month'] : '';
        $startTime = isset($scheduleData['start_time']) ? $scheduleData['start_time'] : '';
        $endTime = isset($scheduleData['end_time']) ? $scheduleData['end_time'] : '';
        $startDate = isset($scheduleData['start_date']) ? $scheduleData['start_date'] : '';
        $endDate = isset($scheduleData['end_date']) ? $scheduleData['end_date'] : '';

        // Handle legacy format (single day as string)
        if (empty($days) && !empty($day)) {
            $days = [$day];
        }

        // Ensure days is an array
        if (!is_array($days)) {
            $days = [$days];
        }

        // Extract exception dates
        $exceptionDates = [];
        if (isset($scheduleData['exception_dates'])) {
            // Handle JSON string
            if (is_string($scheduleData['exception_dates'])) {
                $decoded = json_decode($scheduleData['exception_dates'], true);
                if (is_array($decoded)) {
                    foreach ($decoded as $exception) {
                        if (isset($exception['date'])) {
                            $exceptionDates[] = $exception['date'];
                        }
                    }
                }
            }
            // Handle array
            else if (is_array($scheduleData['exception_dates'])) {
                foreach ($scheduleData['exception_dates'] as $exception) {
                    if (isset($exception['date'])) {
                        $exceptionDates[] = $exception['date'];
                    }
                }
            }
        }

        // Add public holidays to exception dates, respecting overrides
        if (!empty($startDate) && !empty($endDate)) {
            // Get public holidays controller instance
            $holidaysController = PublicHolidaysController::getInstance();

            // Get public holidays within the date range
            $publicHolidays = $holidaysController->getHolidayDatesInRange($startDate, $endDate);

            // Check for holiday overrides
            $holidayOverrides = [];
            if (isset($scheduleData['holiday_overrides']) && !empty($scheduleData['holiday_overrides'])) {
                // Handle JSON string
                if (is_string($scheduleData['holiday_overrides'])) {
                    $holidayOverrides = json_decode($scheduleData['holiday_overrides'], true);
                }
                // Handle array
                else if (is_array($scheduleData['holiday_overrides'])) {
                    $holidayOverrides = $scheduleData['holiday_overrides'];
                }
            }

            // Filter out overridden holidays
            $nonOverriddenHolidays = [];
            foreach ($publicHolidays as $holidayDate) {
                // Check if this holiday has an override
                if (isset($holidayOverrides[$holidayDate]) &&
                    isset($holidayOverrides[$holidayDate]['override']) &&
                    $holidayOverrides[$holidayDate]['override'] === true) {
                    // This holiday is overridden, don't add to exception dates
                    error_log("Holiday {$holidayDate} is overridden, not adding to exception dates");
                } else {
                    // This holiday is not overridden, add to exception dates
                    $nonOverriddenHolidays[] = $holidayDate;
                }
            }

            // Add non-overridden public holidays to exception dates
            if (!empty($nonOverriddenHolidays)) {
                $exceptionDates = array_merge($exceptionDates, $nonOverriddenHolidays);
            }
        }

        // If we don't have required data, return empty array
        if (empty($pattern) || empty($startDate) || empty($startTime) || empty($endTime)) {
            return $result;
        }

        // Set end date to 3 months from start date if not provided
        if (empty($endDate)) {
            $date = new \DateTime($startDate);
            $date->modify('+3 months');
            $endDate = $date->format('Y-m-d');
        }

        // Generate events based on pattern
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        // Weekly pattern
        if ($pattern === 'weekly' && !empty($days)) {
            // Get day indices for all selected days
            $dayIndices = [];
            foreach ($days as $day) {
                $dayIndices[] = self::getDayIndex($day);
            }

            // Set start date to the first occurrence of any selected day
            $current = clone $start;
            $currentDayIndex = (int)$current->format('w');

            // If current day is not in selected days, find the next occurrence
            if (!in_array($currentDayIndex, $dayIndices)) {
                $daysToAdd = 1;
                $nextDate = clone $current;
                $nextDate->modify('+' . $daysToAdd . ' day');

                while (!in_array((int)$nextDate->format('w'), $dayIndices)) {
                    $daysToAdd++;
                    $nextDate = clone $current;
                    $nextDate->modify('+' . $daysToAdd . ' day');
                }

                $current = $nextDate;
            }

            // Generate events for each day in the date range
            while ($current <= $end) {
                $currentDayIndex = (int)$current->format('w');
                $currentDayName = self::getDayName($currentDayIndex);
                $dateStr = $current->format('Y-m-d');

                // If current day is in selected days
                if (in_array($currentDayIndex, $dayIndices)) {
                    // Skip exception dates
                    if (!in_array($dateStr, $exceptionDates)) {
                        $result[] = [
                            'day' => $currentDayName,
                            'date' => $dateStr,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'notes' => '',
                            'type' => 'class'
                        ];
                    }
                }

                // Move to next day
                $current->modify('+1 day');
            }
        }

        // Bi-weekly pattern
        else if ($pattern === 'biweekly' && !empty($days)) {
            // Get day indices for all selected days
            $dayIndices = [];
            foreach ($days as $day) {
                $dayIndices[] = self::getDayIndex($day);
            }

            // Set start date to the first occurrence of any selected day
            $current = clone $start;
            $currentDayIndex = (int)$current->format('w');

            // If current day is not in selected days, find the next occurrence
            if (!in_array($currentDayIndex, $dayIndices)) {
                $daysToAdd = 1;
                $nextDate = clone $current;
                $nextDate->modify('+' . $daysToAdd . ' day');

                while (!in_array((int)$nextDate->format('w'), $dayIndices)) {
                    $daysToAdd++;
                    $nextDate = clone $current;
                    $nextDate->modify('+' . $daysToAdd . ' day');
                }

                $current = $nextDate;
            }

            // Track which week we're in (0 = first week, 1 = second week)
            $weekCounter = 0;

            // Generate events for each day in the date range
            while ($current <= $end) {
                $currentDayIndex = (int)$current->format('w');
                $currentDayName = self::getDayName($currentDayIndex);
                $dateStr = $current->format('Y-m-d');

                // If current day is in selected days and we're in the first week of the biweek
                if (in_array($currentDayIndex, $dayIndices) && $weekCounter === 0) {
                    // Skip exception dates
                    if (!in_array($dateStr, $exceptionDates)) {
                        $result[] = [
                            'day' => $currentDayName,
                            'date' => $dateStr,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'notes' => '',
                            'type' => 'class'
                        ];
                    }
                }

                // Move to next day
                $current->modify('+1 day');

                // Update week counter (0 = first week, 1 = second week)
                if ((int)$current->format('w') === 0) { // If it's Sunday
                    $weekCounter = ($weekCounter + 1) % 2;
                }
            }
        }

        // Monthly pattern
        else if ($pattern === 'monthly' && !empty($dayOfMonth)) {
            // Generate events for each month
            $current = clone $start;

            while ($current <= $end) {
                $dateToUse = clone $current;

                if ($dayOfMonth === 'last') {
                    // Set to last day of the month
                    $dateToUse->modify('last day of this month');
                } else {
                    // Set to specific day of month
                    $dateToUse->setDate(
                        $dateToUse->format('Y'),
                        $dateToUse->format('m'),
                        intval($dayOfMonth)
                    );

                    // If day is beyond the end of the month, move to next month
                    if ($dateToUse->format('m') != $current->format('m')) {
                        $current->modify('first day of next month');
                        continue;
                    }
                }

                $dateStr = $dateToUse->format('Y-m-d');

                // Skip exception dates
                if (!in_array($dateStr, $exceptionDates)) {
                    $result[] = [
                        'day' => $dateToUse->format('l'),
                        'date' => $dateStr,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'notes' => '',
                        'type' => 'class'
                    ];
                }

                // Move to next month
                $current->modify('first day of next month');
            }
        }

        return $result;
    }

    /**
     * Get day index from day name
     *
     * @param string $dayName Day name (e.g., 'Monday')
     * @return int Day index (0 = Sunday, 1 = Monday, etc.)
     */
    private static function getDayIndex($dayName) {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return array_search($dayName, $days);
    }

    /**
     * Helper function to get day name from day index
     *
     * @param int $dayIndex Day index (0 = Sunday, 1 = Monday, etc.)
     * @return string Day name
     */
    private static function getDayName($dayIndex) {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return isset($days[$dayIndex]) ? $days[$dayIndex] : '';
    }
    /**
     * Handle AJAX request to check for class conflicts
     */
    public function checkClassConflictsAjax() {
        // Check nonce
        if (!isset($_POST['nonce'])) {
            $this->sendJsonError('Security check failed.');
            return;
        }

        // Get schedule data from request
        $scheduleData = isset($_POST['schedule_data']) ? json_decode(stripslashes($_POST['schedule_data']), true) : [];
        $classId = isset($_POST['class_id']) ? intval($_POST['class_id']) : null;
        $agentId = isset($_POST['agent_id']) ? intval($_POST['agent_id']) : null;
        $learnerIds = isset($_POST['learner_ids']) ? json_decode(stripslashes($_POST['learner_ids']), true) : [];

        // Check for conflicts
        $conflicts = $this->checkClassConflicts($scheduleData, $classId, $agentId, $learnerIds);

        if (empty($conflicts)) {
            $this->sendJsonSuccess(['message' => 'No conflicts found.']);
        } else {
            $this->sendJsonSuccess([
                'message' => 'Potential conflicts detected.',
                'conflicts' => $conflicts
            ]);
        }
    }

    /**
     * Check for class conflicts
     *
     * @param array $scheduleData Schedule data to check
     * @param int|null $classId Current class ID (to exclude from conflict check)
     * @param int|null $agentId Agent ID to check for conflicts
     * @param array $learnerIds Learner IDs to check for conflicts
     * @return array List of conflicts
     */
    private function checkClassConflicts($scheduleData, $classId = null, $agentId = null, $learnerIds = []) {
        $conflicts = [];

        // If no schedule data, return empty conflicts
        if (empty($scheduleData)) {
            return $conflicts;
        }

        try {
            // Get database service
            $db = \WeCoza\Services\Database\DatabaseService::getInstance();

            // Process each schedule item
            foreach ($scheduleData as $schedule) {
                // Skip if missing required data
                if (!isset($schedule['date']) || !isset($schedule['start_time']) || !isset($schedule['end_time'])) {
                    continue;
                }

                $date = $schedule['date'];
                $startTime = $schedule['start_time'];
                $endTime = $schedule['end_time'];

                // Check for agent conflicts
                if ($agentId) {
                    $agentConflicts = $this->checkAgentConflicts($db, $date, $startTime, $endTime, $agentId, $classId);
                    if (!empty($agentConflicts)) {
                        $conflicts['agent'][] = [
                            'date' => $date,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'conflicts' => $agentConflicts
                        ];
                    }
                }

                // Check for learner conflicts
                if (!empty($learnerIds)) {
                    $learnerConflicts = $this->checkLearnerConflicts($db, $date, $startTime, $endTime, $learnerIds, $classId);
                    if (!empty($learnerConflicts)) {
                        $conflicts['learner'][] = [
                            'date' => $date,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'conflicts' => $learnerConflicts
                        ];
                    }
                }
            }

            return $conflicts;
        } catch (\Exception $e) {
            error_log('Error checking class conflicts: ' . $e->getMessage());
            return ['error' => 'An error occurred while checking for conflicts.'];
        }
    }

    /**
     * Check for agent conflicts
     *
     * @param \WeCoza\Services\Database\DatabaseService $db Database service
     * @param string $date Date to check
     * @param string $startTime Start time to check
     * @param string $endTime End time to check
     * @param int $agentId Agent ID to check
     * @param int|null $excludeClassId Class ID to exclude from check
     * @return array List of conflicting classes
     */
    private function checkAgentConflicts($db, $date, $startTime, $endTime, $agentId, $excludeClassId = null) {
        $conflicts = [];

        try {
            // Query for classes where this agent is assigned using new schema
            $sql = "SELECT c.class_id, c.class_type,
                           schedule_item->>'start_time' as start_time,
                           schedule_item->>'end_time' as end_time
                    FROM classes c,
                         jsonb_array_elements(c.schedule_data) as schedule_item
                    WHERE c.class_agent = ?
                    AND schedule_item->>'date' = ?
                    AND (
                        (schedule_item->>'start_time' <= ? AND schedule_item->>'end_time' > ?) OR
                        (schedule_item->>'start_time' < ? AND schedule_item->>'end_time' >= ?) OR
                        (schedule_item->>'start_time' >= ? AND schedule_item->>'end_time' <= ?)
                    )";

            $params = [$agentId, $date, $endTime, $startTime, $endTime, $startTime, $startTime, $endTime];

            // Exclude current class if provided
            if ($excludeClassId) {
                $sql .= " AND c.class_id != ?";
                $params[] = $excludeClassId;
            }

            $stmt = $db->query($sql, $params);

            while ($row = $stmt->fetch()) {
                $conflicts[] = [
                    'class_id' => $row['class_id'],
                    'class_type' => $row['class_type'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time']
                ];
            }

            return $conflicts;
        } catch (\Exception $e) {
            error_log('Error checking agent conflicts: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check for learner conflicts
     *
     * @param \WeCoza\Services\Database\DatabaseService $db Database service
     * @param string $date Date to check
     * @param string $startTime Start time to check
     * @param string $endTime End time to check
     * @param array $learnerIds Learner IDs to check
     * @param int|null $excludeClassId Class ID to exclude from check
     * @return array List of conflicting classes by learner
     */
    private function checkLearnerConflicts($db, $date, $startTime, $endTime, $learnerIds, $excludeClassId = null) {
        $conflicts = [];

        try {
            // For each learner, check for conflicts
            foreach ($learnerIds as $learnerId) {
                // Query for classes where this learner is assigned using JSONB contains
                $sql = "SELECT c.class_id, c.class_type,
                               schedule_item->>'start_time' as start_time,
                               schedule_item->>'end_time' as end_time
                        FROM classes c,
                             jsonb_array_elements(c.schedule_data) as schedule_item
                        WHERE c.learner_ids @> ?::jsonb
                        AND schedule_item->>'date' = ?
                        AND (
                            (schedule_item->>'start_time' <= ? AND schedule_item->>'end_time' > ?) OR
                            (schedule_item->>'start_time' < ? AND schedule_item->>'end_time' >= ?) OR
                            (schedule_item->>'start_time' >= ? AND schedule_item->>'end_time' <= ?)
                        )";

                $params = [
                    json_encode([$learnerId]),
                    $date,
                    $endTime, $startTime,
                    $endTime, $startTime,
                    $startTime, $endTime
                ];

                // Exclude current class if provided
                if ($excludeClassId) {
                    $sql .= " AND c.class_id != ?";
                    $params[] = $excludeClassId;
                }

                $stmt = $db->query($sql, $params);

                $learnerConflicts = [];
                while ($row = $stmt->fetch()) {
                    $learnerConflicts[] = [
                        'class_id' => $row['class_id'],
                        'class_type' => $row['class_type'],
                        'start_time' => $row['start_time'],
                        'end_time' => $row['end_time']
                    ];
                }

                if (!empty($learnerConflicts)) {
                    $conflicts[$learnerId] = $learnerConflicts;
                }
            }

            return $conflicts;
        } catch (\Exception $e) {
            error_log('Error checking learner conflicts: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Handle AJAX request to export calendar data
     */
    public function exportCalendarAjax() {
        // Check nonce
        if (!isset($_POST['nonce'])) {
            $this->sendJsonError('Security check failed.');
            return;
        }

        // Get class IDs from request
        $classIds = isset($_POST['class_ids']) ? json_decode(stripslashes($_POST['class_ids']), true) : [];

        // Generate iCalendar content
        $icalContent = CalendarExportService::generateICalendar($classIds);

        // Set headers for file download
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="wecoza-classes.ics"');

        // Output the iCalendar content
        echo $icalContent;
        exit;
    }

    /**
     * Handle display classes shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function displayClassesShortcode($atts) {
        // Process shortcode attributes
        $atts = \shortcode_atts([
            'limit' => 50,
            'order_by' => 'created_at',
            'order' => 'DESC',
            'show_loading' => true,
        ], $atts);

        try {
            // Get all classes from database
            $classes = $this->getAllClasses($atts);

            // Prepare view data
            $viewData = [
                'classes' => $classes,
                'show_loading' => $atts['show_loading'],
                'total_count' => count($classes)
            ];

            // Render the view
            return \WeCoza\view('components/classes-display', $viewData);

        } catch (\Exception $e) {
            // Log error and return user-friendly message
            \error_log('Error in displayClassesShortcode: ' . $e->getMessage());
            \error_log('Error trace: ' . $e->getTraceAsString());

            // For debugging - show detailed error (remove in production)
            if (current_user_can('manage_options')) {
                return '<div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Debug Error:</strong> ' . esc_html($e->getMessage()) . '
                    <br><small>File: ' . esc_html($e->getFile()) . ' Line: ' . $e->getLine() . '</small>
                </div>';
            }

            return '<div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Unable to load classes at this time. Please try again later.
            </div>';
        }
    }

    /**
     * Get all classes from database with optional filtering
     *
     * @param array $options Query options (limit, order_by, order)
     * @return array Array of class data
     */
    private function getAllClasses($options = []) {
        $db = \WeCoza\Services\Database\DatabaseService::getInstance();

        // Set defaults
        $limit = isset($options['limit']) ? intval($options['limit']) : 50;
        $order_by = isset($options['order_by']) ? $options['order_by'] : 'created_at';
        $order = isset($options['order']) ? strtoupper($options['order']) : 'DESC';

        // Validate order_by to prevent SQL injection
        $allowed_columns = [
            'class_id', 'client_id', 'class_type', 'class_subject',
            'original_start_date', 'delivery_date', 'created_at', 'updated_at'
        ];

        if (!in_array($order_by, $allowed_columns)) {
            $order_by = 'created_at';
        }

        // Validate order direction
        if (!in_array($order, ['ASC', 'DESC'])) {
            $order = 'DESC';
        }

        // Build the query - start simple without JOINs to avoid missing table issues
        $sql = "
            SELECT
                c.class_id,
                c.client_id,
                c.class_type,
                c.class_subject,
                c.class_code,
                c.class_duration,
                c.original_start_date,
                c.delivery_date,
                c.seta_funded,
                c.seta,
                c.exam_class,
                c.exam_type,
                c.class_agent,
                c.project_supervisor_id,
                c.created_at,
                c.updated_at
            FROM public.classes c
            ORDER BY c." . $order_by . " " . $order . "
            LIMIT " . $limit;

        $stmt = $db->query($sql);
        $results = $stmt->fetchAll();

        // Add placeholder names for missing related data
        foreach ($results as &$row) {
            $row['client_name'] = 'Client ID: ' . ($row['client_id'] ?? 'Unknown');
            $row['site_name'] = 'Site ID: ' . ($row['site_id'] ?? 'Unknown');
            $row['agent_name'] = 'Agent ID: ' . ($row['class_agent'] ?? 'Unassigned');
            $row['supervisor_name'] = 'Supervisor ID: ' . ($row['project_supervisor_id'] ?? 'Unassigned');
        }

        return $results;
    }

    /**
     * Handle display single class shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function displaySingleClassShortcode($atts) {
        // Process shortcode attributes
        $atts = \shortcode_atts([
            'class_id' => '',
            'show_loading' => true,
        ], $atts);

        try {
            // Get class_id from shortcode attribute or URL parameter
            $class_id = intval($atts['class_id']);

            // If no class_id in shortcode, try to get it from URL parameter
            if (empty($class_id) || $class_id <= 0) {
                $class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;
            }

            // Validate class_id parameter
            if (empty($class_id) || $class_id <= 0) {
                return '<div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Invalid Class ID:</strong> Please provide a valid class_id parameter or URL parameter.
                    <br><small>Example: [wecoza_display_single_class class_id="25"] or URL: ?class_id=25</small>
                </div>';
            }

            // Get single class from database
            $class = $this->getSingleClass($class_id);

            // Prepare view data
            $viewData = [
                'class' => $class,
                'show_loading' => $atts['show_loading'],
                'error_message' => ''
            ];

            // If class not found, set error message
            if (empty($class)) {
                $viewData['error_message'] = "Class with ID {$class_id} was not found in the database.";
            }

            // Render the view
            return \WeCoza\view('components/single-class-display', $viewData);

        } catch (\Exception $e) {
            // Log error and return user-friendly message
            \error_log('Error in displaySingleClassShortcode: ' . $e->getMessage());
            \error_log('Error trace: ' . $e->getTraceAsString());

            // For debugging - show detailed error (remove in production)
            if (current_user_can('manage_options')) {
                return '<div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Debug Error:</strong> ' . esc_html($e->getMessage()) . '
                    <br><small>File: ' . esc_html($e->getFile()) . ' Line: ' . $e->getLine() . '</small>
                </div>';
            }

            return '<div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Unable to load class details at this time. Please try again later.
            </div>';
        }
    }

    /**
     * Get single class from database with related data
     *
     * @param int $class_id Class ID to retrieve
     * @return array|null Class data or null if not found
     */
    private function getSingleClass($class_id) {
        $db = \WeCoza\Services\Database\DatabaseService::getInstance();

        // Simple query to get class data by class_id
        $sql = "SELECT * FROM public.classes WHERE class_id = :class_id LIMIT 1";

        $stmt = $db->query($sql, ['class_id' => $class_id]);
        $result = $stmt->fetch();

        // If no result found, return null
        if (!$result) {
            return null;
        }

        // Add fallback names for related data (since we're not joining tables)
        $result['client_name'] = 'Client ID: ' . ($result['client_id'] ?? 'Unknown');
        $result['agent_name'] = 'Agent ID: ' . ($result['class_agent'] ?? 'Unassigned');
        $result['supervisor_name'] = 'Supervisor ID: ' . ($result['project_supervisor_id'] ?? 'Unassigned');

        return $result;
    }
}
