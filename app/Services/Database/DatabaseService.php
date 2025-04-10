<?php
/**
 * DatabaseService.php
 * 
 * Service for database operations
 */

namespace WeCoza\Services\Database;

class DatabaseService {
    /**
     * PDO instance
     */
    private static $instance = null;
    private $pdo;

    /**
     * Constructor - private to prevent direct instantiation
     */
    private function __construct() {
        try {
            // Get database credentials from WordPress config
            $dbHost = DB_HOST;
            $dbName = DB_NAME;
            $dbUser = DB_USER;
            $dbPass = DB_PASSWORD;
            
            // Create PDO instance
            $this->pdo = new \PDO(
                "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
                $dbUser,
                $dbPass,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (\PDOException $e) {
            // Log error
            error_log('Database connection error: ' . $e->getMessage());
            throw new \Exception('Database connection failed');
        }
    }

    /**
     * Get database instance (singleton)
     * 
     * @return DatabaseService
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get PDO instance
     * 
     * @return \PDO
     */
    public function getPdo() {
        return $this->pdo;
    }

    /**
     * Execute a query
     * 
     * @param string $sql SQL query
     * @param array $params Query parameters
     * @return \PDOStatement
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            error_log('Query error: ' . $e->getMessage());
            throw new \Exception('Database query failed');
        }
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    public function commit() {
        return $this->pdo->commit();
    }

    /**
     * Rollback a transaction
     */
    public function rollback() {
        return $this->pdo->rollBack();
    }

    /**
     * Get last insert ID
     * 
     * @return string
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
