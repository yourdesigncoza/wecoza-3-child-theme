<?php
// [wecoza_dynamic_table sql_id="4" columns="class_id,c.subject,c.start_date,c.end_date" exclude_columns_from_editing="class_id"]

/*------------------YDCOZA-----------------------*/
/* Main function to generate the dynamic table   */
/* based on the provided shortcode attributes.   */
/* It handles data fetching, table generation,   */
/* and prepares JavaScript data for frontend.    */
/*-----------------------------------------------*/
function wecoza_dynamic_table_shortcode($atts) {
    $atts = shortcode_atts(array(
        'sql_id' => '',
        'columns' => '',
        'exclude_columns_from_editing' => '',
    ), $atts);

    $sql_id = intval($atts['sql_id']);
    if (!$sql_id) {
        return '<p>' . __('Invalid SQL ID provided.', 'wecoza') . '</p>';
    }

    $query_data = Wecoza3_Logger::get_query_by_id($sql_id);
    if (!$query_data) {
        return '<p>' . __('SQL query not found.', 'wecoza') . '</p>';
    }

    $columns = !empty($atts['columns']) ? explode(',', $atts['columns']) : [];
    $output = '<div class="wecoza-table-container">';
    $output .= '<table id="wecoza-dynamic-table" class="table table-striped">';
    $output .= '<thead><tr>';
    foreach ($columns as $column) {
        $output .= '<th>' . esc_html(ucwords(str_replace('_', ' ', $column))) . '</th>';
    }
    $output .= '</tr></thead>';
    $output .= '<tbody></tbody>'; // Empty tbody for AJAX data
    $output .= '</table>';
    $output .= '</div>';
    $output .= '<button id="wecoza-loader" class="btn btn-primary" type="button">
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  Loading...
</button>';

    $output .= "
        <script>
            jQuery(document).ready(function($) {
                $('#wecoza-loader').show();
                // Fetch data via AJAX
                $.ajax({
                    url: '" . admin_url('admin-ajax.php') . "',
                    type: 'POST',
                    data: {
                        action: 'fetch_dynamic_table_data',
                        sql_id: " . json_encode($sql_id) . "
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#wecoza-dynamic-table tbody').html(response.data);
                            console.log('Table data loaded successfully.');
                            $('#wecoza-loader').hide();
                        } else {
                            console.error('Failed to load data:', response.data);
                            $('#wecoza-loader').hide();
                        }
                    },
                    error: function() {
                        console.error('An error occurred while loading the table data.');
                        $('#wecoza-loader').hide();
                    }
                });
            });
        </script>
    ";

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