<?php
/**
 * Hide The Title - Meta box functionality.
 *
 * Allows hiding titles on individual posts/pages via a meta box checkbox.
 *
 * @package WeCoza_3_Child_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// ──────────────────────────────────────────────────────────────────────────────
// 1) Register a "Hide The Title" meta‐box for all public post types
// ──────────────────────────────────────────────────────────────────────────────
add_action( 'add_meta_boxes', function (): void {
    // Get every public post type (posts, pages, CPTs, etc.)
    $all_post_types = get_post_types(
        [ 'public' => true ],
        'names',
        'and'
    );

    foreach ($all_post_types as $pt) {
        add_meta_box(
            'hide_title_metabox',                   // Metabox ID
            __('Hide The Title', 'hide-titles'),    // Box title
            'hide_title_render_metabox',            // Callback to render
            $pt,                                     // Post type slug
            'side',                                  // Context (sidebar)
            'high'                                   // Priority
        );
    }
});

/**
 * Renders the checkbox inside the “Hide The Title” metabox.
 *
 * @param WP_Post $post
 */
function hide_title_render_metabox($post) {
    // Security nonce
    wp_nonce_field('hide_title_nonce_action', 'hide_title_nonce');

    // Get current saved value (if any)
    $hide = get_post_meta($post->ID, '_hide_title', true);
    ?>
    <p>
        <label for="hide_title_checkbox">
            <input
                type="checkbox"
                name="hide_title_checkbox"
                id="hide_title_checkbox"
                value="1" <?php checked( $hide, '1' ); ?> 
            />
            <?php esc_html_e('Hide The Title', 'hide-titles'); ?>
        </label>
    </p>
    <?php
}


// ──────────────────────────────────────────────────────────────────────────────
// 2) Save that checkbox value when the post is saved
// ──────────────────────────────────────────────────────────────────────────────
add_action('save_post', function($post_id) {
    // Check if our nonce is set
    if ( ! isset($_POST['hide_title_nonce']) ) {
        return;
    }
    // Verify the nonce is valid
    if ( ! wp_verify_nonce( $_POST['hide_title_nonce'], 'hide_title_nonce_action' ) ) {
        return;
    }
    // If this is an autosave, bail
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }
    // Check user permissions for this post type
    $post_type = get_post_type($post_id);
    if ('page' === $post_type) {
        if (! current_user_can('edit_page', $post_id) ) {
            return;
        }
    } else {
        if (! current_user_can('edit_post', $post_id) ) {
            return;
        }
    }

    // Save or delete the meta based on checkbox
    if ( isset($_POST['hide_title_checkbox']) && '1' === $_POST['hide_title_checkbox'] ) {
        update_post_meta($post_id, '_hide_title', '1');
    } else {
        delete_post_meta($post_id, '_hide_title');
    }
});


// ──────────────────────────────────────────────────────────────────────────────
// 3) Filter the_title() on the front end: return empty string if checkbox is set
// ──────────────────────────────────────────────────────────────────────────────
add_filter('the_title', function($title, $post_id) {
    // Only on front‐end, singular view, main loop
    if ( is_admin() ) {
        return $title;
    }
    if ( is_singular() && in_the_loop() && is_main_query() ) {
        $hide = get_post_meta($post_id, '_hide_title', true);
        if ('1' === $hide) {
            return '';
        }
    }
    return $title;
}, 10, 2);

// Also hook get_the_title() to cover themes that call it directly:
add_filter('get_the_title', function($title, $post_id) {
    if ( is_admin() ) {
        return $title;
    }
    if ( is_singular() && is_main_query() ) {
        $hide = get_post_meta($post_id, '_hide_title', true);
        if ('1' === $hide) {
            return '';
        }
    }
    return $title;
}, 10, 2);
