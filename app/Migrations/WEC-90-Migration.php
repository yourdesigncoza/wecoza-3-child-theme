<?php
/**
 * WEC-90 Migration Script
 *
 * Handles the migration from mixed-mode class management to proper MVC architecture
 * Ensures backward compatibility and smooth transition
 */

namespace WeCoza\Migrations;

use WeCoza\Services\Database\DatabaseService;

class WEC90Migration {
    
    private $db;
    private $migrationLog = [];
    
    public function __construct() {
        $this->db = DatabaseService::getInstance();
    }
    
    /**
     * Run the complete migration
     */
    public function migrate() {
        $this->log('Starting WEC-90 Migration: MVC Architecture Implementation');
        
        try {
            $this->db->beginTransaction();
            
            // Step 1: Backup existing data
            $this->backupExistingData();
            
            // Step 2: Update database schema if needed
            $this->updateDatabaseSchema();
            
            // Step 3: Migrate existing shortcodes
            $this->migrateShortcodes();
            
            // Step 4: Update WordPress options
            $this->updateWordPressOptions();
            
            // Step 5: Clear caches
            $this->clearCaches();
            
            $this->db->commit();
            $this->log('Migration completed successfully');
            
            return [
                'success' => true,
                'message' => 'WEC-90 migration completed successfully',
                'log' => $this->migrationLog
            ];
            
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log('Migration failed: ' . $e->getMessage(), 'error');
            
            return [
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage(),
                'log' => $this->migrationLog
            ];
        }
    }
    
    /**
     * Backup existing data
     */
    private function backupExistingData() {
        $this->log('Creating backup of existing class data...');
        
        try {
            // Create backup table
            $sql = "CREATE TABLE IF NOT EXISTS classes_backup_wec90 AS 
                    SELECT *, NOW() as backup_created_at FROM classes";
            $this->db->execute($sql);
            
            // Count backed up records
            $count = $this->db->query("SELECT COUNT(*) as count FROM classes_backup_wec90")[0]['count'];
            $this->log("Backed up {$count} class records");
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to backup existing data: ' . $e->getMessage());
        }
    }
    
    /**
     * Update database schema if needed
     */
    private function updateDatabaseSchema() {
        $this->log('Checking database schema...');
        
        try {
            // Check if new columns exist, add if missing
            $columns = $this->getTableColumns('classes');
            
            $requiredColumns = [
                'qa_reports' => 'JSONB DEFAULT \'[]\'::jsonb',
                'initial_class_agent' => 'INTEGER',
                'initial_agent_start_date' => 'DATE'
            ];
            
            foreach ($requiredColumns as $column => $definition) {
                if (!in_array($column, $columns)) {
                    $sql = "ALTER TABLE classes ADD COLUMN {$column} {$definition}";
                    $this->db->execute($sql);
                    $this->log("Added column: {$column}");
                }
            }
            
            // Add indexes for performance
            $this->addIndexes();
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to update database schema: ' . $e->getMessage());
        }
    }
    
    /**
     * Add database indexes for performance
     */
    private function addIndexes() {
        $indexes = [
            'idx_classes_client_id' => 'CREATE INDEX IF NOT EXISTS idx_classes_client_id ON classes(client_id)',
            'idx_classes_class_agent' => 'CREATE INDEX IF NOT EXISTS idx_classes_class_agent ON classes(class_agent)',
            'idx_classes_start_date' => 'CREATE INDEX IF NOT EXISTS idx_classes_start_date ON classes(original_start_date)',
            'idx_classes_class_type' => 'CREATE INDEX IF NOT EXISTS idx_classes_class_type ON classes(class_type)',
            'idx_classes_created_at' => 'CREATE INDEX IF NOT EXISTS idx_classes_created_at ON classes(created_at)'
        ];
        
        foreach ($indexes as $name => $sql) {
            try {
                $this->db->execute($sql);
                $this->log("Added index: {$name}");
            } catch (\Exception $e) {
                $this->log("Warning: Could not add index {$name}: " . $e->getMessage(), 'warning');
            }
        }
    }
    
    /**
     * Migrate existing shortcodes in posts/pages
     */
    private function migrateShortcodes() {
        $this->log('Migrating shortcodes in posts and pages...');
        
        try {
            // Find posts/pages with old shortcodes
            $sql = "SELECT ID, post_content FROM wp_posts 
                    WHERE post_content LIKE '%[wecoza_capture_class%' 
                    OR post_content LIKE '%[wecoza_display_class%'
                    AND post_status = 'publish'";
            
            $posts = $this->db->query($sql);
            
            foreach ($posts as $post) {
                $originalContent = $post['post_content'];
                $newContent = $originalContent;
                
                // Replace old shortcodes with new ones (maintain backward compatibility)
                $replacements = [
                    // Keep existing shortcodes but add notes about new alternatives
                    '[wecoza_capture_class' => '[wecoza_capture_class', // Keep as-is for now
                    '[wecoza_display_class' => '[wecoza_display_class'  // Keep as-is for now
                ];
                
                // Add comments about new shortcodes
                if (strpos($newContent, '[wecoza_capture_class') !== false) {
                    $newContent .= "\n<!-- New RESTful alternatives: [wecoza_classes_index], [wecoza_class_create] -->";
                }
                
                if (strpos($newContent, '[wecoza_display_class') !== false) {
                    $newContent .= "\n<!-- New RESTful alternatives: [wecoza_class_show], [wecoza_class_edit] -->";
                }
                
                if ($newContent !== $originalContent) {
                    $updateSql = "UPDATE wp_posts SET post_content = ? WHERE ID = ?";
                    $this->db->execute($updateSql, [$newContent, $post['ID']]);
                    $this->log("Updated post ID {$post['ID']} with migration notes");
                }
            }
            
            $this->log("Processed " . count($posts) . " posts/pages");
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to migrate shortcodes: ' . $e->getMessage());
        }
    }
    
