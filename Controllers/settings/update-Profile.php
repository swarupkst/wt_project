<?php
session_start();
require '../../config.php';

// Assuming the user's email is stored in session after login
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$email = $_SESSION['email'];

// Get POST data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$oldPassword = isset($_POST['oldPassword']) ? $_POST['oldPassword'] : '';
$newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

$response = ['success' => false];

// Fetch current user
$stmt = $conn->prepare("SELECT password FROM all_users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    $response['message'] = "User not found";
    echo json_encode($response);
    exit;
}
$row = $result->fetch_assoc();
$currentHashedPassword = $row['password'];
$stmt->close();

// Change Name and/or Password
if (!empty($name)) {
    // Update Name
    $stmt = $conn->prepare("UPDATE all_users SET name=? WHERE email=?");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $stmt->close();
    $response['nameUpdated'] = true;
}

// Change Password
if (!empty($oldPassword) && !empty($newPassword) && !empty($confirmPassword)) {
    // Verify old password
    if (!password_verify($oldPassword, $currentHashedPassword)) {
        $response['message'] = "Old password is incorrect";
        echo json_encode($response);
        exit;
    }
    // Check new password match
    if ($newPassword !== $confirmPassword) {
        $response['message'] = "New passwords do not match";
        echo json_encode($response);
        exit;
    }
    // Update password (hash it)
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE all_users SET password=? WHERE email=?");
    $stmt->bind_param("ss", $hashed, $email);
    $stmt->execute();
    $stmt->close();
    $response['passwordUpdated'] = true;
}

$response['success'] = true;
echo json_encode($response);
?>