<?php
/*------------------YDCOZA-----------------------*/
/* Create submenu for SQL Query Manager           */
/* Adds a submenu item under the Wecoza menu      */
/*-----------------------------------------------*/
function wecoza3_create_sql_query_admin_menu() {
    add_submenu_page(
        'wecoza-dashboard',                // Parent slug
        __('SQL Query Manager', 'wecoza'), // Page title
        __('SQL Queries', 'wecoza'),       // Menu title
        'manage_options',                  // Capability
        'wecoza3-sql-manager',             // Menu slug
        'wecoza3_sql_query_admin_page'     // Function to display the page
    );
}
add_action('admin_menu', 'wecoza3_create_sql_query_admin_menu');

/*------------------YDCOZA-----------------------*/
/* Admin Menu for SQL Query Manager               */
/* Displays the main interface for managing       */
/* SQL queries, including add, edit, and list     */
/*-----------------------------------------------*/
function wecoza3_sql_query_admin_page() {
    global $wpdb;

    $edit_query_id = isset($_GET['edit_query']) ? intval($_GET['edit_query']) : null;
    $query_data = null;

    // Fetch the query details if an edit action is requested
    if ($edit_query_id) {
        $query_data = Wecoza3_Logger::get_query_by_id($edit_query_id);
    }

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wecoza3_action']) && $_POST['wecoza3_action'] === 'add_query') {
        // Sanitize form inputs
        $query_name = sanitize_text_field($_POST['query_name']);
        $query_description = sanitize_textarea_field($_POST['query_description']);
        $sql_query = sanitize_textarea_field($_POST['sql_query']);

        // Debugging: Log the form submission
        error_log("Form submitted: Name = " . $query_name . ", Description = " . $query_description . ", SQL = " . $sql_query);

        // Call the add_query function
        Wecoza3_Logger::add_query($query_name, $query_description, $sql_query);
    }

    ?>
    <div class="wrap">
        <h1><?php _e('SQL Query Manager', 'wecoza'); ?></h1>

        <!-- Form to add or edit a SQL query -->
        <h2><?php echo $edit_query_id ? __('Edit Query', 'wecoza') : __('Add New Query', 'wecoza'); ?></h2>
        <form method="post" action="">
            <input type="hidden" name="wecoza3_action" value="<?php echo $edit_query_id ? 'edit_query' : 'add_query'; ?>" />
            <input type="hidden" name="query_id" value="<?php echo $edit_query_id; ?>" />

            <label for="query_name"><?php _e('Query Name', 'wecoza'); ?></label><br />
            <input class="form-control" type="text" name="query_name" value="<?php echo $query_data ? esc_html($query_data->query_name) : ''; ?>" required /><br />

            <label for="query_description"><?php _e('Query Description', 'wecoza'); ?></label><br />
            <textarea class="form-control" rows="6" cols="50" name="query_description" required><?php echo $query_data ? esc_html($query_data->query_description) : ''; ?></textarea><br />

            <label for="sql_query"><?php _e('SQL Query', 'wecoza'); ?></label><br />
            <textarea class="form-control" rows="6" cols="50" name="sql_query" required><?php echo $query_data ? esc_html($query_data->sql_query) : ''; ?></textarea><br />

            <input type="submit" class="button button-primary" value="<?php echo $edit_query_id ? __('Update Query', 'wecoza') : __('Add Query', 'wecoza'); ?>" />
        </form>
        <br />
        <hr />

        <!-- Display existing queries -->
        <h2><?php _e('Existing SQL Queries', 'wecoza'); ?></h2>
        <form method="post" action="">
            <input type="text" name="search_query" placeholder="<?php _e('Search Queries', 'wecoza'); ?>" />
            <input type="submit" class="button button-primary" value="<?php _e('Search', 'wecoza'); ?>" />
        </form>
        <br />

        <table class="widefat fixed">
            <thead>
                <tr>
                    <th><?php _e('ID', 'wecoza'); ?></th>
                    <th><?php _e('Query Name', 'wecoza'); ?></th>
                    <th><?php _e('Query Description', 'wecoza'); ?></th>
                    <th><?php _e('SQL Query', 'wecoza'); ?></th>
                    <th><?php _e('Actions', 'wecoza'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch the SQL queries from the database using Wecoza3_Logger()
                $queries = Wecoza3_Logger::get_all_queries();
                if ($queries) {
                    foreach ($queries as $query) {
                            // Decode the base64-encoded SQL query
                            $raw_sql_query = base64_decode($query->sql_query);
                            // Unslash the query to remove extra slashes added by WordPress
                            $raw_sql_query = wp_unslash($raw_sql_query);

                        ?>
                        <tr>
                            <td><?php echo esc_html($query->id); ?></td>
                            <td><?php echo esc_html($query->query_name); ?></td>
                            <td><?php echo esc_html($query->query_description); ?></td>
                            <td><?php echo esc_html($raw_sql_query); ?></td>
                            <td>
                                <a href="?page=wecoza3-sql-manager&edit_query=<?php echo $query->id; ?>"><?php _e('Edit', 'wecoza'); ?></a> |
                                <a href="?page=wecoza3-sql-manager&delete_query=<?php echo $query->id; ?>" onclick="return confirm('<?php _e('Are you sure?', 'wecoza'); ?>');"><?php _e('Delete', 'wecoza'); ?></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5">' . __('No queries found.', 'wecoza') . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

/*------------------YDCOZA-----------------------*/
/* Handle SQL Query Add, Edit, Delete Actions     */
/* Processes form submissions for query management*/
/*-----------------------------------------------*/
function wecoza3_handle_sql_query_actions() {
    if (isset($_POST['wecoza3_action'])) {
        // Sanitize input
        $query_name = sanitize_text_field($_POST['query_name']);
        $query_description = sanitize_textarea_field($_POST['query_description']);
        $sql_query = sanitize_textarea_field($_POST['sql_query']);

        if ($_POST['wecoza3_action'] === 'edit_query' && isset($_POST['query_id'])) {
            // Update existing query
            $query_id = intval($_POST['query_id']);
            
            // Encode the SQL query before saving it
            $encoded_sql_query = base64_encode(sanitize_textarea_field($_POST['sql_query']));
            
            // Update the query in the database
            Wecoza3_Logger::update_query($query_id, $query_name, $query_description, $encoded_sql_query);
        } elseif ($_POST['wecoza3_action'] === 'edit_query' && isset($_POST['query_id'])) {
            // Update existing query
            $query_id = intval($_POST['query_id']);
            Wecoza3_Logger::update_query($query_id, $query_name, $query_description, $sql_query);
        }
    }

    // Handle delete action
    if (isset($_GET['delete_query'])) {
        $query_id = intval($_GET['delete_query']);
        Wecoza3_Logger::delete_query($query_id);
    }
}
add_action('admin_init', 'wecoza3_handle_sql_query_actions');