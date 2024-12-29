<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = md5($_POST['password']); // Encrypt the password with MD5

// Check if user already exists
$checkUserSql = "SELECT * FROM customers WHERE email='$email'";
$result = $conn->query($checkUserSql);

if ($result->num_rows > 0) {
    echo "<script>alert('User already exists!'); window.location.href = 'register.html';</script>";
} else {
    $sql = "INSERT INTO customers (fname, lname, email, phone, address, password, role) VALUES ('$fname', '$lname', '$email', '$phone', '$address', '$password', 'Customer')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User registered successfully!'); window.location.href = 'userhome.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'register.html';</script>";
    }
}

$conn->close();
?>