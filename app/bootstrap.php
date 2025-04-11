<?php
/**
 * Bootstrap file for WeCoza 3 Child Theme
 *
 * This file initializes the MVC structure and loads all necessary components
 */

namespace WeCoza;

// Define constants
define('WECOZA_PATH', dirname(__DIR__));
define('WECOZA_APP_PATH', WECOZA_PATH . '/app');
define('WECOZA_CONFIG_PATH', WECOZA_PATH . '/config');
define('WECOZA_PUBLIC_PATH', WECOZA_PATH . '/public');
define('WECOZA_VIEWS_PATH', WECOZA_APP_PATH . '/Views');

/**
 * Autoloader function
 */
spl_autoload_register(function ($class) {
    // Only handle our namespace
    if (strpos($class, 'WeCoza\\') !== 0) {
        return;
    }

    // Convert namespace to path
    $class = str_replace('WeCoza\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $path = WECOZA_APP_PATH . '/' . $class . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
});

/**
 * Load configuration
 *
 * @param string $name Config name
 * @return array
 */
function config($name) {
    $path = WECOZA_CONFIG_PATH . '/' . $name . '.php';
    if (file_exists($path)) {
        return require $path;
    }
    return [];
}

/**
 * Load view
 *
 * @param string $name View name
 * @param array $data Data to pass to view
 * @return string
 */
function view($name, $data = []) {
    $path = WECOZA_VIEWS_PATH . '/' . $name . '.view.php';
    if (!file_exists($path)) {
        return 'View not found: ' . $name;
    }

    // Start output buffering
    ob_start();

    // Extract data to make variables available in view
    extract($data);

    // Include view file
    include $path;

    // Return buffered content
    return ob_get_clean();
}

/**
 * Load view helpers
 */
function load_view_helpers() {
    // Include the view helpers file
    require_once WECOZA_APP_PATH . '/Helpers/ViewHelpers.php';

    // Create function aliases in the global namespace
    if (!function_exists('select_dropdown')) {
        function select_dropdown($name, $options, $attributes = [], $selected = '', $empty_label = 'Select') {
            return \WeCoza\Helpers\select_dropdown($name, $options, $attributes, $selected, $empty_label);
        }
    }

    if (!function_exists('select_dropdown_with_optgroups')) {
        function select_dropdown_with_optgroups($name, $optgroups, $attributes = [], $selected = '', $empty_label = 'Select') {
            return \WeCoza\Helpers\select_dropdown_with_optgroups($name, $optgroups, $attributes, $selected, $empty_label);
        }
    }

    if (!function_exists('form_input')) {
        function form_input($type, $name, $label, $attributes = [], $value = '', $required = false, $invalid_feedback = 'Please fill out this field.', $valid_feedback = 'Looks good!') {
            return \WeCoza\Helpers\form_input($type, $name, $label, $attributes, $value, $required, $invalid_feedback, $valid_feedback);
        }
    }

    if (!function_exists('form_textarea')) {
        function form_textarea($name, $label, $attributes = [], $value = '', $required = false, $invalid_feedback = 'Please fill out this field.', $valid_feedback = 'Looks good!') {
            return \WeCoza\Helpers\form_textarea($name, $label, $attributes, $value, $required, $invalid_feedback, $valid_feedback);
        }
    }

    if (!function_exists('form_group')) {
        function form_group($type, $name, $label, $col_class = 'col-md-4', $attributes = [], $value = '', $required = false, $invalid_feedback = 'Please fill out this field.', $valid_feedback = 'Looks good!') {
            return \WeCoza\Helpers\form_group($type, $name, $label, $col_class, $attributes, $value, $required, $invalid_feedback, $valid_feedback);
        }
    }

    if (!function_exists('form_row')) {
        function form_row($fields) {
            return \WeCoza\Helpers\form_row($fields);
        }
    }

    if (!function_exists('section_divider')) {
        function section_divider($classes = '') {
            return \WeCoza\Helpers\section_divider($classes);
        }
    }

    if (!function_exists('section_header')) {
        function section_header($title, $description = '', $title_tag = 'h5') {
            return \WeCoza\Helpers\section_header($title, $description, $title_tag);
        }
    }

    if (!function_exists('button')) {
        function button($text, $type = 'button', $style = 'primary', $attributes = []) {
            return \WeCoza\Helpers\button($text, $type, $style, $attributes);
        }
    }
}

/**
 * Initialize application
 */
function init() {
    // Load configuration
    $config = config('app');

    // Load view helpers
    load_view_helpers();

    // Initialize controllers
    if (isset($config['controllers']) && is_array($config['controllers'])) {
        foreach ($config['controllers'] as $controller) {
            if (class_exists($controller)) {
                new $controller();
            }
        }
    }

    // Add AJAX handlers
    add_action('wp_ajax_wecoza_save_learner', 'WeCoza\\Controllers\\LearnerController::saveAjax');
    add_action('wp_ajax_nopriv_wecoza_save_learner', 'WeCoza\\Controllers\\LearnerController::saveAjax');

    // Class AJAX handlers
    add_action('wp_ajax_save_class', 'WeCoza\\Controllers\\ClassController::saveClassAjax');
    add_action('wp_ajax_nopriv_save_class', 'WeCoza\\Controllers\\ClassController::saveClassAjax');
}

// Initialize the application
init();
