<?php 
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "csp";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate POST data
    $Role = isset($_POST['r']) ? $_POST['r'] : '';
    $Name = isset($_POST['t0']) ? $_POST['t0'] : '';
    $Aadhar = isset($_POST['t1']) ? $_POST['t1'] : '';
    $Password = isset($_POST['p2']) ? $_POST['p2'] : '';
    $Mobile = isset($_POST['m2']) ? $_POST['m2'] : '';
    $Gender = isset($_POST['g']) ? $_POST['g'] : '';
    $Dob = isset($_POST['d']) ? $_POST['d'] : '';

    // Validate required fields
    if (empty($Role) || empty($Name) || empty($Aadhar) || empty($Password) || empty($Mobile) || empty($Gender) || empty($Dob)) {
        echo "<h1>Error: All fields are required!</h1>";
        exit;
    }

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO register (Role, Name, Aadhar, Password, Mobile, Gender, Dob) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $Role, $Name, $Aadhar, $Password, $Mobile, $Gender, $Dob);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<h1>Registered Successfully</h1>";
        echo '<a href="http://localhost/CSP Web/Login.html"><b>Click here to login</b></a>';
    } else {
        echo "<h1>Error:</h1> " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form not submitted properly!";
}
?>
