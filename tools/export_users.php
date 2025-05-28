<?php
require_once '../db_connect.php';

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_' . date('Y-m-d') . '.csv"');

// Create output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, ['ID', 'Name', 'Email', 'Registration Date']);

try {
    $stmt = $conn->query("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

fclose($output);
?> 