<?php

require_once "../Controller/registerController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Form</title>
  <link rel="stylesheet" href="registration.css">
</head>
<body>
  <div class="form-container">
    <h2>Registration Form</h2>

    <?php if ($error): ?>
      <div class="message error"><?php echo esc($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="" method="post" novalidate>
      <div class="form-row">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required value="<?php echo esc($name); ?>">
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required value="<?php echo esc($username); ?>">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required value="<?php echo esc($email); ?>">
        </div>

        <div class="form-group">
          <label for="role">Select Role</label>
          <select id="role" name="role" required>
            <option value="" disabled <?php echo $role==""?'selected':''; ?>>-- Select --</option>
            <option value="student" <?php echo $role==='student'?'selected':''; ?>>Student</option>
            <option value="librarian" <?php echo $role==='librarian'?'selected':''; ?>>Librarian</option>
            <option value="admin" <?php echo $role==='admin'?'selected':''; ?>>Admin</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
          <label for="confirm_password">Re-type Password</label>
          <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
      </div>

      <button type="submit" class="btn">Register</button>
    </form>

    <div class="link">
      <p>Already have account? <a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>
