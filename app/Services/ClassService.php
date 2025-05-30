<?php
/**
 * ClassService.php
 *
 * Business logic service for class operations
 * Handles complex business rules and coordinates between repository and validation
 */

namespace WeCoza\Services;

use WeCoza\Contracts\ClassRepositoryInterface;
use WeCoza\Validators\ClassValidator;
use WeCoza\Models\Assessment\ClassModel;

class ClassService {
    
    private $repository;
    private $validator;
    
    public function __construct(ClassRepositoryInterface $repository, ClassValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    /**
     * Create a new class
     *
     * @param array $data Class data
     * @return array ['success' => bool, 'data' => ClassModel|null, 'errors' => array]
     */
    public function createClass(array $data): array {
        try {
            // Validate data
            if (!$this->validator->validateCreate($data)) {
                return [
                    'success' => false,
                    'data' => null,
                    'errors' => $this->validator->getErrors()
                ];
            }
            
            // Process and clean data
            $processedData = $this->processClassData($data);
            
            // Generate class code if not provided
            if (empty($processedData['class_code'])) {
                $processedData['class_code'] = $this->generateClassCode($processedData);
            }
            
            // Create class through repository
            $class = $this->repository->create($processedData);
            
            return [
                'success' => true,
                'data' => $class,
                'errors' => []
            ];
            
        } catch (\Exception $e) {
            error_log("ClassService::createClass error: " . $e->getMessage());
            return [
                'success' => false,
                'data' => null,
                'errors' => ['general' => 'Failed to create class: ' . $e->getMessage()]
            ];
        }
    }
    
    /**
     * Update an existing class
     *
     * @param int $id Class ID
     * @param array $data Updated data
     * @return array ['success' => bool, 'data' => ClassModel|null, 'errors' => array]
     */
    public function updateClass(int $id, array $data): array {
        try {
            // Check if class exists
            if (!$this->repository->exists($id)) {
                return [
                    'success' => false,
                    'data' => null,
                    'errors' => ['general' => 'Class not found']
                ];
            }
            
            // Validate data
            if (!$this->validator->validateUpdate($data, $id)) {
                return [
                    'success' => false,
                    'data' => null,
                    'errors' => $this->validator->getErrors()
                ];
            }
            
            // Process and clean data
            $processedData = $this->processClassData($data);
            
            // Update class through repository
            $class = $this->repository->update($id, $processedData);
            
            return [
                'success' => true,
                'data' => $class,
                'errors' => []
            ];
            
        } catch (\Exception $e) {
            error_log("ClassService::updateClass error: " . $e->getMessage());
            return [
                'success' => false,
                'data' => null,
                'errors' => ['general' => 'Failed to update class: ' . $e->getMessage()]
            ];
        }
    }
    
    /**
     * Get a class by ID
     *
     * @param int $id Class ID
     * @return ClassModel|null
     */
    public function getClass(int $id): ?ClassModel {
        return $this->repository->findById($id);
    }
    
    /**
     * Get all classes with optional filters
     *
     * @param array $filters Optional filters
     * @param array $orderBy Optional ordering
     * @return array
     */
    public function getAllClasses(array $filters = [], array $orderBy = []): array {
        return $this->repository->findAll($filters, $orderBy);
    }
    
    /**
     * Get classes with pagination
     *
     * @param int $page Page number
     * @param int $perPage Items per page
     * @param array $filters Optional filters
     * @param array $orderBy Optional ordering
     * @return array
     */
    public function getClassesPaginated(int $page, int $perPage, array $filters = [], array $orderBy = []): array {
        return $this->repository->paginate($page, $perPage, $filters, $orderBy);
    }
    
    /**
     * Delete a class
     *
     * @param int $id Class ID
     * @return array ['success' => bool, 'errors' => array]
     */
    public function deleteClass(int $id): array {
        try {
            // Check if class exists
            if (!$this->repository->exists($id)) {
                return [
                    'success' => false,
                    'errors' => ['general' => 'Class not found']
                ];
            }
            
            // Check if class can be deleted (business rules)
            $canDelete = $this->canDeleteClass($id);
            if (!$canDelete['allowed']) {
                return [
                    'success' => false,
                    'errors' => ['general' => $canDelete['reason']]
                ];
            }
            
            // Delete class
            $result = $this->repository->delete($id);
            
            return [
                'success' => $result,
                'errors' => $result ? [] : ['general' => 'Failed to delete class']
            ];
            
        } catch (\Exception $e) {
            error_log("ClassService::deleteClass error: " . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['general' => 'Failed to delete class: ' . $e->getMessage()]
            ];
        }
    }
    
    /**
     * Get classes by client
     *
     * @param int $clientId Client ID
     * @return array
     */
    public function getClassesByClient(int $clientId): array {
        return $this->repository->findByClientId($clientId);
    }
    
    /**
     * Get classes by agent
     *
     * @param int $agentId Agent ID
     * @return array
     */
    public function getClassesByAgent(int $agentId): array {
        return $this->repository->findByAgentId($agentId);
    }
    
    /**
     * Get classes by learner
     *
     * @param int $learnerId Learner ID
     * @return array
     */
    public function getClassesByLearner(int $learnerId): array {
        return $this->repository->findByLearnerId($learnerId);
    }
    
    /**
     * Get class statistics
     *
     * @param array $filters Optional filters
     * @return array
     */
    public function getClassStatistics(array $filters = []): array {
        return $this->repository->getStatistics($filters);
    }
    
    /**
     * Process and clean class data
     *
     * @param array $data Raw class data
     * @return array Processed data
     */
    private function processClassData(array $data): array {
        $processed = [];
        
        // Clean and convert data types
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'client_id':
                case 'site_id':
                case 'class_agent':
                case 'project_supervisor_id':
                case 'class_duration':
                case 'initial_class_agent':
                    $processed[$key] = !empty($value) ? intval($value) : null;
                    break;
                    
                case 'seta_funded':
                case 'exam_class':
                    $processed[$key] = $this->toBool($value);
                    break;
                    
                case 'learner_ids':
                case 'backup_agent_ids':
                case 'schedule_data':
                case 'stop_restart_dates':
                case 'class_notes_data':
                case 'qa_reports':
                    $processed[$key] = $this->processJsonField($value);
                    break;
                    
                case 'original_start_date':
                case 'delivery_date':
                case 'initial_agent_start_date':
                    $processed[$key] = !empty($value) ? $value : null;
                    break;
                    
                default:
                    $processed[$key] = is_string($value) ? trim($value) : $value;
                    break;
            }
        }
        
