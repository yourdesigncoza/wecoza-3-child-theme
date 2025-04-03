<?php
/*------------------YDCOZA-----------------------*/
/* Create Top-Level Menu for Wecoza Plugin        */
/* Adds a new top-level menu item in WP admin     */
/*-----------------------------------------------*/
function wecoza3_create_menu() {
    // Add the top-level menu
    add_menu_page(
        __('Wecoza Plugin', 'wecoza'),
        __('Wecoza', 'wecoza'),
        'manage_options',
        'wecoza-dashboard',
        'wecoza3_main_page', // Function to display the main page
        'dashicons-admin-generic',
        59
    );

    // Add Database Settings submenu
    add_submenu_page(
        'wecoza-dashboard',
        __('Database Settings', 'wecoza'),
        __('Database Settings', 'wecoza'),
        'manage_options',
        'wecoza-db-settings',
        'wecoza3_db_settings_page'
    );

    // Add Redirects submenu
    add_submenu_page(
        'wecoza-dashboard',
        __('Redirects', 'wecoza'),
        __('Redirects', 'wecoza'),
        'manage_options',
        'wecoza-redirects',
        'wecoza3_redirects_page'
    );
}
add_action('admin_menu', 'wecoza3_create_menu');

/*------------------YDCOZA-----------------------*/
/* Display the Main Wecoza Page                   */
/* Renders the main dashboard for the plugin      */
/*-----------------------------------------------*/
function wecoza3_main_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Wecoza Plugin Dashboard', 'wecoza'); ?></h1>
        <p><?php _e('Welcome to the Wecoza Plugin Dashboard. Use the submenus to manage different aspects of the plugin.', 'wecoza'); ?></p>
    </div>
    <?php
}

