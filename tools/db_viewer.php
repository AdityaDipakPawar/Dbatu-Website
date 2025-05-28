<?php
// WARNING: Only use this in development environment!
require_once '../db_connect.php';

$query = isset($_POST['query']) ? $_POST['query'] : "SELECT * FROM users";
$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $conn->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Viewer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .container { margin-top: 50px; }
        .query-form { margin-bottom: 30px; }
        pre { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Database Viewer</h2>
        
        <form method="POST" class="query-form">
            <div class="form-group">
                <label>SQL Query:</label>
                <textarea name="query" class="form-control" rows="3"><?php echo htmlspecialchars($query); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Execute Query</button>
        </form>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($result): ?>
            <h3>Results:</h3>
            <pre><?php print_r($result); ?></pre>
        <?php endif; ?>
    </div>
</body>
</html> 