<?php
/**
 * ClassRepository.php
 *
 * Repository implementation for class data operations
 * Provides clean data access layer with optimized queries
 */

namespace WeCoza\Repositories;

use WeCoza\Contracts\ClassRepositoryInterface;
use WeCoza\Models\Assessment\ClassModel;
use WeCoza\Services\Database\DatabaseService;

class ClassRepository implements ClassRepositoryInterface {
    
    private $db;
    
    public function __construct() {
        $this->db = DatabaseService::getInstance();
    }
    
    /**
     * Find a class by ID
     */
    public function findById(int $id): ?ClassModel {
        try {
            $sql = "SELECT c.*, 
                           cl.name as client_name,
                           s.name as site_name,
                           s.address as site_address,
                           a.name as agent_name,
                           sup.name as supervisor_name
                    FROM classes c
                    LEFT JOIN clients cl ON c.client_id = cl.id
                    LEFT JOIN sites s ON c.site_id = s.id
                    LEFT JOIN agents a ON c.class_agent = a.id
                    LEFT JOIN supervisors sup ON c.project_supervisor_id = sup.id
                    WHERE c.class_id = ?";
            
            $result = $this->db->query($sql, [$id]);
            
            if (empty($result)) {
                return null;
            }
            
            return new ClassModel($result[0]);
        } catch (\Exception $e) {
            error_log("ClassRepository::findById error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Find all classes with optional filters
     */
    public function findAll(array $filters = [], array $orderBy = [], ?int $limit = null, int $offset = 0): array {
        try {
            $sql = "SELECT c.*, 
                           cl.name as client_name,
                           s.name as site_name,
                           a.name as agent_name,
                           sup.name as supervisor_name
                    FROM classes c
                    LEFT JOIN clients cl ON c.client_id = cl.id
                    LEFT JOIN sites s ON c.site_id = s.id
                    LEFT JOIN agents a ON c.class_agent = a.id
                    LEFT JOIN supervisors sup ON c.project_supervisor_id = sup.id";
            
            $params = [];
            $whereConditions = $this->buildWhereConditions($filters, $params);
            
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }
            
            if (!empty($orderBy)) {
                $sql .= " ORDER BY " . implode(', ', $orderBy);
            } else {
                $sql .= " ORDER BY c.created_at DESC";
            }
            
            if ($limit !== null) {
                $sql .= " LIMIT " . intval($limit);
                if ($offset > 0) {
                    $sql .= " OFFSET " . intval($offset);
                }
            }
            
            $results = $this->db->query($sql, $params);
            
            return array_map(function($row) {
                return new ClassModel($row);
            }, $results);
            
        } catch (\Exception $e) {
            error_log("ClassRepository::findAll error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Find classes by client ID
     */
    public function findByClientId(int $clientId): array {
        return $this->findAll(['client_id' => $clientId]);
    }
    
    /**
     * Find classes by agent ID
     */
    public function findByAgentId(int $agentId): array {
        return $this->findAll(['class_agent' => $agentId]);
    }
    
    /**
     * Find classes by date range
     */
    public function findByDateRange(string $startDate, string $endDate): array {
        $filters = [
            'date_range' => ['start' => $startDate, 'end' => $endDate]
        ];
        return $this->findAll($filters);
    }
    
    /**
     * Create a new class
     */
    public function create(array $data): ClassModel {
        try {
            $this->db->beginTransaction();
            
            $class = new ClassModel($data);
            $result = $class->save();
            
            if (!$result) {
                throw new \Exception('Failed to create class');
            }
            
            $this->db->commit();
            return $class;
            
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log("ClassRepository::create error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Update an existing class
     */
    public function update(int $id, array $data): ClassModel {
        try {
            $this->db->beginTransaction();
            
            $existingClass = $this->findById($id);
            if (!$existingClass) {
                throw new \Exception("Class with ID {$id} not found");
            }
            
            // Merge existing data with updates
            $data['id'] = $id;
            $class = new ClassModel($data);
            $result = $class->update();
            
            if (!$result) {
                throw new \Exception('Failed to update class');
            }
            
            $this->db->commit();
            return $class;
            
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log("ClassRepository::update error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Delete a class
     */
    public function delete(int $id): bool {
        try {
            $this->db->beginTransaction();
            
            $sql = "DELETE FROM classes WHERE class_id = ?";
            $result = $this->db->execute($sql, [$id]);
            
            $this->db->commit();
            return $result;
            
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log("ClassRepository::delete error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Check if a class exists
     */
    public function exists(int $id): bool {
        try {
            $sql = "SELECT 1 FROM classes WHERE class_id = ? LIMIT 1";
            $result = $this->db->query($sql, [$id]);
            return !empty($result);
        } catch (\Exception $e) {
            error_log("ClassRepository::exists error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get class count with optional filters
     */
    public function count(array $filters = []): int {
        try {
            $sql = "SELECT COUNT(*) as total FROM classes c";
            $params = [];
            $whereConditions = $this->buildWhereConditions($filters, $params);
            
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }
            
            $result = $this->db->query($sql, $params);
            return intval($result[0]['total'] ?? 0);
            
        } catch (\Exception $e) {
            error_log("ClassRepository::count error: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get classes with pagination
     */
    public function paginate(int $page, int $perPage, array $filters = [], array $orderBy = []): array {
        $offset = ($page - 1) * $perPage;
        $data = $this->findAll($filters, $orderBy, $perPage, $offset);
        $total = $this->count($filters);
        
        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }
    
    /**
     * Find classes with learner assignments
     */
    public function findByLearnerId(int $learnerId): array {
        try {
            $sql = "SELECT c.*, 
                           cl.name as client_name,
                           s.name as site_name,
                           a.name as agent_name
                    FROM classes c
                    LEFT JOIN clients cl ON c.client_id = cl.id
                    LEFT JOIN sites s ON c.site_id = s.id
                    LEFT JOIN agents a ON c.class_agent = a.id
                    WHERE c.learner_ids @> ?::jsonb";
            
            $result = $this->db->query($sql, [json_encode([$learnerId])]);
            
            return array_map(function($row) {
                return new ClassModel($row);
            }, $result);
            
        } catch (\Exception $e) {
            error_log("ClassRepository::findByLearnerId error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get class statistics
     */
    public function getStatistics(array $filters = []): array {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_classes,
                        COUNT(CASE WHEN exam_class = true THEN 1 END) as exam_classes,
                        COUNT(CASE WHEN seta_funded = true THEN 1 END) as seta_funded_classes,
                        AVG(class_duration) as avg_duration
                    FROM classes c";
            
            $params = [];
            $whereConditions = $this->buildWhereConditions($filters, $params);
            
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }
            
            $result = $this->db->query($sql, $params);
            return $result[0] ?? [];
            
        } catch (\Exception $e) {
            error_log("ClassRepository::getStatistics error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Begin database transaction
     */
    public function beginTransaction(): void {
        $this->db->beginTransaction();
    }
    
    /**
     * Commit database transaction
     */
    public function commit(): void {
        $this->db->commit();
    }
    
    /**
     * Rollback database transaction
     */
    public function rollback(): void {
        $this->db->rollback();
    }
    
    /**
     * Build WHERE conditions from filters
     */
    private function buildWhereConditions(array $filters, array &$params): array {
        $conditions = [];
        
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'client_id':
                    $conditions[] = "c.client_id = ?";
                    $params[] = $value;
                    break;
                    
                case 'class_agent':
                    $conditions[] = "c.class_agent = ?";
                    $params[] = $value;
                    break;
                    
                case 'class_type':
                    $conditions[] = "c.class_type = ?";
                    $params[] = $value;
                    break;
                    
                case 'exam_class':
                    $conditions[] = "c.exam_class = ?";
                    $params[] = $value;
                    break;
                    
                case 'seta_funded':
                    $conditions[] = "c.seta_funded = ?";
                    $params[] = $value;
                    break;
                    
                case 'date_range':
                    if (isset($value['start']) && isset($value['end'])) {
                        $conditions[] = "c.original_start_date BETWEEN ? AND ?";
                        $params[] = $value['start'];
                        $params[] = $value['end'];
                    }
                    break;
                    
                case 'search':
                    $conditions[] = "(c.class_subject ILIKE ? OR c.class_code ILIKE ?)";
                    $searchTerm = '%' . $value . '%';
                    $params[] = $searchTerm;
                    $params[] = $searchTerm;
                    break;
            }
        }
        
        return $conditions;
    }
}
