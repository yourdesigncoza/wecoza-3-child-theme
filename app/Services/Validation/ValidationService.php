<?php
/**
 * ValidationService.php
 *
 * A service for handling form validation across the application
 */

namespace WeCoza\Services\Validation;

class ValidationService {
    /**
     * @var array Validation errors
     */
    private $errors = [];

    /**
     * @var array Validation rules
     */
    private $rules = [];

    /**
     * @var array Data to validate
     */
    private $data = [];

    /**
     * Constructor
     *
     * @param array $rules Validation rules
     */
    public function __construct(array $rules = []) {
        $this->rules = $rules;
    }

    /**
     * Set validation rules
     *
     * @param array $rules Validation rules
     * @return $this
     */
    public function setRules(array $rules) {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Validate data against rules
     *
     * @param array $data Data to validate
     * @return bool Whether validation passed
     */
    public function validate(array $data) {
        $this->data = $data;
        $this->errors = [];

        foreach ($this->rules as $field => $fieldRules) {
            $this->validateField($field, $fieldRules);
        }

        return empty($this->errors);
    }

    /**
     * Validate a single field
     *
     * @param string $field Field name
     * @param array $fieldRules Rules for the field
     */
    private function validateField($field, $fieldRules) {
        $value = $this->getFieldValue($field);

        foreach ($fieldRules as $rule => $ruleValue) {
            switch ($rule) {
                case 'required':
                    if ($ruleValue && empty($value) && $value !== '0') {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field is required.');
                    }
                    break;

                case 'min_length':
                    if (strlen($value) < $ruleValue) {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field must be at least ' . $ruleValue . ' characters.');
                    }
                    break;

                case 'max_length':
                    if (strlen($value) > $ruleValue) {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field cannot exceed ' . $ruleValue . ' characters.');
                    }
                    break;

                case 'email':
                    if ($ruleValue && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field must contain a valid email address.');
                    }
                    break;

                case 'numeric':
                    if ($ruleValue && !empty($value) && !is_numeric($value)) {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field must contain only numbers.');
                    }
                    break;

                case 'date':
                    if ($ruleValue && !empty($value)) {
                        $date = \DateTime::createFromFormat('Y-m-d', $value);
                        if (!$date || $date->format('Y-m-d') !== $value) {
                            $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field must contain a valid date in YYYY-MM-DD format.');
                        }
                    }
                    break;

                case 'in_array':
                    if (!empty($value) && !in_array($value, $ruleValue)) {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field must be one of: ' . implode(', ', $ruleValue) . '.');
                    }
                    break;

                case 'array':
                    if ($ruleValue && (!is_array($value) || empty($value))) {
                        $this->addError($field, 'The ' . $this->formatFieldName($field) . ' field must contain at least one selection.');
                    }
                    break;

                case 'custom':
                    if (is_callable($ruleValue)) {
                        $result = call_user_func($ruleValue, $value, $this->data);
                        if ($result !== true) {
                            $this->addError($field, is_string($result) ? $result : 'The ' . $this->formatFieldName($field) . ' field is invalid.');
                        }
                    }
                    break;
            }
        }
    }

    /**
     * Get the value of a field from the data
     *
     * @param string $field Field name
     * @return mixed Field value
     */
    private function getFieldValue($field) {
        return isset($this->data[$field]) ? $this->data[$field] : null;
    }

    /**
     * Add an error message for a field
     *
     * @param string $field Field name
     * @param string $message Error message
     */
    private function addError($field, $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    /**
     * Format a field name for display in error messages
     *
     * @param string $field Field name
     * @return string Formatted field name
     */
    private function formatFieldName($field) {
        return ucfirst(str_replace('_', ' ', $field));
    }

    /**
     * Get all validation errors
     *
     * @return array Validation errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get errors for a specific field
     *
     * @param string $field Field name
     * @return array Field errors
     */
    public function getFieldErrors($field) {
        return isset($this->errors[$field]) ? $this->errors[$field] : [];
    }

    /**
     * Check if a field has errors
     *
     * @param string $field Field name
     * @return bool Whether the field has errors
     */
    public function hasFieldErrors($field) {
        return isset($this->errors[$field]) && !empty($this->errors[$field]);
    }

    /**
     * Get the first error message for a field
     *
     * @param string $field Field name
     * @return string|null First error message
     */
    public function getFirstFieldError($field) {
        return $this->hasFieldErrors($field) ? $this->errors[$field][0] : null;
    }

    /**
     * Get all errors as a flat array of messages
     *
     * @return array Flat array of error messages
     */
    public function getAllErrorMessages() {
        $messages = [];
        foreach ($this->errors as $fieldErrors) {
            $messages = array_merge($messages, $fieldErrors);
        }
        return $messages;
    }
}
