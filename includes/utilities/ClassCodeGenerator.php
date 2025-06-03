<?php
/**
 * WeCoza Class Code Generator Utility
 *
 * Isolated class for generating unique class codes based on client ID, class type and subject selections.
 * Format: [ClientID]-[ClassType]-[SubjectID]-[YYYY]-[MM]-[DD]-[HH]-[MM]
 *
 * Example output: 11-REALLL-RLN-2025-06-25-02-14
 * Where:
 * - 11 = Client ID
 * - REALLL = Class Type
 * - RLN = Subject ID
 * - 2025-06-25-02-14 = DateTime stamp (YYYY-MM-DD-HH-MM format)
 *
 * @author WeCoza Development Team
 * @version 2.0.0
 */

namespace WeCoza\Utilities;

class ClassCodeGenerator {
    
    /**
     * Generate a class code based on client ID, class type and subject
     *
     * @param string $clientId The selected client ID (e.g., "11")
     * @param string $classType The selected class type (e.g., "REALLL")
     * @param string $subjectId The selected subject ID (e.g., "RLN")
     * @return string The generated class code (e.g., "11-REALLL-RLN-2025-06-25-02-14")
     */
    public static function generateClassCode($clientId, $classType, $subjectId) {
        // Format: [ClientID]-[ClassType]-[SubjectID]-[YYYY]-[MM]-[DD]-[HH]-[MM]
        // Example: 11-REALLL-RLN-2025-06-25-02-14
        $now = new \DateTime();

        // Create readable datetime components
        $year = $now->format('Y'); // Full year (2025)
        $month = $now->format('m'); // Month (01-12)
        $day = $now->format('d'); // Day (01-31)
        $hour = $now->format('H'); // Hour (00-23)
        $minute = $now->format('i'); // Minute (00-59)

        return $clientId . '-' . $classType . '-' . $subjectId . '-' . $year . '-' . $month . '-' . $day . '-' . $hour . '-' . $minute;
    }
    
    /**
     * Generate a class code with custom datetime
     * Useful for testing or when you need a specific timestamp
     *
     * @param string $clientId The selected client ID
     * @param string $classType The selected class type
     * @param string $subjectId The selected subject ID
     * @param \DateTime $customDateTime Custom datetime to use for generation
     * @return string The generated class code
     */
    public static function generateClassCodeWithDateTime($clientId, $classType, $subjectId, \DateTime $customDateTime) {
        // Create readable datetime components
        $year = $customDateTime->format('Y'); // Full year (2025)
        $month = $customDateTime->format('m'); // Month (01-12)
        $day = $customDateTime->format('d'); // Day (01-31)
        $hour = $customDateTime->format('H'); // Hour (00-23)
        $minute = $customDateTime->format('i'); // Minute (00-59)

        return $clientId . '-' . $classType . '-' . $subjectId . '-' . $year . '-' . $month . '-' . $day . '-' . $hour . '-' . $minute;
    }
    
    /**
     * Parse a class code to extract its components
     * Supports both old and new formats for backward compatibility
     *
     * @param string $classCode The class code to parse
     * @return array|false Array with components or false if invalid format
     */
    public static function parseClassCode($classCode) {
        $parts = explode('-', $classCode);

        // New format: CLIENTID-CLASSTYPE-SUBJECTID-YYYY-MM-DD-HH-MM (8 parts)
        if (count($parts) === 8) {
            $clientId = $parts[0];
            $classType = $parts[1];
            $subjectId = $parts[2];
            $year = $parts[3];
            $month = $parts[4];
            $day = $parts[5];
            $hour = $parts[6];
            $minute = $parts[7];

            return [
                'client_id' => $clientId,
                'class_type' => $classType,
                'subject_id' => $subjectId,
                'year' => $year,
                'format' => 'new',
                'generated_at' => [
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'hour' => $hour,
                    'minute' => $minute,
                    'formatted' => "$year-$month-$day $hour:$minute"
                ]
            ];
        }

        // Old format: CLASSTYPE-SUBJECTID-YEAR-DATETIME (4 parts)
        if (count($parts) === 4) {
            $classType = $parts[0];
            $subjectId = $parts[1];
            $year = $parts[2];
            $dateTimeStamp = $parts[3];

            // Validate datetime stamp format (should be 10 digits: YMDHMM)
            if (strlen($dateTimeStamp) !== 10 || !is_numeric($dateTimeStamp)) {
                return false;
            }

            // Parse datetime components
            $dtYear = '20' . substr($dateTimeStamp, 0, 2);
            $dtMonth = substr($dateTimeStamp, 2, 2);
            $dtDay = substr($dateTimeStamp, 4, 2);
            $dtHour = substr($dateTimeStamp, 6, 2);
            $dtMinute = substr($dateTimeStamp, 8, 2);

            return [
                'client_id' => null, // Not available in old format
                'class_type' => $classType,
                'subject_id' => $subjectId,
                'year' => $year,
                'format' => 'old',
                'datetime_stamp' => $dateTimeStamp,
                'generated_at' => [
                    'year' => $dtYear,
                    'month' => $dtMonth,
                    'day' => $dtDay,
                    'hour' => $dtHour,
                    'minute' => $dtMinute,
                    'formatted' => "$dtYear-$dtMonth-$dtDay $dtHour:$dtMinute"
                ]
            ];
        }

        return false;
    }
    
    /**
     * Validate if a class code follows the expected format
     * 
     * @param string $classCode The class code to validate
     * @return bool True if valid format, false otherwise
     */
    public static function isValidClassCode($classCode) {
        return self::parseClassCode($classCode) !== false;
    }
}
