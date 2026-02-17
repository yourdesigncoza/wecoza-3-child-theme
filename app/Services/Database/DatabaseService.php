<?php
/**
 * DatabaseService.php
 *
 * Service for database operations.
 * Uses PostgresConnection singleton for unified connection management.
 *
 * @package WeCoza_3_Child_Theme
 */

namespace WeCoza\Services\Database;

class DatabaseService {

    /**
     * Singleton instance.
     *
     * @var DatabaseService|null
     */
    private static ?DatabaseService $instance = null;

    /**
     * PostgresConnection instance.
     *
     * @var PostgresConnection
     */
    private PostgresConnection $connection;

    /**
     * Private constructor - uses unified PostgresConnection.
     */
    private function __construct() {
        $this->connection = PostgresConnection::getInstance();
    }

    /**
     * Get database instance (singleton).
     *
     * @return DatabaseService
     */
    public static function getInstance(): DatabaseService {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get PDO instance.
     *
     * @return \PDO
     */
    public function getPdo(): \PDO {
        return $this->connection->getPdo();
    }

    /**
     * Execute a query.
     *
     * @param string               $sql    SQL query.
     * @param array<string, mixed> $params Query parameters.
     * @return \PDOStatement
     */
    public function query(string $sql, array $params = []): \PDOStatement {
        return $this->connection->query($sql, $params);
    }

    /**
     * Begin a transaction.
     *
     * @return bool
     */
    public function beginTransaction(): bool {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit a transaction.
     *
     * @return bool
     */
    public function commit(): bool {
        return $this->connection->commit();
    }

    /**
     * Rollback a transaction.
     *
     * @return bool
     */
    public function rollback(): bool {
        return $this->connection->rollback();
    }

    /**
     * Check if in transaction.
     *
     * @return bool
     */
    public function inTransaction(): bool {
        return $this->connection->inTransaction();
    }

    /**
     * Get last insert ID.
     *
     * @param string|null $name Sequence name for PostgreSQL.
     * @return string
     */
    public function lastInsertId(?string $name = null): string {
        return $this->connection->lastInsertId($name);
    }
}
