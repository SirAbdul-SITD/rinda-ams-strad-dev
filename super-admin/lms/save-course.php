<?php
require_once('../settings.php');

// Set header to return JSON
header('Content-Type: application/json');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required = ['course_name', 'course_code', 'curriculum_type_id', 'level'];
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
            'message' => 'Missing required fields: ' . implode(', ', $missing)
        ]);
        exit;
    }

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Handle file upload
        $thumbnailPath = null;
        if (!empty($_FILES['thumbnail']['name'])) {
            $uploadDir = './uploads/course-thumbnails/';
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new Exception("Failed to create upload directory.");
                }
            }

            $fileExt = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $fileName = 'thumbnail_' . time() . '_' . uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $fileName;

            // Check if file is an image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['thumbnail']['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Only JPG, PNG, GIF, and WebP files are allowed for thumbnails.");
            }

            // Check file size (max 2MB)
            if ($_FILES['thumbnail']['size'] > 2097152) {
                throw new Exception("Thumbnail image must be less than 2MB.");
            }

            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                throw new Exception("Failed to upload thumbnail image.");
            }
            
            $thumbnailPath = 'uploads/course-thumbnails/' . $fileName;
        }

        // Insert course into database
        $stmt = $pdo->prepare("
            INSERT INTO courses 
            (course_name, course_code, curriculum_type_id, level, description, thumbnail) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $success = $stmt->execute([
            trim($_POST['course_name']),
            trim($_POST['course_code']),
            $_POST['curriculum_type_id'],
            trim($_POST['level']),
            !empty($_POST['description']) ? trim($_POST['description']) : null,
            $thumbnailPath
        ]);

        if (!$success) {
            throw new Exception("Failed to save course to database.");
        }

        $courseId = $pdo->lastInsertId();
        
        // Create folder for the course in the file manager
        $folderName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $_POST['course_name']);
        $folderPath = 'uploads/courses/' . $folderName . '_' . $courseId;
        
        // Create the physical directory
        if (!file_exists($folderPath)) {
            if (!mkdir($folderPath, 0777, true)) {
                throw new Exception("Failed to create course folder.");
            }
        }
        
        // Create folder record in database
        $folderStmt = $pdo->prepare("
            INSERT INTO folders 
            (name, parent_id, created_by, permission, created_at) 
            VALUES (?, NULL, ?, 'private', NOW())
        ");
        
        $folderSuccess = $folderStmt->execute([
            $_POST['course_name'] . ' Materials',
            $_SESSION['user_id'] // Assuming you have user session
        ]);
        
        if (!$folderSuccess) {
            throw new Exception("Failed to create folder record in database.");
        }
        
        $folderId = $pdo->lastInsertId();

        // Commit transaction
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Course created successfully with dedicated folder!',
            'course_id' => $courseId,
            'folder_id' => $folderId
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        
        // Delete uploaded file if transaction failed
        if (!empty($thumbnailPath) && file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
        
        // Delete folder if it was created
        if (!empty($folderPath) && file_exists($folderPath)) {
            rmdir($folderPath);
        }
        
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'error_details' => $e->getFile() . ':' . $e->getLine()
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