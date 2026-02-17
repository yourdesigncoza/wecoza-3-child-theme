<?php
/**
 * Main Functions for WeCoza Theme
 *
 * @package WeCoza_3_Child_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Only enable debug output when WP_DEBUG is explicitly enabled.
if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY ) {
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
}

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
/* Cached table data retrieval                   */
/* Uses WordPress Transients API to cache JSON   */
/* data and avoid disk I/O on every request      */
/*-----------------------------------------------*/

/**
 * Get table data with transient caching.
 *
 * Caches the JSON file contents for 1 hour to avoid
 * disk I/O and JSON parsing on every AJAX request.
 *
 * @return array<int, array<string, mixed>> Table data array.
 */
function wecoza_get_cached_table_data(): array {
    $cache_key = 'wecoza_table_data_cache';
    $all_data = get_transient( $cache_key );

    if ( false === $all_data ) {
        $json_file = defined( 'WECOZA_PLUGIN_DIR' ) ? WECOZA_PLUGIN_DIR . 'includes/data.json' : '';

        if ( empty( $json_file ) || ! file_exists( $json_file ) ) {
            return [];
        }

        $json_data = file_get_contents( $json_file );
        $all_data = json_decode( $json_data, true );

        if ( ! is_array( $all_data ) ) {
            $all_data = [];
        }

        // Cache for 1 hour.
        set_transient( $cache_key, $all_data, HOUR_IN_SECONDS );
    }

    return $all_data;
}

/**
 * Clear the table data cache.
 *
 * Call this when data.json is updated to invalidate the cache.
 */
function wecoza_clear_table_data_cache(): void {
    delete_transient( 'wecoza_table_data_cache' );
}

/*------------------YDCOZA-----------------------*/
/* AJAX handler for retrieving table data        */
/* Handles pagination, searching, and sorting    */
/* Uses transient caching to avoid disk I/O      */
/*-----------------------------------------------*/
function wecoza_get_table_data() {
    check_ajax_referer('wecoza_table_nonce', 'nonce');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'id';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'asc';

    // Get cached data or read from file.
    $all_data = wecoza_get_cached_table_data();

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
/**
 * Whitelist of allowed tables for update operations.
 *
 * @return array<string> Allowed table names.
 */
function wecoza_get_allowed_tables(): array {
    return apply_filters( 'wecoza_allowed_update_tables', [
        'agents',
        'clients',
        'learners',
        'classes',
        'assessments',
    ] );
}

/**
 * Whitelist of allowed columns for update operations.
 *
 * @param string $table_name The table name.
 * @return array<string> Allowed column names for the table.
 */
function wecoza_get_allowed_columns( string $table_name ): array {
    $columns_map = [
        'agents'      => [ 'name', 'email', 'phone', 'status', 'notes' ],
        'clients'     => [ 'name', 'email', 'phone', 'address', 'status' ],
        'learners'    => [ 'name', 'email', 'phone', 'status', 'class_id' ],
        'classes'     => [ 'name', 'description', 'status', 'start_date', 'end_date' ],
        'assessments' => [ 'name', 'description', 'status', 'score' ],
    ];

    $allowed = $columns_map[ $table_name ] ?? [];

    return apply_filters( 'wecoza_allowed_update_columns', $allowed, $table_name );
}

/**
 * Validate an identifier (table or column name) against a whitelist.
 *
 * @param string        $identifier The identifier to validate.
 * @param array<string> $whitelist  Allowed values.
 * @return bool True if valid.
 */
function wecoza_validate_identifier( string $identifier, array $whitelist ): bool {
    return in_array( $identifier, $whitelist, true );
}

/**
 * AJAX handler for updating records.
 * Uses PDO with whitelisted identifiers for security.
 */
function wecoza_update_record(): void {
    try {
        check_ajax_referer( 'wecoza_table_nonce', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            throw new Exception( 'Insufficient permissions' );
        }

        $record_id   = isset( $_POST['record_id'] ) ? absint( $_POST['record_id'] ) : 0;
        $raw_data    = isset( $_POST['updated_data'] ) && is_array( $_POST['updated_data'] ) ? $_POST['updated_data'] : [];
        $table_name  = isset( $_POST['table_name'] ) ? sanitize_key( $_POST['table_name'] ) : '';

        if ( ! $record_id || empty( $raw_data ) || empty( $table_name ) ) {
            throw new Exception( 'Invalid data provided' );
        }

        // Validate table name against whitelist.
        $allowed_tables = wecoza_get_allowed_tables();
        if ( ! wecoza_validate_identifier( $table_name, $allowed_tables ) ) {
            throw new Exception( 'Invalid table name' );
        }

        // Get allowed columns for this table.
        $allowed_columns = wecoza_get_allowed_columns( $table_name );

        // Sanitize and validate each field.
        $updated_data = [];
        foreach ( $raw_data as $field => $value ) {
            $field = sanitize_key( $field );

            if ( ! wecoza_validate_identifier( $field, $allowed_columns ) ) {
                continue; // Skip invalid columns silently.
            }

            $updated_data[ $field ] = sanitize_text_field( $value );
        }

        if ( empty( $updated_data ) ) {
            throw new Exception( 'No valid fields to update' );
        }

        $db  = new Wecoza3_DB();
        $pdo = $db->get_pdo();

        // Build SET clause with validated identifiers.
        $set_clauses = [];
        $params      = [ ':id' => $record_id ];

        foreach ( $updated_data as $field => $value ) {
            // Field is already validated against whitelist - safe to use directly.
            $param_name            = ':field_' . $field;
            $set_clauses[]         = sprintf( '"%s" = %s', $field, $param_name );
            $params[ $param_name ] = $value;
        }

        // Table name is validated against whitelist - safe to use directly.
        $query = sprintf(
            'UPDATE "%s" SET %s WHERE id = :id',
            $table_name,
            implode( ', ', $set_clauses )
        );

        $stmt   = $pdo->prepare( $query );
        $result = $stmt->execute( $params );

        if ( $result ) {
            wp_send_json_success( 'Record updated successfully' );
        } else {
            throw new Exception( 'Failed to update record' );
        }
    } catch ( PDOException $e ) {
        error_log( 'WeCoza PDO Error: ' . $e->getMessage() );
        wp_send_json_error( 'Database error occurred' );
    } catch ( Exception $e ) {
        error_log( 'WeCoza Update Error: ' . $e->getMessage() );
        wp_send_json_error( $e->getMessage() );
    }
}
add_action('wp_ajax_wecoza_update_record', 'wecoza_update_record');
