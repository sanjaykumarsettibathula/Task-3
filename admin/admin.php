<?php
require __DIR__ . '/../includes/config.php';

$pageTitle = "Admin Panel";
require __DIR__ . '/../includes/header.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get all users
$users = $conn->query("SELECT id, username, role FROM users ORDER BY username");
?>

<h1>Admin Panel</h1>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message <?= strpos($_SESSION['message'], 'Error') !== false ? 'error' : 'success' ?>">
        <?= $_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<div class="user-management">
    <h2>User Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                    <form method="POST" action="update_role.php">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <select name="role">
                            <?php foreach (['user', 'editor', 'admin'] as $role): ?>
                                <option value="<?= $role ?>" <?= $user['role'] === $role ? 'selected' : '' ?>>
                                    <?= ucfirst($role) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <a href="delete_user.php?id=<?= $user['id'] ?>" 
                           onclick="return confirm('Are you sure you want to delete this user? All their posts will be deleted too!')">
                           Delete
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>