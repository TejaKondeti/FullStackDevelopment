<?php
// Configuration for Infobip API and Database
define('INFOBIP_API_URL', 'https://api.infobip.com'); // Correct base URL
define('INFOBIP_API_KEY', 'e0a84b5e24c6c971a3a871f42299c62a-44d0ce64-a930-4c89-9555-f000a00416b2'); // Replace with your Infobip API key
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'farmerdashboard');

$responseMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farmerID = $_POST['farmer_id'];
    $proposalMessage = $_POST['proposal_message'];
    $price = $_POST['price'];

    // Retrieve farmer's phone number
    $farmerPhone = getFarmerPhoneNumber($farmerID);

    if ($farmerPhone) {
        // Validate and format phone number
        $formattedPhone = formatPhoneNumber($farmerPhone);

        if ($formattedPhone) {
            // Send SMS via Infobip API
            $responseMessage = sendProposalMessage($formattedPhone, $proposalMessage, $price);

            // Save the proposal to the database
            $dbResponse = saveProposalToDatabase($formattedPhone, $proposalMessage, $price);
        } else {
            $responseMessage = "Error: Invalid phone number format.";
        }
    } else {
        $responseMessage = "Error: Farmer phone number not found.";
    }
}

// Function to send SMS via Infobip API
function sendProposalMessage($farmerPhone, $proposalMessage, $price) {
    $ch = curl_init();

    $messageBody = "Proposal Message: $proposalMessage\nPrice: $price";
    $payload = [
        'messages' => [
            [
                'from' => 'YourBrandName', // Replace with your actual sender ID
                'destinations' => [
                    ['to' => $farmerPhone]
                ],
                'text' => $messageBody
            ]
        ]
    ];

    curl_setopt($ch, CURLOPT_URL, INFOBIP_API_URL . "/sms/2/text/advanced");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: App ' . INFOBIP_API_KEY,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Log response for debugging
    file_put_contents("infobip_debug.log", "Sending to: $farmerPhone\nHTTP Status: $httpStatus\nResponse: $response\n", FILE_APPEND);

    if (curl_errno($ch)) {
        return "Error: " . curl_error($ch);
    }

    curl_close($ch);

    if ($httpStatus == 200) {
        return "Proposal sent successfully via SMS!";
    } else {
        return "Error: Failed to send SMS. HTTP Status: $httpStatus. Response: " . $response;
    }
}

// Function to retrieve farmer's phone number
function getFarmerPhoneNumber($farmerID) {
    $conn = createDatabaseConnection();
    if (!$conn) {
        die("Error: Could not connect to the database.");
    }

    $stmt = $conn->prepare("SELECT ContactNo FROM crop_data WHERE id = ?");
    if (!$stmt) {
        die("Error: Prepare failed for getFarmerPhoneNumber: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("i", $farmerID);
    $stmt->execute();
    $stmt->bind_result($farmerPhone);
    $stmt->fetch();

    $stmt->close();
    $conn->close();

    return $farmerPhone ? $farmerPhone : null;
}

// Function to format the phone number
function formatPhoneNumber($phoneNumber) {
    // Ensure the phone number starts with a "+" for E.164 format
    $phoneNumber = preg_replace('/\s+/', '', $phoneNumber); // Remove spaces
    if (substr($phoneNumber, 0, 1) !== '+') {
        $phoneNumber = '+91' . ltrim($phoneNumber, '0'); // Replace +91 with your country code
    }

    // Validate that the phone number is in E.164 format
    if (preg_match('/^\+\d{10,15}$/', $phoneNumber)) {
        return $phoneNumber;
    }
    return false;
}

// Function to save the proposal to the database
function saveProposalToDatabase($farmerPhone, $proposalMessage, $price) {
    $conn = createDatabaseConnection();
    if (!$conn) {
        return "Error: Could not connect to the database.";
    }

    $stmt = $conn->prepare("INSERT INTO proposals (farmer_phone, proposal_message, price) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error: Prepare failed for saveProposalToDatabase: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("sss", $farmerPhone, $proposalMessage, $price);
    $stmt->execute();

    $status = $stmt->affected_rows > 0 ? "Proposal saved in the database!" : "Error: Could not save proposal.";

    $stmt->close();
    $conn->close();

    return $status;
}

// Function to create a database connection
function createDatabaseConnection() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Submission Status</title>
</head>
<body>
    <h1>Proposal Submission Status</h1>
    <p><?php echo $responseMessage; ?></p>
    <a href="MarketerDashboard.php">Back to Proposals</a>
</body>
</html>
