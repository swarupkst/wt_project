<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("Unauthorized");

require_once("../model/database.php");

$query = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM books";
if ($query !== '') {
    $sql .= " WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?";
}
$sql .= " ORDER BY title ASC";

$stmt = $conn->prepare($sql);
if ($query !== '') {
    $likeQuery = "%$query%";
    $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);
}
$stmt->execute();
$result = $stmt->get_result();

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
    echo "<tr><td colspan='6'>No books found</td></tr>";
}
?>
