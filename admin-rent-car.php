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

    // Calculate rental price
    $car_price_query = "SELECT price FROM cars WHERE Car_ID='$car_id'";
    $result = $conn->query($car_price_query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price_per_month = $row['price'];

        $pickup_date_obj = new DateTime($pickup_date);
        $return_date_obj = new DateTime($return_date);
        $interval = $pickup_date_obj->diff($return_date_obj);
        $days = $interval->days;
        $price_per_day = $price_per_month / 30;
        $total_price = $days * $price_per_day;
    } else {
        echo "<script>alert('Error: Car not found'); window.location.href = 'view-cars.html';</script>";
        exit();
    }

    // Insert data into reservation table
    $sql = "INSERT INTO reservations (car_id, customer_id, reservation_date, pickup_date, return_date, payment_amount) 
            VALUES (?, ?, CURDATE(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissd", $car_id, $customer_id, $pickup_date, $return_date, $total_price);

    if ($stmt->execute()) {
        $reservation_id = $stmt->insert_id; // Get the inserted reservation ID

        // Insert data into payments table
        $payment_sql = "INSERT INTO payments (reservation_id, payment_date, amount) 
                        VALUES (?, CURDATE(), ?)";
        $payment_stmt = $conn->prepare($payment_sql);
        $payment_stmt->bind_param("id", $reservation_id, $total_price);
        $payment_stmt->execute();
        $payment_stmt->close();

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
