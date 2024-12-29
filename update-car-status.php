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

if (!isset($_SESSION['admin_email'])) {
    die("Unauthorized access");
}

$car_id = $_POST['car_id'];
$status = $_POST['status'];

$sql = "UPDATE cars SET status='$status' WHERE Car_ID='$car_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: view-cars.html?message=Car status updated successfully");
    exit();
} else {
    header("Location: view-cars.html?error=" . urlencode("Error: " . $conn->error));
    exit();
}

$conn->close();
?>