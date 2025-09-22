<?php
session_start();
require '../../config.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$email = $_SESSION['email'];
$newName = isset($_POST['newName']) ? trim($_POST['newName']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($newName) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Fields cannot be empty']);
    exit;
}

// Fetch current user password hash
$stmt = $conn->prepare("SELECT password FROM all_users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}
$row = $result->fetch_assoc();
$stmt->close();

// Verify password
if (!password_verify($password, $row['password'])) {
    echo json_encode(['success' => false, 'message' => 'Incorrect password']);
    exit;
}

// Update name
$stmt = $conn->prepare("UPDATE all_users SET name=? WHERE email=?");
$stmt->bind_param("ss", $newName, $email);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true, 'message' => 'Name updated successfully']);
?>