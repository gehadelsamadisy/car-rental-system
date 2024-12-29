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

$card_number = $_POST['card_number'];
$card_expiry = $_POST['card_expiry'];
$card_cvc = $_POST['card_cvc'];
$customer_email = $_SESSION['email'];

// Get customer ID from email
$customer_result = $conn->query("SELECT customer_id FROM customers WHERE email='$customer_email'");
$customer = $customer_result->fetch_assoc();
$customer_id = $customer['customer_id'];

// Get the latest reservation for the customer
$reservation_result = $conn->query("SELECT reservation_id FROM reservations WHERE customer_id='$customer_id' ORDER BY reservation_id DESC LIMIT 1");
$reservation = $reservation_result->fetch_assoc();
$reservation_id = $reservation['reservation_id'];

// Insert payment record
$sql = "INSERT INTO payments (reservation_id, payment_date, amount) VALUES ('$reservation_id', CURDATE(), 100)"; // Assuming a fixed amount for simplicity

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Payment successful!'); window.location.href = 'userhome.html';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'payment.html';</script>";
}

$conn->close();
?>