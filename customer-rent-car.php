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
$pickup_date = $_POST['pickup_date'];
$return_date = $_POST['return_date'];
$customer_email = $_SESSION['email'];

// Get customer ID from email
$customer_result = $conn->query("SELECT customer_id FROM customers WHERE email='$customer_email'");
$customer = $customer_result->fetch_assoc();
$customer_id = $customer['customer_id'];

// Get the car's price per month (adjust the query based on your database)
$car_result = $conn->query("SELECT price FROM cars WHERE Car_ID='$car_id'");
$car = $car_result->fetch_assoc();
$pricePerMonth = $car['price'];

// Calculate the number of days for rent
$pickup = new DateTime($pickup_date);
$return = new DateTime($return_date);
$interval = $pickup->diff($return);
$days = $interval->days;

// Calculate total price
$total_price = ($days / 30) * $pricePerMonth;

// Debug: Output calculated values (this is for debugging purposes)
echo "<h3>Debug Information:</h3>";
echo "Price per month: " . $pricePerMonth . "<br>";
echo "Pickup date: " . $pickup_date . "<br>";
echo "Return date: " . $return_date . "<br>";
echo "Days rented: " . $days . "<br>";
echo "Total price: " . $total_price . "<br>";

// Insert reservation into the database
$sql = "INSERT INTO reservations (car_id, customer_id, reservation_date, pickup_date, return_date, payment_amount) 
        VALUES ('$car_id', '$customer_id', CURDATE(), '$pickup_date', '$return_date', '$total_price')";

if ($conn->query($sql) === TRUE) {
    // Update car status to 'Rented'
    $conn->query("UPDATE cars SET status='Rented' WHERE Car_ID='$car_id'");
    echo "<script>alert('Car reserved successfully!'); window.location.href = 'userhome.html';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'view-cars.html';</script>";
}

$conn->close();
?>
