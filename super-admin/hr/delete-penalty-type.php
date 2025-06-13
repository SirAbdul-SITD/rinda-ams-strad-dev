<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_POST['type_id'])) {
        throw new Exception('Type ID is required');
    }

    $type_id = intval($_POST['type_id']);

    // Check if penalty type exists
    $stmt = $pdo->prepare("SELECT id FROM penalty_types WHERE id = ?");
    $stmt->execute([$type_id]);
    if ($stmt->rowCount() === 0) {
        throw new Exception('Penalty type not found');
    }

    // Check if penalty type is being used in any penalties
    $stmt = $pdo->prepare("SELECT id FROM penalties WHERE penalty_type_id = ?");
    $stmt->execute([$type_id]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('Cannot delete penalty type that is being used in existing penalties');
    }

    // Delete penalty type
    $stmt = $pdo->prepare("DELETE FROM penalty_types WHERE id = ?");
    $stmt->execute([$type_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Penalty type deleted successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 