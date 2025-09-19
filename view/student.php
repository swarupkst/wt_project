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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student.css">
    <script>

        function searchBooks() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let books = document.getElementsByClassName("book-card");

            for (let i = 0; i < books.length; i++) {
                let title = books[i].querySelector(".book-title").innerText.toLowerCase();
                let author = books[i].querySelector(".book-author").innerText.toLowerCase();
                let isbn = books[i].querySelector(".book-isbn").innerText.toLowerCase();

                if (title.includes(input) || author.includes(input) || isbn.includes(input)) {
                    books[i].style.display = "block";
                } else {
                    books[i].style.display = "none";
                }
            }
        }
    </script>
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


    <div class="available_book">
        <h2>Available Books</h2>
        <input type="text" id="searchInput" onkeyup="searchBooks()" placeholder="Search by title, author, ISBN...">

        <div class="book-container">
            <?php
            $sql = "SELECT * FROM books ORDER BY title ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='book-card'>
                            <h3 class='book-title'>{$row['title']}</h3>
                            <p class='book-author'>by {$row['author']}</p>
                            <p class='book-isbn'>ISBN: {$row['isbn']}</p>
                            <p class='book-qty'>Quantity: {$row['quantity']}</p>";

                    if ($row['quantity'] > 0) {
                        echo "<form action='../Controller/borrow_book.php' method='POST'>
                                <input type='hidden' name='book_id' value='{$row['id']}'>
                                <span class='status available'>AVAILABLE</span>
                                <button type='submit' class='request-btn'>Borrow</button>
                              </form>";
                    } else {
                        echo "<span class='status not-available'>Out of Stock</span>";
                    }

                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>


    <div class="table-box">
        <h2>My Borrowed Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT bb.*, b.title 
                        FROM borrowed_books bb 
                        JOIN books b ON bb.book_id = b.id 
                        WHERE bb.student_id = $student_id 
                        ORDER BY bb.borrow_date DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $rowClass = '';
                        if (is_null($row['return_date']) && strtotime($row['due_date']) < time()) {
                            $rowClass = "class='overdue'";
                        }
                        echo "<tr $rowClass>
                                <td>{$row['title']}</td>
                                <td>{$row['borrow_date']}</td>
                                <td>{$row['due_date']}</td>
                                <td>".($row['return_date'] ?? 'Not Returned')."</td>
                                <td>";
                        if (is_null($row['return_date'])) {
                            echo "<form action='../Controller/return_book.php' method='POST'>
                                    <input type='hidden' name='borrow_id' value='{$row['id']}'>
                                    <input type='hidden' name='book_id' value='{$row['book_id']}'>
                                    <button type='submit'>Return</button>
                                  </form>";
                        } else {
                            echo "✔ Returned";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No borrowed books yet</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
