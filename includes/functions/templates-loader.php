<?php
/**
 * Plugin Templates Loader
 *
 * Allows loading custom page templates from the theme's templates directory.
 *
 * @package WeCoza_3_Child_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Handles loading of custom page templates from the theme.
 */
class Plugin_Templates_Loader {

    /**
     * Path to the templates directory.
     */
    private string $templates_dir;

    /**
     * Constructor: Register template filters.
     */
    public function __construct() {
        $this->templates_dir = plugin_dir_path( __FILE__ ) . '../../templates/';
        add_filter( 'theme_page_templates', [ $this, 'register_plugin_templates' ] );
        add_filter( 'template_include', [ $this, 'add_template_filter' ] );
    }

    /**
     * Load all templates from the templates directory.
     *
     * @return array<string,string> Map of template path => template name.
     */
    private function load_plugin_templates(): array {
        $templates    = [];
        $template_dir = $this->templates_dir;

        if ( ! is_dir( $template_dir ) ) {
            return $templates;
        }

        $handle = opendir( $template_dir );
        if ( ! $handle ) {
            return $templates;
        }

        while ( ( $file = readdir( $handle ) ) !== false ) {
            $full_path = $template_dir . $file;

            if ( filetype( $full_path ) === 'dir' ) {
                continue;
            }

            $filedata      = get_file_data( $full_path, [ 'Template Name' => 'Template Name' ] );
            $template_name = $filedata['Template Name'] ?? '';

            if ( $template_name ) {
                $templates[ $full_path ] = $template_name;
            }
        }

        closedir( $handle );

        return $templates;
    }

    /**
     * Register plugin templates with WordPress.
     *
     * @param array<string,string> $theme_templates Existing theme templates.
     * @return array<string,string> Merged templates.
     */
    public function register_plugin_templates( array $theme_templates ): array {
        $plugin_templates = $this->load_plugin_templates();
        return array_merge( $theme_templates, $plugin_templates );
    }

    /**
     * Filter template include to use plugin templates when selected.
     *
     * @param string $template Current template path.
     * @return string Template path to use.
     */
    public function add_template_filter( string $template ): string {
        global $post;

        // Guard against null post object (404, archive pages, etc.).
        if ( ! $post instanceof \WP_Post ) {
            return $template;
        }

        $user_selected_template = get_page_template_slug( $post->ID );

        if ( empty( $user_selected_template ) ) {
            return $template;
        }

        // Check if the selected template exists in the plugin folder.
        $file_name       = pathinfo( $user_selected_template, PATHINFO_BASENAME );
        $plugin_template = $this->templates_dir . $file_name;

        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }

        return $template;
    }
}
