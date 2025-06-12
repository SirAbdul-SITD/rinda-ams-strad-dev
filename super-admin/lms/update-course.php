<?php
// Start session before any output
session_start();

// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../settings.php');
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Set header to return JSON
header('Content-Type: application/json');

// Function to send JSON response
function sendResponse($success, $message, $data = null, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Log the received data for debugging
$log_data = [
    'POST' => $_POST,
    'FILES' => $_FILES,
    'SERVER' => [
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
        'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'] ?? 'not set'
    ]
];
file_put_contents('update_course_debug.log', "\n\n" . date('Y-m-d H:i:s') . " - Request data: " . print_r($log_data, true), FILE_APPEND);

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    sendResponse(false, 'Unauthorized access', null, 401);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    sendResponse(false, 'Invalid request method. Only POST is allowed.', [
        'received_method' => $_SERVER['REQUEST_METHOD']
    ], 405);
}

// Validate required fields
$required_fields = ['course_id', 'course_name', 'subject', 'class_level'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        sendResponse(false, "Missing required field: $field", [
            'received_data' => $_POST
        ], 400);
    }
}

try {
    // Get database connection
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception("Failed to connect to database");
    }
    
    // Get current course data
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$_POST['course_id']]);
    $current_course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$current_course) {
        sendResponse(false, 'Course not found', null, 404);
    }
    
    // Handle file upload if new thumbnail is provided
    $thumbnail_path = $current_course['thumbnail'];
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/course_thumbnails/';
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }
        
        $file_info = pathinfo($_FILES['thumbnail']['name']);
        $extension = strtolower($file_info['extension']);
        
        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowed_types)) {
            sendResponse(false, 'Invalid file type. Allowed types: ' . implode(', ', $allowed_types), null, 400);
        }
        
        // Generate unique filename
        $new_filename = uniqid() . '.' . $extension;
        $upload_path = 'course_thumbnails/' . $new_filename;
        $full_path = __DIR__ . '/' . $upload_path;
        
        if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $full_path)) {
            throw new Exception("Failed to move uploaded file");
        }
        
        // Delete old thumbnail if exists
        if ($current_course['thumbnail']) {
            $old_thumbnail_path = __DIR__ . '/' . $current_course['thumbnail'];
            if (file_exists($old_thumbnail_path)) {
                unlink($old_thumbnail_path);
            }
        }
        
        $thumbnail_path = $upload_path;
    }
    
    // Prepare data for update
    $data = [
        'course_name' => $_POST['course_name'],
        'subject' => $_POST['subject'],
        'class_level' => $_POST['class_level'],
        'description' => $_POST['description'] ?? null,
        'status' => $_POST['status'] ?? 'active',
        'thumbnail' => $thumbnail_path,
        'id' => $_POST['course_id']
    ];
    
    // Log the data being used for update
    file_put_contents('update_course_debug.log', "\nUpdate data: " . print_r($data, true), FILE_APPEND);
    
    // Update database
    $sql = "UPDATE courses SET 
            course_name = :course_name,
            subject = :subject,
            class_level = :class_level,
            description = :description,
            status = :status,
            thumbnail = :thumbnail,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($data);
    
    if ($result) {
        sendResponse(true, 'Course updated successfully', [
            'course_id' => $_POST['course_id'],
            'thumbnail' => $thumbnail_path
        ]);
    } else {
        throw new Exception("Failed to update course in database");
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    sendResponse(false, 'Database error occurred', [
        'error_details' => $e->getMessage()
    ], 500);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    sendResponse(false, 'An error occurred', [
        'error_details' => $e->getMessage()
    ], 500);
}
?>