<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

require_once("../model/database.php");

$query = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM users WHERE role='student'";
if ($query !== '') {
    $sql .= " AND (full_name LIKE ? OR email LIKE ?)";
}

$sql .= " ORDER BY full_name ASC";
$stmt = $conn->prepare($sql);

if ($query !== '') {
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['full_name']}</td>
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
    echo "<tr><td colspan='3'>No students found</td></tr>";
}
?>
