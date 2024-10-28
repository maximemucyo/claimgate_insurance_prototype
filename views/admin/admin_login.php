<?php
session_start();
require_once '../../config/db.php';
require_once '../../controllers/AuthController.php';

$auth = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ClaimGate - Admin Login</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="admin_login.php">
            <div class="form-group">
                <label for="username">Username or Email:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
