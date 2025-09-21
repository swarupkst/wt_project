<?php
session_start();
require_once("../model/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../view/admin.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>
