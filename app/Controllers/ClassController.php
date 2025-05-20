<?php
/**
 * ClassController.php
 *
 * Controller for handling class-related operations
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
        // Constructor is empty - hooks are registered in ajax-handlers.php
        // This allows us to avoid namespace issues with WordPress functions
    }

    /**
     * Register all class-related shortcodes
     */
    public function registerShortcodes() {
        \add_shortcode('wecoza_capture_class', [$this, 'captureClassShortcode']);
        \add_shortcode('wecoza_display_class', [$this, 'displayClassShortcode']);
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
            'siteAddresses' => self::getSiteAddresses(),
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

        // Get data for the view
        $viewData = [
            'clients' => $this->getClients(),
            'sites' => $this->getSites(),
            'agents' => $this->getAgents(),
            'supervisors' => $this->getSupervisors(),
            'learners' => $this->getLearnersExam(),
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
     * Handle class display shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function displayClassShortcode($atts) {
        // Process shortcode attributes
        $atts = \shortcode_atts([
            'class_id' => 0,
            'show_header' => true,
        ], $atts);

        // If no class ID provided, show a list of classes
        if (empty($atts['class_id'])) {
            return $this->displayClassList();
        }

        // Get the class data
        $class = ClassModel::getById($atts['class_id']);
        if (!$class) {
            return '<div class="alert alert-danger">Class not found.</div>';
        }

        // Render the view
        return \WeCoza\view('components/class-display', [
            'class' => $class,
            'show_header' => $atts['show_header']
        ]);
    }

    /**
     * Display a list of classes
     *
     * @return string HTML output
     */
    private function displayClassList() {
        // Get all classes
        $classes = $this->getAllClasses();

        // Render the view
        return \WeCoza\view('components/class-list', [
            'classes' => $classes
        ]);
    }

    /**
     * Handle AJAX request to save class data
     */
    public static function saveClassAjax() {
        // Create a temporary instance to access instance methods
        $instance = new self();

        // Check nonce
        if (!isset($_POST['nonce'])) {
            $instance->sendJsonError('Security check failed.');
            return;
        }

        // Process form data
        $formData = self::processFormData($_POST);

        // Validate form data
        $validator = ClassModel::validate($formData);
        if (!$validator->validate($formData)) {
            $instance->sendJsonError(
                'Validation failed. Please check the form for errors.'
            );
            return;
        }

        // Create or update class
        $class = new ClassModel($formData);

        $result = false;
        if (isset($formData['id']) && !empty($formData['id'])) {
            $result = $class->update();
        } else {
            $result = $class->save();
        }

        if ($result) {
            $instance->sendJsonSuccess([
                'message' => 'Class saved successfully.',
                'class_id' => $class->getId()
            ]);
        } else {
            $instance->sendJsonError('Failed to save class.');
        }
    }

    /**
     * Simple sanitization helper
     *
     * @param string $text Text to sanitize
     * @return string Sanitized text
     */
    private static function sanitizeText($text) {
        return trim(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
    }

    /**
     * Process form data
     *
     * @param array $data Raw form data
     * @return array Processed data
     */
    private static function processFormData($data) {
        $processed = [];

        // Basic fields
        $processed['id'] = isset($data['class_id']) && $data['class_id'] !== 'auto-generated' ? intval($data['class_id']) : null;
        $processed['clientId'] = isset($data['client_id']) ? intval($data['client_id']) : null;
        $processed['siteId'] = isset($data['site_id']) ? $data['site_id'] : null;
        $processed['siteAddress'] = isset($data['site_address']) ? self::sanitizeText($data['site_address']) : null;
        $processed['classType'] = isset($data['class_type']) ? self::sanitizeText($data['class_type']) : null;
        $processed['classStartDate'] = isset($data['class_start_date']) ? self::sanitizeText($data['class_start_date']) : null;
        $processed['setaFunded'] = isset($data['seta_funded']) ? self::sanitizeText($data['seta_funded']) : null;
        $processed['setaId'] = isset($data['seta_id']) ? self::sanitizeText($data['seta_id']) : null;
        $processed['examClass'] = isset($data['exam_class']) ? self::sanitizeText($data['exam_class']) : null;
        $processed['examType'] = isset($data['exam_type']) ? self::sanitizeText($data['exam_type']) : null;
        $processed['qaVisitDates'] = isset($data['qa_visit_dates']) ? self::sanitizeText($data['qa_visit_dates']) : null;
        $processed['classAgent'] = isset($data['class_agent']) ? intval($data['class_agent']) : null;
        $processed['projectSupervisor'] = isset($data['project_supervisor']) ? intval($data['project_supervisor']) : null;
        $processed['deliveryDate'] = isset($data['delivery_date']) ? self::sanitizeText($data['delivery_date']) : null;

        // Array fields
        $processed['classNotes'] = isset($data['class_notes']) && is_array($data['class_notes']) ? array_map([self::class, 'sanitizeText'], $data['class_notes']) : [];
        $processed['learnerIds'] = isset($data['add_learner']) && is_array($data['add_learner']) ? array_map('intval', $data['add_learner']) : [];
        $processed['backupAgentIds'] = isset($data['backup_agent']) && is_array($data['backup_agent']) ? array_map('intval', $data['backup_agent']) : [];

        // Schedule data
        $processed['scheduleData'] = [];

        // Handle new schedule form data
        if (isset($data['schedule_data']) && is_array($data['schedule_data'])) {
            // Store the schedule pattern data
            $processed['schedulePattern'] = $data['schedule_data'];

            // Store holiday overrides if present
            if (isset($data['schedule_data']['holiday_overrides'])) {
                $processed['schedulePattern']['holiday_overrides'] = $data['schedule_data']['holiday_overrides'];
            }

            // Generate schedule data based on pattern
            $scheduleData = self::generateScheduleData($data['schedule_data']);
            if (!empty($scheduleData)) {
                $processed['scheduleData'] = $scheduleData;
            }
        }
        // Legacy format support
        else if (isset($data['schedule_day']) && is_array($data['schedule_day'])) {
            $count = count($data['schedule_day']);
            for ($i = 0; $i < $count; $i++) {
                $processed['scheduleData'][] = [
                    'day' => isset($data['schedule_day'][$i]) ? self::sanitizeText($data['schedule_day'][$i]) : '',
                    'date' => isset($data['schedule_date'][$i]) ? self::sanitizeText($data['schedule_date'][$i]) : '',
                    'start_time' => isset($data['start_time'][$i]) ? self::sanitizeText($data['start_time'][$i]) : '',
                    'end_time' => isset($data['end_time'][$i]) ? self::sanitizeText($data['end_time'][$i]) : '',
                    'notes' => isset($data['schedule_notes'][$i]) ? self::sanitizeText($data['schedule_notes'][$i]) : '',
                    'type' => isset($data['event_type'][$i]) ? self::sanitizeText($data['event_type'][$i]) : ''
                ];
            }
        }

        // Stop/restart dates
        $processed['stopDates'] = isset($data['stop_dates']) && is_array($data['stop_dates']) ? array_map('sanitize_text_field', $data['stop_dates']) : [];
        $processed['restartDates'] = isset($data['restart_dates']) && is_array($data['restart_dates']) ? array_map('sanitize_text_field', $data['restart_dates']) : [];

        return $processed;
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
     */
    private function sendJsonError($message) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $message
        ]);
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
     * Get all clients
     *
     * @return array List of clients
     */
    private function getClients() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 11, 'name' => 'Aspen Pharmacare'],
            ['id' => 14, 'name' => 'Barloworld'],
            ['id' => 9, 'name' => 'Bidvest Group'],
            ['id' => 8, 'name' => 'FirstRand'],
            ['id' => 4, 'name' => 'MTN Group'],
            ['id' => 15, 'name' => 'Multichoice Group'],
            ['id' => 5, 'name' => 'Naspers'],
            ['id' => 12, 'name' => 'Nedbank Group'],
            ['id' => 10, 'name' => 'Sanlam'],
            ['id' => 1, 'name' => 'Sasol Limited'],
            ['id' => 3, 'name' => 'Shoprite Holdings'],
            ['id' => 2, 'name' => 'Standard Bank Group'],
            ['id' => 13, 'name' => 'Tiger Brands'],
            ['id' => 6, 'name' => 'Vodacom Group'],
            ['id' => 7, 'name' => 'Woolworths Holdings']
        ];
    }

    /**
     * Get all sites
     *
     * @return array List of sites grouped by client
     */
    private function getSites() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            11 => [ // Aspen Pharmacare
                ['id' => '11_1', 'name' => 'Aspen Pharmacare - Head Office'],
                ['id' => '11_2', 'name' => 'Aspen Pharmacare - Production Unit'],
                ['id' => '11_3', 'name' => 'Aspen Pharmacare - Research Centre']
            ],
            14 => [ // Barloworld
                ['id' => '14_1', 'name' => 'Barloworld - Northern Branch'],
                ['id' => '14_2', 'name' => 'Barloworld - Southern Branch'],
                ['id' => '14_3', 'name' => 'Barloworld - Central Branch']
            ],
            // Additional clients would be added here
        ];
    }

    /**
     * Get site addresses
     *
     * @return array Mapping of site IDs to addresses
     */
    private static function getSiteAddresses() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            // Aspen Pharmacare
            "11_1" => "Aspen Pharmacare - Head Office, 100 Pharma Rd, Durban, 4001",
            "11_2" => "Aspen Pharmacare - Production Unit, 101 Pharma Rd, Durban, 4001",
            "11_3" => "Aspen Pharmacare - Research Centre, 102 Pharma Rd, Durban, 4001",

            // Barloworld
            "14_1" => "Barloworld - Northern Branch, 10 Northern Ave, Johannesburg, 2001",
            "14_2" => "Barloworld - Southern Branch, 20 Southern St, Johannesburg, 2002",
            "14_3" => "Barloworld - Central Branch, 30 Central Blvd, Johannesburg, 2003",

            // Additional sites would be added here
        ];
    }

    /**
     * Get all agents
     *
     * @return array List of agents
     */
    private function getAgents() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 1, 'name' => 'Michael M. van der Berg'],
            ['id' => 2, 'name' => 'Thandi T. Nkosi'],
            ['id' => 3, 'name' => 'Rajesh R. Patel'],
            ['id' => 4, 'name' => 'Lerato L. Moloi'],
            ['id' => 5, 'name' => 'Johannes J. Pretorius'],
            ['id' => 6, 'name' => 'Nomvula N. Dlamini'],
            ['id' => 7, 'name' => 'David D. O\'Connor'],
            ['id' => 8, 'name' => 'Zanele Z. Mthembu'],
            ['id' => 9, 'name' => 'Pieter P. van Zyl'],
            ['id' => 10, 'name' => 'Fatima F. Ismail'],
            ['id' => 11, 'name' => 'Sipho S. Ndlovu'],
            ['id' => 12, 'name' => 'Anita A. van Rensburg'],
            ['id' => 13, 'name' => 'Themba T. Mkhize'],
            ['id' => 14, 'name' => 'Sarah S. Botha'],
            ['id' => 15, 'name' => 'Lwazi L. Zuma']
        ];
    }

    /**
     * Get all supervisors
     *
     * @return array List of supervisors
     */
    private function getSupervisors() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 1, 'name' => 'Ethan J. Williams'],
            ['id' => 2, 'name' => 'Aisha K. Mohamed'],
            ['id' => 3, 'name' => 'Carlos M. Rodriguez'],
            ['id' => 4, 'name' => 'Emily R. Thompson'],
            ['id' => 5, 'name' => 'Samuel B. Johnson'],
            ['id' => 6, 'name' => 'Lungile T. Mthethwa'],
            ['id' => 7, 'name' => 'David C. Martins'],
            ['id' => 8, 'name' => 'Zanele P. Khumalo'],
            ['id' => 9, 'name' => 'Johan D. Venter'],
            ['id' => 10, 'name' => 'Fatima H. Desai'],
            ['id' => 11, 'name' => 'Sipho M. Zondi'],
            ['id' => 12, 'name' => 'Annelize S. du Preez'],
            ['id' => 13, 'name' => 'Themba L. Sithole'],
            ['id' => 14, 'name' => 'Sophia V. Naidoo'],
            ['id' => 15, 'name' => 'Mandla N. Dube']
        ];
    }

    /**
     * Get all learners for exam selection
     *
     * @return array List of learners available for exam classes
     */
    private function getLearnersExam() {
        // This would typically come from a database query
        // For now, returning static data for exam selection
        return [
            ['id' => 1, 'name' => 'John J.M. Smith'],
            ['id' => 2, 'name' => 'Nosipho N. Dlamini'],
            ['id' => 3, 'name' => 'Ahmed A. Patel'],
            ['id' => 4, 'name' => 'Lerato L. Moloi'],
            ['id' => 5, 'name' => 'Pieter P. van der Merwe'],
            ['id' => 6, 'name' => 'Thandi T. Nkosi'],
            ['id' => 7, 'name' => 'Daniel D. O\'Connor'],
            ['id' => 8, 'name' => 'Zinhle Z. Mthembu'],
            ['id' => 9, 'name' => 'Willem W. Botha'],
            ['id' => 10, 'name' => 'Nomsa N. Tshabalala'],
            ['id' => 11, 'name' => 'Raj R. Singh'],
            ['id' => 12, 'name' => 'Emma E. van Wyk'],
            ['id' => 13, 'name' => 'Sibusiso S. Ngcobo'],
            ['id' => 14, 'name' => 'Charmaine C. Pillay'],
            ['id' => 15, 'name' => 'Themba T. Maseko'],
            ['id' => 23, 'name' => 'Sibusiso eryery. Montgomery'],
            ['id' => 24, 'name' => 'John2 ey. Montgomery'],
            ['id' => 25, 'name' => 'John2 y ery. Montgomery3'],
            ['id' => 35, 'name' => 'Peter P.J. Wessels'],
            ['id' => 36, 'name' => 'Peter 2 P.J. Wessels2'],
            ['id' => 37, 'name' => 'Comm Nume. Wessels']
        ];
    }

    /**
     * Get all classes
     *
     * @return array List of classes
     */
    private function getAllClasses() {
        // This would typically come from a database query
        // For now, returning an empty array
        return [];
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
            // Query for classes where this agent is assigned on the same date with overlapping times
            $sql = "SELECT c.id, c.class_type, cs.start_time, cs.end_time
                    FROM wecoza_classes c
                    JOIN wecoza_class_schedule cs ON c.id = cs.class_id
                    WHERE c.class_agent = ?
                    AND cs.date = ?
                    AND (
                        (cs.start_time <= ? AND cs.end_time > ?) OR
                        (cs.start_time < ? AND cs.end_time >= ?) OR
                        (cs.start_time >= ? AND cs.end_time <= ?)
                    )";

            $params = [$agentId, $date, $endTime, $startTime, $endTime, $startTime, $startTime, $endTime];

            // Exclude current class if provided
            if ($excludeClassId) {
                $sql .= " AND c.id != ?";
                $params[] = $excludeClassId;
            }

            $stmt = $db->query($sql, $params);

            while ($row = $stmt->fetch()) {
                $conflicts[] = [
                    'class_id' => $row['id'],
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
                // Query for classes where this learner is assigned on the same date with overlapping times
                $sql = "SELECT c.id, c.class_type, cs.start_time, cs.end_time
                        FROM wecoza_classes c
                        JOIN wecoza_class_schedule cs ON c.id = cs.class_id
                        JOIN wecoza_class_learners cl ON c.id = cl.class_id
                        WHERE cl.learner_id = ?
                        AND cs.date = ?
                        AND (
                            (cs.start_time <= ? AND cs.end_time > ?) OR
                            (cs.start_time < ? AND cs.end_time >= ?) OR
                            (cs.start_time >= ? AND cs.end_time <= ?)
                        )";

                $params = [$learnerId, $date, $endTime, $startTime, $endTime, $startTime, $startTime, $endTime];

                // Exclude current class if provided
                if ($excludeClassId) {
                    $sql .= " AND c.id != ?";
                    $params[] = $excludeClassId;
                }

                $stmt = $db->query($sql, $params);

                $learnerConflicts = [];
                while ($row = $stmt->fetch()) {
                    $learnerConflicts[] = [
                        'class_id' => $row['id'],
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
}
