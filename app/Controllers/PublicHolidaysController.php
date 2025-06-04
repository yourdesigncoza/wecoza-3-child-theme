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
     * Get public holidays formatted for FullCalendar
     *
     * @param int $year The year to get holidays for
     * @return array Array of FullCalendar-compatible event objects
     */
    public function getHolidaysForCalendar($year) {
        $holidays = $this->repository->getHolidaysByYear($year);
        $calendarEvents = array();

        foreach ($holidays as $holiday) {
            $calendarEvents[] = array(
                'id' => 'holiday_' . $holiday->getDate(),
                'title' => $holiday->getName(),
                'start' => $holiday->getDate(),
                'allDay' => true,
                'display' => 'background', // Shows as background event
                'classNames' => array('wecoza-public-holiday'),
                'extendedProps' => array(
                    'type' => 'public_holiday',
                    'isObserved' => $holiday->isObserved(),
                    'description' => $holiday->getDescription(),
                    'interactive' => false // Mark as non-interactive
                )
            );
        }

        return $calendarEvents;
    }

    /**
     * AJAX handler for getting public holidays
     * Following WordPress AJAX best practices
     */
    public static function handlePublicHolidaysAjax() {
        // Verify nonce for security
        if (!wp_verify_nonce($_POST['nonce'] ?? '', 'wecoza_calendar_nonce')) {
            wp_send_json_error('Security check failed');
            return;
        }

        // Get and validate year parameter
        $year = intval($_POST['year'] ?? date('Y'));

        // Validate year range (reasonable bounds)
        if ($year < 2020 || $year > 2030) {
            $year = date('Y');
        }

        try {
            // Get controller instance
            $controller = self::getInstance();

            // Get holidays formatted for FullCalendar
            $holidays = $controller->getHolidaysForCalendar($year);

            // Return holidays in FullCalendar format
            wp_send_json($holidays);

        } catch (Exception $e) {
            error_log('WeCoza Public Holidays Error: ' . $e->getMessage());
            error_log('WeCoza Public Holidays Error Stack: ' . $e->getTraceAsString());
            wp_send_json_error('Failed to load public holidays: ' . $e->getMessage());
        }
    }

    /**
     * Register hooks for the controller
     *
     * Registers WordPress AJAX handlers for public holidays
     */
    public function registerHooks() {
        // Register AJAX handlers for public holidays
        add_action('wp_ajax_wecoza_get_public_holidays', array($this, 'handlePublicHolidaysAjax'));
        add_action('wp_ajax_nopriv_wecoza_get_public_holidays', array($this, 'handlePublicHolidaysAjax'));
    }
}