        return $processed;
    }
    
    /**
     * Generate class code based on class data
     *
     * @param array $data Class data
     * @return string Generated class code
     */
    private function generateClassCode(array $data): string {
        $code = '';
        
        // Add client prefix if available
        if (!empty($data['client_id'])) {
            $code .= 'C' . str_pad($data['client_id'], 3, '0', STR_PAD_LEFT);
        }
        
        // Add class type prefix
        if (!empty($data['class_type'])) {
            $typeCode = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $data['class_type']), 0, 3));
            $code .= $typeCode;
        }
        
        // Add date component
        if (!empty($data['original_start_date'])) {
            $date = new \DateTime($data['original_start_date']);
            $code .= $date->format('Ymd');
        } else {
            $code .= date('Ymd');
        }
        
        // Add random suffix to ensure uniqueness
        $code .= strtoupper(substr(uniqid(), -3));
        
        return $code;
    }
    
    /**
     * Check if a class can be deleted
     *
     * @param int $id Class ID
     * @return array ['allowed' => bool, 'reason' => string]
     */
    private function canDeleteClass(int $id): array {
        // Get class data
        $class = $this->repository->findById($id);
        if (!$class) {
            return ['allowed' => false, 'reason' => 'Class not found'];
        }
        
        // Check if class has started
        $startDate = $class->getOriginalStartDate();
        if ($startDate && strtotime($startDate) <= time()) {
            return ['allowed' => false, 'reason' => 'Cannot delete classes that have already started'];
        }
        
        // Check if class has learners assigned
        $learnerIds = $class->getLearnerIds();
        if (!empty($learnerIds)) {
            return ['allowed' => false, 'reason' => 'Cannot delete classes with assigned learners'];
        }
        
        return ['allowed' => true, 'reason' => ''];
    }
    
    /**
     * Process JSON field data
     *
     * @param mixed $value Field value
     * @return array
     */
    private function processJsonField($value): array {
        if (is_array($value)) {
            return $value;
        }
        
        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }
    
    /**
     * Convert various boolean representations to actual boolean
     *
     * @param mixed $value Value to convert
     * @return bool
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
     * Validate file uploads
     *
     * @param array $files Uploaded files
     * @return array ['success' => bool, 'errors' => array]
     */
    public function validateFileUploads(array $files): array {
        $isValid = $this->validator->validateFileUploads($files);
        
        return [
            'success' => $isValid,
            'errors' => $isValid ? [] : $this->validator->getErrors()
        ];
    }
}
