<?php
/**
 * PostgresConnection.php
 *
 * Unified PostgreSQL connection singleton.
 * Consolidates database connections to prevent multiple connection overhead.
 *
 * Configuration (add to wp-config.php):
 *   define('WECOZA_PG_HOST', 'your-host');
 *   define('WECOZA_PG_PORT', '5432');
 *   define('WECOZA_PG_DBNAME', 'your-db');
 *   define('WECOZA_PG_USER', 'your-user');
 *   define('WECOZA_PG_PASSWORD', 'your-password');
 *
 * @package WeCoza_3_Child_Theme
 * @since 6.0.3
 */

namespace WeCoza\Services\Database;

// Exit if accessed directly.
defined('ABSPATH') || exit;

class PostgresConnection {

    /**
     * Singleton instance.
     *
     * @var PostgresConnection|null
     */
    private static ?PostgresConnection $instance = null;

    /**
     * PDO connection instance.
     *
     * @var \PDO|null
     */
    private ?\PDO $pdo = null;

    /**
     * Whether connection has been attempted.
     *
     * @var bool
     */
    private bool $connectionAttempted = false;

    /**
     * Last connection error message.
     *
     * @var string
     */
    private string $lastError = '';

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct() {
        // Connection is lazy-loaded on first getPdo() call.
    }

    /**
     * Prevent cloning of the singleton.
     */
    private function __clone() {}

    /**
     * Prevent unserialization of the singleton.
     *
     * @throws \Exception Always throws.
     */
    public function __wakeup() {
        throw new \Exception('Cannot unserialize singleton');
    }

    /**
     * Get the singleton instance.
     *
     * @return PostgresConnection
     */
    public static function getInstance(): PostgresConnection {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get database credentials from wp-config.php constants or options.
     * Constants are preferred for performance (no DB lookups).
     *
     * @return array{host: string, port: string, dbname: string, user: string, password: string}
     */
    private function getCredentials(): array {
        return [
            'host'     => defined('WECOZA_PG_HOST') ? WECOZA_PG_HOST : get_option('wecoza_postgres_host', ''),
            'port'     => defined('WECOZA_PG_PORT') ? WECOZA_PG_PORT : get_option('wecoza_postgres_port', '5432'),
            'dbname'   => defined('WECOZA_PG_DBNAME') ? WECOZA_PG_DBNAME : get_option('wecoza_postgres_dbname', ''),
            'user'     => defined('WECOZA_PG_USER') ? WECOZA_PG_USER : get_option('wecoza_postgres_user', ''),
            'password' => defined('WECOZA_PG_PASSWORD') ? WECOZA_PG_PASSWORD : get_option('wecoza_postgres_password', ''),
        ];
    }

    /**
     * Establish the database connection.
     *
     * @throws \Exception If connection fails.
     */
    private function connect(): void {
        if ($this->pdo instanceof \PDO) {
            return;
        }

        $this->connectionAttempted = true;
        $creds = $this->getCredentials();

        if (empty($creds['host']) || empty($creds['dbname']) || empty($creds['user'])) {
            $this->lastError = 'PostgreSQL credentials not configured. Check wp-config.php constants or wecoza_postgres_* options.';
            throw new \Exception($this->lastError);
        }

        $dsn = sprintf(
            'pgsql:host=%s;dbname=%s;port=%s;sslmode=require',
            $creds['host'],
            $creds['dbname'],
            $creds['port']
        );

        try {
            $this->pdo = new \PDO($dsn, $creds['user'], $creds['password'], [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (\PDOException $e) {
            $this->lastError = 'PostgreSQL connection failed: ' . $e->getMessage();
            error_log($this->lastError);
            throw new \Exception('Database connection failed');
        }
    }

    /**
     * Get the PDO connection instance.
     * Creates connection on first call (lazy loading).
     *
     * @return \PDO
     * @throws \Exception If connection fails.
     */
    public function getPdo(): \PDO {
        $this->connect();
        return $this->pdo;
    }

    /**
     * Check if connection is established.
     *
     * @return bool
     */
    public function isConnected(): bool {
        return $this->pdo instanceof \PDO;
    }

    /**
     * Get last error message.
     *
     * @return string
     */
    public function getLastError(): string {
        return $this->lastError;
    }

    /**
     * Execute a query with prepared statement.
     *
     * @param string               $sql    SQL query with placeholders.
     * @param array<string, mixed> $params Query parameters.
     * @return \PDOStatement
     * @throws \Exception If query fails.
     */
    public function query(string $sql, array $params = []): \PDOStatement {
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Begin a transaction.
     *
     * @return bool
     */
    public function beginTransaction(): bool {
        return $this->getPdo()->beginTransaction();
    }

    /**
     * Commit a transaction.
     *
     * @return bool
     */
    public function commit(): bool {
        return $this->getPdo()->commit();
    }

    /**
     * Rollback a transaction.
     *
     * @return bool
     */
    public function rollback(): bool {
        return $this->getPdo()->rollBack();
    }

    /**
     * Check if in transaction.
     *
     * @return bool
     */
    public function inTransaction(): bool {
        return $this->isConnected() && $this->pdo->inTransaction();
    }

    /**
     * Get last insert ID.
     *
     * @param string|null $name Sequence name for PostgreSQL.
     * @return string
     */
    public function lastInsertId(?string $name = null): string {
        return $this->getPdo()->lastInsertId($name);
    }

    /**
     * Reset the singleton instance (useful for testing).
     */
    public static function resetInstance(): void {
        if (self::$instance !== null && self::$instance->pdo !== null) {
            self::$instance->pdo = null;
        }
        self::$instance = null;
    }
}
