<?php
/**
 * Database migration to add class subject fields to the wecoza_classes table
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

// Table name
$table_name = $wpdb->prefix . 'wecoza_classes';

// Check if the table exists
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;

if ($table_exists) {
    // Check if the columns already exist
    $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_name");
    $column_names = array_map(function($column) {
        return $column->Field;
    }, $columns);

    // Add class_subject column if it doesn't exist
    if (!in_array('class_subject', $column_names)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN class_subject VARCHAR(50) NULL AFTER class_type");
        error_log('Added class_subject column to ' . $table_name);
    }

    // Add class_code column if it doesn't exist
    if (!in_array('class_code', $column_names)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN class_code VARCHAR(50) NULL AFTER class_subject");
        error_log('Added class_code column to ' . $table_name);
    }

    // Add class_duration column if it doesn't exist
    if (!in_array('class_duration', $column_names)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN class_duration INT NULL AFTER class_code");
        error_log('Added class_duration column to ' . $table_name);
    }

    error_log('Database migration for class subject fields completed.');
} else {
    error_log('Table ' . $table_name . ' does not exist. Migration skipped.');
}
