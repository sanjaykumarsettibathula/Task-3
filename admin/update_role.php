<?php
require __DIR__ . '/../includes/config.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// CSRF protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['message'] = 'Error: CSRF token validation failed';
    header("Location: admin.php");
    exit();
}

if (isset($_POST['user_id']) && isset($_POST['role'])) {
    $user_id = (int)$_POST['user_id'];
    $role = $_POST['role'];
    
    // Validate role
    $allowed_roles = ['user', 'editor', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        $_SESSION['message'] = 'Error: Invalid role specified';
        header("Location: admin.php");
        exit();
    }
    
    // Prevent self-demotion
    if ($user_id === $_SESSION['user_id'] && $role !== 'admin') {
        $_SESSION['message'] = 'Error: You cannot remove your own admin privileges';
        header("Location: admin.php");
        exit();
    }
    
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Role updated successfully';
    } else {
        $_SESSION['message'] = 'Error updating role: ' . $conn->error;
    }
}

header("Location: admin.php");
exit();
?>