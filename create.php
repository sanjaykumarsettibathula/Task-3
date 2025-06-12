<?php
include 'config.php';

$pageTitle = "Create New Post";
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo '<div class="message error">Error creating post. Please try again.</div>';
    }
}
?>

<div class="form-container">
    <h1>Create New Post</h1>
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

<?php include 'footer.php'; ?>