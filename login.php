<?php
// Debug: Show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!-- Debug: Script started -->\n";

// Use absolute path
$config_path = __DIR__ . '/includes/config.php';
echo "<!-- Config path: $config_path -->\n";

if (!file_exists($config_path)) {
    die("<!-- Error: config.php not found at $config_path -->");
}

require $config_path;
echo "<!-- Debug: Config loaded -->\n";

$pageTitle = "Login";
$header_path = __DIR__ . '/includes/header.php';
echo "<!-- Header path: $header_path -->\n";

if (!file_exists($header_path)) {
    die("<!-- Error: header.php not found at $header_path -->");
}

require $header_path;
echo "<!-- Debug: Header loaded -->\n";

// Debug form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<!-- Debug: Form submitted -->\n";
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    echo "<!-- Debug: Username: $username -->\n";
    
    try {
        echo "<!-- Debug: Preparing statement -->\n";
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("s", $username);
        echo "<!-- Debug: Parameters bound -->\n";
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        echo "<!-- Debug: Query executed -->\n";
        
        $result = $stmt->get_result();
        echo "<!-- Debug: Got result -->\n";
        
        if ($result->num_rows == 1) {
            echo "<!-- Debug: User found -->\n";
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                echo "<!-- Debug: Password verified -->\n";
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "User not found.";
        }
    } catch (Exception $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<div class="form-container">
    <h1>Login</h1>
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
        <button type="submit" class="btn">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php 
$footer_path = __DIR__ . '/includes/footer.php';
if (file_exists($footer_path)) {
    require $footer_path;
    echo "<!-- Debug: Footer loaded -->\n";
} else {
    echo "<!-- Error: footer.php not found at $footer_path -->\n";
}
?>