<?php

session_start();
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showForm($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function showActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Register</title>
      <link rel="stylesheet" href="../../assets/styles/auth/login-Register-Style.css">
</head>
<body>
    <div class="container">
        <!-- Login Form -->
        <div class="form-box <?= showActiveForm('login', $activeForm); ?>" id="login-form">
            <form id="loginForm" action="../../Controllers/auth/login-Register.php" method="post" autocomplete="off" novalidate>
                <h2>📚 Library Management System</h2>
                <h3>Login</h3>
                <?= showForm($errors['login']); ?>
                <input type="email" name="email" id="loginEmail" placeholder="Email" required>
                <div class="error" id="loginEmailError"></div>
                <input type="password" name="password" id="loginPassword" placeholder="Password" required>
                <div class="error" id="loginPasswordError"></div>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showRegisterForm()">Register</a></p>
                <div>
                    <p id="forgotPassword"><a href="#">Forgot Password?</a></p>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div class="form-box <?= showActiveForm('register', $activeForm); ?>" id="register-form" style="display: none;">
            <form id="registerForm" action="../../Controllers/auth/login-Register.php" method="post" autocomplete="off" novalidate>
                <h2>📚 Library Management System</h2>
                <h3>Register</h3>
                <?= showForm($errors['register']); ?>
                <input type="text" name="name" id="name" placeholder="Name" required>
                <div class="error" id="nameError"></div>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div class="error" id="emailError"></div>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="error" id="passwordError"></div>
                <select name="role" id="role" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <!-- <option value="librarian">Librarian</option>
                    <option value="admin">Admin</option> -->
                </select>
                <div class="error" id="roleError"></div>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showLoginForm()">Login</a></p>
            </form>
        </div>
    </div>
     <script src="../../assets/scripts/auth/login-Register-Script.js"></script>
</body>
</html>
