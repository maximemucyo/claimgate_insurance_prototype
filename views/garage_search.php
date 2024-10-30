<?php
session_start();
require '../config/db.php';
require '../controllers/ClaimController.php';

$controller = new ClaimController($pdo);

// Handle search input
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$garages = $controller->getApprovedGarages($search);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClaimGate - Garage Search</title>
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
            color: #ffc107 !important; /* Yellow on hover */
        }

        .header-title {
            text-align: left;
            margin-top: 3px;
            margin-bottom: 10px;
            color: #343a40; /* Darker color for contrast */
        }

        .submit-btn {
            background-color: #3187c4; /* Green background for button */
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
        .footerr {
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


        <div class="container my-5">
            <h1 class="text-center text-dark">Find an Approved Garage</h1>

            <!-- Search form -->
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search garages..."
                        value="<?php echo htmlspecialchars($search); ?>">
                    <button class="submit-btn" type="submit">Search</button>
                </div>
            </form>

            <!-- Display garages -->
            <?php if ($garages): ?>
                <div class="row">
                    <?php foreach ($garages as $garage): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($garage['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($garage['address']); ?></p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">View Reviews</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center">No garages found. Try a different search term.</p>
            <?php endif; ?>
        </div>

        <footer class="footerr">
            <p>&copy; 2024 ClaimGate</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
</body>

</html>
