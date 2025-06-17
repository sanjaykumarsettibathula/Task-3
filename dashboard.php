<?php
require __DIR__ . '/includes/config.php';

$pageTitle = "Dashboard";
require __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pagination
$per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = max(0, ($page - 1) * $per_page);

// Get total posts
$total = $conn->query("SELECT COUNT(id) as total FROM posts")->fetch_assoc()['total'];
$pages = ceil($total / $per_page);

// Get posts for current page
$stmt = $conn->prepare("SELECT p.*, u.username 
                       FROM posts p 
                       JOIN users u ON p.user_id = u.id 
                       ORDER BY p.created_at DESC 
                       LIMIT ?, ?");
$stmt->bind_param("ii", $start, $per_page);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message <?= strpos($_SESSION['message'], 'Error') !== false ? 'error' : 'success' ?>">
        <?= $_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<form action="search.php" method="GET" class="search-form">
    <input type="text" name="query" placeholder="Search posts..." required>
    <button type="submit">Search</button>
</form>

<div class="post-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="post">
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <small>Posted by <?= htmlspecialchars($post['username']) ?> on <?= $post['created_at'] ?></small>
                
                <?php if ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['user_role'] === 'admin'): ?>
                    <div class="post-actions">
                        <a href="edit.php?id=<?= $post['id'] ?>">Edit</a>
                        <a href="delete.php?id=<?= $post['id'] ?>" 
                           onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts found. <a href="create.php">Create your first post!</a></p>
    <?php endif; ?>
</div>

<?php if ($pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">Previous</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
        
        <?php if ($page < $pages): ?>
            <a href="?page=<?= $page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>