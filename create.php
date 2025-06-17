<?php
require __DIR__ . '/includes/config.php';

$pageTitle = "Create New Post";
require __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $content, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Post created successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error creating post. Please try again.";
        }
    }
}
?>

<div class="form-container">
    <h1>Create New Post</h1>
    <?php if (isset($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <button type="submit" class="btn">Create Post</button>
        <a href="dashboard.php" class="btn">Cancel</a>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>