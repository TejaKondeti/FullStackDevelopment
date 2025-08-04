<?php 
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "csp";

// Retrieve POST data
$Role = $_POST['r'];
$MarketName = $_POST['t0'];
$MarketerName = $_POST['t1'];
$Aadhar = $_POST['t2'];
$Password = $_POST['p1'];
$Mobile = $_POST['m2'];
$Gender = $_POST['g'];
$Address = $_POST['d'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert data into database with backticks around column names
$sql = "INSERT INTO marketregister (`Role`, `Market Name`, `Marketer Name`, `Aadhar`, `Password`, `Mobile`, `Gender`, `Address`) 
        VALUES ('$Role', '$MarketName', '$MarketerName', '$Aadhar', '$Password', '$Mobile', '$Gender', '$Address')";

if (mysqli_query($conn, $sql)) {
    echo "<h1>Registered Successfully</h1>";
    echo '<a href="Market Login.html"><b>Click here to login</b></a>';
} else {
    echo "<h1>Error:</h1> " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
