<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is an admin
if (!isset($_SESSION['admin_email'])) {
    die("Unauthorized access");
}

// Get data from POST request
$car_id = $_POST['car_id']; // This is fetched from the hidden input in the form
$customer_id = $_POST['customer_id']; // Customer ID from the form
$pickup_date = $_POST['pickup_date']; // Pickup date from the form
$return_date = $_POST['return_date']; // Return date from the form

// Fetch customer details based on customer_id
$customer_result = $conn->query("SELECT customer_id FROM customers WHERE customer_id='$customer_id'");

if ($customer_result === FALSE) {
    echo "<script>alert('Error fetching customer: " . $conn->error . "');</script>";
    exit();
}

if ($customer_result->num_rows > 0) {
    // Insert reservation into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO reservations (car_id, customer_id, reservation_date, pickup_date, return_date, payment_amount) VALUES (?, ?, CURDATE(), ?, ?, 0)");
    $stmt->bind_param("iiss", $car_id, $customer_id, $pickup_date, $return_date);

    if ($stmt->execute() === TRUE) {
        // Update car status to 'Rented'
        $conn->query("UPDATE cars SET status='Rented' WHERE Car_ID='$car_id'");
        echo "<script>alert('Car rented successfully!'); window.location.href = 'view-cars.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'admin-rent-car.php?car_id=$car_id';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Customer not found'); window.location.href = 'admin-rent-car.php?car_id=$car_id';</script>";
}

// Close the connection
$conn->close();
?>
