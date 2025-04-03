<?php
/*------------------YDCOZA-----------------------*/
/* Enable error reporting for debugging purposes */
/* This helps identify issues during development */
/*-----------------------------------------------*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*------------------YDCOZA-----------------------*/
/* Check if PostgreSQL functions are available   */
/* If not, provide a custom escape function      */
/*-----------------------------------------------*/
// if (!function_exists('pg_escape_string')) {
//     error_log("pg_escape_string function is not available");
    
//     function pg_escape_string($str) {
//         return str_replace(array('\\', "'", '"', "\x00", "\n", "\r", "\x1a"), array('\\\\', "''", '""', "\\0", "\\n", "\\r", "\\Z"), $str);
//     }
// }

/*------------------YDCOZA-----------------------*/
/* AJAX handler for retrieving table data        */
/* Handles pagination, searching, and sorting    */
/*-----------------------------------------------*/
function wecoza_get_table_data() {
    check_ajax_referer('wecoza_table_nonce', 'nonce');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'id';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'asc';

    // Read JSON file
    $json_file = WECOZA_PLUGIN_DIR . 'includes/data.json';
    $json_data = file_get_contents($json_file);
    $all_data = json_decode($json_data, true);

    // Filter data based on search
    if (!empty($search)) {
        $all_data = array_filter($all_data, function($item) use ($search) {
            foreach ($item as $key => $value) {
                if (stripos($value, $search) !== false) {
                    return true;
                }
            }
            return false;
        });
    }

    // Sort data
    usort($all_data, function($a, $b) use ($sort, $order) {
        $result = $a[$sort] <=> $b[$sort];
        return $order === 'asc' ? $result : -$result;
    });

    $total = count($all_data);
    $offset = ($page - 1) * $limit;
    $data = array_slice($all_data, $offset, $limit);

    $response = array(
        'total' => $total,
        'totalNotFiltered' => $total,
        'rows' => $data
    );

    wp_send_json($response);
}
add_action('wp_ajax_wecoza_get_table_data', 'wecoza_get_table_data');
add_action('wp_ajax_nopriv_wecoza_get_table_data', 'wecoza_get_table_data');

/*------------------YDCOZA-----------------------*/
/* AJAX handler for updating table data          */
/* Currently a placeholder for PostgreSQL logic  */
/*-----------------------------------------------*/
function wecoza_update_table_data() {
    check_ajax_referer('wecoza_table_nonce', 'nonce');

    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Insufficient permissions');
    }

    // TODO: Implement actual data update logic with PostgreSQL
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    // Perform update operation here

    wp_send_json_success('Data updated successfully');
}

/*------------------YDCOZA-----------------------*/
/* AJAX handler for deleting table data          */
/* Currently a placeholder for PostgreSQL logic  */
/*-----------------------------------------------*/
function wecoza_delete_table_data() {
    check_ajax_referer('wecoza_table_nonce', 'nonce');

    if (!current_user_can('delete_posts')) {
        wp_send_json_error('Insufficient permissions');
    }

    // TODO: Implement actual data deletion logic with PostgreSQL
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Perform delete operation here

    wp_send_json_success('Data deleted successfully');
}
add_action('wp_ajax_wecoza_update_table_data', 'wecoza_update_table_data');
add_action('wp_ajax_wecoza_delete_table_data', 'wecoza_delete_table_data');

/*------------------YDCOZA-----------------------*/
/* AJAX handler for updating records             */
/* Uses PDO for database operations              */
/*-----------------------------------------------*/
function wecoza_update_record() {
    try {
        check_ajax_referer('wecoza_table_nonce', 'nonce');

        if (!current_user_can('edit_posts')) {
            throw new Exception('Insufficient permissions');
        }

        $record_id = isset($_POST['record_id']) ? intval($_POST['record_id']) : 0;
        $updated_data = isset($_POST['updated_data']) ? $_POST['updated_data'] : array();
        $table_name = isset($_POST['table_name']) ? sanitize_text_field($_POST['table_name']) : '';

        if (!$record_id || empty($updated_data) || empty($table_name)) {
            throw new Exception('Invalid data provided');
        }

        $db = new Wecoza3_DB();
        $pdo = $db->get_pdo();

        $set_clauses = [];
        $params = [':id' => $record_id];

        foreach ($updated_data as $field => $value) {
            $quoted_field = $pdo->quote($field);
            $quoted_field = substr($quoted_field, 1, -1); // Remove the quotes added by PDO
            $set_clauses[] = "\"$quoted_field\" = :$field";
            $params[":$field"] = $value;
        }

        $quoted_table = $pdo->quote($table_name);
        $quoted_table = substr($quoted_table, 1, -1); // Remove the quotes added by PDO

        $query = "UPDATE \"$quoted_table\" SET " . implode(', ', $set_clauses) . " WHERE id = :id";

        // error_log("Query: " . $query);
        // error_log("Params: " . print_r($params, true));

        $stmt = $pdo->prepare($query);
        $result = $stmt->execute($params);

        if ($result) {
            wp_send_json_success('Record updated successfully');
        } else {
            throw new Exception('Failed to update record');
        }
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        wp_send_json_error('Database error: ' . $e->getMessage());
    } catch (Exception $e) {
        error_log("General Error: " . $e->getMessage());
        wp_send_json_error($e->getMessage());
    }
}
add_action('wp_ajax_wecoza_update_record', 'wecoza_update_record');
