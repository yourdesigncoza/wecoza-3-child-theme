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
            // Get PostgreSQL database credentials from options
            $pgHost = get_option('wecoza_postgres_host', '');
            $pgPort = get_option('wecoza_postgres_port', '');
            $pgName = get_option('wecoza_postgres_dbname', '');
            $pgUser = get_option('wecoza_postgres_user', '');
            $pgPass = get_option('wecoza_postgres_password', '');

            // Create PDO instance for PostgreSQL
            $this->pdo = new \PDO(
                "pgsql:host=$pgHost;port=$pgPort;dbname=$pgName",
                $pgUser,
                $pgPass,
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
     * Check if in transaction
     *
     * @return bool
     */
    public function inTransaction() {
        return $this->pdo->inTransaction();
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
