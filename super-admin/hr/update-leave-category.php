<?php
require_once '../settings.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $days = isset($_POST['days']) ? intval($_POST['days']) : 0;

    if ($id && $name && $days) {
        try {
            $sql = "SELECT COUNT(*) as count FROM leave_categories WHERE LOWER(TRIM(category)) = LOWER(TRIM(?)) AND id != ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                echo json_encode(['success' => false, 'message' => 'Category name already exists.']);
                return;
            }

            $sql = "UPDATE leave_categories SET category = :name, duration_in_days = :days WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':days', $days);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo json_encode(['success' => true, 'message' => 'Category updated successfully.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
} 