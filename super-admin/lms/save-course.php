<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized access']));
}

// Validate input
$required_fields = ['course_name', 'subject', 'class_level'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        die(json_encode(['success' => false, 'message' => ucfirst($field) . ' is required']));
    }
}

try {
    $pdo = getDBConnection();
    
    // Handle file upload if thumbnail is provided
    $thumbnail_path = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/courses/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_info = pathinfo($_FILES['thumbnail']['name']);
        $extension = strtolower($file_info['extension']);
        
        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowed_types)) {
            die(json_encode(['success' => false, 'message' => 'Invalid file type. Allowed types: ' . implode(', ', $allowed_types)]));
        }
        
        // Generate unique filename
        $filename = uniqid() . '.' . $extension;
        $thumbnail_path = 'uploads/courses/' . $filename;
        
        if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_dir . $filename)) {
            die(json_encode(['success' => false, 'message' => 'Error uploading file']));
        }
    }
    
    // Prepare data for insertion
    $data = [
        'course_name' => $_POST['course_name'],
        'subject' => $_POST['subject'],
        'class_level' => $_POST['class_level'],
        'description' => $_POST['description'] ?? null,
        'status' => $_POST['status'] ?? 'active',
        'thumbnail' => $thumbnail_path,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    // Insert into database
    $sql = "INSERT INTO courses (course_name, subject, class_level, description, status, thumbnail, created_at) 
            VALUES (:course_name, :subject, :class_level, :description, :status, :thumbnail, :created_at)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    
    echo json_encode(['success' => true, 'message' => 'Course added successfully']);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}