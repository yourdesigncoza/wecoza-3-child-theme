<?php
/**
 * CalendarExportService.php
 *
 * Service for exporting calendar data to various formats
 */

namespace WeCoza\Services\Export;

use WeCoza\Models\Assessment\ClassModel;
use WeCoza\Services\Database\DatabaseService;

class CalendarExportService {
    /**
     * Generate iCalendar (.ics) file content for classes
     *
     * @param array $classIds Array of class IDs to export
     * @return string iCalendar file content
     */
    public static function generateICalendar($classIds = []) {
        // Start building the iCalendar content
        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "PRODID:-//WeCoza//Class Calendar//EN\r\n";
        $ical .= "CALSCALE:GREGORIAN\r\n";
        $ical .= "METHOD:PUBLISH\r\n";
        $ical .= "X-WR-CALNAME:WeCoza Classes\r\n";
        $ical .= "X-WR-TIMEZONE:Africa/Johannesburg\r\n";
        
        // Get classes from database
        $classes = self::getClassesData($classIds);
        
        // Add each class schedule as an event
        foreach ($classes as $class) {
            $ical .= self::createClassEvents($class);
        }
        
        // Close the calendar
        $ical .= "END:VCALENDAR\r\n";
        
        return $ical;
    }
    
    /**
     * Get classes data from database
     *
     * @param array $classIds Array of class IDs to fetch
     * @return array Classes data
     */
    private static function getClassesData($classIds = []) {
        try {
            $db = DatabaseService::getInstance();
            
            // Build query based on whether specific class IDs were provided
            if (!empty($classIds)) {
                // Convert array of IDs to comma-separated string for IN clause
                $idPlaceholders = implode(',', array_fill(0, count($classIds), '?'));
                
                $sql = "SELECT c.id, c.client_id, c.site_id, c.site_address, c.class_type, 
                        c.class_start_date, c.class_agent, cl.name as client_name, 
                        a.name as agent_name
                        FROM wecoza_classes c
                        LEFT JOIN clients cl ON c.client_id = cl.client_id
                        LEFT JOIN agents a ON c.class_agent = a.agent_id
                        WHERE c.id IN ($idPlaceholders)";
                
                $stmt = $db->query($sql, $classIds);
            } else {
                // Get all classes
                $sql = "SELECT c.id, c.client_id, c.site_id, c.site_address, c.class_type, 
                        c.class_start_date, c.class_agent, cl.name as client_name, 
                        a.name as agent_name
                        FROM wecoza_classes c
                        LEFT JOIN clients cl ON c.client_id = cl.client_id
                        LEFT JOIN agents a ON c.class_agent = a.agent_id";
                
                $stmt = $db->query($sql);
            }
            
            $classes = $stmt->fetchAll();
            
            // For each class, get its schedule data
            foreach ($classes as &$class) {
                $scheduleQuery = "SELECT * FROM wecoza_class_schedule WHERE class_id = ?";
                $scheduleStmt = $db->query($scheduleQuery, [$class['id']]);
                $class['schedule'] = $scheduleStmt->fetchAll();
                
                // Get stop/restart dates
                $datesQuery = "SELECT * FROM wecoza_class_dates WHERE class_id = ?";
                $datesStmt = $db->query($datesQuery, [$class['id']]);
                $class['dates'] = $datesStmt->fetchAll();
            }
            
            return $classes;
        } catch (\Exception $e) {
            error_log('Error fetching classes for export: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create iCalendar events for a class
     *
     * @param array $class Class data
     * @return string iCalendar events
     */
    private static function createClassEvents($class) {
        $events = "";
        
        // Process each scheduled session
        foreach ($class['schedule'] as $schedule) {
            // Skip if no date or times
            if (empty($schedule['date']) || empty($schedule['start_time']) || empty($schedule['end_time'])) {
                continue;
            }
            
            // Format date and times for iCalendar
            $startDateTime = self::formatDateTime($schedule['date'] . ' ' . $schedule['start_time']);
            $endDateTime = self::formatDateTime($schedule['date'] . ' ' . $schedule['end_time']);
            
            // Create a unique ID for this event
            $uid = md5($class['id'] . '-' . $schedule['date'] . '-' . $schedule['start_time']) . '@wecoza.co.za';
            
            // Create event summary
            $summary = $class['client_name'] . ' - ' . $class['class_type'];
            if (!empty($schedule['notes'])) {
                $summary .= ' - ' . $schedule['notes'];
            }
            
            // Create event description
            $description = "Class Type: " . $class['class_type'] . "\\n";
            $description .= "Client: " . $class['client_name'] . "\\n";
            if (!empty($class['site_address'])) {
                $description .= "Location: " . $class['site_address'] . "\\n";
            }
            if (!empty($class['agent_name'])) {
                $description .= "Agent: " . $class['agent_name'] . "\\n";
            }
            if (!empty($schedule['notes'])) {
                $description .= "Notes: " . $schedule['notes'] . "\\n";
            }
            
            // Check if this date falls within a stop/restart period
            $skipEvent = false;
            foreach ($class['dates'] as $dateRange) {
                $stopDate = strtotime($dateRange['stop_date']);
                $restartDate = strtotime($dateRange['restart_date']);
                $eventDate = strtotime($schedule['date']);
                
                if ($eventDate >= $stopDate && $eventDate < $restartDate) {
                    $skipEvent = true;
                    break;
                }
            }
            
            // Skip this event if it falls within a stop/restart period
            if ($skipEvent) {
                continue;
            }
            
            // Build the event
            $events .= "BEGIN:VEVENT\r\n";
            $events .= "UID:" . $uid . "\r\n";
            $events .= "DTSTAMP:" . self::formatDateTime(date('Y-m-d H:i:s')) . "\r\n";
            $events .= "DTSTART:" . $startDateTime . "\r\n";
            $events .= "DTEND:" . $endDateTime . "\r\n";
            $events .= "SUMMARY:" . self::escapeString($summary) . "\r\n";
            $events .= "DESCRIPTION:" . self::escapeString($description) . "\r\n";
            if (!empty($class['site_address'])) {
                $events .= "LOCATION:" . self::escapeString($class['site_address']) . "\r\n";
            }
            $events .= "END:VEVENT\r\n";
        }
        
        return $events;
    }
    
    /**
     * Format date and time for iCalendar
     *
     * @param string $dateTime Date and time in Y-m-d H:i:s format
     * @return string Formatted date and time
     */
    private static function formatDateTime($dateTime) {
        return date('Ymd\THis\Z', strtotime($dateTime));
    }
    
    /**
     * Escape special characters in iCalendar strings
     *
     * @param string $string String to escape
     * @return string Escaped string
     */
    private static function escapeString($string) {
        $string = str_replace(array("\\", ";", ","), array("\\\\", "\\;", "\\,"), $string);
        return $string;
    }
}
