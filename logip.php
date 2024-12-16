<?php
$data = file_get_contents('php://input');

$json = json_decode($data, true);

$ip = $json['ip'];

$file = 'ips.txt';
file_put_contents($file, "IP Address: $ip\n", FILE_APPEND);

echo json_encode(['status' => 'success']);
?>
