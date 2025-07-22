<?php
/**
 * ShortcodeListController.php
 * 
 * Controller for handling the shortcode list display functionality
 * Provides a comprehensive list of all available WeCoza shortcodes
 */

namespace WeCoza\Controllers;

class ShortcodeListController {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register WordPress hooks
        add_action('init', [$this, 'registerShortcodes']);
    }

    /**
     * Register shortcode list shortcode
     */
    public function registerShortcodes() {
        add_shortcode('wecoza_shortcode_list', [$this, 'displayShortcodeList']);
    }

    /**
     * Handle shortcode list display
     * 
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function displayShortcodeList($atts) {
        // Parse shortcode attributes with defaults
        $atts = shortcode_atts([
            'show_loading' => 'true',
            'category' => 'all' // Future enhancement for filtering by category
        ], $atts, 'wecoza_shortcode_list');

        // Convert string boolean to actual boolean
        $show_loading = filter_var($atts['show_loading'], FILTER_VALIDATE_BOOLEAN);

        try {
            // Get all available shortcodes
            $shortcodes = $this->getAllShortcodes();
            
            // Prepare view data
            $data = [
                'shortcodes' => $shortcodes,
                'show_loading' => $show_loading,
                'total_count' => count($shortcodes),
                'category_filter' => $atts['category']
            ];

            // Render the view
            return $this->renderView('components/shortcode-list', $data);

        } catch (Exception $e) {
            // Log error and return user-friendly message
            error_log('WeCoza Shortcode List Error: ' . $e->getMessage());
            
            return '<div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Error:</strong> Unable to load shortcode list. Please try again later.
                    </div>';
        }
    }

    /**
     * Get all available WeCoza shortcodes with their information
     * 
     * @return array Array of shortcode information
     */
    private function getAllShortcodes() {
        return [
            // Class Management Shortcodes
            [
                'name' => 'wecoza_capture_class',
                'category' => 'Class Management',
                'description' => 'Displays a comprehensive form for creating and managing training classes',
                'usage' => '[wecoza_capture_class]',
                'parameters' => 'Accepts URL parameters for mode (create/update) and class_id',
                'controller' => 'ClassController',
                'view' => 'components/class-capture-form.view.php',
                'url_params' => true,
                'shortcode_attrs' => false
            ],
            [
                'name' => 'wecoza_display_classes',
                'category' => 'Class Management',
                'description' => 'Displays all classes from the database in a Bootstrap 5 compatible table',
                'usage' => '[wecoza_display_classes limit="25" order_by="class_subject"]',
                'parameters' => 'limit, order_by, order, show_loading',
                'controller' => 'ClassController',
                'view' => 'components/classes-display.view.php',
                'url_params' => false,
                'shortcode_attrs' => true
            ],
            [
                'name' => 'wecoza_display_single_class',
                'category' => 'Class Management',
                'description' => 'Displays detailed information for a single class with calendar integration',
                'usage' => '[wecoza_display_single_class class_id="25"]',
                'parameters' => 'class_id (required), show_loading',
                'controller' => 'ClassController',
                'view' => 'components/single-class-display.view.php',
                'url_params' => true,
                'shortcode_attrs' => true
            ],
            
            // Learner Management Shortcodes moved to standalone plugin
            
            // Reporting & Analytics Shortcodes
            [
                'name' => 'wecoza_outstanding_deliveries',
                'category' => 'Reporting',
                'description' => 'Displays a table of outstanding deliveries with status indicators',
                'usage' => '[wecoza_outstanding_deliveries]',
                'parameters' => 'No parameters required',
                'controller' => 'Legacy implementation',
                'view' => 'includes/shortcodes/outstanding-deliveries-shortcode.php',
                'url_params' => false,
                'shortcode_attrs' => false
            ],
            
            // Utility Shortcodes
            [
                'name' => 'wecoza_dynamic_table',
                'category' => 'Utilities',
                'description' => 'Creates dynamic data tables with various configuration options',
                'usage' => '[wecoza_dynamic_table]',
                'parameters' => 'Various table configuration parameters',
                'controller' => 'Legacy implementation',
                'view' => 'includes/shortcodes/datatable.php',
                'url_params' => false,
                'shortcode_attrs' => true
            ],
            
            // Meta Shortcodes
            [
                'name' => 'wecoza_shortcode_list',
                'category' => 'Documentation',
                'description' => 'Displays this comprehensive list of all available WeCoza shortcodes',
                'usage' => '[wecoza_shortcode_list]',
                'parameters' => 'show_loading, category (future enhancement)',
                'controller' => 'ShortcodeListController',
                'view' => 'components/shortcode-list.view.php',
                'url_params' => false,
                'shortcode_attrs' => true
            ]
        ];
    }

    /**
     * Render a view file with data
     * 
     * @param string $view_name View file name (without .view.php extension)
     * @param array $data Data to pass to the view
     * @return string Rendered HTML
     */
    private function renderView($view_name, $data = []) {
        // Extract data for use in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $view_file = WECOZA_CHILD_DIR . '/app/Views/' . $view_name . '.view.php';
        
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            echo '<div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> View file not found: ' . esc_html($view_name) . '
                  </div>';
        }
        
        // Return the buffered content
        return ob_get_clean();
    }
}
