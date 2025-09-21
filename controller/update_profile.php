<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../model/database.php");

$student_id = $_SESSION['user_id'];
$name = $_POST['full_name'];
$password = $_POST['password'];

if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET full_name = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $hashedPassword, $student_id);
} else {
    $sql = "UPDATE users SET full_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $student_id);
}

if ($stmt->execute()) {
    $_SESSION['success'] = "Profile updated successfully!";
    header("Location: ../view/profile.php");
} else {
    $_SESSION['error'] = "Something went wrong!";
    header("Location: ../view/profile.php");
}
?>
