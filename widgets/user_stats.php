<?php
require_once '../db_connect.php';

try {
    // Total users
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    $totalUsers = $stmt->fetchColumn();

    // Users today
    $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()");
    $todayUsers = $stmt->fetchColumn();

    // Users this month
    $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE MONTH(created_at) = MONTH(CURRENT_DATE())");
    $monthUsers = $stmt->fetchColumn();

    echo json_encode([
        'success' => true,
        'stats' => [
            'total' => $totalUsers,
            'today' => $todayUsers,
            'month' => $monthUsers
        ]
    ]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?> 