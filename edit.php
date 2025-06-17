<?php
require __DIR__ . '/includes/config.php';

$pageTitle = "Edit Post";
require __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = (int)$_GET['id'];

// Verify user owns the post or is admin
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND (user_id = ? OR ? = 'admin')");
$admin_role = $_SESSION['user_role'] === 'admin' ? 'admin' : '';
$stmt->bind_param("iis", $id, $_SESSION['user_id'], $admin_role);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Post updated successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error updating post. Please try again.";
        }
    }
}
?>

<div class="form-container">
    <h1>Edit Post</h1>
    <?php if (isset($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>
        <button type="submit" class="btn">Update Post</button>
        <a href="dashboard.php" class="btn">Cancel</a>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>