<?php
// Database connection parameters
$servername = "localhost"; // Usually localhost
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (usually empty)
$database = "trek_database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $trek_name = $_POST['trek_name'];
    $customer_name = $_POST['customer_name'];
    $mobile_no = $_POST['mobile_no'];
    $booking_date = $_POST['booking_date'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bookings (trek_name, customer_name, mobile_no, booking_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $trek_name, $customer_name, $mobile_no, $booking_date);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

