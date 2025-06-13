<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_GET['type_id'])) {
        throw new Exception('Type ID is required');
    }

    $type_id = intval($_GET['type_id']);

    // Get penalty type details
    $stmt = $pdo->prepare("SELECT id, type_name, description, amount FROM penalty_types WHERE id = ?");
    $stmt->execute([$type_id]);
    $penalty_type = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penalty_type) {
        throw new Exception('Penalty type not found');
    }

    echo json_encode([
        'success' => true,
        'data' => $penalty_type
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 