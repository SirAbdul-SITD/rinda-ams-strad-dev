<?php
require_once '../settings.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception('Invalid penalty ID');
    }

    $penalty_id = intval($_POST['id']);

    // Fetch penalty details with staff and department information
    $query = "SELECT p.*, 
                     CONCAT(s.first_name, ' ', s.last_name) as staff_name,
                     d.department
              FROM penalties p
              JOIN staffs s ON p.staff_id = s.id
              LEFT JOIN departments d ON s.department_id = d.id
              WHERE p.id = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$penalty_id]);
    $penalty = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penalty) {
        throw new Exception('Penalty not found');
    }

    echo json_encode([
        'success' => true,
        'penalty' => $penalty
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 