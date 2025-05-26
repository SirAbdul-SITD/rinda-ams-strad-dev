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
    // First get the file path if it exists
    $stmt = $pdo->prepare("SELECT file_path FROM course_materials WHERE id = ?");
    $stmt->execute([$_POST['material_id']]);
    $filePath = $stmt->fetchColumn();
    
    // Delete the material record
    $stmt = $pdo->prepare("DELETE FROM course_materials WHERE id = ?");
    $success = $stmt->execute([$_POST['material_id']]);
    
    if (!$success) {
        throw new Exception("Failed to delete material from database");
    }
    
    // Delete the file if it exists
    if ($filePath && file_exists($filePath)) {
        if (!unlink($filePath)) {
            throw new Exception("Failed to delete material file");
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Material deleted successfully',
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