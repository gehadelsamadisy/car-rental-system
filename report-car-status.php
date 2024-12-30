<?php
// filepath: /c:/xampp/htdocs/Final Project/report-car-status.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car_id = $_GET['car_id'] ?? null;
$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;

if ($car_id && $start_date && $end_date) {
    $sql = "SELECT reservations.reservation_id, cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location, reservations.reservation_date, reservations.pickup_date, reservations.return_date
            FROM reservations
            LEFT JOIN cars ON reservations.car_id = cars.Car_ID
            LEFT JOIN offices ON cars.office_id = offices.office_id
            WHERE reservations.car_id = ? AND reservations.reservation_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $car_id, $start_date, $end_date);
} else {
    $sql = "SELECT reservations.reservation_id, cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location, reservations.reservation_date, reservations.pickup_date, reservations.return_date
            FROM reservations
            LEFT JOIN cars ON reservations.car_id = cars.Car_ID
            LEFT JOIN offices ON cars.office_id = offices.office_id";
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