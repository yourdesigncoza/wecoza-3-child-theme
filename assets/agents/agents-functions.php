<?php
/**
 * agents Management System
 * 
 * This file contains core functionality for managing agents including file loading,
 * asset enqueueing, and AJAX handlers.
 * 
 * @deprecated 1.0.0 This functionality has been moved to the WeCoza Agents Plugin.
 *                   These functions will be removed in a future version.

 */

// Add deprecation notice
if (!defined('WECOZA_AGENTS_PLUGIN_MIGRATION_NOTICE_SHOWN')) {
    define('WECOZA_AGENTS_PLUGIN_MIGRATION_NOTICE_SHOWN', true);
    if (WP_DEBUG) {
        error_log('[WeCoza Agents] DEPRECATED: agents-functions.php is deprecated. Agent functionality has been moved to the WeCoza Agents Plugin.');
    }
}

/**
 * @deprecated 1.0.0 Use WeCoza Agents Plugin which auto-loads all required files
 */
function load_agents_files() {
    _deprecated_function(__FUNCTION__, '1.0.0', 'WeCoza Agents Plugin auto-loads all files');
    
    // Only load if plugin is not active
    if (!defined('WECOZA_AGENTS_VERSION')) {
        // Define array of required files
        $required_files = array(
            '/assets/agents/agents-capture-shortcode.php',
            '/assets/agents/agents-display-shortcode.php'
        );

        // Load each required file
        foreach ($required_files as $file) {
            $file_path = WECOZA_CHILD_DIR . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            } else {
                error_log("Required file not found: {$file_path}");
            }
        }
    }
}
load_agents_files();

/**
 * Enqueue necessary JavaScript and CSS files for agents functionality
 *
 * @since 1.0.0
 * @deprecated 1.0.0 Use WeCoza Agents Plugin which handles asset loading automatically
 * @return void
 */
function enqueue_agents_assets() {
    _deprecated_function(__FUNCTION__, '1.0.0', 'WeCoza Agents Plugin handles asset loading automatically');
    
    // Only enqueue if plugin is not active
    if (!defined('WECOZA_AGENTS_VERSION')) {
        // Enqueue main agents JavaScript file
        wp_enqueue_script(
            'agents-app', 
            WECOZA_CHILD_URL . '/assets/agents/js/agents-app.js', 
            array('jquery'), 
            WECOZA_PLUGIN_VERSION, 
            true
        );

        // Get WordPress uploads directory information
        $uploads_dir = wp_upload_dir();

        // Localize script with necessary data
        wp_localize_script('agents-app', 'agents_nonce', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('agents_nonce'),
            'uploads_url' => $uploads_dir['baseurl'],
            'is_admin' => current_user_can('manage_options')
        ));
    }
}
// Only add action if plugin is not active
if (!defined('WECOZA_AGENTS_VERSION')) {
    add_action('wp_enqueue_scripts', 'enqueue_agents_assets');
}