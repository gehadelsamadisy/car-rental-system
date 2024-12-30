<?php
// filepath: /c:/xampp/htdocs/Final Project/report-reservations.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
$clear = isset($_GET['clear']) ? $_GET['clear'] : null;

if ($clear) {
    $searchResults = [];
} else if ($start_date && $end_date) {
    $sql = "SELECT reservations.reservation_id, cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location, customers.fname, customers.lname, customers.phone, customers.address, customers.email, reservations.reservation_date, reservations.pickup_date, reservations.return_date
            FROM reservations
            LEFT JOIN cars ON reservations.car_id = cars.Car_ID
            LEFT JOIN customers ON reservations.customer_id = customers.customer_id
            LEFT JOIN offices ON cars.office_id = offices.office_id
            WHERE reservations.reservation_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $searchResults = [];
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
    $stmt->close();
} else {
    $sql = "SELECT reservations.reservation_id, cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location, customers.fname, customers.lname, customers.phone, customers.address, customers.email, reservations.reservation_date, reservations.pickup_date, reservations.return_date
            FROM reservations
            LEFT JOIN cars ON reservations.car_id = cars.Car_ID
            LEFT JOIN customers ON reservations.customer_id = customers.customer_id
            LEFT JOIN offices ON cars.office_id = offices.office_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $searchResults = [];
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($searchResults);

$conn->close();
?>