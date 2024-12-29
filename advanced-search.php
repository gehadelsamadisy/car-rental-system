<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car_info = $_GET['car_info'] ?? '';
$customer_info = $_GET['customer_info'] ?? '';
$reservation_date = $_GET['reservation_date'] ?? '';

$sql = "SELECT cars.Car_ID, cars.plate_id, cars.brand, cars.model, cars.color, cars.year, cars.price, cars.status, cars.location, customers.name AS customer_name, customers.email AS customer_email, reservations.reservation_date, reservations.pickup_date, reservations.return_date
        FROM cars
        LEFT JOIN reservations ON cars.Car_ID = reservations.car_id
        LEFT JOIN customers ON reservations.customer_id = customers.customer_id
        WHERE 1=1";

if (!empty($car_info)) {
    $sql .= " AND (cars.brand LIKE '%$car_info%' OR cars.model LIKE '%$car_info%' OR cars.color LIKE '%$car_info%' OR cars.year LIKE '%$car_info%')";
}

if (!empty($customer_info)) {
    $sql .= " AND (customers.name LIKE '%$customer_info%' OR customers.email LIKE '%$customer_info%')";
}

if (!empty($reservation_date)) {
    $sql .= " AND (reservations.reservation_date LIKE '%$reservation_date%' OR reservations.pickup_date LIKE '%$reservation_date%' OR reservations.return_date LIKE '%$reservation_date%')";
}

$result = $conn->query($sql);

$searchResults = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
}

echo json_encode($searchResults);

$conn->close();
?>