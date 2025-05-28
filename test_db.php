<?php
require_once 'db_connect.php';

try {
    // Test connection
    $stmt = $conn->query("SELECT 1");
    echo "Database connection successful!";
    
    // Test users table
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    $count = $stmt->fetchColumn();
    echo "<br>Number of users in database: " . $count;
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 