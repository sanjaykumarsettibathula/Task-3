<?php
include 'config.php';

$pageTitle = "Edit Post";
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM posts WHERE id=$id");
$post = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo '<div class="message error">Error updating post. Please try again.</div>';
    }
}
?>

<div class="form-container">
    <h1>Edit Post</h1>
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

<?php include 'footer.php'; ?>