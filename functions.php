<?php
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
 * Enqueue all necessary GLOBAL assets
 */

function enqueue_assets() {
        // Bootstrap 5 https://fastbootstrap.com/get-started/installation/
        wp_enqueue_style('bootstrap-5', 'https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css');
        // wp_enqueue_style('bootstrap-5', 'https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css');
        wp_enqueue_script('bootstrap-5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
        // wp_enqueue_script('bootstrap-5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

        // Bootstrap Table
        wp_enqueue_style('bootstrap-table', 'https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css');
        wp_enqueue_script('bootstrap-table', 'https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js', array('jquery'), null, true);

        // Custom styles
        wp_enqueue_style('ydcoza-css', WECOZA_CHILD_URL . '/includes/css/ydcoza-styles.css', array(), WECOZA_PLUGIN_VERSION);


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


        // Chart .js
        wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);



        // Custom scripts with localization
        wp_enqueue_script('wecoza-table-handler', WECOZA_CHILD_URL . '/includes/js/app.js', array('jquery', 'bootstrap-table'), WECOZA_PLUGIN_VERSION, true);
        wp_localize_script('wecoza-table-handler', 'wecoza_table_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wecoza_table_nonce')
        ));

}
add_action('wp_enqueue_scripts', 'enqueue_assets'); // Enqueue assets


function enqueue_select2_scripts() {
  // Enqueue Select2 CSS
  wp_enqueue_style(
    'select2-css',
    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
    array(),
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

  // Enqueue your custom script that initializes Select2
  // wp_enqueue_script(
  //   'my-custom-select2-init',
  //   get_stylesheet_directory_uri() . '/js/my-select2-init.js',
  //   array('select2-js'),
  //   '1.0',
  //   true
  // );
}
add_action('wp_enqueue_scripts', 'enqueue_select2_scripts');




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
