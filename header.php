<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Blog Application' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <?php if (isset($_SESSION['user_id'])): ?>
        <nav class="main-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="create.php">New Post</a>
            <a href="logout.php">Logout</a>
        </nav>
    <?php endif; ?>