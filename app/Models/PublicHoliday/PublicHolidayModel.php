<?php
/**
 * PublicHolidayModel.php
 *
 * Model for handling public holiday data
 *
 * @package WeCoza
 * @subpackage Models
 */

namespace WeCoza\Models\PublicHoliday;

class PublicHolidayModel {
    /**
     * @var string The date of the public holiday (Y-m-d format)
     */
    private $date;

    /**
     * @var string The name of the public holiday
     */
    private $name;

    /**
     * @var string The description of the public holiday
     */
    private $description;

    /**
     * @var bool Whether this is an observed holiday (e.g., Monday after a Sunday holiday)
     */
    private $isObserved;

    /**
     * Constructor
     *
     * @param string $date The date of the public holiday (Y-m-d format)
     * @param string $name The name of the public holiday
     * @param string $description The description of the public holiday
     * @param bool $isObserved Whether this is an observed holiday
     */
    public function __construct($date, $name, $description = '', $isObserved = false) {
        $this->date = $date;
        $this->name = $name;
        $this->description = $description;
        $this->isObserved = $isObserved;
    }

    /**
     * Get the date of the public holiday
     *
     * @return string The date in Y-m-d format
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Get the name of the public holiday
     *
     * @return string The name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the description of the public holiday
     *
     * @return string The description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Check if this is an observed holiday
     *
     * @return bool True if this is an observed holiday
     */
    public function isObserved() {
        return $this->isObserved;
    }

    /**
     * Convert the model to an array
     *
     * @return array The model data as an array
     */
    public function toArray() {
        return [
            'date' => $this->date,
            'name' => $this->name,
            'description' => $this->description,
            'isObserved' => $this->isObserved
        ];
    }
}
