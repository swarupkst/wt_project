<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit();
}

require_once("../model/database.php");

$student_id = intval($_POST['id'] ?? 0);

if ($student_id > 0) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='student'");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../view/librarian.php");
exit();
?>
