<?php
session_start();
require_once '../db_connect.php';

// Basic authentication - you should implement proper admin authentication
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

try {
    $stmt = $conn->query("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .container { margin-top: 50px; }
        .table-responsive { margin-top: 20px; }
        .user-count { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registered Users</h2>
        <div class="user-count">
            Total Users: <?php echo count($users); ?>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($user['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editUser(<?php echo $user['id']; ?>)">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
        function editUser(id) {
            // Implement edit functionality
            alert('Edit user ' + id);
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.post('delete_user.php', { id: id }, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error deleting user');
                    }
                });
            }
        }
    </script>
</body>
</html> 