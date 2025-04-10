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
            $pgHost = get_option('wecoza_postgres_host', 'db-wecoza-3-do-user-17263152-0.m.db.ondigitalocean.com');
            $pgPort = get_option('wecoza_postgres_port', '25060');
            $pgName = get_option('wecoza_postgres_dbname', 'defaultdb');
            $pgUser = get_option('wecoza_postgres_user', 'doadmin');
            $pgPass = get_option('wecoza_postgres_password', '');

            // Log connection attempt
            error_log("Connecting to PostgreSQL database: host=$pgHost, port=$pgPort, dbname=$pgName, user=$pgUser");

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

            // Log successful connection
            error_log("Successfully connected to PostgreSQL database");

            // Test the connection with a simple query
            $stmt = $this->pdo->query("SELECT current_database(), current_user");
            $result = $stmt->fetch();
            error_log("Connected to database: " . print_r($result, true));

        } catch (\PDOException $e) {
            // Log detailed error
            error_log('Database connection error: ' . $e->getMessage());
            error_log('Error code: ' . $e->getCode());
            error_log('Error trace: ' . $e->getTraceAsString());
            throw new \Exception('Database connection failed: ' . $e->getMessage());
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
            // Log the query and parameters
            error_log('Executing query: ' . $sql);
            if (!empty($params)) {
                error_log('Query parameters: ' . print_r($params, true));
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            // Log success
            error_log('Query executed successfully');

            return $stmt;
        } catch (\PDOException $e) {
            // Log detailed error
            error_log('Query error: ' . $e->getMessage());
            error_log('Error code: ' . $e->getCode());
            error_log('SQL: ' . $sql);
            if (!empty($params)) {
                error_log('Parameters: ' . print_r($params, true));
            }
            error_log('Error trace: ' . $e->getTraceAsString());

            throw new \Exception('Database query failed: ' . $e->getMessage());
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
