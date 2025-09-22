<?php 
session_start();
require_once '../../config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM all_users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = "Email is already registered!";
        $_SESSION['active_form'] = "register";
    } else {
        $conn->query("INSERT INTO all_users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    }
    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM all_users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            
            if ($user['role'] === 'admin') {
                
                if ($user['email'] === 'sabbir@gmail.com') {
                    header("Location: ../../Views/dash/admin/super-Admin-Dashboard.php");
                    // sabbir@gmail.com  X7q!pR9v@2Lm#dW4
                }
                else {  
                header("Location: ../../Views/dash/admin/admin-Dashboard.php");
                }

            } 
            else if ($user['role'] === 'librarian') {
                header("Location: ../../Views/dash/librarian/librarian-Dashboard.php");
                // hossain@gmail.com X7q!pR9v@2Lm#dW4
            }
            else {
                header("Location: ../../Views/dash/student/student-Dashboard.php");
                // niyaz@gmail.com X7q!pR9v@2Lm#dW4
            }
            exit();
        }
    }
           
    $_SESSION['login_error'] = "Incorrect email or password!";
    $_SESSION['active_form'] = "login";

    header("Location: ../../index.php");
    exit();
}   
?>
