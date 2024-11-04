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
            $role = $_POST['userType'];
            
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
            INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)
        ");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role 
        ]);

            // Get the ID of the newly inserted user
            $userId = $this->pdo->lastInsertId();

            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;  // Store role in session

            
                // Redirect based on role
                if ($role === 'garage') {
                    header("Location: ../views/garage"); 
                } elseif($role === 'admin'){
                    header("Location: ../views/admin"); 
                }  elseif($role === 'assessor'){
                    header("Location: ../views/assessor"); 
                } 
                elseif($role['role'] === 'super'){
                    header("Location: ../views/super"); 
                }  
                else{
                    header("Location: ../views/index.php");
                }
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
                $_SESSION['isAdmin'] = ($user['id'] == 1); 
                $_SESSION['role'] = $user['role']; 

                // Redirect based on role
                if ($user['role'] === 'garage') {
                    header("Location: ../views/garage"); 
                } elseif($user['role'] === 'admin'){
                    header("Location: ../views/admin"); 
                }  elseif($user['role'] === 'assessor'){
                    header("Location: ../views/assessor"); 
                }
                elseif($user['role'] === 'super'){
                    header("Location: ../views/super"); 
                }  
                else{
                    header("Location: ../views/index.php");
                }
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