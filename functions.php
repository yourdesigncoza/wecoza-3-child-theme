<?php

/**
 * @package Bootscore Child
 *
 * @version 6.0.0
 */
declare(strict_types=1);

// Exit if accessed directly
defined('ABSPATH') || exit;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



/**
 * WP-Cron Configuration Note:
 *
 * The previous homepage cron logic was removed due to performance issues:
 * - Caused "thundering herd" problem with DB writes on every homepage load
 * - Self-DDoS risk from wp_remote_post() loopback requests
 *
 * Proper setup for wecoza_events_process_notifications:
 * 1. Add to wp-config.php: define('DISABLE_WP_CRON', true);
 * 2. Add server crontab: * /5 * * * * wget -q -O - https://site.com/wp-cron.php >/dev/null 2>&1
 * 3. Register the cron event once on theme activation, not every page load.
 *
 * @see docs/performance-review-2026-02-01.md for details.
 */

// Fix locale and update core warnings
add_filter('locale', function($locale) {
    return is_string($locale) && !empty($locale) ? $locale : 'en_US';
});

/**
 * Admin transient cleanup removed for performance.
 *
 * The previous code ran on every admin page load and forced WordPress
 * to re-fetch updates from wordpress.org API, causing unnecessary
 * HTTP requests and slowdowns.
 *
 * If you need to debug update issues, use WP-CLI:
 *   wp transient delete update_core --network
 *   wp transient delete update_plugins --network
 *   wp transient delete update_themes --network
 *
 * @see docs/performance-review-2026-02-01.md
 */

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

// Define theme constants.
// WECOZA_THEME_VERSION: Bump this when CSS/JS changes to bust browser cache.
define('WECOZA_THEME_VERSION', '6.0.3');
define('WECOZA_PLUGIN_VERSION', WECOZA_THEME_VERSION); // Alias for backward compatibility.
define('WECOZA_CHILD_DIR', get_stylesheet_directory());
define('WECOZA_CHILD_URL', get_stylesheet_directory_uri());

/**
 * Enqueue assets with conditional loading and defer/async strategies.
 *
 * Heavy libraries (Chart.js, Select2) are only loaded on pages that need them.
 * Scripts use 'defer' strategy to avoid blocking page render (WP 6.3+).
 *
 * @see docs/performance-review-2026-02-01.md
 */
function enqueue_assets() {
    // Global CSS - always needed.
    wp_enqueue_style('ydcoza-bootstrap-demo', WECOZA_CHILD_URL . '/includes/css/ydcoza-bootstrap-demo.css', array('main'), WECOZA_PLUGIN_VERSION);
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css', array('ydcoza-bootstrap-demo'), '1.11.3');
    wp_enqueue_style('font-awesome-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array('ydcoza-bootstrap-demo'), '6.5.1');
    wp_enqueue_style('ydcoza_theme-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-theme.css', array('ydcoza-bootstrap-demo'), WECOZA_PLUGIN_VERSION);

    // Helper to check if current page needs form components (Select2, etc.).
    $needs_forms = wecoza_page_needs_forms();

    // Helper to check if current page needs charts.
    $needs_charts = wecoza_page_needs_charts();

    // Select2 - only on pages with forms/dropdowns (deferred loading).
    if ( $needs_forms ) {
        wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0');
        wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), WECOZA_PLUGIN_VERSION, array('in_footer' => true, 'strategy' => 'defer'));
    }

    // Chart.js - only on dashboard/reports pages (deferred loading).
    if ( $needs_charts ) {
        wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array('jquery'), WECOZA_PLUGIN_VERSION, array('in_footer' => true, 'strategy' => 'defer'));
    }

    // Popper - only when needed for tooltips/popovers (deferred loading).
    if ( $needs_forms || $needs_charts ) {
        wp_enqueue_script('popper2-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js', array('jquery'), WECOZA_PLUGIN_VERSION, array('in_footer' => true, 'strategy' => 'defer'));
    }

    // Gradio - only on all-learners-table page (deferred loading).
    if ( is_page('all-learners-table') ) {
        wp_enqueue_script('gradio-script', 'https://gradio.s3-us-west-2.amazonaws.com/4.40.0/gradio.js', array(), WECOZA_PLUGIN_VERSION, array('in_footer' => true, 'strategy' => 'defer'));
    }

    // GMP autocomplete - loaded in head for early availability.
    wp_enqueue_script(
        'wecoza-gmp-autocomplete-style',
        WECOZA_CHILD_URL . '/includes/js/gmp-autocomplete-style.js',
        array(),
        WECOZA_PLUGIN_VERSION,
        array('in_footer' => false, 'strategy' => 'defer')
    );

    // Custom scripts with localization.
    wp_localize_script('wecoza-table-handler', 'wecoza_table_ajax', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('wecoza_table_nonce')));
    wp_localize_script('jquery', 'wecoza_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_assets');

