<?php
require_once '../../db_connect.php';

function createAdminUser($conn, $username, $password, $email, $fullName, $role = 'super_admin') {
    try {
        // Check if admin already exists
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            return "Admin user already exists!";
        }

        // Create new admin user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("
            INSERT INTO admin_users (username, password, email, full_name, role) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$username, $hashedPassword, $email, $fullName, $role]);
        
        return "Admin user created successfully!";
    } catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

// Only run this script directly
if (php_sapi_name() === 'cli' || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    try {
        // Create tables if they don't exist
        $sql = file_get_contents(__DIR__ . '/admin_tables.sql');
        $conn->exec($sql);
        
        // Create default admin user
        $result = createAdminUser(
            $conn,
            'admin',
            'admin123', // Change this password!
            'admin@example.com',
            'System Administrator'
        );
        
        echo $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> 