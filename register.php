<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/validation.php';

$pageTitle = "Register";
require __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validateInput($_POST['username'], 'text', 3, 20);
    $password = validateInput($_POST['password'], 'password');
    
    if (!$username || !$password) {
        $error = "Invalid input. Username must be 3-20 chars, password at least 8 chars.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Registered successfully! Please login.';
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<div class="form-container">
    <h1>Register</h1>
    <?php if (isset($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>