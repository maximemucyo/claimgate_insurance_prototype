<?php
// Database connection settings
$host = "localhost";
$dbname = "claimgatedb";
$username = "root";  // Change according to your environment
$password = "";      // Change according to your environment

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>