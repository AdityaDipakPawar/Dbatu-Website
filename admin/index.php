<?php
require_once 'includes/auth_check.php';
require_once '../db_connect.php';

// Get user statistics
try {
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    $totalUsers = $stmt->fetchColumn();

    $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()");
    $todayUsers = $stmt->fetchColumn();

    $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE MONTH(created_at) = MONTH(CURRENT_DATE())");
    $monthUsers = $stmt->fetchColumn();
} catch(PDOException $e) {
    $error = "Database error";
}

include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2 class="card-text"><?php echo $totalUsers; ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">New Users Today</h5>
                    <h2 class="card-text"><?php echo $todayUsers; ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Users This Month</h5>
                    <h2 class="card-text"><?php echo $monthUsers; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Users</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
                                while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                                    echo "<td>" . date('Y-m-d H:i', strtotime($user['created_at'])) . "</td>";
                                    echo "</tr>";
                                }
                            } catch(PDOException $e) {
                                echo "<tr><td colspan='3'>Error loading users</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 