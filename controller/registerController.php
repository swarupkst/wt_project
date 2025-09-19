<?php
session_start();
require_once "../Model/database.php"; 

function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ck duplicate username and email
    public function exists($username, $email) {
        $sql = "SELECT username, email FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        if ($exists) {
            $stmt->bind_result($existingUsername, $existingEmail);
            $stmt->fetch();
            return ['username' => $existingUsername, 'email' => $existingEmail];
        }
        return false;
    }
    
    public function register($name, $username, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $username, $email, $hashedPassword, $role);
        return $stmt->execute();
    }
}

//logic
$name = $username = $email = $role = "";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $role     = $_POST['role'] ?? '';

    if ($name=="" || $username=="" || $email=="" || $password=="" || $confirm=="" || $role=="") {
        $error = "Must fill all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $user = new User($conn);
        $exists = $user->exists($username, $email);

        if ($exists) {
            if ($exists['username'] === $username) {
                $error = "Username already taken!";
            } elseif ($exists['email'] === $email) {
                $error = "Email already registered!";
            }
        } else {
            if ($user->register($name, $username, $email, $password, $role)) {
                $success = "Registration successful! Now you can <a href='../View/login.php'>Login</a>";
                $name = $username = $email = $role = "";
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}
?>
