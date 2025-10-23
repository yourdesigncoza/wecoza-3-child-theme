<?php
/**
 * Helper Functions for WeCoza 3 Child Theme
 *
 * This file contains utility functions used throughout the theme.
 *
 * @package WeCoza_3_Child_Theme
 * @version 1.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Output Google Fonts preconnect and stylesheet tags.
 */
function ydcoza_google_fonts_links() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <?php
}
add_action( 'wp_head', 'ydcoza_google_fonts_links' );

/**
 * Modify script tag for Gradio to use type="module"
 */
function add_type_module_to_gradio_script($tag, $handle, $src) {
    if ('gradio-script' === $handle) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_type_module_to_gradio_script', 10, 3);

/**
 * AJAX handler for dynamic table data
 */
function fetch_dynamic_table_data() {
    $sql_id = intval($_POST['sql_id']);
    if (!$sql_id) {
        wp_send_json_error('Invalid SQL ID.');
        return;
    }

    $query_data = Wecoza3_Logger::get_query_by_id($sql_id);
    if (!$query_data) {
        wp_send_json_error('SQL query not found.');
        return;
    }

    try {
        $db = new Wecoza3_DB();
        $pdo = $db->get_pdo();
        $stmt = $pdo->query($query_data->sql_query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            wp_send_json_error('No data found.');
            return;
        }

        // Generate table rows
        $rows = '';
        foreach ($results as $row) {
            $rows .= '<tr>';
            foreach ($row as $column_value) {
                $rows .= '<td>' . esc_html($column_value) . '</td>';
            }
            $rows .= '</tr>';
        }

        wp_send_json_success($rows);
    } catch (Exception $e) {
        wp_send_json_error('Error fetching data: ' . $e->getMessage());
    }
}
add_action('wp_ajax_fetch_dynamic_table_data', 'fetch_dynamic_table_data');
add_action('wp_ajax_nopriv_fetch_dynamic_table_data', 'fetch_dynamic_table_data');

/**
 * Add theme‐toggle switch to end of Primary menu
 */
function add_theme_toggle_nav_item( $items, $args ) {
    // change 'primary' to your menu's theme_location if different
    if ( isset($args->theme_location) && $args->theme_location === 'main-menu' ) {
        $items .= '
            <li class="nav-item">
              <div class="theme-control-toggle fa-icon-wait px-2">
                <input
                  class="form-check-input ms-0 theme-control-toggle-input"
                  type="checkbox"
                  data-theme-control="phoenixTheme"
                  value="dark"
                  id="themeControlToggle"
                >
                <label
                  class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                  for="themeControlToggle"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  data-bs-title="Switch theme"
                  style="height:32px;width:32px;"
                >
                  <svg xmlns="http://www.w3.org/2000/svg"
                       width="16px" height="16px"
                       viewBox="0 0 24 24"
                       fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round"
                       class="feather feather-moon icon"
                  >
                    <path d="M21 12.79A9 9 0 1 1 11.21 3
                             7 7 0 0 0 21 12.79z" />
                  </svg>
                </label>
                <label
                  class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                  for="themeControlToggle"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  data-bs-title="Switch theme"
                  style="height:32px;width:32px;"
                >
                  <svg xmlns="http://www.w3.org/2000/svg"
                       width="16px" height="16px"
                       viewBox="0 0 24 24"
                       fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round"
                       class="feather feather-sun icon"
                  >
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                  </svg>
                </label>
              </div>
            </li>
        ';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_theme_toggle_nav_item', 10, 2 );

/**
 * Register "App" Custom Post Type
 */
function ydcoza_register_app_cpt() {
    $labels = array(
        'name'                  => _x( 'Apps', 'Post Type General Name', 'text-domain' ),
        'singular_name'         => _x( 'App', 'Post Type Singular Name', 'text-domain' ),
        'menu_name'             => __( 'Apps', 'text-domain' ),
        'name_admin_bar'        => __( 'App', 'text-domain' ),
        'add_new'               => __( 'Add New', 'text-domain' ),
        'add_new_item'          => __( 'Add New App', 'text-domain' ),
        'edit_item'             => __( 'Edit App', 'text-domain' ),
        'new_item'              => __( 'New App', 'text-domain' ),
        'view_item'             => __( 'View App', 'text-domain' ),
        'all_items'             => __( 'All Apps', 'text-domain' ),
        'search_items'          => __( 'Search Apps', 'text-domain' ),
        'parent_item_colon'     => __( 'Parent Apps:', 'text-domain' ),
        'not_found'             => __( 'No apps found.', 'text-domain' ),
        'not_found_in_trash'    => __( 'No apps found in Trash.', 'text-domain' ),
        'archives'              => __( 'App Archives', 'text-domain' ),
        'attributes'            => __( 'App Attributes', 'text-domain' ),
        'insert_into_item'      => __( 'Insert into app', 'text-domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this app', 'text-domain' ),
        'featured_image'        => __( 'App Featured Image', 'text-domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text-domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text-domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text-domain' ),
        'filter_items_list'     => __( 'Filter apps list', 'text-domain' ),
        'items_list_navigation' => __( 'Apps list navigation', 'text-domain' ),
        'items_list'            => __( 'Apps list', 'text-domain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'hierarchical'       => true,               // behave like Pages
        'show_in_menu'       => true,
        'show_in_rest'       => true,               // Gutenberg support
        'rewrite'            => array( 'slug' => 'app' ),
        'supports'           => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'revisions',
            'page-attributes', // for menu order / parent selection
        ),
        'capability_type'    => 'page',             // use Page caps
        'map_meta_cap'       => true,               // map meta caps properly
    );

    register_post_type( 'app', $args );
}
add_action( 'init', 'ydcoza_register_app_cpt' );

/**
 * Output breadcrumb trail.
 */
function ydcoza_breadcrumbs() {
    $sep  = ' &raquo; ';
    $home = '<a href="' . home_url() . '">Home</a>';

    if ( is_front_page() ) {
        // Nothing
        return;
    }

    echo '<nav aria-label="breadcrumb"><div class="breadcrumb">';
    echo $home;

    if ( is_home() ) {
        echo $sep . 'Blog';
    }
    elseif ( is_singular() ) {
        $post_type = get_post_type();

        // Custom Post Type
        if ( $post_type && $post_type !== 'post' && $post_type !== 'page' ) {
            $pt_obj  = get_post_type_object( $post_type );
            $archive = get_post_type_archive_link( $post_type );
            if ( $archive ) {
                echo $sep . '<a href="' . esc_url( $archive ) . '">' . esc_html( $pt_obj->labels->name ) . '</a>';
            }
        }

        // If Page, show ancestors
        if ( is_page() ) {
            $ancestors = get_post_ancestors( get_the_ID() );
            if ( ! empty( $ancestors ) ) {
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $crumb_id ) {
                    echo $sep . '<a href="' . get_permalink( $crumb_id ) . '">' . get_the_title( $crumb_id ) . '</a>';
                }
            }
        }

        // If Post, show category
        if ( is_single() && get_post_type() === 'post' ) {
            $cats = get_the_category();
            if ( ! empty( $cats ) ) {
                $cat  = $cats[0];
                $link = get_category_link( $cat );
                echo $sep . '<a href="' . esc_url( $link ) . '">' . esc_html( $cat->name ) . '</a>';
            }
        }

        // Finally, current item
        echo $sep . '<span class="current">' . get_the_title() . '</span>';
    }
    elseif ( is_archive() ) {
        if ( is_post_type_archive() ) {
            $pt_obj = get_post_type_object( get_post_type() );
            echo $sep . '<span class="current">' . esc_html( $pt_obj->labels->name ) . ' Archive</span>';
        }
        elseif ( is_category() ) {
            echo $sep . '<span class="current">Category: ' . single_cat_title( '', false ) . '</span>';
        }
        elseif ( is_tag() ) {
            echo $sep . '<span class="current">Tag: ' . single_tag_title( '', false ) . '</span>';
        }
        elseif ( is_author() ) {
            echo $sep . '<span class="current">Author: ' . get_the_author() . '</span>';
        }
        elseif ( is_date() ) {
            echo $sep . '<span class="current">Archives for ' . get_the_date() . '</span>';
        }
    }
    elseif ( is_search() ) {
        echo $sep . '<span class="current">Search results for "' . get_search_query() . '"</span>';
    }
    elseif ( is_404() ) {
        echo $sep . '<span class="current">404 Not Found</span>';
    }

    echo '</div></nav>';
}

/**
 * Fire our breadcrumbs on the Bootscore hook right after <div id="primary"> opens.
 */
function ydcoza_breadcrumbs_after_primary( $template ) {
    // you can restrict to your CPT if you like:
    // if ( is_singular('app') ) {
        if ( function_exists( 'ydcoza_breadcrumbs' ) ) {
            ydcoza_breadcrumbs();
        }
    // }
}
add_action( 'bootscore_after_primary_open', 'ydcoza_breadcrumbs_after_primary', 10, 1 );

/**
 * Hide the front-end admin toolbar for everyone except Administrators.
 */
function hide_admin_toolbar_for_non_admins() {
    if ( ! current_user_can( 'administrator' ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
    }
}
add_action( 'after_setup_theme', 'hide_admin_toolbar_for_non_admins' );

/**
 * Redirect all users to the site’s front page after they log in.
 *
 * @param string           $redirect_to URL to redirect to.
 * @param string           $request     Original requested redirect URL (if any).
 * @param WP_User|WP_Error $user        WP_User object if login was successful, WP_Error otherwise.
 * @return string                      The URL you want to send the user to.
 */
function ydcoza_force_login_redirect_to_home( $redirect_to, $request, $user ) {
    // Only redirect on successful login (i.e. $user is a WP_User object)
    if ( isset( $user->ID ) ) {
        return home_url();
    }
    // Otherwise (e.g. login failed), leave WordPress to handle fallback
    return $redirect_to;
}
add_filter( 'login_redirect', 'ydcoza_force_login_redirect_to_home', 10, 3 );

/**
 * Redirect users to the home page after logout.
 */
function ydcoza_logout_redirect_to_home() {
    wp_redirect( home_url() );
    exit;
}
add_action( 'wp_logout', 'ydcoza_logout_redirect_to_home' );


/**
 * Replace the default WordPress login logo with a custom image.
 */
function ydcoza_custom_login_logo() {
    // URL to your logo file; adjust the path if you placed it elsewhere.
    $logo_url = get_stylesheet_directory_uri() . '/assets/img/logo/wecoza-logo-dark.png';

    // You may need to tweak width/height to match your actual image dimensions.
    ?>
    <style type="text/css">
        /* Target the logo on the login page */
        .login h1 a {
            background-image: url(<?php echo esc_url( $logo_url ); ?>) !important;
            background-size: contain;
            width: 320px;    /* set to your logo’s width */
            height: 80px;    /* set to your logo’s height */
        }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'ydcoza_custom_login_logo' );

/**
 * (Optional) Change the login logo URL to point to your site homepage 
 * instead of wordpress.org.
 */
function ydcoza_custom_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'ydcoza_custom_login_logo_url' );

/**
 * (Optional) Change the logo’s title attribute (hover text) 
 * to your site name rather than “Powered by WordPress”.
 */
function ydcoza_custom_login_logo_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'ydcoza_custom_login_logo_title' );

