<?php
/**
 * View Helpers Loader
 * 
 * This file provides global access to view helper functions.
 * Include this file at the beginning of any view that needs to use the helper functions.
 */

// Include the view helpers if not already included
if (!function_exists('\\WeCoza\\Helpers\\section_divider')) {
    require_once __DIR__ . '/ViewHelpers.php';
}

// Define global function wrappers
if (!function_exists('select_dropdown')) {
    function select_dropdown($name, $options, $attributes = [], $selected = '', $empty_label = 'Select') {
        return \WeCoza\Helpers\select_dropdown($name, $options, $attributes, $selected, $empty_label);
    }
}

if (!function_exists('select_dropdown_with_optgroups')) {
    function select_dropdown_with_optgroups($name, $optgroups, $attributes = [], $selected = '', $empty_label = 'Select') {
        return \WeCoza\Helpers\select_dropdown_with_optgroups($name, $optgroups, $attributes, $selected, $empty_label);
    }
}

if (!function_exists('form_input')) {
    function form_input($type, $name, $label, $attributes = [], $value = '', $required = false, $invalid_feedback = 'Please fill out this field.', $valid_feedback = 'Looks good!') {
        return \WeCoza\Helpers\form_input($type, $name, $label, $attributes, $value, $required, $invalid_feedback, $valid_feedback);
    }
}

if (!function_exists('form_textarea')) {
    function form_textarea($name, $label, $attributes = [], $value = '', $required = false, $invalid_feedback = 'Please fill out this field.', $valid_feedback = 'Looks good!') {
        return \WeCoza\Helpers\form_textarea($name, $label, $attributes, $value, $required, $invalid_feedback, $valid_feedback);
    }
}

if (!function_exists('form_group')) {
    function form_group($type, $name, $label, $col_class = 'col-md-4', $attributes = [], $value = '', $required = false, $invalid_feedback = 'Please fill out this field.', $valid_feedback = 'Looks good!') {
        return \WeCoza\Helpers\form_group($type, $name, $label, $col_class, $attributes, $value, $required, $invalid_feedback, $valid_feedback);
    }
}

if (!function_exists('form_row')) {
    function form_row($fields) {
        return \WeCoza\Helpers\form_row($fields);
    }
}

if (!function_exists('section_divider')) {
    function section_divider($classes = '') {
        return \WeCoza\Helpers\section_divider($classes);
    }
}

if (!function_exists('section_header')) {
    function section_header($title, $description = '', $title_tag = 'h5') {
        return \WeCoza\Helpers\section_header($title, $description, $title_tag);
    }
}

if (!function_exists('button')) {
    function button($text, $type = 'button', $style = 'primary', $attributes = []) {
        return \WeCoza\Helpers\button($text, $type, $style, $attributes);
    }
}