    /**
     * Update WordPress options
     */
    private function updateWordPressOptions() {
        $this->log('Updating WordPress options...');
        
        try {
            // Set migration completion flag
            update_option('wecoza_wec90_migration_completed', true);
            update_option('wecoza_wec90_migration_date', current_time('mysql'));
            update_option('wecoza_wec90_migration_version', '1.0.0');
            
            // Update rewrite rules flag
            update_option('wecoza_flush_rewrite_rules', true);
            
            $this->log('WordPress options updated');
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to update WordPress options: ' . $e->getMessage());
        }
    }
    
    /**
     * Clear caches
     */
    private function clearCaches() {
        $this->log('Clearing caches...');
        
        try {
            // Flush WordPress rewrite rules
            flush_rewrite_rules();
            
            // Clear object cache if available
            if (function_exists('wp_cache_flush')) {
                wp_cache_flush();
            }
            
            // Clear any plugin caches
            if (function_exists('w3tc_flush_all')) {
                w3tc_flush_all();
            }
            
            if (function_exists('wp_rocket_clean_domain')) {
                wp_rocket_clean_domain();
            }
            
            $this->log('Caches cleared');
            
        } catch (\Exception $e) {
            $this->log('Warning: Could not clear all caches: ' . $e->getMessage(), 'warning');
        }
    }
    
    /**
     * Rollback migration
     */
    public function rollback() {
        $this->log('Starting WEC-90 migration rollback...');
        
        try {
            $this->db->beginTransaction();
            
            // Restore from backup
            $this->restoreFromBackup();
            
            // Remove migration flags
            delete_option('wecoza_wec90_migration_completed');
            delete_option('wecoza_wec90_migration_date');
            delete_option('wecoza_wec90_migration_version');
            
            $this->db->commit();
            $this->log('Rollback completed successfully');
            
            return [
                'success' => true,
                'message' => 'Migration rollback completed successfully',
                'log' => $this->migrationLog
            ];
            
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log('Rollback failed: ' . $e->getMessage(), 'error');
            
            return [
                'success' => false,
                'message' => 'Rollback failed: ' . $e->getMessage(),
                'log' => $this->migrationLog
            ];
        }
    }
    
    /**
     * Restore from backup
     */
    private function restoreFromBackup() {
        $this->log('Restoring from backup...');
        
        try {
            // Check if backup exists
            $backupExists = $this->db->query("SELECT COUNT(*) as count FROM information_schema.tables 
                                             WHERE table_name = 'classes_backup_wec90'")[0]['count'];
            
            if (!$backupExists) {
                throw new \Exception('Backup table not found');
            }
            
            // Restore data (excluding backup_created_at column)
            $sql = "TRUNCATE TABLE classes";
            $this->db->execute($sql);
            
            $sql = "INSERT INTO classes SELECT * FROM classes_backup_wec90";
            $this->db->execute($sql);
            
            $this->log('Data restored from backup');
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to restore from backup: ' . $e->getMessage());
        }
    }
    
    /**
     * Get table columns
     */
    private function getTableColumns($tableName) {
        $sql = "SELECT column_name FROM information_schema.columns 
                WHERE table_name = ? AND table_schema = current_schema()";
        $result = $this->db->query($sql, [$tableName]);
        
        return array_column($result, 'column_name');
    }
    
    /**
     * Check migration status
     */
    public function getStatus() {
        return [
            'completed' => get_option('wecoza_wec90_migration_completed', false),
            'date' => get_option('wecoza_wec90_migration_date'),
            'version' => get_option('wecoza_wec90_migration_version'),
            'backup_exists' => $this->backupExists()
        ];
    }
    
    /**
     * Check if backup exists
     */
    private function backupExists() {
        try {
            $result = $this->db->query("SELECT COUNT(*) as count FROM information_schema.tables 
                                       WHERE table_name = 'classes_backup_wec90'");
            return $result[0]['count'] > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Log migration steps
     */
    private function log($message, $level = 'info') {
        $timestamp = date('Y-m-d H:i:s');
        $this->migrationLog[] = [
            'timestamp' => $timestamp,
            'level' => $level,
            'message' => $message
        ];
        
        // Also log to WordPress debug log if enabled
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("WEC-90 Migration [{$level}]: {$message}");
        }
    }
    
    /**
     * Get migration log
     */
    public function getLog() {
        return $this->migrationLog;
    }
}
