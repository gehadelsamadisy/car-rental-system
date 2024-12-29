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


// echo "<script>alert('Processing your request...');</script>";
// Get data from POST request
$car_id = $_POST['car_id'];
echo "<script>alert('Car ID: " . $car_id . "');</script>";
// $customer_email = $_POST['customer_email'];
// $pickup_date = $_POST['pickup_date'];
// $return_date = $_POST['return_date'];




// $customer_result = $conn->query("SELECT customer_id FROM customers WHERE email='$customer_email'");




// if ($customer_result === FALSE) {
//     echo "<script>alert('Error fetching customer: " . $conn->error . "');</script>";
//     exit();
// }

// if ($customer_result->num_rows > 0) {
//     $customer = $customer_result->fetch_assoc();
//     $customer_id = $customer['customer_id'];

//     // Insert reservation
//     $sql = "INSERT INTO reservations (car_id, customer_id, reservation_date, pickup_date, return_date, payment_amount) VALUES ('$car_id', '$customer_id', CURDATE(), '$pickup_date', '$return_date', 0)";

//     if ($conn->query($sql) === TRUE) {
//         // Update car status to 'Rented'
//         $conn->query("UPDATE cars SET status='Rented' WHERE Car_ID='$car_id'");
//         echo "<script>alert('Car rented successfully!'); window.location.href = 'view-cars.html';</script>";
//     } else {
//         echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'admin-rent-car.html?car_id=$car_id';</script>";
//     }
// } else {
//     echo "<script>alert('Customer not found'); window.location.href = 'admin-rent-car.html?car_id=$car_id';</script>";
// }

// Close the connection
$conn->close();
?>