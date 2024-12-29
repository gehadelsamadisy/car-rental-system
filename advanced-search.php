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

$isAdmin = isset($_SESSION['admin_email']);
$conditions = [];

// Add conditions based on the filters provided
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
if (!empty($_GET['customer_name'])) {
    $conditions[] = "reservations.customer_name LIKE '%" . $conn->real_escape_string($_GET['customer_name']) . "%'";
}
if (!empty($_GET['customer_email'])) {
    $conditions[] = "reservations.customer_email LIKE '%" . $conn->real_escape_string($_GET['customer_email']) . "%'";
}
if (!empty($_GET['reservation_date'])) {
    $conditions[] = "reservations.reservation_date = '" . $conn->real_escape_string($_GET['reservation_date']) . "'";
}

// Join `reservations` table to get customer details
$sql = "SELECT 
            cars.*, 
            offices.location, 
            reservations.customer_name, 
            reservations.customer_email, 
            reservations.reservation_date 
        FROM cars 
        JOIN offices ON cars.office_id = offices.office_id
        LEFT JOIN reservations ON cars.Car_ID = reservations.car_id";

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);

$cars = [];
while ($row = $result->fetch_assoc()) {
    $row['isAdmin'] = $isAdmin;
    $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode($cars);

$conn->close();
?>