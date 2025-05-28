<?php
header('Content-Type: application/json');
require_once '../db_connect.php';

try {
    $stmt = $conn->query("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'users' => $users]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?> 