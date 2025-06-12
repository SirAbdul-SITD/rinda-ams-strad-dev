<?php
// Prevent any output before headers
ob_start();

// Start session before any output
session_start();

// Disable error display but enable logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Set error handler to prevent output
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("PHP Error [$errno]: $errstr in $errfile on line $errline");
    return true;
});

// Set exception handler
set_exception_handler(function($e) {
    error_log("Uncaught Exception: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred',
        'error' => $e->getMessage()
    ]);
    exit;
});

require_once('../settings.php');

// Set header to return JSON
header('Content-Type: application/json');

// Function to send JSON response
function sendResponse($success, $message, $data = null, $statusCode = 200) {
    ob_clean(); // Clear any output buffer
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Function to handle errors
function handleError($message, $error = null) {
    error_log("Course Update Error: " . $message . ($error ? " - " . $error : ""));
    sendResponse(false, $message, ['error' => $error], 500);
}

// Log the received data for debugging
$log_data = [
    'POST' => $_POST,
    'FILES' => $_FILES,
    'SERVER' => [
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
        'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'] ?? 'not set'
    ],
    'SESSION' => [
        'user_id' => $_SESSION['user_id'] ?? null,
        'admin_rights' => $_SESSION['admin_rights'] ?? null
    ]
];
error_log("Update Course Request: " . print_r($log_data, true));

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin_rights']) || $_SESSION['admin_rights'] != 1) {
    sendResponse(false, 'Unauthorized access', [
        'session_data' => [
            'user_id' => $_SESSION['user_id'] ?? null,
            'admin_rights' => $_SESSION['admin_rights'] ?? null
        ]
    ], 401);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    sendResponse(false, 'Invalid request method. Only POST is allowed.', [
        'received_method' => $_SERVER['REQUEST_METHOD']
    ], 405);
}

// Validate required fields
$required_fields = ['course_id', 'course_name', 'subject', 'class_level', 'curriculum_type_id', 'course_code', 'level'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        sendResponse(false, "Missing required field: $field", [
            'received_data' => $_POST
        ], 400);
    }
}

try {
    // Get current course data
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->execute([$_POST['course_id']]);
    $current_course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$current_course) {
        sendResponse(false, 'Course not found', null, 404);
    }
    
    // Check if course_code is unique (excluding current course)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM courses WHERE course_code = ? AND course_id != ?");
    $stmt->execute([$_POST['course_code'], $_POST['course_id']]);
    if ($stmt->fetchColumn() > 0) {
        sendResponse(false, 'Course code already exists', null, 400);
    }
    
    // Handle file upload if new thumbnail is provided
    $thumbnail_path = $current_course['thumbnail'];
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/course_thumbnails/';
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                throw new Exception("Failed to create upload directory: " . $upload_dir);
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
            throw new Exception("Failed to move uploaded file. Check directory permissions: " . $upload_dir);
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
        'course_code' => $_POST['course_code'],
        'subject' => $_POST['subject'],
        'class_level' => $_POST['class_level'],
        'level' => $_POST['level'],
        'description' => $_POST['description'] ?? null,
        'thumbnail' => $thumbnail_path,
        'curriculum_type_id' => $_POST['curriculum_type_id'],
        'course_id' => $_POST['course_id']
    ];
    
    // Log the data being used for update
    error_log("Update Course Data: " . print_r($data, true));
    
    // Update database
    $sql = "UPDATE courses SET 
            course_name = :course_name,
            course_code = :course_code,
            subject = :subject,
            class_level = :class_level,
            level = :level,
            description = :description,
            thumbnail = :thumbnail,
            curriculum_type_id = :curriculum_type_id,
            updated_at = CURRENT_TIMESTAMP
            WHERE course_id = :course_id";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($data);
    
    if ($result) {
        sendResponse(true, 'Course updated successfully', [
            'course_id' => $_POST['course_id'],
            'thumbnail' => $thumbnail_path
        ]);
    } else {
        $error = $stmt->errorInfo();
        throw new Exception("Failed to update course in database. SQL State: " . $error[0] . " - " . $error[2]);
    }
    
} catch (PDOException $e) {
    handleError('Database error occurred', $e->getMessage());
} catch (Exception $e) {
    handleError('An error occurred', $e->getMessage());
}
?>