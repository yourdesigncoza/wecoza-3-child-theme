<?php
/**
 * PublicHolidayRepository.php
 *
 * Repository for handling public holiday data access
 * This will be replaced with actual database access in the future
 *
 * @package WeCoza
 * @subpackage Models
 */

namespace WeCoza\Models\PublicHoliday;

class PublicHolidayRepository {
    /**
     * @var PublicHolidayRepository Singleton instance
     */
    private static $instance = null;

    /**
     * @var array Array of hardcoded public holidays
     */
    private $holidays = [];

    /**
     * Get the singleton instance
     *
     * @return PublicHolidayRepository
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - initializes the repository with hardcoded data
     * In the future, this will be replaced with database access
     */
    private function __construct() {
        $this->initializeHolidays();
    }

    /**
     * Initialize holidays with hardcoded data
     * This simulates a database table with Year, Date, and HolidayDesc columns
     */
    private function initializeHolidays() {
        // 2025 Public Holidays
        $this->addHoliday(2025, '01-01', 'New Year\'s Day');
        $this->addHoliday(2025, '03-21', 'Human Rights Day');
        $this->addHoliday(2025, '04-18', 'Good Friday');
        $this->addHoliday(2025, '04-21', 'Family Day');
        $this->addHoliday(2025, '04-27', 'Freedom Day');
        $this->addHoliday(2025, '04-28', 'Public holiday (Freedom Day observed)', true);
        $this->addHoliday(2025, '05-01', 'Workers\' Day');
        $this->addHoliday(2025, '06-16', 'Youth Day');
        $this->addHoliday(2025, '08-09', 'National Women\'s Day');
        $this->addHoliday(2025, '09-24', 'Heritage Day');
        $this->addHoliday(2025, '12-16', 'Day of Reconciliation');
        $this->addHoliday(2025, '12-25', 'Christmas Day');
        $this->addHoliday(2025, '12-26', 'Day of Goodwill');

        // 2026 Public Holidays
        $this->addHoliday(2026, '01-01', 'New Year\'s Day');
        $this->addHoliday(2026, '03-21', 'Human Rights Day');
        $this->addHoliday(2026, '04-03', 'Good Friday');
        $this->addHoliday(2026, '04-06', 'Family Day');
        $this->addHoliday(2026, '04-27', 'Freedom Day');
        $this->addHoliday(2026, '05-01', 'Workers\' Day');
        $this->addHoliday(2026, '06-16', 'Youth Day');
        $this->addHoliday(2026, '08-09', 'National Women\'s Day');
        $this->addHoliday(2026, '08-10', 'Public holiday (National Women\'s Day observed)', true);
        $this->addHoliday(2026, '09-24', 'Heritage Day');
        $this->addHoliday(2026, '12-16', 'Day of Reconciliation');
        $this->addHoliday(2026, '12-25', 'Christmas Day');
        $this->addHoliday(2026, '12-26', 'Day of Goodwill');
    }

    /**
     * Add a holiday to the repository
     *
     * @param int $year The year of the holiday
     * @param string $date The date in MM-DD format
     * @param string $name The name of the holiday
     * @param bool $isObserved Whether this is an observed holiday
     */
    private function addHoliday($year, $date, $name, $isObserved = false) {
        // Parse the date components to ensure correct format
        list($month, $day) = explode('-', $date);

        // Create a DateTime object to ensure correct date
        $dateObj = new \DateTime();
        $dateObj->setDate($year, (int)$month, (int)$day);

        // Format the date in Y-m-d format
        $formattedDate = $dateObj->format('Y-m-d');

        // Debug log
        error_log("Adding holiday: {$name} on {$formattedDate}");

        $this->holidays[] = new PublicHolidayModel(
            $formattedDate,
            $name,
            '', // Empty description
            $isObserved
        );
    }

    /**
     * Get all holidays
     *
     * @return array Array of PublicHolidayModel objects
     */
    public function getAllHolidays() {
        return $this->holidays;
    }

