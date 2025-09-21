<?php


require_once "../controller/registerController.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../model/database.php");




$user_id = $_SESSION['user_id'];
$sqlUser = "SELECT full_name FROM users WHERE id = $user_id";
$userResult = $conn->query($sqlUser);
$user = $userResult->fetch_assoc();
$user_name = $user['full_name'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library - Users</title>
  <link rel="stylesheet" href="../view/admin.css">
</head>
<body>
  <div class="profile-bar">
        <div class="profile-info">
            👤 Welcome, <b><?php echo htmlspecialchars($user_name); ?></b>
        </div>
        <div>
            <a href="profile.php" class="profile-btn">Profile</a>
            <a href="../controller/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

<div class="two_table">

  <!-- Student Table -->
   <div class="student_table">
  <table>
  <h2>Students</h2>
  <thead>
    <tr>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $sqlStudents = "SELECT * FROM users WHERE role='student' ORDER BY id ASC";
      $students = $conn->query($sqlStudents);
      if ($students->num_rows > 0) {
        while($row = $students->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['full_name']}</td>
                  <td>{$row['username']}</td>
                  <td>{$row['email']}</td>
                  <td>
                    <form action='../Controller/delete_user.php' method='POST'>
                      <input type='hidden' name='id' value='{$row['id']}'>
                      <button type='submit'>Delete</button>
                    </form>
                  </td>
                </tr>";
        }
      }
    ?>
  </tbody>
</table>
    </div>

  <!-- Librarian Table -->
   <div class="lib_table">
  <table>
  <h2>Librarians</h2>
  <thead>
    <tr>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $sqlLibrarians = "SELECT * FROM users WHERE role='librarian' ORDER BY id ASC";
      $librarians = $conn->query($sqlLibrarians);
      if ($librarians->num_rows > 0) {
        while($row = $librarians->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['full_name']}</td>
                  <td>{$row['username']}</td>
                  <td>{$row['email']}</td>
                  <td>
                    <form action='../Controller/delete_user.php' method='POST'>
                      <input type='hidden' name='id' value='{$row['id']}'>
                      <button type='submit'>Delete</button>
                    </form>
                  </td>
                </tr>";
        }
      }
    ?>
  </tbody>
</table>
    </div>

      <div class="form-container">
      
    

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

      <button type="submit" class="btn">ADD User</button>
    </form>

    
  </div>

</div>

</body>
</html>
