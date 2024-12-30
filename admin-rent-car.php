<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $car_id = $_POST['car_id'];
    $customer_id = $_POST['customer_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Debugging: Output retrieved form values (for debugging purposes)
    echo "<h3>Debug Information:</h3>";
    echo "Car ID: " . $car_id . "<br>";
    echo "Customer ID: " . $customer_id . "<br>";
    echo "Pickup Date: " . $pickup_date . "<br>";
    echo "Return Date: " . $return_date . "<br>";

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carsystem";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into reservation table
    $sql = "INSERT INTO reservations (car_id, customer_id, reservation_date, pickup_date, return_date) 
            VALUES (?, ?, CURDATE(), ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $car_id, $customer_id, $pickup_date, $return_date);

    if ($stmt->execute()) {
        // Update car status to 'Rented'
        $conn->query("UPDATE cars SET status='Rented' WHERE Car_ID='$car_id'");
        echo "<script>alert('Reservation successful!'); window.location.href = 'adminhome.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'view-cars.html';</script>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
