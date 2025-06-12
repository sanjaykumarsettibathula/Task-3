<?php
include 'config.php';

$pageTitle = "Search Results";
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if (!empty($searchQuery)) {
    $stmt = $conn->prepare("SELECT * FROM posts 
                          WHERE title LIKE CONCAT('%', ?, '%')
                          OR content LIKE CONCAT('%', ?, '%')
                          ORDER BY created_at DESC");
    $stmt->bind_param("ss", $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<h1>Search Results for "<?= htmlspecialchars($searchQuery) ?>"</h1>

<div class="post-list">
    <?php if (count($results) > 0): ?>
        <?php foreach ($results as $post): ?>
            <div class="post">
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p><?= substr(nl2br(htmlspecialchars($post['content'])), 0, 200) ?>...</p>
                <small>Posted on <?= $post['created_at'] ?></small>
                <div class="post-actions">
                    <a href="view_post.php?id=<?= $post['id'] ?>">Read More</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        | <a href="edit.php?id=<?= $post['id'] ?>">Edit</a>
                        | <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts found matching your search.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>