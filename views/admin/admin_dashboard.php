<?php
session_start();
require_once '../../config/db.php';
require_once '../../controllers/AdminController.php';

// Check if user is logged in and is an admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') { // Assuming admin ID is 1
//     exit();
// }

$adminController = new AdminController($pdo);
$claims = $adminController->getAllClaims();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <header>
        <h1>ClaimGate - Admin Dashboard</h1>
        
    </header>
    <div class="container">
        <h2>All Claims</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Policyholder</th>
                    <th>Incident Type</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($claims as $claim): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($claim['id']); ?></td>
                        <td><?php echo htmlspecialchars($claim['policyholder_name']); ?></td>
                        <td><?php echo htmlspecialchars($claim['incident_type']); ?></td>
                        <td><?php echo htmlspecialchars($claim['status']); ?></td>
                        <td><?php echo htmlspecialchars($claim['date_submitted']); ?></td>
                        <td>
                            <a href="claim_detail_admin.php?id=<?php echo $claim['id']; ?>">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
