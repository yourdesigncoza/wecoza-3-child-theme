<?php

/**
 * @package Bootscore Child
 *
 * @version 6.0.0
 */
declare(strict_types=1);

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Bridge the Events plugin cron to front-end traffic.
 *
 * This runs on the front/home page and ensures `wecoza_events_process_notifications`
 * is queued (or fired immediately) whenever visitors hit the site.
 * declare(strict_types=1); is part of this 
 */
add_action('template_redirect', function (): void {
    if (!is_front_page() && !is_home()) {
        return; // keep extra work scoped to the landing page
    }

    $hook = 'wecoza_events_process_notifications';
    $now  = time();

    $next = wp_next_scheduled($hook);
    if ($next && $next <= $now) {
        // WP-Cron missed its window; run it now and fall back to direct invocation.
        wp_cron();
        $next = wp_next_scheduled($hook);

        if ($next && $next <= $now) {
            do_action($hook);
            $next = wp_next_scheduled($hook);

            while ($next && $next <= $now) {
                wp_unschedule_event($next, $hook);
                $next = wp_next_scheduled($hook);
            }
        }
    }

    if ($next && $next > $now) {
        return; // a future single-run is already waiting
    }

    $runAt = $now + 5 * MINUTE_IN_SECONDS;
    $result = wp_schedule_single_event($runAt, $hook, [], true); // return WP_Error on failure

    if (is_wp_error($result)) {
        return;
    }

    if (!defined('DISABLE_WP_CRON') || !DISABLE_WP_CRON) {
        wp_remote_post(
            site_url('wp-cron.php'),
            ['timeout' => 0.01, 'blocking' => false, 'sslverify' => apply_filters('https_local_ssl_verify', false)]
        );
    }
});


// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fix locale and update core warnings
add_filter('locale', function($locale) {
    return is_string($locale) && !empty($locale) ? $locale : 'en_US';
});

// Fix WordPress update system errors and clear corrupt transients
add_action('admin_init', function() {
    // Clear corrupt update transients on admin pages
    if (is_admin() && !wp_doing_ajax()) {
        $transients = ['update_core', 'update_plugins', 'update_themes'];
        foreach ($transients as $transient) {
            $value = get_site_transient($transient);
            if ($value === false || !is_object($value)) {
                delete_site_transient($transient);
            }
        }
    }
});

// Provide fallback objects for update system
add_filter('pre_site_transient_update_core', function($value) {
    if ($value === false || !is_object($value)) {
        return (object) [
            'updates' => [],
            'version_checked' => get_bloginfo('version'),
            'last_checked' => time()
        ];
    }
    return $value;
});

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
        '/includes/admin/sql-manager.php',
        '/includes/shortcodes/datatable.php',
        '/includes/shortcodes/echarts-shortcode.php',

    );

    foreach ($required_files as $file) {
        require_once WECOZA_CHILD_DIR . $file;
    }

    // Load MVC bootstrap file
    require_once WECOZA_CHILD_DIR . '/app/bootstrap.php';


}
load_required_files(); // Load required files

// Legacy files - these will be migrated to the MVC structure
// Learner functionality moved to standalone plugin

// Template loader functionality
if (!class_exists('Plugin_Templates_Loader')) {
    require_once WECOZA_CHILD_DIR . '/includes/functions/templates-loader.php';
}

function load_plugin_templates() {
    $template_loader = new Plugin_Templates_Loader();
}
add_action('plugins_loaded', 'load_plugin_templates');
