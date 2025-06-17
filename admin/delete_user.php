<?php
require __DIR__ . '/../includes/config.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    
    // Prevent self-deletion
    if ($user_id === $_SESSION['user_id']) {
        $_SESSION['message'] = 'Error: You cannot delete your own account';
        header("Location: admin.php");
        exit();
    }
    
    // Delete user (posts will be deleted automatically due to ON DELETE CASCADE)
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'User deleted successfully';
    } else {
        $_SESSION['message'] = 'Error deleting user: ' . $conn->error;
    }
}

header("Location: admin.php");
exit();
?>