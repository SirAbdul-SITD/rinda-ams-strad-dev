<?php
require_once('../settings.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

if (empty($_POST['material_id']) || empty($_POST['course_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    // Get course details to determine folder path
    $stmt = $pdo->prepare("SELECT course_name FROM courses WHERE course_id = ?");
    $stmt->execute([$_POST['course_id']]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$course) {
        throw new Exception("Course not found");
    }
    
    $courseFolder = 'uploads/courses/' . preg_replace('/[^a-zA-Z0-9-_]/', '_', $course['course_name']) . '_' . $_POST['course_id'];
    
    $uploadPath = null;
    $externalUrl = null;
    
    // Handle file upload if provided
    if ($_POST['material_type'] != 'link' && !empty($_FILES['material_file']['name'])) {
        // Create folders if they don't exist
        if (!file_exists($courseFolder)) {
            if (!mkdir($courseFolder, 0777, true)) {
                throw new Exception("Failed to create course folder");
            }
        }
        
        $typeFolder = $courseFolder . '/' . $_POST['material_type'] . 's';
        if (!file_exists($typeFolder)) {
            if (!mkdir($typeFolder, 0777, true)) {
                throw new Exception("Failed to create material type folder");
            }
        }
        
        $fileExt = pathinfo($_FILES['material_file']['name'], PATHINFO_EXTENSION);
        $fileName = 'material_' . time() . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $typeFolder . '/' . $fileName;
        
        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $targetPath)) {
            $uploadPath = str_replace('../../', '', $targetPath);
            
            // Delete old file if it exists
            $stmt = $pdo->prepare("SELECT file_path FROM course_materials WHERE id = ?");
            $stmt->execute([$_POST['material_id']]);
            $oldFile = $stmt->fetchColumn();
            
            if ($oldFile && file_exists($oldFile)) {
                unlink($oldFile);
            }
        } else {
            throw new Exception("Failed to upload new file");
        }
    } elseif ($_POST['material_type'] == 'link') {
        $externalUrl = $_POST['external_url'];
        
        // Delete old file if it exists (when changing from file to link)
        $stmt = $pdo->prepare("SELECT file_path FROM course_materials WHERE id = ?");
        $stmt->execute([$_POST['material_id']]);
        $oldFile = $stmt->fetchColumn();
        
        if ($oldFile && file_exists($oldFile)) {
            unlink($oldFile);
        }
    }
    
    // Update database record
    $stmt = $pdo->prepare("
        UPDATE course_materials SET
            title = ?,
            type = ?,
            file_path = ?,
            external_url = ?,
            description = ?,
            duration = ?,
            `order` = ?,
            updated_at = NOW()
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $_POST['material_title'],
        $_POST['material_type'],
        $uploadPath,
        $externalUrl,
        $_POST['material_description'] ?? null,
        $_POST['duration'] ?? null,
        $_POST['material_order'] ?? 0,
        $_POST['material_id']
    ]);
    
    if (!$success) {
        throw new Exception("Failed to update material in database");
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Material updated successfully',
        'redirect' => 'course-details.php?id=' . $_POST['course_id']
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>