    /**
     * Get holidays for a specific year
     *
     * @param int $year The year to get holidays for
     * @return array Array of PublicHolidayModel objects
     */
    public function getHolidaysByYear($year) {
        $yearHolidays = [];
        $yearPrefix = $year . '-';

        foreach ($this->holidays as $holiday) {
            if (strpos($holiday->getDate(), $yearPrefix) === 0) {
                $yearHolidays[] = $holiday;
            }
        }

        return $yearHolidays;
    }

    /**
     * Get holiday by date
     *
     * @param string $date Date in Y-m-d format
     * @return PublicHolidayModel|null The holiday model or null if not found
     */
    public function getHolidayByDate($date) {
        foreach ($this->holidays as $holiday) {
            if ($holiday->getDate() === $date) {
                return $holiday;
            }
        }
        return null;
    }

    /**
     * Check if a date is a public holiday
     *
     * @param string $date Date in Y-m-d format
     * @return bool True if the date is a public holiday
     */
    public function isPublicHoliday($date) {
        return $this->getHolidayByDate($date) !== null;
    }

    /**
     * Get holidays within a date range
     *
     * @param string $startDate Start date in Y-m-d format
     * @param string $endDate End date in Y-m-d format
     * @return array Array of PublicHolidayModel objects
     */
    public function getHolidaysInRange($startDate, $endDate) {
        $result = [];

        foreach ($this->holidays as $holiday) {
            $holidayDate = $holiday->getDate();
            if ($holidayDate >= $startDate && $holidayDate <= $endDate) {
                $result[] = $holiday;
            }
        }

        return $result;
    }

    /**
     * Get holiday dates within a date range
     *
     * @param string $startDate Start date in Y-m-d format
     * @param string $endDate End date in Y-m-d format
     * @return array Array of dates in Y-m-d format
     */
    public function getHolidayDatesInRange($startDate, $endDate) {
        $holidays = $this->getHolidaysInRange($startDate, $endDate);

        return array_map(function($holiday) {
            return $holiday->getDate();
        }, $holidays);
    }

    /**
     * Add a new holiday
     *
     * @param string $date Date in Y-m-d format
     * @param string $name Holiday name
     * @param bool $isObserved Whether this is an observed holiday
     * @return bool Success status
     */
    public function addNewHoliday($date, $name, $isObserved = false) {
        // Ensure date is in Y-m-d format
        try {
            $dateObj = new \DateTime($date);
            $formattedDate = $dateObj->format('Y-m-d');

            // Debug log
            error_log("Adding new holiday: {$name} on {$formattedDate}");

            // In a real database implementation, this would insert a new record
            $this->holidays[] = new PublicHolidayModel(
                $formattedDate,
                $name,
                '', // Empty description
                $isObserved
            );

            return true;
        } catch (\Exception $e) {
            error_log("Error adding holiday: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing holiday
     *
     * @param string $date Date in Y-m-d format
     * @param string $name Holiday name
     * @param bool $isObserved Whether this is an observed holiday
     * @return bool Success status
     */
    public function updateHoliday($date, $name, $isObserved = false) {
        try {
            // Ensure date is in Y-m-d format
            $dateObj = new \DateTime($date);
            $formattedDate = $dateObj->format('Y-m-d');

            // Debug log
            error_log("Updating holiday on {$formattedDate} to: {$name}");

            // In a real database implementation, this would update an existing record
            foreach ($this->holidays as $key => $holiday) {
                if ($holiday->getDate() === $formattedDate) {
                    $this->holidays[$key] = new PublicHolidayModel(
                        $formattedDate,
                        $name,
                        '', // Empty description
                        $isObserved
                    );
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            error_log("Error updating holiday: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a holiday
     *
     * @param string $date Date in Y-m-d format
     * @return bool Success status
     */
    public function deleteHoliday($date) {
        try {
            // Ensure date is in Y-m-d format
            $dateObj = new \DateTime($date);
            $formattedDate = $dateObj->format('Y-m-d');

            // Debug log
            error_log("Deleting holiday on {$formattedDate}");

            // In a real database implementation, this would delete a record
            foreach ($this->holidays as $key => $holiday) {
                if ($holiday->getDate() === $formattedDate) {
                    unset($this->holidays[$key]);
                    $this->holidays = array_values($this->holidays); // Reindex array
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            error_log("Error deleting holiday: " . $e->getMessage());
            return false;
        }
    }
}
