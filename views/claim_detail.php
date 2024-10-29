<?php
require '../config/db.php'; // Database connection

// Check if claim ID is provided via GET request
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $claim_id = $_GET['id'];

    // Fetch claim details from the database
    $stmt = $pdo->prepare("SELECT * FROM claims WHERE id = :claim_id");
    $stmt->execute(['claim_id' => $claim_id]);
    $claim = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($claim) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ClaimGate - Claim Details</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="../css/styles.css">
            <style>
                body {
                    font-family: 'Nunito', sans-serif;
                    /* background-color: #f8f9fa; */
                }

                .card-header {
                    background-color: #0f2942;
                    color: white;
                }

                .progress {
                    height: 25px;
                    color: green;
                }

                .progress-bar {
                    transition: width 0.4s ease;
                }

                .table th,
                .table td {
                    vertical-align: middle;
                }

                .navbar {}

                .navbar-brand {
                    font-weight: bold;

                    font-size: 1.5rem;

                }

                .nav-link {
                    color: white !important;

                    transition: color 0.3s;

                }

                .nav-link:hover {
                    color: #ffc107 !important;
                    /* Yellow on hover */
                }

                .footer {
                    text-align: center;
                    padding: 20px;
                    background-color: #f2f2f2;
                    color: black;
                    position: relative;
                    bottom: 0;
                    width: 100%;
                }
            </style>
        </head>

        <body>
            <header class=" text-black py-3">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">ClaimGate</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
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

            <div class="container my-5">
                <h2 class="text-center mb-4">Claim Details for Claim #<?php echo htmlspecialchars($claim['id']); ?></h2>

                <!-- Claim Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Claim Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-black">
                            <tbody class="text-black mb-4">
                                <tr>
                                    <th class="text-black">Policyholder Name</th>
                                    <td><?php echo htmlspecialchars($claim['policyholder_name']); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-black">Incident Type</th>
                                    <td><?php echo htmlspecialchars($claim['incident_type']); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-black">Description</th>
                                    <td><?php echo nl2br(htmlspecialchars($claim['description'])); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-black">Status</th>
                                    <td><?php echo htmlspecialchars($claim['status']); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-black">Date Submitted</th>
                                    <td><?php echo htmlspecialchars($claim['date_submitted']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Uploaded Documents Card -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Uploaded Documents</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-black">Insurance Certificate</th>
                                    <td><?php echo $claim['insurance_certificate'] ? '<a href="' . htmlspecialchars($claim['insurance_certificate']) . '" class="btn btn-link">Download</a>' : 'Not provided'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-black">Driving License</th>
                                    <td><?php echo $claim['driving_license'] ? '<a href="' . htmlspecialchars($claim['driving_license']) . '" class="btn btn-link">Download</a>' : 'Not provided'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-black">Log Book</th>
                                    <td><?php echo $claim['log_book'] ? '<a href="' . htmlspecialchars($claim['log_book']) . '" class="btn btn-link">Download</a>' : 'Not provided'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-black">Police Report</th>
                                    <td><?php echo $claim['police_report'] ? '<a href="' . htmlspecialchars($claim['police_report']) . '" class="btn btn-link">Download</a>' : 'Not provided'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-black">Damage Estimate</th>
                                    <td><?php echo $claim['damage_estimate'] ? '<a href="' . htmlspecialchars($claim['damage_estimate']) . '" class="btn btn-link">Download</a>' : 'Not provided'; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Third Party Information Card -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Third-Party Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-black">Third Party Name</th>
                                    <td><?php echo $claim['third_party_name'] ? htmlspecialchars($claim['third_party_name']) : 'Not applicable'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-black">Third Party Info</th>
                                    <td><?php echo $claim['third_party_info'] ? nl2br(htmlspecialchars($claim['third_party_info'])) : 'Not applicable'; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Supporting Files Card -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Supporting Files</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-black">Claim File</th>
                                    <td><?php echo $claim['claim_file'] ? '<a href="' . htmlspecialchars($claim['claim_file']) . '" class="btn btn-link">Download</a>' : 'Not provided'; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Progress Tracker -->
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">Claim Progress Tracker</h4>
                    </div>
                    <div class="card-body ">
                        <div class="progress">
                            <?php
                            $statuses = ['Claim Filed', 'In Review', 'Bidding', 'Repair', 'Completed'];
                            $currentStatusIndex = array_search($claim['status'], $statuses);

                            foreach ($statuses as $index => $status) {
                                $isActive = $index <= $currentStatusIndex ? 'bg-success' : 'bg-grey';
                                echo "<div class='progress-bar $isActive' style='width: " . (100 / count($statuses)) . "%;'>$status</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <footer class=" footer">
                <p class="mb-0">&copy; 2024 ClaimGate</p>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "<div class='container my-5'><p class='alert alert-danger'>Claim not found.</p></div>";
    }
} else {
    echo "<div class='container my-5'><p class='alert alert-danger'>Error: No valid claim ID provided.</p></div>";
}
?>

