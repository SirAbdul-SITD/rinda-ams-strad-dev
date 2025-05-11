<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_clean(); 
require_once '../settings.php';

// Ensure we return JSON
header('Content-Type: application/json');

// Check if user is logged in (if needed)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

// Validate the event ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'Invalid event ID']);
    exit();
}

try {
    // Get the event from database
    $stmt = $pdo->prepare("SELECT * FROM academic_calendar WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$event) {
        echo json_encode(['error' => 'Event not found']);
        exit();
    }
    
    // Return the event data as JSON
    echo json_encode($event);
    
} catch (PDOException $e) {
    // Log the error for debugging
    error_log("Database error: " . $e->getMessage());
    
    // Return a JSON error response
    echo json_encode(['error' => 'Database error occurred']);
}
exit();
?>