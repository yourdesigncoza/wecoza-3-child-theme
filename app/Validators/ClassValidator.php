<?php
/**
 * ClassValidator.php
 *
 * Centralized validation service for class data
 * Provides comprehensive validation rules and error handling
 */

namespace WeCoza\Validators;

use WeCoza\Services\Validation\ValidationService;

class ClassValidator {
    
    private $validationService;
    private $errors = [];
    
    public function __construct() {
        $this->validationService = new ValidationService();
    }
    
    /**
     * Validate class data for creation
     *
     * @param array $data Class data to validate
     * @return bool True if valid, false otherwise
     */
    public function validateCreate(array $data): bool {
        $this->errors = [];
        
        // Required field validation
        $this->validateRequiredFields($data);
        
        // Data type validation
        $this->validateDataTypes($data);
        
        // Business rule validation
        $this->validateBusinessRules($data);
        
        // Date validation
        $this->validateDates($data);
        
        // JSON field validation
        $this->validateJsonFields($data);
        
        return empty($this->errors);
    }
    
    /**
     * Validate class data for update
     *
     * @param array $data Class data to validate
     * @param int $classId Existing class ID
     * @return bool True if valid, false otherwise
     */
    public function validateUpdate(array $data, int $classId): bool {
        $this->errors = [];
        
        // ID validation
        if (!isset($data['id']) || intval($data['id']) !== $classId) {
            $this->errors['id'] = 'Invalid class ID for update';
        }
        
        // Same validation as create, but some fields may be optional
        $this->validateDataTypes($data);
        $this->validateBusinessRules($data);
        $this->validateDates($data);
        $this->validateJsonFields($data);
        
        return empty($this->errors);
    }
    
    /**
     * Get validation errors
     *
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }
    
    /**
     * Get formatted error messages
     *
     * @return string
     */
    public function getErrorMessages(): string {
        if (empty($this->errors)) {
            return '';
        }
        
        $messages = [];
        foreach ($this->errors as $field => $error) {
            $messages[] = ucfirst($field) . ': ' . $error;
        }
        
        return implode('; ', $messages);
    }
    
