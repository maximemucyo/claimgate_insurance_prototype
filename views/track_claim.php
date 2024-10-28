<?php
session_start();
require '../config/db.php';
require '../controllers/ClaimController.php';

$controller = new ClaimController($pdo);
$claim = $controller->getClaim($_SESSION['user_id']);

if (!$claim) {
    echo "<p class='text-center text-danger'>No claim found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClaimGate - Track Claim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;

        }
        .navbar {
            /* background-color: #343a40; Dark Grey navbar */
        }

        .navbar-brand {
            font-weight: bold; /* Bold logo text */
            font-size: 1.5rem; /* Larger font size */
            color: white !important; /* White color for brand */
        }

        .nav-link {
            color: white !important; /* White text for links */
            transition: color 0.3s; /* Smooth color transition */
        }

        .nav-link:hover {
            color: #ffc107 !important; /* Yellow on hover */
        }

        .header-title {
            text-align: left;
            margin-top: 3px;
            margin-bottom: 10px;
            color: #343a40; /* Darker color for contrast */
        }

        .submit-btn {
            background-color: #28a745; /* Green background for button */
            color: white; /* White text */
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

    </style>
</head>
<body class="bg-light">
<header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">ClaimGate</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> <!-- Hamburger icon -->
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto"> <!-- Aligns menu items to the right -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="submit_claim.php">Submit Claim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="track_claim.php">Track Claim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="garage_search.php">Garage Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../controllers/AuthController.php?action=logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Track Claim Status</h2>
        <div class="claim-timeline bg-white p-4 rounded shadow">
            <?php if (isset($claim['timeline']) && is_array($claim['timeline']) && count($claim['timeline']) > 0): ?>
                <?php foreach ($claim['timeline'] as $event): ?>
                    <div class="timeline-event border-start ps-3 mb-3 <?php echo $event['completed'] ? 'border-success' : 'border-warning'; ?>">
                        <p class="mb-1"><strong><?php echo htmlspecialchars($event['date']); ?></strong></p>
                        <p class="<?php echo $event['completed'] ? 'text-success' : 'text-warning'; ?>">
                            <?php echo htmlspecialchars($event['description']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-center">No timeline events yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-white text-black py-3 mt-5 text-center">
        <div class="container">
            <p class="mb-0">&copy; 2024 ClaimGate</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
