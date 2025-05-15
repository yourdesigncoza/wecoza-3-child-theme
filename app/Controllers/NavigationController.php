<?php
/**
 * NavigationController.php
 *
 * Controller for handling navigation-related operations
 */

namespace WeCoza\Controllers;

use WeCoza\Walkers\Bootstrap_Sidebar_Walker;

class NavigationController {
    /**
     * Constructor
     */
    public function __construct() {
        // Register WordPress hooks
        \add_action('after_setup_theme', [$this, 'registerMenus']);
        \add_action('init', [$this, 'registerShortcodes']);

        // Create a sample menu if it doesn't exist
        \add_action('after_switch_theme', [$this, 'createSampleMenu']);
    }

    /**
     * Register navigation menus
     */
    public function registerMenus() {
        \register_nav_menus([
            'sidebar-menu' => \__('Sidebar Menu', 'wecoza')
        ]);
    }

    /**
     * Register navigation-related shortcodes
     */
    public function registerShortcodes() {
        \add_shortcode('wecoza_sidebar_menu', [$this, 'renderSidebarMenu']);
    }

    /**
     * Create a sample menu for the sidebar
     */
    public function createSampleMenu() {
        // Check if the menu already exists
        $menu_name = 'Sidebar Menu';
        $menu_exists = \wp_get_nav_menu_object($menu_name);

        if (!$menu_exists) {
            // Create the menu
            $menu_id = \wp_create_nav_menu($menu_name);

            // Add menu items
            \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'Dashboard',
                'menu-item-url' => \home_url('/'),
                'menu-item-status' => 'publish'
            ]);

            // Add a menu item with a submenu
            $parent_id = \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'Class Management',
                'menu-item-url' => '#',
                'menu-item-status' => 'publish'
            ]);

            // Add submenu items
            \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'Create Class',
                'menu-item-url' => \home_url('/create-class/'),
                'menu-item-parent-id' => $parent_id,
                'menu-item-status' => 'publish'
            ]);

            \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'All Classes',
                'menu-item-url' => \home_url('/all-classes/'),
                'menu-item-parent-id' => $parent_id,
                'menu-item-status' => 'publish'
            ]);

            // Add more menu items
            \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'Learners',
                'menu-item-url' => \home_url('/learners/'),
                'menu-item-status' => 'publish'
            ]);

            \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'Agents',
                'menu-item-url' => \home_url('/agents/'),
                'menu-item-status' => 'publish'
            ]);

            \wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => 'Clients',
                'menu-item-url' => \home_url('/clients/'),
                'menu-item-status' => 'publish'
            ]);

            // Assign the menu to the sidebar-menu location
            $locations = \get_theme_mod('nav_menu_locations');
            $locations['sidebar-menu'] = $menu_id;
            \set_theme_mod('nav_menu_locations', $locations);
        }
    }

    /**
     * Render the sidebar menu
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function renderSidebarMenu($atts = []) {
        // Parse attributes
        $atts = \shortcode_atts([
            'container_class' => 'sidebar-nav',
            'menu_class' => 'nav flex-column',
            'fallback_cb' => false
        ], $atts);

        // Start output buffering
        ob_start();

        // Check if the sidebar menu exists
        if (\has_nav_menu('sidebar-menu')) {
            // Render the menu
            \wp_nav_menu([
                'theme_location' => 'sidebar-menu',
                'container' => 'nav',
                'container_class' => $atts['container_class'],
                'menu_class' => $atts['menu_class'],
                'fallback_cb' => $atts['fallback_cb'],
                'walker' => new Bootstrap_Sidebar_Walker()
            ]);
        } else {
            // Display a message if the menu doesn't exist
            echo '<div class="alert alert-info">Please create a menu and assign it to the "Sidebar Menu" location.</div>';
        }

        // Return the buffered content
        return ob_get_clean();
    }

    /**
     * Render the sidebar menu directly (not as a shortcode)
     *
     * @param array $args Menu arguments
     * @return string HTML output
     */
    public static function getSidebarMenu($args = []) {
        // Default arguments
        $default_args = [
            'theme_location' => 'sidebar-menu',
            'container' => 'nav',
            'container_class' => 'sidebar-nav',
            'menu_class' => 'nav flex-column',
            'fallback_cb' => false,
            'walker' => new Bootstrap_Sidebar_Walker(),
            'echo' => false
        ];

        // Merge default arguments with provided arguments
        $args = \wp_parse_args($args, $default_args);

        // Return the menu
        return \wp_nav_menu($args);
    }
}
