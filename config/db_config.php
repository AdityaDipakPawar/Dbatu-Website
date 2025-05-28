<?php
$servername = "localhost";
$username = "admin";  // Your MySQL username
$password = "123456";      // Your MySQL password
$dbname = "dbatu_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 