<?php
/**
 * AJAX Handlers for WeCoza 3 Child Theme
 *
 * This file contains all AJAX handlers for the theme
 */

// Prevent direct access to this file
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Register AJAX handlers
 */
function register_ajax_handlers() {
    // Learner AJAX handlers moved to standalone plugin

    // Contact form AJAX handler
    \add_action('wp_ajax_wecoza_save_contact', 'WeCoza\\Controllers\\ContactController::saveContactAjax');
    \add_action('wp_ajax_nopriv_wecoza_save_contact', 'WeCoza\\Controllers\\ContactController::saveContactAjax');
}

// Register AJAX handlers
register_ajax_handlers();

