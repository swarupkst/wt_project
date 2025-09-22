<?php
session_start();
// require_once '../config.php';
include(__DIR__ . '/../config.php');

// Handle Delete User
if (isset($_POST['delete_id'])) {
    $user_id = intval($_POST['delete_id']);
    
    // Prevent deletion of the super admin (sabbir@gmail.com)
    $check_super_admin = $conn->prepare("SELECT email FROM all_users WHERE id = ?");
    $check_super_admin->bind_param("i", $user_id);
    $check_super_admin->execute();
    $result = $check_super_admin->get_result();
    $user_to_delete = $result->fetch_assoc();
    
    if ($user_to_delete && $user_to_delete['email'] === 'sabbir@gmail.com') {
        echo "<script>alert('Cannot delete super admin account!');</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM all_users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully!');</script>";
        } else {
            echo "<script>alert('Delete error: " . $conn->error . "');</script>";
        }
    }
}

// Handle Add User
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM all_users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO all_users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        
        if ($stmt->execute()) {
            echo "<script>alert('New user created successfully!');</script>";
        } else {
            echo "<script>alert('Data insert error: " . $conn->error . "');</script>";
        }
    }
}

// Handle Update User
if (isset($_POST['edit_id']) && isset($_POST['edit_name']) && isset($_POST['edit_email']) && isset($_POST['edit_role'])) {
    $user_id = intval($_POST['edit_id']);
    $name = trim($_POST['edit_name']);
    $email = trim($_POST['edit_email']);
    $role = $_POST['edit_role'];
    
    // Check if email already exists (excluding current user)
    $checkEmail = $conn->prepare("SELECT email FROM all_users WHERE email = ? AND id != ?");
    $checkEmail->bind_param("si", $email, $user_id);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already taken by another user!');</script>";
    } else {
        if (!empty($_POST['edit_password'])) {
            // Update with new password
            $password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE all_users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $email, $password, $role, $user_id);
        } else {
            // Update without changing password
            $stmt = $conn->prepare("UPDATE all_users SET name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $role, $user_id);
        }
        
        if ($stmt->execute()) {
            echo "<script>alert('User updated successfully!');</script>";
        } else {
            echo "<script>alert('Update error: " . $conn->error . "');</script>";
        }
    }
}
?>
