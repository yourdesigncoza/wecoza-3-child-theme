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
    // Learner AJAX handlers
    \add_action('wp_ajax_wecoza_save_learner', 'WeCoza\\Controllers\\LearnerController::saveAjax');
    \add_action('wp_ajax_nopriv_wecoza_save_learner', 'WeCoza\\Controllers\\LearnerController::saveAjax');

    // Class AJAX handlers
    \add_action('wp_ajax_save_class', 'WeCoza\\Controllers\\ClassController::saveClassAjax');
    \add_action('wp_ajax_nopriv_save_class', 'WeCoza\\Controllers\\ClassController::saveClassAjax');

    // Class conflicts AJAX handler
    \add_action('wp_ajax_check_class_conflicts', function() {
        $controller = new WeCoza\Controllers\ClassController();
        $controller->checkClassConflictsAjax();
    });
    \add_action('wp_ajax_nopriv_check_class_conflicts', function() {
        $controller = new WeCoza\Controllers\ClassController();
        $controller->checkClassConflictsAjax();
    });

    // Calendar export AJAX handler
    \add_action('wp_ajax_export_calendar', function() {
        $controller = new WeCoza\Controllers\ClassController();
        $controller->exportCalendarAjax();
    });
    \add_action('wp_ajax_nopriv_export_calendar', function() {
        $controller = new WeCoza\Controllers\ClassController();
        $controller->exportCalendarAjax();
    });

    // Class subjects AJAX handler
    \add_action('wp_ajax_get_class_subjects', function() {
        $controller = new WeCoza\Controllers\ClassController();
        $controller->getClassSubjectsAjax();
    });
    \add_action('wp_ajax_nopriv_get_class_subjects', function() {
        $controller = new WeCoza\Controllers\ClassController();
        $controller->getClassSubjectsAjax();
    });
    
    // Contact form AJAX handler
    \add_action('wp_ajax_wecoza_save_contact', 'WeCoza\\Controllers\\ContactController::saveContactAjax');
    \add_action('wp_ajax_nopriv_wecoza_save_contact', 'WeCoza\\Controllers\\ContactController::saveContactAjax');
}

// Register AJAX handlers
register_ajax_handlers();

/**
 * Register shortcodes
 */
function register_shortcodes() {
    // Class shortcodes
    $classController = new WeCoza\Controllers\ClassController();
    \add_shortcode('wecoza_capture_class', [$classController, 'captureClassShortcode']);
    \add_shortcode('wecoza_display_class', [$classController, 'displayClassShortcode']);
    
}

// Register shortcodes
\add_action('init', 'register_shortcodes');

/**
 * Enqueue assets
 */
function enqueue_class_assets() {
    // Class assets
    $classController = new WeCoza\Controllers\ClassController();
    $classController->enqueueAssets();
}

// Enqueue assets
\add_action('wp_enqueue_scripts', 'enqueue_class_assets');
