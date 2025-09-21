<?php
session_start(); 

require_once("../model/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password  = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        if ($user['role'] == 'student') {
            header("Location: ../view/student.php");
        } 
        elseif ($user['role'] == 'librarian') {
            header("Location: ../view/librarian.php");
        }
        elseif ($user['role'] == 'admin') {
            header("Location: ../view/admin.php");
        }
        exit();
    } else {
        echo '<script>alert("Invalid login!"); window.location.href="../View/login.php";</script>';
    }
}
?>