<?php
include(__DIR__ . '/../config.php');

// Helper function to redirect safely
function redirect($page = '') {
    // Redirect to the given page relative to current file
    header("Location: " . $page);
    exit;
}

// ==================== ADD BOOK ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['author'], $_POST['category'], $_POST['copies'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $copies = (int) $_POST['copies'];
    
    if (!empty($title) && !empty($author) && !empty($category) && $copies > 0) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, copies) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $author, $category, $copies);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Book added successfully!';
            redirect('librarian-Dashboard.php'); // Same folder redirect
        } else {
            $_SESSION['message'] = 'Error adding book: ' . $conn->error;
            redirect('librarian-Dashboard.php');
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Please fill all fields with valid data';
        redirect('librarian-Dashboard.php');
    }
}

// ==================== EDIT BOOK ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_book_id'])) {
    $id = (int) $_POST['edit_book_id'];
    $title = trim($_POST['edit_title']);
    $author = trim($_POST['edit_author']);
    $category = trim($_POST['edit_category']);
    $copies = (int) $_POST['edit_copies'];
    
    if (!empty($title) && !empty($author) && !empty($category) && $copies > 0) {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, copies=? WHERE id=?");
        $stmt->bind_param("sssii", $title, $author, $category, $copies, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Book updated successfully!';
            redirect('librarian-Dashboard.php');
        } else {
            $_SESSION['message'] = 'Error updating book: ' . $conn->error;
            redirect('librarian-Dashboard.php');
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Please fill all fields with valid data';
        redirect('librarian-Dashboard.php');
    }
}

// ==================== DELETE BOOK ====================
if (isset($_GET['delete_id'])) {
    $id = (int) $_GET['delete_id'];
    
    $check_stmt = $conn->prepare("SELECT id FROM books WHERE id=?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Book deleted successfully!';
        } else {
            $_SESSION['message'] = 'Error deleting book: ' . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Book not found!';
    }
    $check_stmt->close();
    
    redirect('librarian-Dashboard.php'); // Always redirect to the same folder
}
