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

// Check if user exists and password matches
$sql = "SELECT * FROM customers WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User authenticated successfully
    $_SESSION['email'] = $email;
    echo "<script>alert('Login successful!'); window.location.href = 'userhome.html';</script>";
} else {
    // Authentication failed
    echo "<script>alert('Invalid email or password!'); window.location.href = 'login.html';</script>";
}

$conn->close();
?>