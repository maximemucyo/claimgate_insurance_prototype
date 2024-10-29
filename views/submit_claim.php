<?php
session_start();
require '../config/db.php';
require '../controllers/ClaimController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ClaimController($pdo);
    $controller->submitClaim();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClaimGate - Submit Claim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            /* background-color: #151617; Light background for better contrast */
            /* background-image:  url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg') ; */
        }

        .navbar {
            /* background-color: #343a40; Dark Grey navbar */
        }

        .navbar-brand {
            font-weight: bold;
            /* Bold logo text */
            font-size: 1.5rem;
            /* Larger font size */
            color: white !important;
            /* White color for brand */
        }

        .nav-link {
            color: white !important;
            /* White text for links */
            transition: color 0.3s;
            /* Smooth color transition */
        }

        .nav-link:hover {
            color: #ffc107 !important;
            /* Yellow on hover */
        }

        .header-title {
            text-align: left;
            margin-top: 3px;
            margin-bottom: 10px;
            color: #343a40;
            /* Darker color for contrast */
        }

        .card-header {
            background-color: #0f2942;
            color: white;
        }


        .submit-btn {
            background-color: #28a745;
            /* Green background for button */
            color: white;
            /* White text */
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            color: black;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">ClaimGate</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

        <h2 class="mb-4 text-center">Submit a Claim</h2>

        <form method="POST" enctype="multipart/form-data" id="submitClaimForm" class="shadow p-4 bg-white rounded">
            <p class="text-center mb-5 text-muted">Please provide all the necessary information to process your claim
                effectively.</p>

            <!-- Section 1: Personal Information -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-3">Personal Information</h4>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="policyholder_name" class="form-label">Your Name</label>
                        <input type="text" id="policyholder_name" name="policyholder_name" class="form-control"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="incident_type" class="form-label">Incident Type</label>
                        <input type="text" id="incident_type" name="incident_type" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Section 2: Incident Details -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-3">Incident Details</h4>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="third_party_name" class="form-label">Third Party Name (if applicable)</label>
                        <input type="text" id="third_party_name" name="third_party_name" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="third_party_info" class="form-label">Third Party Info</label>
                        <textarea id="third_party_info" name="third_party_info" class="form-control"
                            rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Document Uploads -->
             <div class= card>
             <div class="card-header">
            <h4 class="mb-3">Document Uploads</h4>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="insurance_certificate" class="form-label">Insurance Certificate</label>
                    <input type="file" id="insurance_certificate" name="insurance_certificate" class="form-control"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="driving_license" class="form-label">Driving License</label>
                    <input type="file" id="driving_license" name="driving_license" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="log_book" class="form-label">Log Book</label>
                    <input type="file" id="log_book" name="log_book" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="police_report" class="form-label">Police Report</label>
                    <input type="file" id="police_report" name="police_report" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="damage_estimate" class="form-label">Damage Estimate (Optional)</label>
                    <input type="file" id="damage_estimate" name="damage_estimate" class="form-control">
                </div>
                <div class="col-12">
                    <label for="claim_file" class="form-label">Upload Supporting Files (e.g., Car Photos)</label>
                    <input type="file" id="claim_file" name="claim_file" class="form-control" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3 px-4">Submit Claim</button>
            </div>
            </div>
        </form>
    </div>

    <footer class=" footer">
        <div class="container">
            <p class="mb-0">&copy; 2024 ClaimGate</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
