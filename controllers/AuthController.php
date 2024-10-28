<?php
session_start();

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Register user
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

            // Check if username or email already exists
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->execute(['username' => $username, 'email' => $email]);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                echo "Username or email already exists.";
                return;
            }

            // Insert new user into the database
            $stmt = $this->pdo->prepare("
                INSERT INTO users (username, email, password) 
                VALUES (:username, :email, :password)
            ");
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]);

            // Get the ID of the newly inserted user
            $userId = $this->pdo->lastInsertId();

            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;

            // Redirect to the dashboard (index.php) after successful registration
            header("Location: ../views/index.php");
            exit();
        }
    }

    // Login user
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Fetch user from database
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password and check admin status
            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['isAdmin'] = ($user['id'] == 1); // Assuming admin ID is 1

                // Redirect to the dashboard (index.php)
                header("Location: ../views/index.php");
                exit();
            } else {
                echo "Invalid username or password.";
            }
        }
    }

    // Logout user
    public function logout() {
        session_destroy();
        header("Location: ../views/login.php");
        exit();
    }
}

// Trigger logout if action=logout is passed in the URL
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    require '../config/db.php'; // Ensure database connection is available
    $auth = new AuthController($pdo);
    $auth->logout();
}
