<?php
// [wecoza_dynamic_table sql_id="4" columns="class_id,c.subject,c.start_date,c.end_date" exclude_columns_from_editing="class_id"]

/*------------------YDCOZA-----------------------*/
/* Main function to generate the dynamic table   */
/* based on the provided shortcode attributes.   */
/* It handles data fetching, table generation,   */
/* and prepares JavaScript data for frontend.    */
/*-----------------------------------------------*/
function wecoza_dynamic_table_shortcode($atts) {
    // Ensure user is logged in
    if (!is_user_logged_in()) {
        return '<p>' . __('You must be logged in to view this content.', 'wecoza') . '</p>';
    }

    /*------------------YDCOZA-----------------------*/
    /* Process shortcode attributes, setting         */
    /* default values if not provided.               */
    /*-----------------------------------------------*/
    $atts = shortcode_atts(array(
        'sql_id' => '',
        'columns' => '',
        'exclude_columns_from_editing' => '',
    ), $atts);

    /*------------------YDCOZA-----------------------*/
    /* Validate the SQL ID and fetch the query       */
    /* from the database using Wecoza3_Logger.       */
    /*-----------------------------------------------*/
    $sql_id = intval($atts['sql_id']);
    if (!$sql_id) {
        return '<p>' . __('Invalid SQL ID provided.', 'wecoza') . '</p>';
    }

    $query_data = Wecoza3_Logger::get_query_by_id($sql_id);
    if (!$query_data) {
        return '<p>' . __('SQL query not found.', 'wecoza') . '</p>';
    }

    /*------------------YDCOZA-----------------------*/
    /* Initialize database connection and execute    */
    /* the query to fetch results.                   */
    /*-----------------------------------------------*/
    try {
        $db = new Wecoza3_DB();
        $pdo = $db->get_pdo();
    } catch (\Exception $e) {
        return wecoza_display_error_alert('Database Connection Error', 'There was an error connecting to the database. Please check your database settings and try again.');
    }

    $is_simple_query = is_simple_query($query_data->sql_query);
    $table_name = $is_simple_query ? extract_table_name_from_query($query_data->sql_query) : '';

    try {
        $stmt = $pdo->query($query_data->sql_query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return wecoza_display_error_alert('Query Execution Error', 'There was an error executing the query. Please check the SQL and try again.');
    }

    if (empty($results)) {
        return '<p>No data found.</p>';
    }

    /*------------------YDCOZA-----------------------*/
    /* Process column information based on shortcode */
    /* attributes or fetched results.                */
    /*-----------------------------------------------*/
    $columns = !empty($atts['columns']) ? explode(',', $atts['columns']) : array_keys($results[0]);
    $exclude_columns = !empty($atts['exclude_columns_from_editing']) ? explode(',', $atts['exclude_columns_from_editing']) : [];

    /*------------------YDCOZA-----------------------*/
    /* Generate the HTML for the dynamic table,      */
    /* including headers and data rows.              */
    /*-----------------------------------------------*/
    $output = '<div class="wecoza-table-container">';
    $output .= '<table id="wecoza-dynamic-table" class="table table-striped" data-table-name="' . esc_attr($table_name) . '" data-show-refresh="true" data-auto-refresh="true">';

    $output .= '<thead><tr>';
    foreach ($columns as $column) {
        $output .= '<th data-field="' . esc_attr($column) . '">' . esc_html(ucwords(str_replace('_', ' ', $column))) . '</th>';
    }
    if ($is_simple_query) {
        $output .= '<th data-field="actions">Actions</th>';
    }
    $output .= '</tr></thead>';
    $output .= '<tbody>';
    foreach ($results as $row) {
        $output .= '<tr>';
        foreach ($columns as $column) {
            $is_editable = $is_simple_query && !in_array($column, $exclude_columns);
            $output .= '<td' . ($is_editable ? ' data-editable="true"' : '') . ' data-field="' . esc_attr($column) . '">' . esc_html($row[$column]) . '</td>';
        }
        if ($is_simple_query) {
            $output .= '<td>
                <button class="edit-btn btn btn-primary btn-sm" data-id="' . esc_attr($row['id']) . '">Edit</button>
                <button class="delete-btn btn btn-danger btn-sm" data-id="' . esc_attr($row['id']) . '">Delete</button>
            </td>';
        }
        $output .= '</tr>';
    }
    $output .= '</tbody>';
    $output .= '</table>';

    /*------------------YDCOZA-----------------------*/
    /* Add HTML for the edit modal, which will be    */
    /* used for editing table entries.               */
    /*-----------------------------------------------*/
    $output .= '
    <div class="modal fade" id="wecozaEditModal" tabindex="-1" aria-labelledby="wecozaEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wecozaEditModalLabel">Edit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="wecozaEditForm">
                        <!-- Form fields will be dynamically added here -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="wecozaSaveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>';

    $output .= '</div>'; // Close wecoza-table-container

    /*------------------YDCOZA-----------------------*/
    /* Add a debugging section to display the SQL    */
    /* query used to generate the table.             */
    /*-----------------------------------------------*/
    $output .= '<details><summary>SQL Query</summary><pre>' . esc_html($query_data->sql_query) . '</pre></details>';

    /*------------------YDCOZA-----------------------*/
    /* Pass necessary data to JavaScript for         */
    /* frontend functionality.                       */
    /*-----------------------------------------------*/
    $output .= "<script>
        var wecozaTableData = {
            isSimpleQuery: " . json_encode($is_simple_query) . ",
            excludeColumns: " . json_encode($exclude_columns) . ",
            tableName: '" . esc_js($table_name) . "',
            columns: " . json_encode($columns) . ",
            sqlId: " . json_encode($sql_id) . ",
            isEditable: " . json_encode($is_simple_query) . " // Add this line
        };
    </script>";

    return $output;
}
add_shortcode('wecoza_dynamic_table', 'wecoza_dynamic_table_shortcode');

/*------------------YDCOZA-----------------------*/
/* Function to display error alerts              */
/* Uses Bootstrap classes for styling            */
/*-----------------------------------------------*/
function wecoza_display_error_alert($title, $message) {
    ob_start();
    ?>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <div>
            <h4 class="alert-heading"><?php echo esc_html($title); ?></h4>
            <p><?php echo esc_html($message); ?></p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/*------------------YDCOZA-----------------------*/
/* Function to determine if a given SQL query    */
/* is simple (without complex operations) or not.*/
/*-----------------------------------------------*/
function is_simple_query($sql_query) {
    $complex_keywords = ['join', 'union', 'group by', 'having', 'select distinct', 'subquery', 'limit'];
    $lowercase_query = strtolower($sql_query);
    foreach ($complex_keywords as $keyword) {
        if (strpos($lowercase_query, $keyword) !== false) {
            return false;
        }
    }
    return true;
}

/*------------------YDCOZA-----------------------*/
/* Function to extract the table name from a     */
/* given SQL query using regex.                  */
/*-----------------------------------------------*/
function extract_table_name_from_query($sql_query) {
    preg_match('/\bfrom\s+(\w+)/i', $sql_query, $matches);
    return isset($matches[1]) ? $matches[1] : '';
}