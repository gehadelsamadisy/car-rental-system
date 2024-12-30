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

$conditions = [];

if (!empty($_GET['brand'])) {
    $conditions[] = "cars.brand LIKE '%" . $conn->real_escape_string($_GET['brand']) . "%'";
}
if (!empty($_GET['model'])) {
    $conditions[] = "cars.model LIKE '%" . $conn->real_escape_string($_GET['model']) . "%'";
}
if (!empty($_GET['year'])) {
    $conditions[] = "cars.year LIKE '%" . $conn->real_escape_string($_GET['year']) . "%'";
}
if (!empty($_GET['color'])) {
    $conditions[] = "cars.color LIKE '%" . $conn->real_escape_string($_GET['color']) . "%'";
}

if (!empty($_GET['location'])) {
    $conditions[] = "offices.location LIKE '%" . $conn->real_escape_string($_GET['location']) . "%'";
}

if (!empty($_GET['fname'])) {
    $conditions[] = "customers.fname LIKE '%" . $conn->real_escape_string($_GET['fname']) . "%'";
}
if (!empty($_GET['lname'])) {
    $conditions[] = "customers.lname LIKE '%" . $conn->real_escape_string($_GET['lname']) . "%'";
}
if (!empty($_GET['phone'])) {
    $conditions[] = "customers.phone LIKE '%" . $conn->real_escape_string($_GET['phone']) . "%'";
}
if (!empty($_GET['reservationDate'])) {
    $conditions[] = "reservations.reservation_date = '" . $conn->real_escape_string($_GET['reservationDate']) . "'";
}

$sql = "SELECT cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, offices.location, customers.fname, customers.lname, customers.phone, customers.address, customers.email, reservations.reservation_date, reservations.pickup_date, reservations.return_date
        FROM cars
        LEFT JOIN reservations ON cars.Car_ID = reservations.car_id
        LEFT JOIN customers ON reservations.customer_id = customers.customer_id
        LEFT JOIN offices ON cars.office_id = offices.office_id";


if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);

$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode($cars);

$conn->close();
?>