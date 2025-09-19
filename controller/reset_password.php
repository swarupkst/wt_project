<?php
require_once("../Model/database.php");

if (!isset($_GET['token'])) {
    die("❌ No token provided.");
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT reset_token, token_expire FROM users WHERE reset_token=? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("❌ Invalid token!");
}

// Token expiry check
if (strtotime($user['token_expire']) < time()) {
    die("❌ Token is expired!");
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt2 = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, token_expire=NULL WHERE reset_token=?");
    $stmt2->bind_param("ss", $new_password, $token);
    $stmt2->execute();

    echo "✅ Password changed successfully! <a href='../View/login.php'>Login</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
</head>
<body>
  <h2>Reset Your Password</h2>
  <form method="post">
      <label>New Password:</label>
      <input type="password" name="password" required>
      <button type="submit">Reset Password</button>
  </form>
</body>
</html>
