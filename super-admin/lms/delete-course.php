<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized access']));
}

// Validate input
if (empty($_POST['id'])) {
    die(json_encode(['success' => false, 'message' => 'Course ID is required']));
}

try {
    $pdo = getDBConnection();
    
    // Get course thumbnail path before deletion
    $stmt = $pdo->prepare("SELECT thumbnail FROM courses WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Delete the course
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    
    if ($stmt->rowCount() > 0) {
        // Delete thumbnail file if exists
        if ($course && $course['thumbnail']) {
            $thumbnail_path = '../' . $course['thumbnail'];
            if (file_exists($thumbnail_path)) {
                unlink($thumbnail_path);
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Course deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Course not found']);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}