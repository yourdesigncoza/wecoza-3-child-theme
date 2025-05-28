<?php
/**
 * Database Connection Test
 * 
 * This file tests the PostgreSQL connection to verify it's working correctly.
 * Place this in your theme root and access via browser to test.
 */

// Include WordPress
require_once('../../../wp-config.php');
require_once('../../../wp-load.php');

// Include the DatabaseService
require_once('app/Services/Database/DatabaseService.php');

echo "<h1>PostgreSQL Database Connection Test</h1>";

try {
    // Test 1: Check if PostgreSQL credentials are configured
    echo "<h2>1. Checking PostgreSQL Configuration</h2>";
    
    $pgHost = get_option('wecoza_postgres_host', 'db-wecoza-3-do-user-17263152-0.m.db.ondigitalocean.com');
    $pgPort = get_option('wecoza_postgres_port', '25060');
    $pgName = get_option('wecoza_postgres_dbname', 'defaultdb');
    $pgUser = get_option('wecoza_postgres_user', 'doadmin');
    $pgPass = get_option('wecoza_postgres_password', '');
    
    echo "<ul>";
    echo "<li><strong>Host:</strong> " . esc_html($pgHost) . "</li>";
    echo "<li><strong>Port:</strong> " . esc_html($pgPort) . "</li>";
    echo "<li><strong>Database:</strong> " . esc_html($pgName) . "</li>";
    echo "<li><strong>Username:</strong> " . esc_html($pgUser) . "</li>";
    echo "<li><strong>Password:</strong> " . (empty($pgPass) ? '❌ NOT SET' : '✅ SET') . "</li>";
    echo "</ul>";
    
    if (empty($pgPass)) {
        echo "<div style='background: #ffebee; padding: 10px; border-left: 4px solid #f44336; margin: 10px 0;'>";
        echo "<strong>⚠️ WARNING:</strong> PostgreSQL password is not set! Please configure it in WP Admin → WeCoza Settings → Database.";
        echo "</div>";
    }
    
    // Test 2: Test PDO PostgreSQL connection
    echo "<h2>2. Testing Direct PDO Connection</h2>";
    
    $dsn = "pgsql:host=$pgHost;port=$pgPort;dbname=$pgName";
    echo "<p><strong>Connection String:</strong> $dsn</p>";
    
    $pdo = new PDO(
        $dsn,
        $pgUser,
        $pgPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    
    echo "<div style='background: #e8f5e8; padding: 10px; border-left: 4px solid #4caf50; margin: 10px 0;'>";
    echo "✅ <strong>SUCCESS:</strong> Direct PDO connection established!";
    echo "</div>";
    
    // Test 3: Test DatabaseService
    echo "<h2>3. Testing DatabaseService Class</h2>";
    
    $db = \WeCoza\Services\Database\DatabaseService::getInstance();
    echo "<div style='background: #e8f5e8; padding: 10px; border-left: 4px solid #4caf50; margin: 10px 0;'>";
    echo "✅ <strong>SUCCESS:</strong> DatabaseService instance created!";
    echo "</div>";
    
    // Test 4: Test a simple query
    echo "<h2>4. Testing Simple Query</h2>";
    
    $stmt = $db->query("SELECT version() as postgres_version");
    $result = $stmt->fetch();
    
    echo "<p><strong>PostgreSQL Version:</strong> " . esc_html($result['postgres_version']) . "</p>";
    
    echo "<div style='background: #e8f5e8; padding: 10px; border-left: 4px solid #4caf50; margin: 10px 0;'>";
    echo "✅ <strong>SUCCESS:</strong> Query executed successfully!";
    echo "</div>";
    
    // Test 5: Check if classes table exists
    echo "<h2>5. Testing Classes Table</h2>";
    
    $stmt = $db->query("SELECT COUNT(*) as table_exists FROM information_schema.tables WHERE table_name = 'classes'");
    $result = $stmt->fetch();
    
    if ($result['table_exists'] > 0) {
        echo "<div style='background: #e8f5e8; padding: 10px; border-left: 4px solid #4caf50; margin: 10px 0;'>";
        echo "✅ <strong>SUCCESS:</strong> 'classes' table exists!";
        echo "</div>";
        
        // Test 6: Check classes table structure
        echo "<h2>6. Testing Classes Table Structure</h2>";
        
        $stmt = $db->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'classes' ORDER BY ordinal_position");
        $columns = $stmt->fetchAll();
        
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
        echo "<tr><th style='padding: 8px; background: #f5f5f5;'>Column Name</th><th style='padding: 8px; background: #f5f5f5;'>Data Type</th></tr>";
        
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td style='padding: 8px;'>" . esc_html($column['column_name']) . "</td>";
            echo "<td style='padding: 8px;'>" . esc_html($column['data_type']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test 7: Count existing records
        echo "<h2>7. Testing Data Access</h2>";
        
        $stmt = $db->query("SELECT COUNT(*) as record_count FROM classes");
        $result = $stmt->fetch();
        
        echo "<p><strong>Existing records in classes table:</strong> " . esc_html($result['record_count']) . "</p>";
        
    } else {
        echo "<div style='background: #ffebee; padding: 10px; border-left: 4px solid #f44336; margin: 10px 0;'>";
        echo "❌ <strong>ERROR:</strong> 'classes' table does not exist!";
        echo "</div>";
    }
    
    // Test 8: Test transaction support
    echo "<h2>8. Testing Transaction Support</h2>";
    
    $db->beginTransaction();
    echo "<p>✅ Transaction started</p>";
    
    $db->rollback();
    echo "<p>✅ Transaction rolled back</p>";
    
    echo "<div style='background: #e8f5e8; padding: 10px; border-left: 4px solid #4caf50; margin: 10px 0;'>";
    echo "✅ <strong>SUCCESS:</strong> Transaction support working!";
    echo "</div>";
    
    echo "<h2>🎉 Overall Result</h2>";
    echo "<div style='background: #e8f5e8; padding: 15px; border-left: 4px solid #4caf50; margin: 10px 0; font-size: 16px;'>";
    echo "✅ <strong>ALL TESTS PASSED!</strong> Your PostgreSQL connection is working correctly.";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<h2>❌ Database Connection Error</h2>";
    echo "<div style='background: #ffebee; padding: 10px; border-left: 4px solid #f44336; margin: 10px 0;'>";
    echo "<strong>Error:</strong> " . esc_html($e->getMessage());
    echo "</div>";
    
    echo "<h3>Common Solutions:</h3>";
    echo "<ul>";
    echo "<li>Check if PostgreSQL password is set in WP Admin → WeCoza Settings → Database</li>";
    echo "<li>Verify the host, port, and database name are correct</li>";
    echo "<li>Ensure your server can connect to DigitalOcean PostgreSQL</li>";
    echo "<li>Check if your IP is whitelisted in DigitalOcean database settings</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<h2>❌ General Error</h2>";
    echo "<div style='background: #ffebee; padding: 10px; border-left: 4px solid #f44336; margin: 10px 0;'>";
    echo "<strong>Error:</strong> " . esc_html($e->getMessage());
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Test completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
