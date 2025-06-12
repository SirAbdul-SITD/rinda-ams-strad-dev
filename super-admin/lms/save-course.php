<?php
session_start();
require_once '../db.php';
require_once '../settings.php';

// Enable error reporting but don't display errors
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_log("Starting save-course.php script");

// Set proper JSON header
header('Content-Type: application/json');

// Function to send JSON response and exit
function sendJsonResponse($success, $message) {
    error_log("Sending JSON response: " . json_encode(['success' => $success, 'message' => $message]));
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin_rights']) || $_SESSION['admin_rights'] != 1) {
    error_log("Unauthorized access attempt. Session data: " . print_r($_SESSION, true));
    sendJsonResponse(false, 'Unauthorized access. Please make sure you are logged in as an admin.');
}

// Log the incoming request data
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

// Validate input
$required_fields = ['course_name', 'course_code', 'subject', 'level', 'class_level', 'curriculum_type_id'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        error_log("Missing required field: " . $field);
        sendJsonResponse(false, ucfirst(str_replace('_', ' ', $field)) . ' is required');
    }
}

try {
    // Check if course code already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM courses WHERE course_code = ?");
    $stmt->execute([$_POST['course_code']]);
    if ($stmt->fetchColumn() > 0) {
        error_log("Course code already exists: " . $_POST['course_code']);
        sendJsonResponse(false, 'Course code already exists');
    }
    
    // Handle file upload if thumbnail is provided
    $thumbnail_path = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/courses/';
        $full_upload_dir = __DIR__ . '/../' . $upload_dir;
        
        // Check if directory exists and is writable
        if (!file_exists($full_upload_dir)) {
            // Try to create directory with proper permissions
            if (!@mkdir($full_upload_dir, 0777, true)) {
                error_log("Failed to create directory: " . $full_upload_dir . " - Error: " . error_get_last()['message']);
                sendJsonResponse(false, 'Error creating upload directory. Please check server permissions.');
            }
            // Ensure proper permissions after creation
            @chmod($full_upload_dir, 0777);
        } elseif (!is_writable($full_upload_dir)) {
            error_log("Directory not writable: " . $full_upload_dir . " - Current permissions: " . substr(sprintf('%o', fileperms($full_upload_dir)), -4));
            sendJsonResponse(false, 'Upload directory is not writable. Please check server permissions.');
        }
        
        $file_info = pathinfo($_FILES['thumbnail']['name']);
        $extension = strtolower($file_info['extension']);
        
        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowed_types)) {
            error_log("Invalid file type: " . $extension);
            sendJsonResponse(false, 'Invalid file type. Allowed types: ' . implode(', ', $allowed_types));
        }
        
        // Generate unique filename
        $filename = uniqid() . '.' . $extension;
        $thumbnail_path = $upload_dir . $filename;
        $full_path = $full_upload_dir . $filename;
        
        // Try to move the uploaded file
        if (!@move_uploaded_file($_FILES['thumbnail']['tmp_name'], $full_path)) {
            error_log("Failed to move uploaded file to: " . $full_path . " - Error: " . error_get_last()['message']);
            sendJsonResponse(false, 'Error uploading file. Please check server permissions.');
        }
        
        // Ensure proper file permissions
        @chmod($full_path, 0644);
    }
    
    // Prepare data for insertion
    $data = [
        'course_name' => $_POST['course_name'],
        'course_code' => $_POST['course_code'],
        'curriculum_type_id' => $_POST['curriculum_type_id'],
        'level' => $_POST['level'],
        'description' => $_POST['description'] ?? null,
        'subject' => $_POST['subject'],
        'class_level' => $_POST['class_level'],
        'thumbnail' => $thumbnail_path,
        'folder_id' => null // This can be set later if needed
    ];
    
    // Log the data being inserted
    error_log("Data being inserted: " . print_r($data, true));
    
    // Insert into database
    $sql = "INSERT INTO courses (
                course_name, 
                course_code, 
                curriculum_type_id, 
                level, 
                description, 
                subject, 
                class_level, 
                thumbnail, 
                folder_id,
                created_at,
                updated_at
            ) VALUES (
                :course_name, 
                :course_code, 
                :curriculum_type_id, 
                :level, 
                :description, 
                :subject, 
                :class_level, 
                :thumbnail, 
                :folder_id,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($data);
    
    if ($result) {
        error_log("Course added successfully");
        sendJsonResponse(true, 'Course added successfully');
    } else {
        $error = $stmt->errorInfo();
        error_log("Database error: " . print_r($error, true));
        sendJsonResponse(false, 'Database error: ' . $error[2]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    sendJsonResponse(false, 'Database error occurred: ' . $e->getMessage());
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    sendJsonResponse(false, 'An error occurred: ' . $e->getMessage());
}