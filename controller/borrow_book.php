<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit();
}

require_once("../model/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);

    // check book quantity
    $sql = "SELECT quantity FROM books WHERE id = $book_id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    if ($book['quantity'] > 0) {
        // reduce quantity
        $conn->query("UPDATE books SET quantity = quantity - 1 WHERE id = $book_id");

        // calculate due date (7 days later)
        $due_date = date('Y-m-d', strtotime('+7 days'));

        // insert into borrowed_books
        $conn->query("INSERT INTO borrowed_books (student_id, book_id, due_date) 
                      VALUES ($student_id, $book_id, '$due_date')");
    }

    header("Location: ../View/student.php");
    exit();
}
?>
