<?php
session_start();
require_once '../config.php'; 

header('Content-Type: application/json');

// Get user_id from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
    echo json_encode(["success" => false, "error" => "User not logged in"]);
    exit;
}

if (!isset($_FILES['profile_picture'])) {
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
    exit;
}

// Prepare upload directory
$targetDir = "../assets/uploads/profile_pictures/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$fileName = uniqid() . "_" . basename($_FILES["profile_picture"]["name"]);
$targetFilePath = $targetDir . $fileName;
$image_path_db = "assets/uploads/profile_pictures/" . $fileName; // For DB & display

// Move uploaded file
if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
    // Check if profile picture already exists for user
    $stmt = $conn->prepare("SELECT id FROM user_profile_pictures WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        // Update
        $stmt2 = $conn->prepare("UPDATE user_profile_pictures SET image_path = ?, uploaded_at = NOW() WHERE user_id = ?");
        $stmt2->bind_param("si", $image_path_db, $user_id);
        $success = $stmt2->execute();
        $stmt2->close();
    } else {
        $stmt->close();
        // Insert
        $stmt2 = $conn->prepare("INSERT INTO user_profile_pictures (user_id, image_path) VALUES (?, ?)");
        $stmt2->bind_param("is", $user_id, $image_path_db);
        $success = $stmt2->execute();
        $stmt2->close();
    }

    if ($success) {
        echo json_encode(["success" => true, "path" => $image_path_db]);
    } else {
        echo json_encode(["success" => false, "error" => "DB error"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "File move failed"]);
}
?>