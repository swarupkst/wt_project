<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit();
}

require_once("../model/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_id = intval($_POST['borrow_id']);
    $book_id = intval($_POST['book_id']);

    // update return_date
    $conn->query("UPDATE borrowed_books SET return_date = NOW() WHERE id = $borrow_id");

    // increase quantity
    $conn->query("UPDATE books SET quantity = quantity + 1 WHERE id = $book_id");

    header("Location: ../View/student.php");
    exit();
}
?>
