<?php

/**
 * @package Bootscore Child
 *
 * @version 6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Enqueue scripts and styles
 */
// add_action('wp_enqueue_scripts', 'bootscore_child_enqueue_styles');
// function bootscore_child_enqueue_styles() {

//   // Compiled main.css
//   $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/assets/css/main.css'));
//   wp_enqueue_style('main', get_stylesheet_directory_uri() . '/assets/css/main.css', array('parent-style'), $modified_bootscoreChildCss);
  
  // custom.js
  // Get modification time. Enqueue file with modification date to prevent browser from loading cached scripts when file content changes. 
//   $modificated_CustomJS = date('YmdHi', filemtime(get_stylesheet_directory() . '/assets/js/custom.js'));
//   wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), $modificated_CustomJS, false, true);
// }


// Prevent direct access to this file
defined('ABSPATH') or die('No script kiddies please!');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define plugin constants
$rand = rand();
define('WECOZA_PLUGIN_VERSION', $rand);
define('WECOZA_CHILD_DIR', get_stylesheet_directory(__FILE__));
define('WECOZA_CHILD_URL', get_stylesheet_directory_uri(__FILE__));



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
 * Enqueue all necessary GLOBAL assets
 */

function enqueue_assets() {
        // Bootstrap 5 https://fastbootstrap.com/get-started/installation/
        // wp_enqueue_style('bootstrap-5', 'https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css');
        // wp_enqueue_style('bootstrap-5', 'https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css');

          // style.css
          wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

        wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css');
        
        wp_enqueue_script('popper2-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js', array('jquery'), null, true);
        wp_enqueue_script('bootstrap-5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

        // Bootstrap Table
        // wp_enqueue_style('bootstrap-table', 'https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css');
        // wp_enqueue_script('bootstrap-table', 'https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js', array('jquery'), null, true);

        // // Bootstrap with Document css
        // wp_enqueue_style('ydcoza_boot_demo-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-bootstrap-demo.css', array('parent-style'), WECOZA_PLUGIN_VERSION);
        // Theme styles - load after Parent 
        wp_enqueue_style('ydcoza_theme-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-theme.css', array('parent-style'), WECOZA_PLUGIN_VERSION);
        // // Override styles - load after Parent
        // wp_enqueue_style('ydcoza_line-css', WECOZA_CHILD_URL . '/includes/css/line.css', array('parent-style'), WECOZA_PLUGIN_VERSION); 
        // // Override styles - load after Parent
        // wp_enqueue_style('ydcoza-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-styles.css', array('parent-style'), WECOZA_PLUGIN_VERSION);

        // Check if we are on a specific page
        if (is_page('all-learners-table')) { // Replace 'your-page-slug' with the slug of your target page
            wp_enqueue_script(
                'gradio-script',
                'https://gradio.s3-us-west-2.amazonaws.com/4.40.0/gradio.js',
                array(), // No dependencies
                WECOZA_PLUGIN_VERSION,    // No version specified
                true     // Load in the footer
            );
        }

        wp_enqueue_style(
            'select2-css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            array('jquery'),
            '4.1.0-rc.0'
        );

        // Enqueue Select2 JS
        wp_enqueue_script(
            'select2-js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            array('jquery'),
            '4.1.0-rc.0',
            true
        );

        // Chart .js
        wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);

        // Custom scripts with localization
        wp_localize_script('wecoza-table-handler', 'wecoza_table_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wecoza_table_nonce')
        ));

        // Localize AJAX URL for all scripts
        wp_localize_script('jquery', 'wecoza_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));

        // // simplebar.min.js
        // wp_enqueue_script('simplebar-js', WECOZA_CHILD_URL . '/includes/js/simplebar.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, false);
        // // popper.min.js
        // // wp_enqueue_script('popper-js', WECOZA_CHILD_URL . '/includes/js/popper.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // anchor.min.js
        // wp_enqueue_script('anchor-js', WECOZA_CHILD_URL . '/includes/js/anchor.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // is.min.js
        // wp_enqueue_script('is-js', WECOZA_CHILD_URL . '/includes/js/is.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // fontawesome-all.min.js
        // wp_enqueue_script('fontawesome_all-js', WECOZA_CHILD_URL . '/includes/js/fontawesome-all.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // lodash.min.js
        // wp_enqueue_script('lodash-js', WECOZA_CHILD_URL . '/includes/js/lodash.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // list.min.js
        // wp_enqueue_script('list-js', WECOZA_CHILD_URL . '/includes/js/list.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // dayjs.min.js
        // wp_enqueue_script('dayjs-js', WECOZA_CHILD_URL . '/includes/js/dayjs.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // choices.min.js
        // wp_enqueue_script('choices-js', WECOZA_CHILD_URL . '/includes/js/choices.min.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // phoenix .js
        // wp_enqueue_script('phoenix-js', WECOZA_CHILD_URL . '/includes/js/phoenix.js', array('jquery'),  WECOZA_PLUGIN_VERSION, true);
        // // config.js
        // wp_enqueue_script('config-js', WECOZA_CHILD_URL . '/includes/js/config.js', array('jquery'),  WECOZA_PLUGIN_VERSION, false);
        wp_enqueue_script('wecoza-table-handler', WECOZA_CHILD_URL . '/includes/js/app.js', array('jquery', 'bootstrap-table'), WECOZA_PLUGIN_VERSION, true);


}
add_action('wp_enqueue_scripts', 'enqueue_assets'); // Enqueue assets





