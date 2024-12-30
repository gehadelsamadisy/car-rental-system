<?php
// Include database connection file (make sure to replace with your actual connection details)
include('db_connection.php'); 

// Check if the form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and car_id
    $car_id = $_POST['car_id'];
    $customer_id = $_POST['customer_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Sanitize inputs (for security purposes)
    $car_id = mysqli_real_escape_string($conn, $car_id);
    $customer_id = mysqli_real_escape_string($conn, $customer_id);
    $pickup_date = mysqli_real_escape_string($conn, $pickup_date);
    $return_date = mysqli_real_escape_string($conn, $return_date);

    // Create SQL query to insert the data into the reservation table
    $query = "INSERT INTO reservation (car_id, customer_id, pickup_date, return_date)
              VALUES ('$car_id', '$customer_id', '$pickup_date', '$return_date')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "Reservation has been successfully added!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