/*------------------YDCOZA-----------------------*/
/* Display the Database Settings Page             */
/* Renders the page for managing DB credentials   */
/*-----------------------------------------------*/
function wecoza3_db_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Database Settings', 'wecoza'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wecoza_db_settings_group');
            do_settings_sections('wecoza-db-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/*------------------YDCOZA-----------------------*/
/* Display the Redirects Page                     */
/* Renders the page for capturing redirect URLs   */
/*-----------------------------------------------*/
function wecoza3_redirects_page() {
    // Check if user has permission to access this page
    if (!current_user_can('manage_options')) {
        return;
    }

    // Save the form data if the form is submitted
    if (isset($_POST['wecoza_redirects_submit'])) {
        update_option('wecoza_learners_capture_form_url', sanitize_text_field($_POST['learners_capture_form_url']));
        update_option('wecoza_learners_update_form_url', sanitize_text_field($_POST['learners_update_form_url']));
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    // Retrieve stored URLs
    $learners_capture_form_url = get_option('wecoza_learners_capture_form_url', '');
    $learners_update_form_url = get_option('wecoza_learners_update_form_url', '');

    // Display the form
    ?>
    <div class="wrap">
        <h1><?php _e('Redirects', 'wecoza'); ?></h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="learners_capture_form_url"><?php _e('Learners Capture Form URL', 'wecoza'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="learners_capture_form_url" name="learners_capture_form_url" value="<?php echo esc_attr($learners_capture_form_url); ?>" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="learners_update_form_url"><?php _e('Learners Update Form URL', 'wecoza'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="learners_update_form_url" name="learners_update_form_url" value="<?php echo esc_attr($learners_update_form_url); ?>" class="regular-text" required>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Changes', 'primary', 'wecoza_redirects_submit'); ?>
        </form>
    </div>
    <?php
}

/*------------------YDCOZA-----------------------*/
/* Initialize Settings Sections and Fields        */
/* Sets up the settings API for database configs  */
/*-----------------------------------------------*/
function wecoza3_settings_init() {
    // PostgreSQL Settings
    add_settings_section('wecoza_postgres_section', __('PostgreSQL Settings', 'wecoza'), 'wecoza3_postgres_section_callback', 'wecoza-db-settings');
    
    add_settings_field('wecoza_postgres_host', __('Host', 'wecoza'), 'wecoza3_postgres_host_callback', 'wecoza-db-settings', 'wecoza_postgres_section');
    add_settings_field('wecoza_postgres_dbname', __('Database Name', 'wecoza'), 'wecoza3_postgres_dbname_callback', 'wecoza-db-settings', 'wecoza_postgres_section');
    add_settings_field('wecoza_postgres_port', __('Port', 'wecoza'), 'wecoza3_postgres_port_callback', 'wecoza-db-settings', 'wecoza_postgres_section');
    add_settings_field('wecoza_postgres_user', __('Username', 'wecoza'), 'wecoza3_postgres_user_callback', 'wecoza-db-settings', 'wecoza_postgres_section');
    add_settings_field('wecoza_postgres_password', __('Password', 'wecoza'), 'wecoza3_postgres_password_callback', 'wecoza-db-settings', 'wecoza_postgres_section');

    // MySQL Settings
    add_settings_section('wecoza_mysql_section', __('MySQL Settings', 'wecoza'), 'wecoza3_mysql_section_callback', 'wecoza-db-settings');
    
    add_settings_field('wecoza_mysql_host', __('Host', 'wecoza'), 'wecoza3_mysql_host_callback', 'wecoza-db-settings', 'wecoza_mysql_section');
    add_settings_field('wecoza_mysql_dbname', __('Database Name', 'wecoza'), 'wecoza3_mysql_dbname_callback', 'wecoza-db-settings', 'wecoza_mysql_section');
    add_settings_field('wecoza_mysql_user', __('Username', 'wecoza'), 'wecoza3_mysql_user_callback', 'wecoza-db-settings', 'wecoza_mysql_section');
    add_settings_field('wecoza_mysql_password', __('Password', 'wecoza'), 'wecoza3_mysql_password_callback', 'wecoza-db-settings', 'wecoza_mysql_section');

    // Register settings
    register_setting('wecoza_db_settings_group', 'wecoza_postgres_host');
    register_setting('wecoza_db_settings_group', 'wecoza_postgres_dbname');
    register_setting('wecoza_db_settings_group', 'wecoza_postgres_port');
    register_setting('wecoza_db_settings_group', 'wecoza_postgres_user');
    register_setting('wecoza_db_settings_group', 'wecoza_postgres_password');
    register_setting('wecoza_db_settings_group', 'wecoza_mysql_host');
    register_setting('wecoza_db_settings_group', 'wecoza_mysql_dbname');
    register_setting('wecoza_db_settings_group', 'wecoza_mysql_user');
    register_setting('wecoza_db_settings_group', 'wecoza_mysql_password');
}
add_action('admin_init', 'wecoza3_settings_init');

// Callback functions for settings fields
function wecoza3_postgres_section_callback() { echo '<p>' . __('Enter your PostgreSQL database credentials:', 'wecoza') . '</p>'; }
function wecoza3_mysql_section_callback() { echo '<p>' . __('Enter your MySQL database credentials:', 'wecoza') . '</p>'; }

function wecoza3_postgres_host_callback() {
    $value = get_option('wecoza_postgres_host', 'db-wecoza-3-do-user-17263152-0.m.db.ondigitalocean.com');
    echo '<input type="text" name="wecoza_postgres_host" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_postgres_dbname_callback() {
    $value = get_option('wecoza_postgres_dbname', 'defaultdb');
    echo '<input type="text" name="wecoza_postgres_dbname" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_postgres_port_callback() {
    $value = get_option('wecoza_postgres_port', '25060');
    echo '<input type="text" name="wecoza_postgres_port" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_postgres_user_callback() {
    $value = get_option('wecoza_postgres_user', 'doadmin');
    echo '<input type="text" name="wecoza_postgres_user" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_postgres_password_callback() {
    $value = get_option('wecoza_postgres_password', '');
    echo '<input type="password" name="wecoza_postgres_password" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_mysql_host_callback() {
    $value = get_option('wecoza_mysql_host', 'sql17.cpt2.host-h.net');
    echo '<input type="text" name="wecoza_mysql_host" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_mysql_dbname_callback() {
    $value = get_option('wecoza_mysql_dbname', 'ydcoza_wecoza_logger');
    echo '<input type="text" name="wecoza_mysql_dbname" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_mysql_user_callback() {
    $value = get_option('wecoza_mysql_user', 'devaiywuhb_4');
    echo '<input type="text" name="wecoza_mysql_user" value="' . esc_attr($value) . '" class="regular-text">';
}

function wecoza3_mysql_password_callback() {
    $value = get_option('wecoza_mysql_password', '');
    echo '<input type="password" name="wecoza_mysql_password" value="' . esc_attr($value) . '" class="regular-text">';
}
