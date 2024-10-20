<?php
// Database connection
$servername = "localhost"; // Change if your server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "user_registration"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();
    
    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Bind the result
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Start session
            session_start();
            $_SESSION['email'] = $email; // Store email in session for future use
            
            echo "Login successful!";
            // Redirect to the dashboard or another page
            header("Location: book_trek.html"); // Update with the actual index page path
            exit(); // Ensure no further code is executed after redirect
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email address.";
    }

    // Close the statement and connection
    $stmt->close();
}
$conn->close();
?>
