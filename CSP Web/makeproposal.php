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

// Fetch farmer data based on the ID
if (isset($_GET['id'])) {
    $farmer_id = $_GET['id'];
    // Use the correct variable in the query (not as a string)
    $sql = "SELECT * FROM crop_data WHERE id = $farmer_id";
    $result = mysqli_query($conn, $sql);
    $farmer_data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Proposal</title>
    <style>
        form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            max-width: 600px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1>Making a Proposal for <?php echo htmlspecialchars($farmer_data['ContactNo']); ?></h1>

<form action="Infobipsendproposal.php" method="POST">
    <input type="hidden" name="farmer_id" value="<?php echo htmlspecialchars($farmer_data['id']); ?>">

    <label for="proposal_message">Your Proposal:</label>
    <textarea id="proposal_message" name="proposal_message" rows="4" placeholder="Enter your proposal details..." required></textarea>

    <label for="proposal_price">Offered Price:</label>
    <input type="number" id="proposal_price" name="price" placeholder="Enter your offered price" required>
    
    <button type="submit">Send Proposal</button>
</form>

</body>
</html>
