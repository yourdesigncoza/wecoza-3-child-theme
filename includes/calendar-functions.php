<?php
/**
 * WeCoza Calendar Functions
 * 
 * Handles FullCalendar integration following WordPress best practices
 * 
 * @package WeCoza
 * @since 1.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Enqueue FullCalendar assets
 * Following WordPress best practices for script/style enqueuing
 */
function wecoza_enqueue_calendar_assets() {
    // Only enqueue on pages that need the calendar
    if (!wecoza_should_load_calendar()) {
        return;
    }



    // FullCalendar CSS - using official CDN (latest stable)
    wp_enqueue_style(
        'fullcalendar',
        'https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css',
        array(),
        'latest'
    );

    // WeCoza Calendar CSS
    wp_enqueue_style(
        'wecoza-calendar-css',
        get_stylesheet_directory_uri() . '/public/css/wecoza-calendar.css',
        array('fullcalendar'),
        filemtime(get_stylesheet_directory() . '/public/css/wecoza-calendar.css')
    );

    // FullCalendar JS - using official CDN (latest stable)
    wp_enqueue_script(
        'fullcalendar',
        'https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js',
        array(),
        'latest',
        false // Load in head to ensure it's available early
    );

    // WeCoza Calendar JS
    wp_enqueue_script(
        'wecoza-calendar',
        get_stylesheet_directory_uri() . '/public/js/wecoza-calendar.js',
        array('jquery', 'fullcalendar'),
        filemtime(get_stylesheet_directory() . '/public/js/wecoza-calendar.js'),
        true
    );

    // Localize script with WordPress data
    wp_localize_script('wecoza-calendar', 'wecozaCalendar', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wecoza_calendar_nonce'),
        'strings' => array(
            'loading' => __('Loading calendar...', 'wecoza'),
            'error' => __('Error loading calendar', 'wecoza'),
            'noEvents' => __('No events found', 'wecoza'),
        ),
        'fallbackCdn' => 'https://unpkg.com/fullcalendar/index.global.min.js'
    ));
}
add_action('wp_enqueue_scripts', 'wecoza_enqueue_calendar_assets');

/**
 * Check if calendar should be loaded on current page
 *
 * @return bool True if calendar should be loaded
 */
function wecoza_should_load_calendar() {
    global $post;

    // Always load on frontend for now (we can optimize later)
    if (!is_admin()) {
        return true;
    }

    // Load on single class display pages
    if (is_page() && $post) {
        $content = $post->post_content;

        // Check for single class display shortcode
        if (has_shortcode($content, 'wecoza_display_single_class')) {
            return true;
        }

        // Check for calendar container in content
        if (strpos($content, 'id="classCalendar"') !== false) {
            return true;
        }

        // Check for class_id parameter in URL (indicates single class page)
        if (isset($_GET['class_id']) && intval($_GET['class_id']) > 0) {
            return true;
        }
    }

    // Load on admin pages that might need calendar
    if (is_admin()) {
        $screen = get_current_screen();
        if ($screen && strpos($screen->id, 'wecoza') !== false) {
            return true;
        }
    }

    return false;
}

/**
 * AJAX handler to get calendar events for a class
 * Following WordPress AJAX best practices
 */
function wecoza_get_class_calendar_events() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'wecoza_calendar_nonce')) {
        wp_send_json_error('Security check failed');
        return;
    }

    // Get and validate class ID
    $class_id = intval($_POST['class_id'] ?? 0);

    if (!$class_id) {
        wp_send_json_error('Invalid class ID');
        return;
    }

    try {
        // Get class data
        $class_data = wecoza_get_class_by_id($class_id);

        if (!$class_data) {
            wp_send_json_error('Class not found');
            return;
        }

        // Generate calendar events from class schedule data
        $events = wecoza_generate_calendar_events($class_data);

        // Return events in FullCalendar format (direct JSON array)
        wp_send_json($events);

    } catch (Exception $e) {
        error_log('WeCoza Calendar Error: ' . $e->getMessage());
        error_log('WeCoza Calendar Error Stack: ' . $e->getTraceAsString());
        wp_send_json_error('Failed to load calendar events: ' . $e->getMessage());
    }
}
add_action('wp_ajax_get_class_calendar_events', 'wecoza_get_class_calendar_events');
add_action('wp_ajax_nopriv_get_class_calendar_events', 'wecoza_get_class_calendar_events');

/**
 * Get class data by ID using WeCoza's PostgreSQL database
 *
 * @param int $class_id Class ID
 * @return array|null Class data or null if not found
 */
function wecoza_get_class_by_id($class_id) {
    try {
        // Use WeCoza's DatabaseService for PostgreSQL connection
        $db = \WeCoza\Services\Database\DatabaseService::getInstance();

        $sql = "SELECT * FROM public.classes WHERE class_id = ? LIMIT 1";
        $stmt = $db->query($sql, [$class_id]);
        $result = $stmt->fetch();

        return $result ? $result : null;

    } catch (Exception $e) {
        error_log('WeCoza Calendar - Error fetching class: ' . $e->getMessage());
        return null;
    }
}

