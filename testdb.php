<?php
$conn = new mysqli("localhost", "root", "", "Task4");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to Task4 database!";
$conn->close();
?>