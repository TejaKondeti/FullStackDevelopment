<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "farmerdashboard";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch farmer data with basic error handling
$sql = "SELECT * FROM crop_data";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        /* Button Styling */
        .proposal-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .proposal-button:hover {
            background-color: #45a049;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        .no-records {
            text-align: center;
            font-size: 18px;
            color: #888;
            padding: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Marketer Dashboard</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Crop Type</th>
            <th>Variety</th>
            <th>Defect Percentage</th>
            <th>Location</th>
            <th>Available Bags</th>
            <th>Contact No</th>
            <th>Action</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['crop_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['variety']) . "</td>";
                echo "<td>" . htmlspecialchars($row['defect_percentage']) . "%</td>";
                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                echo "<td>" . htmlspecialchars($row['number_of_bags']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ContactNo']) . "</td>";
                echo '<td><a href="makeproposal.php?id=' . urlencode($row['id']) . '" class="proposal-button">Make a Proposal</a></td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='no-records'>No records found</td></tr>";
        }
        ?>
    </table>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>
