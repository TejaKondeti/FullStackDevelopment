<?php
$u = $_POST["farmer-username"];
$p = $_POST["farmer-password"];
$con = mysqli_connect("localhost:3306", "root", "", "csp") or die("Connection Failed");
$sql = "SELECT * FROM marketregister WHERE Aadhar= '$u' and Password = '$p'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    // Redirect to Farmer Dashboard
    header("Location: MarketerDashboard.php");
    exit();
} else {
    // Display error message and redirect back to login page
    echo "Login Failed. Incorrect credentials or not authorized as Farmer.";
    header("refresh:2;url=login.html");
}
mysqli_close($con);
?>
