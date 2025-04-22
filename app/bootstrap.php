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

    // Make sure view helpers are available
    $helpers_loader = WECOZA_APP_PATH . '/Helpers/view-helpers-loader.php';
    if (file_exists($helpers_loader)) {
        require_once $helpers_loader;
    }

    // Include view file
    include $path;

    // Return buffered content
    return ob_get_clean();
}

/**
 * Load view helpers
 */
function load_view_helpers() {
    // Include the view helpers loader
    require_once WECOZA_APP_PATH . '/Helpers/view-helpers-loader.php';
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

    // Load AJAX handlers
    require_once WECOZA_APP_PATH . '/ajax-handlers.php';
}

// Initialize the application
init();
