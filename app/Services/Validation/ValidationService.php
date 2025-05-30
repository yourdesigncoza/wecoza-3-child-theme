<?php
/**
 * ValidationService.php
 *
 * DEPRECATED: Server-side validation has been removed.
 * All validation is now handled on the frontend using JavaScript and Bootstrap validation.
 * This file is kept for backward compatibility but all methods are disabled.
 */

namespace WeCoza\Services\Validation;

class ValidationService {
    /**
     * Constructor - DEPRECATED
     *
     * @param array $rules Validation rules (ignored)
     */
    public function __construct(array $rules = []) {
        // Server-side validation disabled - using frontend validation only
    }

    /**
     * Set validation rules - DEPRECATED
     *
     * @param array $rules Validation rules (ignored)
     * @return $this
     */
    public function setRules(array $rules) {
        // Server-side validation disabled - using frontend validation only
        return $this;
    }

    /**
     * Validate data - DEPRECATED
     * Always returns true as validation is handled on frontend
     *
     * @param array $data Data to validate (ignored)
     * @return bool Always returns true
     */
    public function validate(array $data) {
        // Server-side validation disabled - using frontend validation only
        return true;
    }

    /**
     * Add a custom error message - DEPRECATED
     * No-op method
     *
     * @param string $field Field name (ignored)
     * @param string $message Error message (ignored)
     */
    public function addCustomError($field, $message) {
        // Server-side validation disabled - using frontend validation only
    }

    /**
     * Get validation errors - DEPRECATED
     * Always returns empty array
     *
     * @return array Always returns empty array
     */
    public function getErrors() {
        // Server-side validation disabled - using frontend validation only
        return [];
    }

    /**
     * Get errors for a specific field - DEPRECATED
     * Always returns empty array
     *
     * @param string $field Field name (ignored)
     * @return array Always returns empty array
     */
    public function getFieldErrors($field) {
        // Server-side validation disabled - using frontend validation only
        return [];
    }

    /**
     * Check if a field has errors - DEPRECATED
     * Always returns false
     *
     * @param string $field Field name (ignored)
     * @return bool Always returns false
     */
    public function hasFieldErrors($field) {
        // Server-side validation disabled - using frontend validation only
        return false;
    }

    /**
     * Get the first error message for a field - DEPRECATED
     * Always returns null
     *
     * @param string $field Field name (ignored)
     * @return string|null Always returns null
     */
    public function getFirstFieldError($field) {
        // Server-side validation disabled - using frontend validation only
        return null;
    }

    /**
     * Get all errors as a flat array - DEPRECATED
     * Always returns empty array
     *
     * @return array Always returns empty array
     */
    public function getAllErrorMessages() {
        // Server-side validation disabled - using frontend validation only
        return [];
    }
}
