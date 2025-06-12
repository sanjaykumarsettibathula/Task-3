<?php
include 'config.php';

$pageTitle = "Dashboard";
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pagination logic
$per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $per_page) - $per_page : 0;

// Get total posts
$total = $conn->query("SELECT COUNT(id) as total FROM posts")->fetch_assoc()['total'];
$pages = ceil($total / $per_page);

// Get posts for current page
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT $start, $per_page");
?>

<h1>Dashboard</h1>

<form action="search.php" method="GET" class="search-form">
    <input type="text" name="query" placeholder="Search posts..." required>
    <button type="submit">Search</button>
</form>

<div class="post-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <h2><?= htmlspecialchars($row['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <small>Posted on <?= $row['created_at'] ?></small>
                <div class="post-actions">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts found.</p>
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

<?php include 'footer.php'; ?>