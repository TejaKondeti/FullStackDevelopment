<?php
// Database connection parameters
$host = "localhost";
$user = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "farmerdashboard"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize input data
$crop = $conn->real_escape_string($_POST['crop']);
$variety = $conn->real_escape_string($_POST['variety']);
$defect_percentage = $conn->real_escape_string($_POST['defect-percentage']);
$location = $conn->real_escape_string($_POST['location']);
$address = $conn->real_escape_string($_POST['address']); 
$bags = $conn->real_escape_string($_POST['bags']); 
$contact = $conn->real_escape_string($_POST['contact-no']);

// Prepare SQL statement
$sql = "INSERT INTO crop_data (`crop_name`, `variety`, `defect_percentage`, `location`, `address`, `number_of_bags`, `ContactNo`)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssissis", $crop, $variety, $defect_percentage, $location, $address, $bags, $contact);

if ($stmt->execute()) {
    // Redirect to 1.html upon successful submission
    header('Location: 1.html');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();
// Close the connection
$conn->close();
?>