/**
 * Add custom styles to the WordPress login page.
 */
function ydcoza_custom_login_styles() {
    ?>
    <style type="text/css">
        /* -------------------------------------------------------------------------- */
        /* login logo                                                                */
        /* -------------------------------------------------------------------------- */
        .login h1 a {
            background-size: 260px !important;
            width: 260px !important;
        }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'ydcoza_custom_login_styles' );

/**
 * Redirect non-logged-in users to login page for all pages except home page.
 * 
 * This function checks if a user is logged in and redirects them to the WordPress 
 * login page if they are not, except for the home page which remains accessible 
 * to all visitors.
 */
function wecoza_redirect_non_logged_users() {
    // Skip if user is already logged in
    if ( is_user_logged_in() ) {
        return;
    }
    
    // Allow access to home page regardless of login status
    // if ( is_front_page() ) {
    //     return;
    // }
    
    // Allow access to login page to prevent redirect loops
    if ( $GLOBALS['pagenow'] === 'wp-login.php' ) {
        return;
    }
    
    // Skip redirects for admin pages and AJAX requests
    if ( is_admin() || wp_doing_ajax() ) {
        return;
    }
    
    // Skip redirects for RSS feeds, REST API, and other special pages
    if ( is_feed() || is_robots() || is_trackback() ) {
        return;
    }
    
    // Get current URL for return redirect after login
    $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    // Redirect to login page with return URL
    $login_url = wp_login_url( $current_url );
    wp_redirect( $login_url );
    exit;
}
add_action( 'template_redirect', 'wecoza_redirect_non_logged_users' );
