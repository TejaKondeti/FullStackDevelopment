<?php
// Capture input data
$u = $_POST["farmer-username"];
$p = $_POST["farmer-password"];

// Connect to the database
$con = new mysqli("localhost", "root", "", "csp", 3306);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Prepare the SQL statement to avoid SQL injection
$stmt = $con->prepare("SELECT * FROM register WHERE Aadhar = ? AND password = ?");
$stmt->bind_param("ss", $u, $p);
$stmt->execute();
$result = $stmt->get_result();

// Verify login credentials
if ($result->num_rows > 0) {
    // Redirect to Farmer Dashboard
    header("Location: Farmer Dashboard.html");
    exit();
} else {
    // Display error message and redirect back to login page
    echo "Login Failed. Incorrect credentials or not authorized as Farmer.";
    header("refresh:2;url=login.html");
}

// Close resources
$stmt->close();
$con->close();
?>
