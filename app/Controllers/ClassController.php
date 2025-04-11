<?php
/**
 * ClassController.php
 *
 * Controller for handling class-related operations
 */

namespace WeCoza\Controllers;

use WeCoza\Models\Assessment\ClassModel;
use WeCoza\Controllers\MainController;

class ClassController {
    /**
     * Constructor
     */
    public function __construct() {
        // Register WordPress hooks
        add_action('init', [$this, 'registerShortcodes']);
        add_action('wp_ajax_save_class', [$this, 'saveClassAjax']);
        add_action('wp_ajax_nopriv_save_class', [$this, 'saveClassAjax']);

        // Enqueue necessary scripts and styles
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    /**
     * Register all class-related shortcodes
     */
    public function registerShortcodes() {
        add_shortcode('wecoza_capture_class', [$this, 'captureClassShortcode']);
        add_shortcode('wecoza_display_class', [$this, 'displayClassShortcode']);
    }

    /**
     * Enqueue necessary scripts and styles
     */
    public function enqueueAssets() {
        // Always enqueue these scripts to ensure they're available
        // FullCalendar CSS and JS
        wp_enqueue_style('fullcalendar-css', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css');
        wp_enqueue_script('fullcalendar-js', 'https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js', ['jquery'], null, true);

        // Custom scripts
        wp_enqueue_script('wecoza-class-js', WECOZA_CHILD_URL . '/public/js/class-capture.js', ['jquery', 'fullcalendar-js'], WECOZA_PLUGIN_VERSION, true);

        // Localize script with AJAX URL and nonce
        wp_localize_script('wecoza-class-js', 'wecozaClass', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wecoza_class_nonce'),
            'siteAddresses' => self::getSiteAddresses(),
            'debug' => true
        ]);

        // Add inline script to initialize calendar when DOM is ready
        wp_add_inline_script('wecoza-class-js', '
            jQuery(document).ready(function($) {
                console.log("DOM ready - checking for calendar");
                if ($("#class-calendar").length) {
                    console.log("Calendar container found - initializing");
                    if (typeof initializeClassCalendar === "function") {
                        initializeClassCalendar();
                    } else {
                        console.error("initializeClassCalendar function not found");
                    }
                } else {
                    console.log("Calendar container not found");
                }
            });
        ', 'after');
    }

    /**
     * Handle class capture shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function captureClassShortcode($atts) {
        // Process shortcode attributes
        $atts = shortcode_atts([
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
            'products' => MainController::getProducts(),
            'class_types' => MainController::getClassType(),
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
        $atts = shortcode_atts([
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
        // Check nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wecoza_class_nonce')) {
            wp_send_json_error(['message' => 'Security check failed.']);
            return;
        }

        // Process form data
        $formData = self::processFormData($_POST);

        // Create or update class
        $class = new ClassModel($formData);

        $result = false;
        if (isset($formData['id']) && !empty($formData['id'])) {
            $result = $class->update();
        } else {
            $result = $class->save();
        }

        if ($result) {
            wp_send_json_success([
                'message' => 'Class saved successfully.',
                'class_id' => $class->getId()
            ]);
        } else {
            wp_send_json_error(['message' => 'Failed to save class.']);
        }
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
        $processed['siteAddress'] = isset($data['site_address']) ? sanitize_text_field($data['site_address']) : null;
        $processed['classType'] = isset($data['class_type']) ? sanitize_text_field($data['class_type']) : null;
        $processed['classStartDate'] = isset($data['class_start_date']) ? sanitize_text_field($data['class_start_date']) : null;
        $processed['setaFunded'] = isset($data['seta_funded']) ? sanitize_text_field($data['seta_funded']) : null;
        $processed['setaId'] = isset($data['seta_id']) ? sanitize_text_field($data['seta_id']) : null;
        $processed['examClass'] = isset($data['exam_class']) ? sanitize_text_field($data['exam_class']) : null;
        $processed['examType'] = isset($data['exam_type']) ? sanitize_text_field($data['exam_type']) : null;
        $processed['qaVisitDates'] = isset($data['qa_visit_dates']) ? sanitize_textarea_field($data['qa_visit_dates']) : null;
        $processed['classAgent'] = isset($data['class_agent']) ? intval($data['class_agent']) : null;
        $processed['projectSupervisor'] = isset($data['project_supervisor']) ? intval($data['project_supervisor']) : null;
        $processed['deliveryDate'] = isset($data['delivery_date']) ? sanitize_text_field($data['delivery_date']) : null;

        // Array fields
        $processed['courseIds'] = isset($data['course_id']) && is_array($data['course_id']) ? array_map('sanitize_text_field', $data['course_id']) : [];
        $processed['classNotes'] = isset($data['class_notes']) && is_array($data['class_notes']) ? array_map('sanitize_text_field', $data['class_notes']) : [];
        $processed['learnerIds'] = isset($data['add_learner']) && is_array($data['add_learner']) ? array_map('intval', $data['add_learner']) : [];
        $processed['backupAgentIds'] = isset($data['backup_agent']) && is_array($data['backup_agent']) ? array_map('intval', $data['backup_agent']) : [];

        // Schedule data
        $processed['scheduleData'] = [];
        if (isset($data['schedule_day']) && is_array($data['schedule_day'])) {
            $count = count($data['schedule_day']);
            for ($i = 0; $i < $count; $i++) {
                $processed['scheduleData'][] = [
                    'day' => isset($data['schedule_day'][$i]) ? sanitize_text_field($data['schedule_day'][$i]) : '',
                    'date' => isset($data['schedule_date'][$i]) ? sanitize_text_field($data['schedule_date'][$i]) : '',
                    'start_time' => isset($data['start_time'][$i]) ? sanitize_text_field($data['start_time'][$i]) : '',
                    'end_time' => isset($data['end_time'][$i]) ? sanitize_text_field($data['end_time'][$i]) : '',
                    'notes' => isset($data['schedule_notes'][$i]) ? sanitize_text_field($data['schedule_notes'][$i]) : '',
                    'type' => isset($data['event_type'][$i]) ? sanitize_text_field($data['event_type'][$i]) : ''
                ];
            }
        }

        // Stop/restart dates
        $processed['stopDates'] = isset($data['stop_dates']) && is_array($data['stop_dates']) ? array_map('sanitize_text_field', $data['stop_dates']) : [];
        $processed['restartDates'] = isset($data['restart_dates']) && is_array($data['restart_dates']) ? array_map('sanitize_text_field', $data['restart_dates']) : [];

        return $processed;
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
}
