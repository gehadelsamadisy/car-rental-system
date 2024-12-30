<?php
// filepath: /c:/xampp/htdocs/Final Project/report-customer-reservations.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';

if ($customer_id) {
    $sql = "SELECT reservations.reservation_id, customers.customer_id, customers.fname, customers.lname, customers.phone, customers.email, cars.model, cars.plate_id, reservations.reservation_date, reservations.pickup_date, reservations.return_date
            FROM reservations
            LEFT JOIN customers ON reservations.customer_id = customers.customer_id
            LEFT JOIN cars ON reservations.car_id = cars.Car_ID
            WHERE reservations.customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
} else {
    $sql = "SELECT reservations.reservation_id, customers.customer_id, customers.fname, customers.lname, customers.phone, customers.email, cars.model, cars.plate_id, reservations.reservation_date, reservations.pickup_date, reservations.return_date
            FROM reservations
            LEFT JOIN customers ON reservations.customer_id = customers.customer_id
            LEFT JOIN cars ON reservations.car_id = cars.Car_ID";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$searchResults = [];
while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}

header('Content-Type: application/json');
echo json_encode($searchResults);

$stmt->close();
$conn->close();
?>