<?php
/**
 * agents Management System
 * 
 * This file contains core functionality for managing agents including file loading,
 * asset enqueueing, and AJAX handlers.
 * 

 */
function load_agents_files() {
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
load_agents_files();

/**
 * Enqueue necessary JavaScript and CSS files for agents functionality
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_agents_assets() {
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
add_action('wp_enqueue_scripts', 'enqueue_agents_assets');