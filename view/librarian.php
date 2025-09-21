<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../model/database.php");
require_once "../controller/registercontroller.php"; // handles add student logic

$librarian_id = $_SESSION['user_id'];
$sqlUser = "SELECT full_name FROM users WHERE id = $librarian_id";
$userResult = $conn->query($sqlUser);
$user = $userResult->fetch_assoc();
$librarian_name = $user['full_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Librarian Dashboard</title>
<link rel="stylesheet" href="../view/librarian.css">
<script>
function searchStudents() {
    let query = document.getElementById("studentSearch").value;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../controller/search_students.php?q=" + encodeURIComponent(query), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("studentTableBody").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function searchBooks() {
    let query = document.getElementById("bookSearch").value;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../controller/search_books.php?q=" + encodeURIComponent(query), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("bookTableBody").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>
</head>
<body>

<!-- Profile Bar -->
<div class="profile-bar">
    <div class="profile-info">
        👤 Welcome, <b><?php echo htmlspecialchars($librarian_name); ?></b>
    </div>
    <div>
        <a href="profile.php" class="profile-btn">Profile</a>
        <a href="../controller/logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<!-- Top Forms -->
<div class="top-forms">
    <!-- Add Book Form -->
    <div class="card">
        <h2>Add Book</h2>
        <form action="../controller/save_book.php" method="POST">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Author(s)</label>
                <input type="text" name="author" required>
            </div>
            <div class="form-group">
                <label>ISBN/ISSN</label>
                <input type="text" name="isbn" required>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" min="1" value="1" required>
            </div>
            <div class="form-group">
                <label>Summary</label>
                <textarea name="summary" required></textarea>
            </div>
            <button type="submit" class="btn">Save Book</button>
        </form>
    </div>

    <!-- Add Student Form -->
    <div class="card">
        <h2>Add Student</h2>

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
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="confirm_password">Re-type Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
            </div>

            <input type="hidden" name="role" value="student">
            <button type="submit" class="btn">Add Student</button>
        </form>
    </div>
</div>

<!-- Bottom Tables: Books & Students Side by Side -->
<div class="bottom-tables">
    <!-- Books Table -->
    <div class="card table-card">
        <h2>Registered Books</h2>
        <input type="text" id="bookSearch" onkeyup="searchBooks()" placeholder="Search book...">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author(s)</th>
                    <th>ISBN</th>
                    <th>Summary</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="bookTableBody">
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
                                <form action='../controller/delete_book.php' method='POST'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No books added yet</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Students Table -->
    <div class="card table-card">
        <h2>Registered Students</h2>
        <input type="text" id="studentSearch" onkeyup="searchStudents()" placeholder="Search student...">
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
            <?php
            $sql = "SELECT * FROM users WHERE role='student' ORDER BY full_name ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['full_name']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <form action='../controller/delete_student.php' method='POST'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No students registered yet</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
