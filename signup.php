<?php
// Database connection
$servername = "localhost";
$username = "root";  // Default XAMPP MySQL username
$password = "";  // Default XAMPP MySQL password is empty
$dbname = "car_rental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the sign-up form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "Sign-up successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
