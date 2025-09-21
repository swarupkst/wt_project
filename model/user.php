<?php
// Model/User.php
require_once "database.php";

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Check duplicate username or email
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

    // Register new user
    public function register($name, $username, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $username, $email, $hashedPassword, $role);
        return $stmt->execute();
    }
}
?>
