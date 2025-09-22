<?php
// include '../../config.php';
include(__DIR__ . '/../../config.php');


// Fetch all books with search and filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

$sql = "SELECT * FROM books WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR author LIKE '%$search%')";
}

if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

$sql .= " ORDER BY title ASC";

$result = $conn->query($sql);
$books = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Get categories for filter
$cat_sql = "SELECT DISTINCT category FROM books ORDER BY category";
$cat_result = $conn->query($cat_sql);
$categories = [];
if ($cat_result && $cat_result->num_rows > 0) {
    while ($row = $cat_result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$conn->close();
?>
