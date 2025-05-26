<?php
// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../settings.php');

// Set header to return JSON
header('Content-Type: application/json');

// Log the received data for debugging
file_put_contents('update_course_debug.log', "\n\n" . date('Y-m-d H:i:s') . " - Received data: " . print_r($_POST, true) . "\nFiles: " . print_r($_FILES, true), FILE_APPEND);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required = ['course_id', 'course_name', 'course_code', 'curriculum_type_id', 'level'];
    $missing = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields: ' . implode(', ', $missing),
            'received_data' => $_POST
        ]);
        exit;
    }

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Debug: Log database connection status
        file_put_contents('update_course_debug.log', "Database connection check: " . ($pdo ? "Connected" : "Not connected") . "\n", FILE_APPEND);

        // Get current course data
        $stmt = $pdo->prepare("SELECT thumbnail FROM courses WHERE course_id = ?");
        $stmt->execute([$_POST['course_id']]);
        $currentCourse = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$currentCourse) {
            throw new Exception("Course not found with ID: " . $_POST['course_id']);
        }

        // Handle file upload
        $thumbnailPath = $currentCourse['thumbnail'];
        if (!empty($_FILES['thumbnail']['name'])) {
            $uploadDir = './uploads/course-thumbnails/';
            
            // Debug: Log upload directory status
            file_put_contents('update_course_debug.log', "Upload directory: $uploadDir, exists: " . (file_exists($uploadDir) ? "Yes" : "No") . ", writable: " . (is_writable($uploadDir) ? "Yes" : "No") . "\n", FILE_APPEND);
            
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new Exception("Failed to create upload directory at: " . realpath($uploadDir));
                }
            }

            $fileExt = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $fileName = 'thumbnail_' . time() . '_' . uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $fileName;

            // Check if file is an image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['thumbnail']['tmp_name']);
            
            // Debug: Log file info
            file_put_contents('update_course_debug.log', "File info - Type: $fileType, Size: " . $_FILES['thumbnail']['size'] . "\n", FILE_APPEND);
            
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Invalid file type. Only JPG, PNG, GIF, and WebP files are allowed.");
            }

            // Check file size (max 2MB)
            if ($_FILES['thumbnail']['size'] > 2097152) {
                throw new Exception("File size exceeds 2MB limit.");
            }

            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                throw new Exception("Failed to move uploaded file. Check permissions.");
            }
            
            // Delete old thumbnail if it exists
            if ($thumbnailPath && file_exists('../../' . $thumbnailPath)) {
                if (!unlink('../../' . $thumbnailPath)) {
                    throw new Exception("Failed to delete old thumbnail.");
                }
            }
            
            $thumbnailPath = 'uploads/course-thumbnails/' . $fileName;
        }

        // Debug: Log the update data
        file_put_contents('update_course_debug.log', "Updating course with data: " . print_r([
            'course_name' => $_POST['course_name'],
            'course_code' => $_POST['course_code'],
            'curriculum_type_id' => $_POST['curriculum_type_id'],
            'level' => $_POST['level'],
            'description' => $_POST['description'] ?? null,
            'thumbnail' => $thumbnailPath,
            'course_id' => $_POST['course_id']
        ], true) . "\n", FILE_APPEND);

        // Update course in database
        $stmt = $pdo->prepare("
            UPDATE courses SET
            course_name = ?,
            course_code = ?,
            curriculum_type_id = ?,
            level = ?,
            description = ?,
            thumbnail = ?
            WHERE course_id = ?
        ");
        
        $success = $stmt->execute([
            trim($_POST['course_name']),
            trim($_POST['course_code']),
            $_POST['curriculum_type_id'],
            trim($_POST['level']),
            !empty($_POST['description']) ? trim($_POST['description']) : null,
            $thumbnailPath,
            $_POST['course_id']
        ]);

        if (!$success) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Database update failed: " . ($errorInfo[2] ?? 'Unknown error'));
        }

        // Commit transaction
        $pdo->commit();

        // Debug: Log success
        file_put_contents('update_course_debug.log', "Course updated successfully\n", FILE_APPEND);

        echo json_encode([
            'success' => true,
            'message' => 'Course updated successfully!'
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        
        // Delete uploaded file if transaction failed
        if (!empty($thumbnailPath) && isset($fileName) && file_exists('./uploads/course-thumbnails/' . $fileName)) {
            unlink('./uploads/course-thumbnails/' . $fileName);
        }
        
        // Debug: Log error
        file_put_contents('update_course_debug.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
        
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'error_details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>