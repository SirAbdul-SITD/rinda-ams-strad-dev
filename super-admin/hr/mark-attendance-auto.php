<?php
require_once '../settings.php';
require_once 'tomprint-config.php';
require_once 'tomprint-api.php';

// Create Tomprint logs table if it doesn't exist
createTomprintLogsTable($pdo);

// Initialize Tomprint API
$tomprint = new TomprintAPI($pdo);

// Get logs for the current day
$today = date('Y-m-d');
$processed = $tomprint->getAttendanceLogs($today, $today);

// Log the result
$logMessage = date('Y-m-d H:i:s') . " - Processed $processed attendance records\n";
file_put_contents(__DIR__ . '/tomprint-sync.log', $logMessage, FILE_APPEND);

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => "Successfully processed $processed attendance records",
    'processed' => $processed
]); 