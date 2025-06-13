<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_GET['penalty_id'])) {
        throw new Exception('Penalty ID is required');
    }

    $penalty_id = intval($_GET['penalty_id']);

    // Get penalty details
    $stmt = $pdo->prepare("
        SELECT p.*, s.first_name, s.last_name, pt.type_name, pt.price
        FROM penalties p
        JOIN staffs s ON p.staff_id = s.id
        JOIN penalty_types pt ON p.penalty_type_id = pt.id
        WHERE p.id = ?
    ");
    $stmt->execute([$penalty_id]);
    $penalty = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penalty) {
        throw new Exception('Penalty not found');
    }

    echo json_encode([
        'success' => true,
        'data' => $penalty
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 