/**
 * Gradio
 */
function add_type_module_to_gradio_script($tag, $handle, $src) {
    if ('gradio-script' === $handle) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_type_module_to_gradio_script', 10, 3);

/**
 * Load required PHP files
 */
function load_required_files() {
    $required_files = array(
        '/includes/functions/db.php',
        '/includes/functions/echarts-functions.php',
        '/includes/admin/settings.php',
        '/includes/admin/sql-manager.php',
        '/includes/shortcodes/datatable.php',
        '/includes/shortcodes/echarts-shortcode.php',
        '/includes/shortcodes/outstanding-deliveries-shortcode.php',
    );

    foreach ($required_files as $file) {
        require_once WECOZA_CHILD_DIR . $file;
    }

    // Load MVC bootstrap file
    require_once WECOZA_CHILD_DIR . '/app/bootstrap.php';

    // Run database migrations
    require_once WECOZA_CHILD_DIR . '/includes/db/migrations/add-class-subject-fields.php';
}
load_required_files(); // Load required files

// Legacy files - these will be migrated to the MVC structure
require_once WECOZA_CHILD_DIR . '/assets/learners/learners-function.php';
require_once WECOZA_CHILD_DIR . '/assets/agents/agents-functions.php';
require_once WECOZA_CHILD_DIR . '/assets/clients/clients-functions.php';

// Template loader functionality
if (!class_exists('Plugin_Templates_Loader')) {
    require_once WECOZA_CHILD_DIR . '/includes/functions/templates-loader.php';
}

function load_plugin_templates() {
    $template_loader = new Plugin_Templates_Loader();
}
add_action('plugins_loaded', 'load_plugin_templates');



/**
 *  Loaded into the wecoza_dynamic_table shortcode
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


// Add theme‐toggle switch to end of Primary menu
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
 * Register “App” Custom Post Type
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
        echo $sep . '<span class="current">Search results for “' . get_search_query() . '”</span>';
    }
    elseif ( is_404() ) {
        echo $sep . '<span class="current">404 Not Found</span>';
    }

    echo '</div></nav>';
}

/**
 * Fire our breadcrumbs on the Bootscore hook right after <div id="primary"> opens.
 */
add_action( 'bootscore_after_primary_open', 'ydcoza_breadcrumbs_after_primary', 10, 1 );
function ydcoza_breadcrumbs_after_primary( $template ) {
    // you can restrict to your CPT if you like:
    // if ( is_singular('app') ) { 
        if ( function_exists( 'ydcoza_breadcrumbs' ) ) {
            ydcoza_breadcrumbs();
        }
    // }
}
