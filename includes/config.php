<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session security settings - MUST come before session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Now start the session
session_start();

// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db = "Task4";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    
    // Generate CSRF token if not exists
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>