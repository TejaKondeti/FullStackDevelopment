<?php 
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "csp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the markets table (only Market Name and Address)
$sql = "SELECT `Market Name`, `Address` FROM marketregister"; // Assuming 'Address' is the correct field name
$result = mysqli_query($conn, $sql);

// Start HTML output
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Market List</h1>
    <table>
        <tr>
            <th>Market Name</th>
            <th>Address</th>
        </tr>';

// Check if there are results and output data
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . htmlspecialchars($row["Market Name"]) . '</td>
                <td>' . htmlspecialchars($row["Address"]) . '</td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="2">No markets found</td></tr>';
}

echo '    </table>
</body>
</html>';

// Close connection
mysqli_close($conn);
?>