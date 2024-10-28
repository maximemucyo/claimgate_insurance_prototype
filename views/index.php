<?php
// Protect the page with the authentication middleware
require '../middleware/auth.php'; // Ensure the user is logged in
require '../config/db.php'; // Database connection

// Fetch claims from the database for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM claims WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$claims = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClaimGate - Your Claims</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #151617; /* Light background for better contrast */
            background-image:  url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg') ;
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

        .submit-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .bg-image {
            background-image: url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh; /* Full height for section */
        }

        .card {
            border: none; /* Remove border */
            border-radius: 10px; /* Rounded corners */
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .table th, .table td {
            vertical-align: middle; /* Center-align cell content */
        }

        .table-dark {
            background-color: #343a40; /* Dark table background */
        }

        .text-warning {
            color: #ffc107 !important; /* Yellow color for warnings */
        }
    </style>
</head>

<body>
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

    <div class="container" style="padding: 5px;">
        <div>
        <h1 class="header-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <h2 class="">Your Claims</h2>

        </div>
        <!-- Button for submitting a new claim -->
        <button type="button" class="submit-btn">
            <a href="submit_claim.php" style="color: white; text-decoration: none;">Submit New Claim</a>
        </button>

        <section class="intro">
            <div class="bg-image">
                <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, .5);">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card bg-dark shadow-lg">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if (count($claims) > 0): ?>
                                                <table class="table table-dark table-bordered mb-0">
                                                    <tr>
                                                        <th>Claim ID</th>
                                                        <th>Incident Type</th>
                                                        <th>Status</th>
                                                        <th>Date Submitted</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <?php foreach ($claims as $claim): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($claim['id']); ?></td>
                                                            <td><?php echo htmlspecialchars($claim['incident_type']); ?></td>
                                                            <td><?php echo htmlspecialchars($claim['status']); ?></td>
                                                            <td><?php echo htmlspecialchars($claim['date_submitted']); ?></td>
                                                            <td>
                                                                <a class="btn btn-link text-warning" href="claim_detail.php?id=<?php echo $claim['id']; ?>">View Details</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            <?php else: ?>
                                                <p class="text-light">No claims found. <a class="text-warning" href="submit_claim.php">Submit a new claim</a>.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2024 ClaimGate</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
