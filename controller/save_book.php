<?php
require_once("../model/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $summary = $_POST['summary'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO books (title, author, isbn, summary, quantity) 
            VALUES ('$title', '$author', '$isbn', '$summary', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../View/librarian.php"); 
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
