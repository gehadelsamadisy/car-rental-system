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

$car_id = $_POST['car_id'];
$customer_email = $_SESSION['email'];

echo "<script>alert('User email: $customer_email');</script>";


// Get customer ID from email
$customer_result = $conn->query("SELECT customer_id FROM customers WHERE email='$customer_email'");
$customer = $customer_result->fetch_assoc();
$customer_id = $customer['customer_id'];

// Insert reservation
$sql = "INSERT INTO reservations (car_id, customer_id, reservation_date, pickup_date, return_date, payment_amount) VALUES ('$car_id', '$customer_id', CURDATE(), CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 0)";

if ($conn->query($sql) === TRUE) {
    // Update car status to 'Rented'
    $conn->query("UPDATE cars SET status='Rented' WHERE Car_ID='$car_id'");
    echo "<script>alert('Car reserved successfully!'); window.location.href = 'userhome.html';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'view-cars.html';</script>";
}

$conn->close();
?>