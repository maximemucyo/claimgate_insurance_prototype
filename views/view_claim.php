<?php
session_start();
require '../config/db.php';
require '../controllers/ClaimController.php';

if (!isset($_GET['id'])) {
    echo "<p>Error: No claim ID provided.</p>";
    exit;
}

$claimId = $_GET['id'];
$controller = new ClaimController($pdo);
$claim = $controller->getClaimById($claimId, $_SESSION['user_id']);

if (!$claim) {
    echo "<p>No claim found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClaimGate - View Claim Details</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .timeline-event {
            margin-bottom: 10px;
            padding: 10px;
            border-left: 3px solid #28a745;
            position: relative;
            padding-left: 20px;
        }

        .timeline-event.completed:before {
            content: "✔"; /* Checkmark for completed stages */
            position: absolute;
            left: -15px;
            top: 10px;
            color: #28a745; /* Green for completed */
            font-weight: bold;
        }

        .timeline-event.pending:before {
            content: "⚪"; /* Circle for pending stages */
            position: absolute;
            left: -15px;
            top: 10px;
            color: #ccc; /* Grey for pending */
        }
    </style>
</head>
<body>
    <header>
        <h1>ClaimGate</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="submit_claim.php">Submit Claim</a></li>
                <li><a href="track_claim.php">Track Claim</a></li>
                <li><a href="garage_search.php">Garage Search</a></li>
                <li><a href="../controllers/AuthController.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Claim Details - Claim ID: <?php echo htmlspecialchars($claim['id']); ?></h1>
        <p><strong>Policyholder Name:</strong> <?php echo htmlspecialchars($claim['policyholder_name']); ?></p>
        <p><strong>Incident Type:</strong> <?php echo htmlspecialchars($claim['incident_type']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($claim['status']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($claim['description']); ?></p>
        
        <h2>Claim Timeline</h2>
        <div class="claim-timeline">
            <?php if (isset($claim['timeline']) && is_array($claim['timeline']) && count($claim['timeline']) > 0): ?>
                <?php foreach ($claim['timeline'] as $event): ?>
                    <div class="timeline-event <?php echo $event['completed'] ? 'completed' : 'pending'; ?>">
                        <p><strong><?php echo htmlspecialchars($event['date']); ?></strong>: <?php echo htmlspecialchars($event['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No timeline events yet.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 ClaimGate</p>
    </footer>
</body>
</html>
