<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Include the Simple HTML DOM library
require 'simple_html_dom.php';

// URL of the commodity prices page
$url = 'https://www.commodityonline.com/mandiprices/paddy-dhan-common/andhra-pradesh';

// Fetch the HTML content from the URL
$html = file_get_html($url);

if (!$html) {
    echo json_encode(['error' => 'Failed to fetch content from the URL']);
    exit;
}

// Extract data from the webpage
$data = [];

// Find and extract the required price data
$data['average_price'] = $html->find('div.price-summary', 0)->find('.average-price', 0)->plaintext ?? 'Not available';
$data['lowest_price'] = $html->find('div.price-summary', 0)->find('.lowest-price', 0)->plaintext ?? 'Not available';
$data['highest_price'] = $html->find('div.price-summary', 0)->find('.highest-price', 0)->plaintext ?? 'Not available';

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
