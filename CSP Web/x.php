<?php
// Database connection
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "farmerdashboard";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$farmer_data = null;

// Fetch farmer data based on the ID passed in the URL
if (isset($_GET['id'])) {
    $farmer_id = $_GET['id'];
    $sql = "SELECT * FROM crop_data WHERE id = $farmer_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $farmer_data = mysqli_fetch_assoc($result);
    } else {
        echo "Farmer data not found.";
        exit;
    }
} else {
    echo "No farmer ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make a Proposal</title>
</head>
<body>
    <h1>Making a Proposal for <?php echo htmlspecialchars($farmer_data['contact_no']); ?></h1>

    <form action="sendproposal.php" method="POST">
        <input type="hidden" name="farmer_id" value="<?php echo htmlspecialchars($farmer_data['id']); ?>">
        <input type="hidden" name="contact_no" value="<?php echo htmlspecialchars($farmer_data['contact_no']); ?>">

        <label>Your Proposal:</label>
        <textarea name="proposal_message" placeholder="Enter your proposal details..." required></textarea><br>

        <label>Offered Price:</label>
        <input type="number" name="price" placeholder="Enter your offered price" required><br>

        <button type="submit">Send Proposal</button>
    </form>
</body>
</html>
