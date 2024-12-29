<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$plate_id = $_POST['plate_id'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$color = $_POST['color'];
$year = $_POST['year'];
$price = $_POST['price'];
$office_id = $_POST['office_id'];
$status = $_POST['status'];

$sql = "INSERT INTO cars (plate_id, brand, model, color, year, price, office_id, status) VALUES ('$plate_id', '$brand', '$model', '$color', '$year', '$price', '$office_id', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Car registered successfully!'); window.location.href = 'adminhome.html';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'register-car.html';</script>";
}

$conn->close();
?>