<?php
require __DIR__ . '/vendor/autoload.php';  // Include Twilio's PHP SDK

use Twilio\Rest\Client;

$account_sid = "your_account_sid";  // Replace with your Twilio Account SID
$auth_token = "your_auth_token";    // Replace with your Twilio Auth Token
$twilio_number = "your_twilio_number"; // Your Twilio phone number

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmer_phone = $_POST["farmer_phone"];  // Get farmer's phone number
    $crop_name = $_POST["crop_name"];        // Crop being offered
    $offered_price = $_POST["offered_price"]; // Marketer's proposed price

    $message_body = "Hello, you have received an offer for your $crop_name at Rs. $offered_price. Reply if interested.";

    $client = new Client($account_sid, $auth_token);

    try {
        $message = $client->messages->create(
            $farmer_phone,  // Farmer's phone number
            [
                'from' => $twilio_number,
                'body' => $message_body
            ]
        );
        echo "Proposal sent successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
