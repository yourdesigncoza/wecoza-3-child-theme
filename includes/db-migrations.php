<?php
function wecoza_run_migrations() {
    $current_db_version = get_option('wecoza_db_version', '0');
    $migrations = array(
        '1.0' => 'wecoza_migration_1_0',
        '1.1' => 'wecoza_migration_1_1',
        // Add new migrations here
    );

    foreach ($migrations as $version => $migration_function) {
        if (version_compare($current_db_version, $version, '<')) {
            call_user_func($migration_function);
            update_option('wecoza_db_version', $version);
        }
    }
}

function wecoza_migration_1_0() {
    global $wpdb;
    // Example migration
    $sql = "ALTER TABLE {$wpdb->prefix}learners ADD COLUMN version_created VARCHAR(10)";
    $wpdb->query($sql);
}