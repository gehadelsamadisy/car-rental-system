<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;

if ($start_date && $end_date) {
    $sql = "SELECT payment_id, reservation_id, payment_date, amount
            FROM payments
            WHERE payment_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
} else {
    $sql = "SELECT payment_id, reservation_id, payment_date, amount
            FROM payments";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$paymentResults = [];
while ($row = $result->fetch_assoc()) {
    $paymentResults[] = $row;
}

header('Content-Type: application/json');
echo json_encode($paymentResults);

$stmt->close();
$conn->close();
?>
