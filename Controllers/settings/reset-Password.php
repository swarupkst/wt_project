<?php
session_start();
require '../../config.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$email = $_SESSION['email'];
$currentPassword = isset($_POST['currentPassword']) ? $_POST['currentPassword'] : '';
$resetNewPassword = isset($_POST['resetNewPassword']) ? $_POST['resetNewPassword'] : '';
$resetConfirmPassword = isset($_POST['resetConfirmPassword']) ? $_POST['resetConfirmPassword'] : '';

if (empty($currentPassword) || empty($resetNewPassword) || empty($resetConfirmPassword)) {
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

// Verify current password
if (!password_verify($currentPassword, $row['password'])) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
    exit;
}

// Check new password match
if ($resetNewPassword !== $resetConfirmPassword) {
    echo json_encode(['success' => false, 'message' => 'New passwords do not match']);
    exit;
}

// Hash new password and update
$newHashedPass = password_hash($resetNewPassword, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE all_users SET password=? WHERE email=?");
$stmt->bind_param("ss", $newHashedPass, $email);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true, 'message' => 'Password reset successfully']);
?>