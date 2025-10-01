<?php
declare(strict_types=1);

// Always return JSON
header('Content-Type: application/json');

// Enforce POST to avoid casual crawling and accidental GETs
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
	http_response_code(405);
	echo json_encode(['error' => 'Method Not Allowed']);
	exit;
}

// Derive client IP server-side; do not trust client-supplied values
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
if (!filter_var($ip, FILTER_VALIDATE_IP)) {
	http_response_code(400);
	echo json_encode(['error' => 'Unable to determine client IP']);
	exit;
}

// Sanitize User-Agent for logging (strip control chars, cap length)
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$ua = preg_replace('/[\x00-\x1F\x7F]/u', '', (string)$ua) ?? '';
$ua = mb_substr($ua, 0, 512, 'UTF-8');

// Prepare log destination (protected directory within project)
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
	// Best-effort create; permissions will be subject to umask
	@mkdir($logDir, 0750, true);
}
$logFile = $logDir . '/ips.ndjson';

// Compose newline-delimited JSON record
$record = [
	'ts' => gmdate('c'), // ISO8601 in UTC
	'ip' => $ip,
	'ua' => $ua,
];

$line = json_encode($record, JSON_UNESCAPED_SLASHES) . PHP_EOL;
$written = @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

if ($written === false) {
	http_response_code(500);
	echo json_encode(['error' => 'Failed to write log']);
	exit;
}

echo json_encode(['status' => 'ok']);
?>
