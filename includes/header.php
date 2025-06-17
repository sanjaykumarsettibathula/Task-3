<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <title><?= $pageTitle ?? 'Blog Application' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<?php if (isset($_SESSION['user_id'])): ?>
    <nav class="main-nav">
        <a href="dashboard.php">Dashboard</a>
        <?php if (($_SESSION['user_role'] ?? '') === 'admin' || ($_SESSION['user_role'] ?? '') === 'editor'): ?>
            <a href="create.php">New Post</a>
        <?php endif; ?>
        <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
            <a href="admin/admin.php">Admin Panel</a>
        <?php endif; ?>
        <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a>
    </nav>
<?php endif; ?>