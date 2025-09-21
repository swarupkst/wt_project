<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit();
}

require_once("../model/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); 

    $sql = "DELETE FROM books WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../view/librarian.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
