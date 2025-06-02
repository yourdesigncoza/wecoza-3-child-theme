<?php

/**
 * @package Bootscore Child
 *
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define plugin constants
$rand = rand();
define('WECOZA_PLUGIN_VERSION', $rand);
define('WECOZA_CHILD_DIR', get_stylesheet_directory(__FILE__));
define('WECOZA_CHILD_URL', get_stylesheet_directory_uri(__FILE__));

/**
 * Enqueue all necessary GLOBAL assets
 */
function enqueue_assets() {
    // style.css
    // wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('ydcoza-bootstrap-demo', WECOZA_CHILD_URL . '/includes/css/ydcoza-bootstrap-demo.css', array('main'), WECOZA_PLUGIN_VERSION);
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css', array('ydcoza-bootstrap-demo'), WECOZA_PLUGIN_VERSION);

    // Theme styles - load after Parent
    wp_enqueue_style('ydcoza_theme-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-theme.css', array('ydcoza-bootstrap-demo'), WECOZA_PLUGIN_VERSION);

    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array('jquery'), '4.1.0-rc.0');


    // JS
    // Check if we are on a specific page
    if (is_page('all-learners-table')) {
        wp_enqueue_script('gradio-script', 'https://gradio.s3-us-west-2.amazonaws.com/4.40.0/gradio.js', array(), WECOZA_PLUGIN_VERSION, true);
    }
    // Enqueue Select2 JS
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0-rc.0', true);
    // Chart .js
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array('jquery'), null, true);
    // popper
    wp_enqueue_script('popper2-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js', array('jquery'), null, true);
    // bootstrap Loaded in Parent theme no need to load again
    // wp_enqueue_script('bootstrap-5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

    // Custom scripts with localization
    wp_localize_script('wecoza-table-handler', 'wecoza_table_ajax', array('ajax_url' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('wecoza_table_nonce') ));
    // Localize AJAX URL for all scripts
    wp_localize_script('jquery', 'wecoza_ajax', array('ajax_url' => admin_url('admin-ajax.php')));


}
add_action('wp_enqueue_scripts', 'enqueue_assets'); // Enqueue assets

/**
 * Ensure child ydcoza-style.css loads last
 */
function ydcoza_load_child_style_last() {
    // YDCOZA Styles
    wp_enqueue_style('ydcoza_styles-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-styles.css', array(), WECOZA_PLUGIN_VERSION);
    // app
    wp_enqueue_script('wecoza-table-handler', WECOZA_CHILD_URL . '/includes/js/app.js', array('jquery'), WECOZA_PLUGIN_VERSION, true);
}
// Run at priority 99 so it fires after most other enqueue calls:
add_action( 'wp_enqueue_scripts', 'ydcoza_load_child_style_last', 99 );


/**
 * Print inline theme-sniffer script before any CSS loads.
 */
function ydcoza_print_theme_sniffer() {
    ?>
    <script>
    (function(){
      var key = 'phoenixTheme';
      var stored = localStorage.getItem(key) || 'auto';
      var resolved = (stored === 'auto')
        ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
        : stored;
      document.documentElement.setAttribute('data-bs-theme', resolved);
    })();
    </script>
    <?php
}
add_action( 'wp_head', 'ydcoza_print_theme_sniffer', 1 );


/**
 * Remove FontAwesome stylesheet
 */

function ydcoza_remove_unwanted_styles() {
    // FontAwesome
    wp_dequeue_style( 'fontawesome' );
    wp_deregister_style( 'fontawesome' );

    // Bootscore
    wp_dequeue_style( 'bootscore-style' );
    wp_deregister_style( 'bootscore-style' );
}
add_action( 'wp_enqueue_scripts', 'ydcoza_remove_unwanted_styles', 20 );



/**
 * Load required PHP files
 */
function load_required_files() {
    $required_files = array(
        '/includes/functions/helper.php', // Add the new helper.php file
        '/includes/functions/show-hide-title.php',
        '/includes/functions/db.php',
        '/includes/functions/echarts-functions.php',
        '/includes/admin/settings.php',
        '/includes/admin/sql-manager.php',
        '/includes/shortcodes/datatable.php',
        '/includes/shortcodes/echarts-shortcode.php',
        '/includes/shortcodes/outstanding-deliveries-shortcode.php',
    );

    foreach ($required_files as $file) {
        require_once WECOZA_CHILD_DIR . $file;
    }

    // Load MVC bootstrap file
    require_once WECOZA_CHILD_DIR . '/app/bootstrap.php';

    // Run database migrations
    require_once WECOZA_CHILD_DIR . '/includes/db/migrations/add-class-subject-fields.php';
}
load_required_files(); // Load required files

// Legacy files - these will be migrated to the MVC structure
require_once WECOZA_CHILD_DIR . '/assets/learners/learners-function.php';
require_once WECOZA_CHILD_DIR . '/assets/agents/agents-functions.php';
require_once WECOZA_CHILD_DIR . '/assets/clients/clients-functions.php';

// Template loader functionality
if (!class_exists('Plugin_Templates_Loader')) {
    require_once WECOZA_CHILD_DIR . '/includes/functions/templates-loader.php';
}

function load_plugin_templates() {
    $template_loader = new Plugin_Templates_Loader();
}
add_action('plugins_loaded', 'load_plugin_templates');
