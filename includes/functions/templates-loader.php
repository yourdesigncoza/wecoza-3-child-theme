<?php

class Plugin_Templates_Loader {
    
    private $templates_dir;
    
    public function __construct() {
        $this->templates_dir = plugin_dir_path(__FILE__) . '../../templates/';
        add_filter('theme_page_templates', array($this, 'register_plugin_templates'));
        add_filter('template_include', array($this, 'add_template_filter'));
    }
    
    private function load_plugin_templates () {
        $templates = array();  // Initialize templates array
        $template_dir = $this->templates_dir;

        // Reads all templates from the folder
        if (is_dir($template_dir)) {
            if ($dh = opendir($template_dir)) {
                while (($file = readdir($dh)) !== false) {
                    $full_path = $template_dir . $file;

                    if (filetype($full_path) == 'dir') {
                        continue;
                    }

                    // Gets Template Name from the file
                    $filedata = get_file_data($full_path, array(
                        'Template Name' => 'Template Name',
                    ));

                    $template_name = $filedata['Template Name'];

                    if ($template_name) {
                        $templates[$full_path] = $template_name;
                    }
                }
                closedir($dh);
            }
        }
        return $templates;
    }

    public function register_plugin_templates($theme_templates) {
        // Merging the WP templates with this plugin's active templates
        $plugin_templates = $this->load_plugin_templates();
        $theme_templates = array_merge($theme_templates, $plugin_templates);
        
        return $theme_templates;
    }

    public function add_template_filter($template) {
        global $post;
        
        $user_selected_template = get_page_template_slug($post->ID);

        // We need to check if the selected template is inside the plugin folder
        $file_name = pathinfo($user_selected_template, PATHINFO_BASENAME);
        $template_dir = $this->templates_dir;

        if (file_exists($template_dir . $file_name)) {
            $template = $template_dir . $file_name;
        }

        return $template;
    }
}