/**
 * Check if current page needs form components (Select2, etc.).
 *
 * @return bool True if page needs form assets.
 */
function wecoza_page_needs_forms(): bool {
    // Dashboard and admin-like pages.
    if ( is_page(['dashboard', 'learners', 'agents', 'clients', 'classes', 'assessments', 'contact']) ) {
        return true;
    }

    // Pages with forms in their templates.
    if ( is_page_template(['templates/dashboard-template.php', 'templates/learner-form.php']) ) {
        return true;
    }

    // Check for form shortcodes in content.
    global $post;
    if ( $post && ( has_shortcode($post->post_content, 'wecoza_form') || has_shortcode($post->post_content, 'contact-form-7') ) ) {
        return true;
    }

    return false;
}

/**
 * Check if current page needs chart components.
 *
 * @return bool True if page needs chart assets.
 */
function wecoza_page_needs_charts(): bool {
    // Dashboard and reports pages.
    if ( is_page(['dashboard', 'reports', 'analytics', 'statistics']) ) {
        return true;
    }

    // Dashboard template.
    if ( is_page_template('templates/dashboard-template.php') ) {
        return true;
    }

    // Check for chart shortcodes.
    global $post;
    if ( $post && has_shortcode($post->post_content, 'wecoza_chart') ) {
        return true;
    }

    return false;
}

/**
 * Ensure child ydcoza-style.css loads last and app.js uses defer strategy.
 */
function ydcoza_load_child_style_last() {
    // YDCOZA Styles
    wp_enqueue_style('ydcoza_styles-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-styles.css', array(), WECOZA_PLUGIN_VERSION);
    // app - deferred to avoid blocking render
    wp_enqueue_script('wecoza-table-handler', WECOZA_CHILD_URL . '/includes/js/app.js', array('jquery'), WECOZA_PLUGIN_VERSION, array('in_footer' => true, 'strategy' => 'defer'));
}
// Run at priority 99 so it fires after most other enqueue calls:
add_action( 'wp_enqueue_scripts', 'ydcoza_load_child_style_last', 99 );


/**
 * Add resource hints (preconnect/dns-prefetch) for external CDNs.
 *
 * Preconnect establishes early connections to important third-party origins,
 * reducing latency when resources are requested.
 */
function ydcoza_add_resource_hints() {
    // CDNs used by the theme - preconnect for faster resource loading.
    $preconnect_origins = array(
        'https://cdn.jsdelivr.net',      // Bootstrap Icons, Select2, Chart.js, Popper
        'https://cdnjs.cloudflare.com',  // FontAwesome
    );

    foreach ( $preconnect_origins as $origin ) {
        printf(
            '<link rel="preconnect" href="%s" crossorigin>' . "\n",
            esc_url( $origin )
        );
    }

    // DNS prefetch for less critical origins.
    $dns_prefetch_origins = array(
        '//fonts.googleapis.com',
        '//fonts.gstatic.com',
    );

    foreach ( $dns_prefetch_origins as $origin ) {
        printf(
            '<link rel="dns-prefetch" href="%s">' . "\n",
            esc_attr( $origin )
        );
    }
}
add_action( 'wp_head', 'ydcoza_add_resource_hints', 1 ); // Priority 1 for early placement.

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
        //'/includes/functions/echarts-functions.php',
        //'/includes/admin/sql-manager.php',
        //'/includes/shortcodes/datatable.php',
        //'/includes/shortcodes/echarts-shortcode.php',

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
