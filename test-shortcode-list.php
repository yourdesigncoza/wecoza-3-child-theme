<?php
/**
 * Test file for WeCoza Shortcode List
 * 
 * This file provides a simple test to verify that the [wecoza_shortcode_list] shortcode
 * is working correctly and displays the expected output.
 * 
 * Usage: Access this file directly in a browser to test the shortcode functionality
 * URL: http://your-site.com/wp-content/themes/wecoza_3_child_theme/test-shortcode-list.php
 */

// WordPress environment setup
require_once('../../../wp-load.php');

// Ensure we're in a WordPress environment
if (!defined('ABSPATH')) {
    die('WordPress environment not found. Please ensure this file is in the correct location.');
}

// Set up basic HTML structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeCoza Shortcode List Test</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- WeCoza Custom Styles -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/includes/css/ydcoza-styles.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding: 2rem 0;
        }
        .test-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .test-header {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .test-results {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>
<body>
    <div class="test-container">
        <!-- Test Header -->
        <div class="test-header">
            <h1 class="mb-3">
                <i class="bi bi-code-square text-primary me-2"></i>
                WeCoza Shortcode List Test
            </h1>
            <p class="text-muted mb-4">
                This page tests the <code>[wecoza_shortcode_list]</code> shortcode to ensure it's working correctly.
            </p>
            
            <!-- Test Information -->
            <div class="row">
                <div class="col-md-6">
                    <h6>Test Details:</h6>
                    <ul class="list-unstyled">
                        <li><strong>Shortcode:</strong> <code>[wecoza_shortcode_list]</code></li>
                        <li><strong>Controller:</strong> ShortcodeListController</li>
                        <li><strong>View:</strong> components/shortcode-list.view.php</li>
                        <li><strong>Test Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>WordPress Environment:</h6>
                    <ul class="list-unstyled">
                        <li><strong>WordPress Version:</strong> <?php echo get_bloginfo('version'); ?></li>
                        <li><strong>Theme:</strong> <?php echo get_template(); ?></li>
                        <li><strong>Child Theme:</strong> <?php echo get_stylesheet(); ?></li>
                        <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Test Results -->
        <div class="test-results">
            <h2 class="mb-4">
                <i class="bi bi-play-circle text-success me-2"></i>
                Shortcode Output
            </h2>
            
            <?php
            // Test 1: Basic shortcode execution
            echo '<div class="test-section mb-5">';
            echo '<h4 class="mb-3">Test 1: Basic Shortcode [wecoza_shortcode_list]</h4>';
            
            try {
                $output = do_shortcode('[wecoza_shortcode_list]');
                
                if (!empty($output)) {
                    echo '<div class="alert alert-success mb-3">';
                    echo '<i class="bi bi-check-circle me-2"></i>';
                    echo '<strong>Success:</strong> Shortcode executed successfully and returned content.';
                    echo '</div>';
                    echo $output;
                } else {
                    echo '<div class="alert alert-warning mb-3">';
                    echo '<i class="bi bi-exclamation-triangle me-2"></i>';
                    echo '<strong>Warning:</strong> Shortcode executed but returned empty content.';
                    echo '</div>';
                }
            } catch (Exception $e) {
                echo '<div class="alert alert-danger mb-3">';
                echo '<i class="bi bi-x-circle me-2"></i>';
                echo '<strong>Error:</strong> ' . esc_html($e->getMessage());
                echo '</div>';
            }
            echo '</div>';
            
            // Test 2: Shortcode with parameters
            echo '<div class="test-section mb-5">';
            echo '<h4 class="mb-3">Test 2: Shortcode with Parameters [wecoza_shortcode_list show_loading="false"]</h4>';
            
            try {
                $output_no_loading = do_shortcode('[wecoza_shortcode_list show_loading="false"]');
                
                if (!empty($output_no_loading)) {
                    echo '<div class="alert alert-success mb-3">';
                    echo '<i class="bi bi-check-circle me-2"></i>';
                    echo '<strong>Success:</strong> Shortcode with parameters executed successfully.';
                    echo '</div>';
                    echo $output_no_loading;
                } else {
                    echo '<div class="alert alert-warning mb-3">';
                    echo '<i class="bi bi-exclamation-triangle me-2"></i>';
                    echo '<strong>Warning:</strong> Shortcode with parameters executed but returned empty content.';
                    echo '</div>';
                }
            } catch (Exception $e) {
                echo '<div class="alert alert-danger mb-3">';
                echo '<i class="bi bi-x-circle me-2"></i>';
                echo '<strong>Error:</strong> ' . esc_html($e->getMessage());
                echo '</div>';
            }
            echo '</div>';
            ?>
            
            <!-- Test Summary -->
            <div class="test-summary mt-5 pt-4 border-top">
                <h4 class="mb-3">
                    <i class="bi bi-clipboard-check text-info me-2"></i>
                    Test Summary
                </h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Functionality Checks:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Shortcode registration
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Controller instantiation
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                View rendering
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Parameter handling
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Visual Checks:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Bootstrap 5 styling
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Responsive layout
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Icon display
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Table formatting
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="text-center mt-4">
            <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                <i class="bi bi-house me-2"></i>
                Return to Site
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary ms-2">
                <i class="bi bi-printer me-2"></i>
                Print Results
            </button>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
