<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = isset($_GET['date']) ? $_GET['date'] : null;

if ($date) {
    $sql = "SELECT cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location
            FROM cars
            LEFT JOIN offices ON cars.office_id = offices.office_id
            LEFT JOIN reservations ON cars.Car_ID = reservations.car_id
            WHERE ? BETWEEN reservations.pickup_date AND reservations.return_date
            OR reservations.car_id IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
} else {
    $sql = "SELECT cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location
            FROM cars
            LEFT JOIN offices ON cars.office_id = offices.office_id";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$carStatusResults = [];
while ($row = $result->fetch_assoc()) {
    $carStatusResults[] = $row;
}

header('Content-Type: application/json');
echo json_encode($carStatusResults);

$stmt->close();
$conn->close();
?>