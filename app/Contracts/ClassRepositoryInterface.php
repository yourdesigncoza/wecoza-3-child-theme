<?php
/**
 * ClassRepositoryInterface.php
 *
 * Repository interface for class data operations
 * Defines the contract for all class data access operations
 */

namespace WeCoza\Contracts;

use WeCoza\Models\Assessment\ClassModel;

interface ClassRepositoryInterface {
    
    /**
     * Find a class by ID
     *
     * @param int $id Class ID
     * @return ClassModel|null
     */
    public function findById(int $id): ?ClassModel;
    
    /**
     * Find all classes with optional filters
     *
     * @param array $filters Optional filters
     * @param array $orderBy Optional ordering
     * @param int|null $limit Optional limit
     * @param int $offset Optional offset
     * @return array
     */
    public function findAll(array $filters = [], array $orderBy = [], ?int $limit = null, int $offset = 0): array;
    
    /**
     * Find classes by client ID
     *
     * @param int $clientId Client ID
     * @return array
     */
    public function findByClientId(int $clientId): array;
    
    /**
     * Find classes by agent ID
     *
     * @param int $agentId Agent ID
     * @return array
     */
    public function findByAgentId(int $agentId): array;
    
    /**
     * Find classes by date range
     *
     * @param string $startDate Start date (Y-m-d format)
     * @param string $endDate End date (Y-m-d format)
     * @return array
     */
    public function findByDateRange(string $startDate, string $endDate): array;
    
    /**
     * Create a new class
     *
     * @param array $data Class data
     * @return ClassModel
     * @throws \Exception If creation fails
     */
    public function create(array $data): ClassModel;
    
    /**
     * Update an existing class
     *
     * @param int $id Class ID
     * @param array $data Updated data
     * @return ClassModel
     * @throws \Exception If update fails
     */
    public function update(int $id, array $data): ClassModel;
    
    /**
     * Delete a class
     *
     * @param int $id Class ID
     * @return bool
     * @throws \Exception If deletion fails
     */
    public function delete(int $id): bool;
    
    /**
     * Check if a class exists
     *
     * @param int $id Class ID
     * @return bool
     */
    public function exists(int $id): bool;
    
    /**
     * Get class count with optional filters
     *
     * @param array $filters Optional filters
     * @return int
     */
    public function count(array $filters = []): int;
    
    /**
     * Get classes with pagination
     *
     * @param int $page Page number (1-based)
     * @param int $perPage Items per page
     * @param array $filters Optional filters
     * @param array $orderBy Optional ordering
     * @return array ['data' => ClassModel[], 'total' => int, 'page' => int, 'perPage' => int]
     */
    public function paginate(int $page, int $perPage, array $filters = [], array $orderBy = []): array;
    
    /**
     * Find classes with learner assignments
     *
     * @param int $learnerId Learner ID
     * @return array
     */
    public function findByLearnerId(int $learnerId): array;
    
    /**
     * Get class statistics
     *
     * @param array $filters Optional filters
     * @return array
     */
    public function getStatistics(array $filters = []): array;
    
    /**
     * Begin database transaction
     *
     * @return void
     */
    public function beginTransaction(): void;
    
    /**
     * Commit database transaction
     *
     * @return void
     */
    public function commit(): void;
    
    /**
     * Rollback database transaction
     *
     * @return void
     */
    public function rollback(): void;
}