/**
 * Generate calendar events from class schedule data
 * 
 * @param array $class_data Class data from database
 * @return array Array of FullCalendar events
 */
function wecoza_generate_calendar_events($class_data) {
    $events = array();
    
    // Parse schedule data if available
    $schedule_data = null;
    if (!empty($class_data['schedule_data'])) {
        $schedule_data = json_decode($class_data['schedule_data'], true);
    }
    
    // If we have schedule data, generate recurring events
    if ($schedule_data && is_array($schedule_data)) {
        $events = wecoza_generate_recurring_events($class_data, $schedule_data);
    } else {
        // Fallback: create basic events from start/end dates
        $events = wecoza_generate_basic_events($class_data);
    }
    
    return $events;
}

/**
 * Generate recurring events from schedule data
 * 
 * @param array $class_data Class data
 * @param array $schedule_data Schedule configuration
 * @return array Array of events
 */
function wecoza_generate_recurring_events($class_data, $schedule_data) {
    $events = array();
    
    // Extract schedule parameters
    $pattern = $schedule_data['pattern'] ?? 'weekly';
    $start_date = $schedule_data['start_date'] ?? $class_data['original_start_date'];
    $end_date = $schedule_data['end_date'] ?? $class_data['delivery_date'];
    $start_time = $schedule_data['start_time'] ?? '09:00';
    $end_time = $schedule_data['end_time'] ?? '17:00';
    $selected_days = $schedule_data['days'] ?? array();
    $exception_dates = $schedule_data['exception_dates'] ?? array();
    
    if (!$start_date || !$end_date) {
        return $events;
    }
    
    // Generate events based on pattern
    $current_date = new DateTime($start_date);
    $end_date_obj = new DateTime($end_date);
    
    while ($current_date <= $end_date_obj) {
        $date_str = $current_date->format('Y-m-d');
        $day_name = $current_date->format('l');
        
        // Check if this date should have a class
        $should_include = false;
        
        if ($pattern === 'weekly' && in_array($day_name, $selected_days)) {
            $should_include = true;
        } elseif ($pattern === 'biweekly' && in_array($day_name, $selected_days)) {
            // Calculate if this is the correct bi-weekly occurrence
            $start_date_obj = new DateTime($start_date);
            $days_diff = $current_date->diff($start_date_obj)->days;
            if ($days_diff % 14 < 7) {
                $should_include = true;
            }
        } elseif ($pattern === 'monthly') {
            // Monthly pattern logic would go here
            $should_include = true;
        }
        
        // Check for exception dates
        if ($should_include && is_array($exception_dates)) {
            foreach ($exception_dates as $exception) {
                if (is_array($exception) && $exception['date'] === $date_str) {
                    $should_include = false;
                    break;
                }
            }
        }
        
        // Add event if it should be included
        if ($should_include) {
            // Create title with class subject and time range (using standard time format)
            $class_subject = $class_data['class_subject'] ?? 'Class Session';
            $event_title = sprintf('%s : %s - %s', $class_subject, $start_time, $end_time);

            $events[] = array(
                'title' => $event_title,
                'start' => $date_str . 'T' . $start_time,
                'end' => $date_str . 'T' . $end_time,
                'extendedProps' => array(
                    'type' => 'class_session',
                    'class_id' => $class_data['class_id'],
                    'class_code' => $class_data['class_code'] ?? '',
                    'description' => sprintf(
                        'Class: %s\nCode: %s\nTime: %s - %s\nDuration: %s hours',
                        $class_data['class_subject'] ?? 'N/A',
                        $class_data['class_code'] ?? 'N/A',
                        $start_time,
                        $end_time,
                        $class_data['class_duration'] ?? 'N/A'
                    )
                )
            );
        }
        
        // Move to next day
        $current_date->add(new DateInterval('P1D'));
    }
    
    return $events;
}

/**
 * Generate basic events from start/end dates (fallback)
 * 
 * @param array $class_data Class data
 * @return array Array of events
 */
function wecoza_generate_basic_events($class_data) {
    $events = array();

    // Get default times if not specified
    $default_start_time = '09:00';
    $default_end_time = '17:00';

    // Add start date event
    if (!empty($class_data['original_start_date'])) {
        $class_subject = $class_data['class_subject'] ?? 'Class';
        $start_title = sprintf('%s : %s - %s (Start)', $class_subject, $default_start_time, $default_end_time);

        $events[] = array(
            'title' => $start_title,
            'start' => $class_data['original_start_date'],
            'extendedProps' => array(
                'type' => 'class_start',
                'class_id' => $class_data['class_id'],
                'description' => 'Class start date'
            )
        );
    }

    // Add delivery date event
    if (!empty($class_data['delivery_date'])) {
        $class_subject = $class_data['class_subject'] ?? 'Class';
        $end_title = sprintf('%s : %s - %s (End)', $class_subject, $default_start_time, $default_end_time);

        $events[] = array(
            'title' => $end_title,
            'start' => $class_data['delivery_date'],
            'extendedProps' => array(
                'type' => 'class_end',
                'class_id' => $class_data['class_id'],
                'description' => 'Class delivery/end date'
            )
        );
    }

    return $events;
}
