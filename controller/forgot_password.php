<?php
session_start();
require_once("../model/database.php");

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expire = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $stmt2 = $conn->prepare("UPDATE users SET reset_token=?, token_expire=? WHERE email=?");
        $stmt2->bind_param("sss", $token, $expire, $email);
        $stmt2->execute();

        $reset_link = "http://localhost/library-management-system/controller/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'Give your email here';
            $mail->Password   = 'give your email password'; 
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom("portfolio@swarupkst.com", "Library System");
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body    = "Click this link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail->send();
            echo "✅ Password reset link sent to your email!";
            
        } catch (Exception $e) {
            echo "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ No account found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
</head>
<body>
  <h2>Forgot Password</h2>
  <form method="post">
      <label>Enter your email:</label>
      <input type="email" name="email" required>
      <button type="submit">Send Reset Link</button>
  </form>
</body>
</html>
