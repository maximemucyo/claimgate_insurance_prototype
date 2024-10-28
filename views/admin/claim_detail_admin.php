<?php
session_start();
require_once '../../config/db.php';
require_once '../../controllers/AdminController.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: admin_login.php");
    exit();
}

$adminController = new AdminController($pdo);

// Get claim ID from URL
$claimId = $_GET['id'] ?? null;

if ($claimId) {
    // Fetch claim details
    $claim = $adminController->getClaimById($claimId);

    if (!$claim) {
        echo "Claim not found.";
        exit();
    }
} else {
    echo "No claim ID provided.";
    exit();
}

// Handle Approve/Reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $adminController->updateClaimStatus($claimId, $action === 'approve' ? 'Approved' : 'Rejected');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Claim Detail</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <header>
        <h1>ClaimGate - Admin Claim Detail</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="../../controllers/AuthController.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Claim Details (ID: <?php echo htmlspecialchars($claim['id']); ?>)</h2>
        <p><strong>Policyholder Name:</strong> <?php echo htmlspecialchars($claim['policyholder_name']); ?></p>
        <p><strong>Incident Type:</strong> <?php echo htmlspecialchars($claim['incident_type']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($claim['description']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($claim['status']); ?></p>

        <h3>Uploaded Documents</h3>
        <ul>
            <li><a href="<?php echo htmlspecialchars($claim['insurance_certificate']); ?>" target="_blank">Insurance Certificate</a></li>
            <li><a href="<?php echo htmlspecialchars($claim['driving_license']); ?>" target="_blank">Driving License</a></li>
            <li><a href="<?php echo htmlspecialchars($claim['log_book']); ?>" target="_blank">Log Book</a></li>
            <li><a href="<?php echo htmlspecialchars($claim['police_report']); ?>" target="_blank">Police Report</a></li>
            <?php if ($claim['damage_estimate']): ?>
                <li><a href="<?php echo htmlspecialchars($claim['damage_estimate']); ?>" target="_blank">Damage Estimate</a></li>
            <?php endif; ?>
        </ul>

        <form method="POST">
            <button type="submit" name="action" value="approve">Approve Claim</button>
            <button type="submit" name="action" value="reject">Reject Claim</button>
        </form>
    </div>
</body>
</html>
