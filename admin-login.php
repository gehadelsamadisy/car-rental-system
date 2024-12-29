<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = md5($_POST['password']); // Encrypt the password with MD5

// Check if admin exists and password matches
$sql = "SELECT * FROM customers WHERE email='$email' AND password='$password' AND role='Admin'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Admin authenticated successfully
    $_SESSION['admin_email'] = $email;
    echo "<script>alert('Login successful!'); window.location.href = 'adminhome.html';</script>";
} else {
    // Authentication failed
    echo "<script>alert('Invalid email or password!'); window.location.href = 'admin-login.html';</script>";
}

$conn->close();
?>