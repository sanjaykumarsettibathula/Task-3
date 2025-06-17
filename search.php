<?php
require __DIR__ . '/includes/config.php';

$pageTitle = "Search Results";
require __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if (empty($searchQuery)) {
    header("Location: dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT p.*, u.username 
                       FROM posts p 
                       JOIN users u ON p.user_id = u.id
                       WHERE p.title LIKE CONCAT('%', ?, '%')
                       OR p.content LIKE CONCAT('%', ?, '%')
                       ORDER BY p.created_at DESC");
$stmt->bind_param("ss", $searchQuery, $searchQuery);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1>Search Results for "<?= htmlspecialchars($searchQuery) ?>"</h1>

<div class="post-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="post">
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                <small>Posted by <?= htmlspecialchars($post['username']) ?> on <?= $post['created_at'] ?></small>
                <div class="post-actions">
                    <a href="view_post.php?id=<?= $post['id'] ?>">Read More</a>
                    <?php if ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['user_role'] === 'admin'): ?>
                        | <a href="edit.php?id=<?= $post['id'] ?>">Edit</a>
                        | <a href="delete.php?id=<?= $post['id'] ?>" 
                             onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts found matching your search.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>