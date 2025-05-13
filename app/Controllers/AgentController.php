<?php
/**
 * AgentController.php
 * 
 * Controller for handling agent-related operations
 */

namespace WeCoza\Controllers;

class AgentController {
    /**
     * Constructor
     */
    public function __construct() {
        // Register WordPress hooks
        add_action('init', [$this, 'registerShortcodes']);
    }

    /**
     * Register all agent-related shortcodes
     */
    public function registerShortcodes() {
        add_shortcode('wecoza_agent_capture', [$this, 'captureAgent']);
        add_shortcode('wecoza_agent_display', [$this, 'displayAgent']);
    }

    /**
     * Handle agent capture shortcode
     * 
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function captureAgent($atts) {
        // Implementation will be added later
        return 'Agent capture form will be displayed here';
    }

    /**
     * Handle agent display shortcode
     * 
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function displayAgent($atts) {
        // Implementation will be added later
        return 'Agent information will be displayed here';
    }
}