    /**
     * Validate required fields
     */
    private function validateRequiredFields(array $data): void {
        $requiredFields = [
            'client_id' => 'Client is required',
            'site_id' => 'Site is required',
            'class_type' => 'Class type is required',
            'class_subject' => 'Class subject is required',
            'original_start_date' => 'Start date is required'
        ];
        
        foreach ($requiredFields as $field => $message) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->errors[$field] = $message;
            }
        }
    }
    
    /**
     * Validate data types
     */
    private function validateDataTypes(array $data): void {
        // Integer fields
        $integerFields = ['client_id', 'site_id', 'class_agent', 'project_supervisor_id', 'class_duration'];
        foreach ($integerFields as $field) {
            if (isset($data[$field]) && !empty($data[$field]) && !is_numeric($data[$field])) {
                $this->errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' must be a number';
            }
        }
        
        // Boolean fields
        $booleanFields = ['seta_funded', 'exam_class'];
        foreach ($booleanFields as $field) {
            if (isset($data[$field]) && !in_array($data[$field], ['true', 'false', '1', '0', 1, 0, true, false], true)) {
                $this->errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' must be true or false';
            }
        }
        
        // String length validation
        $stringFields = [
            'class_address_line' => 100,
            'class_type' => 50,
            'class_subject' => 100,
            'class_code' => 50,
            'exam_type' => 50,
            'seta' => 100
        ];
        
        foreach ($stringFields as $field => $maxLength) {
            if (isset($data[$field]) && strlen($data[$field]) > $maxLength) {
                $this->errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " cannot exceed {$maxLength} characters";
            }
        }
    }
    
    /**
     * Validate business rules
     */
    private function validateBusinessRules(array $data): void {
        // If exam class is true, exam type should be provided
        if (isset($data['exam_class']) && $this->toBool($data['exam_class']) && empty($data['exam_type'])) {
            $this->errors['exam_type'] = 'Exam type is required when class is marked as exam class';
        }
        
        // If SETA funded is true, SETA should be provided
        if (isset($data['seta_funded']) && $this->toBool($data['seta_funded']) && empty($data['seta'])) {
            $this->errors['seta'] = 'SETA information is required when class is SETA funded';
        }
        
        // Class duration should be positive
        if (isset($data['class_duration']) && intval($data['class_duration']) <= 0) {
            $this->errors['class_duration'] = 'Class duration must be greater than 0';
        }
        
        // Validate agent assignments
        if (isset($data['class_agent']) && isset($data['backup_agent_ids'])) {
            $backupAgents = is_string($data['backup_agent_ids']) ? 
                json_decode($data['backup_agent_ids'], true) : $data['backup_agent_ids'];
            
            if (is_array($backupAgents) && in_array($data['class_agent'], $backupAgents)) {
                $this->errors['backup_agent_ids'] = 'Primary agent cannot be listed as backup agent';
            }
        }
    }
    
    /**
     * Validate dates
     */
    private function validateDates(array $data): void {
        $dateFields = ['original_start_date', 'delivery_date', 'initial_agent_start_date'];
        
        foreach ($dateFields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                if (!$this->isValidDate($data[$field])) {
                    $this->errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' must be a valid date (YYYY-MM-DD)';
                }
            }
        }
        
        // Delivery date should not be before start date
        if (isset($data['original_start_date']) && isset($data['delivery_date']) && 
            !empty($data['original_start_date']) && !empty($data['delivery_date'])) {
            
            if (strtotime($data['delivery_date']) < strtotime($data['original_start_date'])) {
                $this->errors['delivery_date'] = 'Delivery date cannot be before start date';
            }
        }
    }
    
    /**
     * Validate JSON fields
     */
    private function validateJsonFields(array $data): void {
        $jsonFields = ['learner_ids', 'backup_agent_ids', 'schedule_data', 'stop_restart_dates', 'class_notes_data', 'qa_reports'];
        
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                if (is_string($data[$field])) {
                    $decoded = json_decode($data[$field], true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $this->errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' must be valid JSON';
                    }
                }
            }
        }
        
        // Validate learner_ids array
        if (isset($data['learner_ids'])) {
            $learnerIds = is_string($data['learner_ids']) ? 
                json_decode($data['learner_ids'], true) : $data['learner_ids'];
            
            if (is_array($learnerIds)) {
                foreach ($learnerIds as $learnerId) {
                    if (!is_numeric($learnerId)) {
                        $this->errors['learner_ids'] = 'All learner IDs must be numeric';
                        break;
                    }
                }
            }
        }
        
        // Validate backup_agent_ids array
        if (isset($data['backup_agent_ids'])) {
            $backupAgentIds = is_string($data['backup_agent_ids']) ? 
                json_decode($data['backup_agent_ids'], true) : $data['backup_agent_ids'];
            
            if (is_array($backupAgentIds)) {
                foreach ($backupAgentIds as $agentId) {
                    if (!is_numeric($agentId)) {
                        $this->errors['backup_agent_ids'] = 'All backup agent IDs must be numeric';
                        break;
                    }
                }
            }
        }
    }
    
    /**
     * Check if a date string is valid
     */
    private function isValidDate(string $date): bool {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
    
    /**
     * Convert various boolean representations to actual boolean
     */
    private function toBool($value): bool {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            return in_array(strtolower($value), ['true', '1', 'yes', 'on']);
        }
        
        return (bool) $value;
    }
    
    /**
     * Validate file uploads (for QA reports)
     */
    public function validateFileUploads(array $files): bool {
        $this->errors = [];
        
        if (empty($files)) {
            return true; // No files to validate
        }
        
        $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        
        foreach ($files as $fieldName => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $this->errors[$fieldName] = 'File upload error: ' . $this->getUploadErrorMessage($file['error']);
                continue;
            }
            
            // Check file size
            if ($file['size'] > $maxFileSize) {
                $this->errors[$fieldName] = 'File size cannot exceed 5MB';
                continue;
            }
            
            // Check file type
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedTypes)) {
                $this->errors[$fieldName] = 'File type not allowed. Allowed types: ' . implode(', ', $allowedTypes);
                continue;
            }
        }
        
        return empty($this->errors);
    }
    
    /**
     * Get upload error message
     */
    private function getUploadErrorMessage(int $errorCode): string {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'File exceeds upload_max_filesize directive';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File exceeds MAX_FILE_SIZE directive';
            case UPLOAD_ERR_PARTIAL:
                return 'File was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown upload error';
        }
    }
}
