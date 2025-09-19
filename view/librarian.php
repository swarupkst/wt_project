<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../Model/database.php");

$student_id = $_SESSION['user_id'];
$sqlUser = "SELECT full_name FROM users WHERE id = $student_id";
$userResult = $conn->query($sqlUser);
$user = $userResult->fetch_assoc();
$student_name = $user['full_name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library - Add Book</title>
  <link rel="stylesheet" href="../view/librarian.css">
</head>
<body>
  <div class="profile-bar">
        <div class="profile-info">
            👤 Welcome, <b><?php echo htmlspecialchars($student_name); ?></b>
        </div>
        <div>
            <a href="profile.php" class="profile-btn">Profile</a>
            <a href="../Controller/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

  <div class="form-container">
    <h2>Add Book Details</h2>
    <form action="../Controller/save_book.php" method="POST">
      <div class="form-group">
        <label for="title">Book Name</label>
        <input type="text" id="title" name="title" placeholder="Enter full book name" required>
      </div>
      <div class="form-group">
        <label for="author">Author(s)</label>
        <input type="text" id="author" name="author" placeholder="Enter author(s) name" required>
      </div>
      <div class="form-group">
        <label for="isbn">ISBN/ISSN</label>
        <input type="text" id="isbn" name="isbn" placeholder="Enter ISBN/ISSN number" required>
      </div>
      <div class="form-group">
   <label for="quantity">Book Quantity</label>
   <input type="number" id="quantity" name="quantity" min="1" value="1" required>
  </div>
      <div class="form-group">
        <label for="summary">Summary / Description</label>
        <textarea id="summary" name="summary" placeholder="Write a short overview..." required></textarea>
      </div>
      <button type="submit">Save Book</button>
    </form>
  </div>

  <table>
  <thead>
    <tr>
      <th>Title</th>
      <th>Author(s)</th>
      <th>ISBN/ISSN</th>
      <th>Summary</th>
      <th>Quantity</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $sql = "SELECT * FROM books ORDER BY title ASC";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['title']}</td>
                  <td>{$row['author']}</td>
                  <td>{$row['isbn']}</td>
                  <td>{$row['summary']}</td>
                  <td>{$row['quantity']}</td>
                  <td>
                    <form action='../Controller/delete_book.php' method='POST' >
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


</body>
</html>
