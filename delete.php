<?php
require __DIR__ . '/includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Verify user owns the post or is admin
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND (user_id = ? OR ? = 'admin')");
    $admin_role = $_SESSION['user_role'] === 'admin' ? 'admin' : '';
    $stmt->bind_param("iis", $id, $_SESSION['user_id'], $admin_role);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Post deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting post.";
    }
}

header("Location: dashboard.php");
exit();
?>