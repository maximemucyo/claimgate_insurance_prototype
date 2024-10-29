<?php
require '../config/db.php';
require '../controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController($pdo);
    $auth->login();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClaimGate - Login</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
         body {
            font-family: 'Nunito', sans-serif;
            /* background-color: #151617; Light background for better contrast */
            /* background-image:  url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg') ; */
        }

    </style>
</head>

<body>
    <header class="text-white py-3">
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#">CLAIM GATE</a>
                <div class="collapse navbar-collapse">
                    <!-- <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="submit_claim.php">Submit Claim</a></li>
                        <li class="nav-item"><a class="nav-link" href="../controllers/AuthController.php?action=logout">Logout</a></li>
                    </ul> -->
                </div>
            </nav>
        </div>
    </header>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg border-0" style="max-width: 28rem; width: 100%;">
            <div class="card-body">
                <h2 class="text-center mb-4">Welcome Back!</h2>
                <p class="text-center text-muted">Login to your ClaimGate account</p>
                <form method="POST" class="mt-4">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                    </div>

                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                </form>

                <p class="text-center mt-3">
                    <a href="register.php" class="text-primary">Don't have an account? Register here</a>
                </p>
            </div>
        </div>
    </div>

    <footer class=" text-black text-center py-3">
        <p>&copy; 2024 ClaimGate</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
