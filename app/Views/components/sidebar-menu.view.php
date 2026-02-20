<?php
/**
 * Sidebar Menu View
 *
 * This view displays the sidebar navigation menu using the Bootstrap_Sidebar_Walker
 *
 * @package WeCoza
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

use WeCoza\Walkers\Bootstrap_Sidebar_Walker;
?>

<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content">
            <?php
            // Check if the sidebar menu exists
            if (has_nav_menu('sidebar-menu')) {
                // Render the menu
                wp_nav_menu([
                    'theme_location' => 'sidebar-menu',
                    'container' => false,
                    'menu_class' => 'navbar-nav flex-column',
                    'fallback_cb' => false,
                    'walker' => new Bootstrap_Sidebar_Walker()
                ]);
            } else {
                // Display a message if the menu doesn't exist
                echo '<div class="alert alert-info">Please create a menu and assign it to the "Sidebar Menu" location.</div>';
            }
            ?>
        </div>
    </div>
    <div class="navbar-vertical-footer">
      
      <div class="support-chat-container show">
        <div class="container-fluid support-chat d-none"></div>
        <button type="button"
                class="btn btn-support-chat p-0 border border-translucent"
                id="wecoza-feedback-fab"
                title="Send Feedback">
          <span class="fs-8 btn-text text-primary text-nowrap">&#x1F41E; Feedback</span>
          <span class="ping-icon-wrapper mt-n4 ms-n6 mt-sm-0 ms-sm-2 position-absolute position-sm-relative">
            <span class="ping-icon-bg"></span>
            <span class="fa-solid fa-circle ping-icon"></span>
          </span>
          <span class="fa-solid fa-bug text-primary fs-8 d-sm-none"></span>
        </button>
      </div>
    </div>
</nav>