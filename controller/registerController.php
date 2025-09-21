<?php
require_once "../model/user.php";

function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

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
            if ($exists['username'] === $username) $error = "Username already taken!";
            elseif ($exists['email'] === $email) $error = "Email already registered!";
        } else {
            if ($user->register($name, $username, $email, $password, $role)) {
                $success = "Registration successful!";
                $name = $username = $email = $role = "";
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}
?>
