<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_POST['type_id']) || empty($_POST['type_name']) || !isset($_POST['amount'])) {
        throw new Exception('Type ID, name, and amount are required');
    }

    $type_id = intval($_POST['type_id']);
    $type_name = trim($_POST['type_name']);
    $description = trim($_POST['description'] ?? '');
    $amount = floatval($_POST['amount']);

    if ($amount < 0) {
        throw new Exception('Amount cannot be negative');
    }

    // Check if type name already exists for other types
    $stmt = $pdo->prepare("SELECT id FROM penalty_types WHERE type_name = ? AND id != ?");
    $stmt->execute([$type_name, $type_id]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('Penalty type with this name already exists');
    }

    // Update penalty type
    $stmt = $pdo->prepare("UPDATE penalty_types SET type_name = ?, description = ?, amount = ? WHERE id = ?");
    $stmt->execute([$type_name, $description, $amount, $type_id]);

    if ($stmt->rowCount() === 0) {
        throw new Exception('Penalty type not found');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Penalty type updated successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 