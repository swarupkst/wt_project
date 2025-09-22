<?php
session_start();
// Get user_id from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$profile_img_path = '../assets/images/profile-picture.png'; // Default image

if ($user_id) {
    require_once '../config.php';
    $stmt = $conn->prepare("SELECT image_path FROM user_profile_pictures WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($img_path);
    if ($stmt->fetch() && !empty($img_path)) {
        $profile_img_path = "../" . $img_path;
    }
    $stmt->close();
}
?>