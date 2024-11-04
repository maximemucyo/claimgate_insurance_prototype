<?php
session_start();
require '../config/db.php';
require '../controllers/ClaimController.php';

$controller = new ClaimController($pdo);
$claim = $controller->getClaim($_SESSION['user_id']);
$claims = $controller->getClaimsByUser($_SESSION['user_id']);
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* background-color: #ffffff; */
            padding: 10px 20px;
        }

        .navbar a {
            color: #333333;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;

            margin-right: 15px;
            /* Add space between links */
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: black !important;
        }

        .nav-link {
            color: black !important;
            transition: color 0.3s;
        }


        .nav-link:hover {
            color: #ffc107 !important;
        }

        .header-title {
            text-align: left;
            margin-top: 3px;
            margin-bottom: 10px;
            color: #343a40; /
        }

        .submit-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s;
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
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
        <h2 class="mb-4 text-center text-dark">Track Claim Status</h2>
        <div class="claim-timeline bg-white p-4 rounded shadow">
            <?php
                if (!$claims) {
                    echo "<p class='text-center text-danger'>No claim found.</p>";
                    exit;
                }
            ?>
            	<div class="row gx-5 gx-xl-10">
										<div class="container">
											<table border="1">
												<thead>
													<tr >
														<th class="text-black">ID</th>
														<th class="text-black">Incident Type</th>
														<th class="text-black">Status</th>
														<th class="text-black">Date Submitted</th>
														<th class="text-black">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($claims as $claim): ?>
														<tr>
															<td><?php echo htmlspecialchars($claim['id']); ?></td>
															<td><?php echo htmlspecialchars($claim['incident_type']); ?></td>
															<td><?php echo htmlspecialchars($claim['status']); ?></td>
															<td><?php echo htmlspecialchars($claim['date_submitted']); ?></td>
															<td>
																<a href="claim_detail.php?id=<?php echo $claim['id']; ?>">View Details</a>
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
										
									</div>                      	
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; 2024 ClaimGate</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>

