<?php
require_once '../config/database.php';

function testDatabase($conn) {
    try {
        // Test admin_users table
        $stmt = $conn->query("SELECT COUNT(*) FROM admin_users");
        $adminCount = $stmt->fetchColumn();
        echo "Number of admin users: " . $adminCount . "\n";

        // Test admin_login_logs table
        $stmt = $conn->query("SELECT COUNT(*) FROM admin_login_logs");
        $logCount = $stmt->fetchColumn();
        echo "Number of login logs: " . $logCount . "\n";

        return true;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return false;
    }
}

if (testDatabase($conn)) {
    echo "Database setup is working correctly!\n";
} else {
    echo "Database setup needs attention!\n";
}
?> 