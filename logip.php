<?php
// Get the raw POST data from the request
$data = file_get_contents('php://input');

// Decode the JSON data
$json = json_decode($data, true);

// Get the IP address from the data
$ip = $json['ip'];

// Log the IP address to a file
$file = 'ips.txt'; // File to store the IP addresses
file_put_contents($file, "IP Address: $ip\n", FILE_APPEND);

// Send a response back to the client
echo json_encode(['status' => 'success']);
?>
