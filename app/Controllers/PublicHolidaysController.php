<?php
/**
 * PublicHolidaysController.php
 *
 * Controller for managing public holidays
 *
 * @package WeCoza
 * @subpackage Controllers
 */

namespace WeCoza\Controllers;

use WeCoza\Models\PublicHoliday\PublicHolidayModel;
use WeCoza\Models\PublicHoliday\PublicHolidayRepository;

class PublicHolidaysController {
    /**
     * @var PublicHolidayRepository Repository for public holiday data
     */
    private $repository;

    /**
     * @var PublicHolidaysController Singleton instance
     */
    private static $instance = null;

    /**
     * Get the singleton instance
     *
     * @return PublicHolidaysController
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->initialize();
        }
        return self::$instance;
    }

    /**
     * Constructor - initializes the controller
     *
     * This constructor is public to be compatible with the bootstrap initialization,
     * but it will always return the singleton instance.
     */
    public function __construct() {
        // This is intentionally empty to avoid initialization
        // The actual initialization happens in the getInstance() method
    }

    /**
     * Initialize the controller
     *
     * This method is called by the singleton getInstance() method
     */
    private function initialize() {
        // Get the repository instance
        $this->repository = PublicHolidayRepository::getInstance();
        $this->registerHooks();
    }

    /**
     * Get all public holidays
     *
     * @return array Array of PublicHolidayModel objects
     */
    public function getAllHolidays() {
        return $this->repository->getAllHolidays();
    }

    /**
     * Get holidays for a specific year
     *
     * @param int $year The year to get holidays for
     * @return array Array of PublicHolidayModel objects
     */
    public function getHolidaysByYear($year) {
        return $this->repository->getHolidaysByYear($year);
    }

    /**
     * Get all public holidays as an array of dates
     *
     * @return array Array of dates in Y-m-d format
     */
    public function getAllHolidayDates() {
        $holidays = $this->repository->getAllHolidays();
        return array_map(function($holiday) {
            return $holiday->getDate();
        }, $holidays);
    }

    /**
     * Check if a date is a public holiday
     *
     * @param string $date Date in Y-m-d format
     * @return bool True if the date is a public holiday
     */
    public function isPublicHoliday($date) {
        return $this->repository->isPublicHoliday($date);
    }

    /**
     * Get public holiday information for a specific date
     *
     * @param string $date Date in Y-m-d format
     * @return PublicHolidayModel|null The holiday model or null if not a holiday
     */
    public function getHolidayInfo($date) {
        return $this->repository->getHolidayByDate($date);
    }

    /**
     * Get public holidays within a date range
     *
     * @param string $startDate Start date in Y-m-d format
     * @param string $endDate End date in Y-m-d format
     * @return array Array of PublicHolidayModel objects
     */
    public function getHolidaysInRange($startDate, $endDate) {
        return $this->repository->getHolidaysInRange($startDate, $endDate);
    }

    /**
     * Get public holiday dates within a date range
     *
     * @param string $startDate Start date in Y-m-d format
     * @param string $endDate End date in Y-m-d format
     * @return array Array of dates in Y-m-d format
     */
    public function getHolidayDatesInRange($startDate, $endDate) {
        return $this->repository->getHolidayDatesInRange($startDate, $endDate);
    }

    /**
     * Get public holidays as calendar events
     *
     * @return array Array of events formatted for FullCalendar
     */
    public function getHolidaysAsCalendarEvents() {
        $events = [];
        $holidays = $this->repository->getAllHolidays();

        foreach ($holidays as $holiday) {
            $date = $holiday->getDate();

            // Debug log
            error_log("Preparing holiday for calendar: {$holiday->getName()} on {$date}");

            // Subtract one day from the date to compensate for the timezone shift
            $dateObj = new \DateTime($date);
            $dateObj->modify('-1 day');
            $adjustedDate = $dateObj->format('Y-m-d');

            // Debug log
            error_log("Adjusted holiday date: {$date} -> {$adjustedDate}");

            $events[] = [
                'title' => $holiday->getName(),
                'start' => $adjustedDate,
                'allDay' => true,
                'className' => 'public-holiday',
                'description' => $holiday->getDescription(),
                'extendedProps' => [
                    'isPublicHoliday' => true,
                    'isObserved' => $holiday->isObserved()
                ]
            ];
        }

        // Debug log
        error_log("Total holidays prepared for calendar: " . count($events));

        return $events;
    }

    /**
     * Add a new holiday
     *
     * @param string $date Date in Y-m-d format
     * @param string $name Holiday name
     * @param bool $isObserved Whether this is an observed holiday
     * @return bool Success status
     */
    public function addHoliday($date, $name, $isObserved = false) {
        return $this->repository->addNewHoliday($date, $name, $isObserved);
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
        return $this->repository->updateHoliday($date, $name, $isObserved);
    }

    /**
     * Delete a holiday
     *
     * @param string $date Date in Y-m-d format
     * @return bool Success status
     */
    public function deleteHoliday($date) {
        return $this->repository->deleteHoliday($date);
    }

    /**
     * Register hooks for the controller
     *
     * Note: This is a placeholder for WordPress hooks.
     * The actual integration is handled in ClassController.
     */
    public function registerHooks() {
        // Hooks are handled in ClassController
    }
}
