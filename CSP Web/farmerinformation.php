<?php
// fetch_farmers.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmerdashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get farmers open to networking
$sql = "SELECT id, name, crop, variety, defect_percentage AS defectPercentage, location, address, bags 
        FROM crop_data
        WHERE open_to_network = 1";

$result = $conn->query($sql);

$farmerData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $farmerData[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($farmerData);
$conn->close();
?>
