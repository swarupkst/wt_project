<?php

session_start();


require_once("../model/database.php");


// Helper for safe echo to HTML
function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// Initialize variables for sticky form values and messages
$name = $username = $email = $role = "";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect & trim inputs
    $name     = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $role     = $_POST['role'] ?? '';

    // Basic validation
    if ($name === "" || $username === "" || $email === "" || $password === "" || $confirm === "" || $role === "") {
        $error = "Must fill the all field";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif ($password !== $confirm) {
        $error = "❌ Passwords do not match!";
    } else {
        // Check for duplicate username or email using prepared statement
        $checkSql = "SELECT username, email FROM users WHERE username = ? OR email = ? LIMIT 1";
        if ($stmt = $conn->prepare($checkSql)) {
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($existingUsername, $existingEmail);
                $stmt->fetch();
                if ($existingUsername === $username) {
                    $error = "❌ Username already taken!";
                } elseif ($existingEmail === $email) {
                    $error = "❌ Email already registered!";
                } else {
                    $error = "Username or Email already exists!";
                }
                $stmt->close();
            } else {
                $stmt->close();
                // No duplicate: proceed to insert
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertSql = "INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
                if ($ins = $conn->prepare($insertSql)) {
                    $ins->bind_param("sssss", $name, $username, $email, $hashedPassword, $role);
                    if ($ins->execute()) {
                        $success = "✅ Registration Successful! Now you can <a href='login.php'>Login</a> ";
                        // Clear sticky values on success
                        $name = $username = $email = $role = "";
                    } else {
                        // DB insertion error (rare, but handle)
                        $error = "Database error: " . $ins->error;
                    }
                    $ins->close();
                } else {
                    $error = "Prepare failed: " . $conn->error;
                }
            }
        } else {
            $error = "Prepare failed: " . $conn->error;
        }
    }
}

$conn->close();
?>