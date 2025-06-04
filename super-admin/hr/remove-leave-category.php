<?php
require_once '../settings.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id) {
        try {
            $sql = "DELETE FROM leave_categories WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo json_encode(['success' => true, 'message' => 'Category removed successfully.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid category ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
} 