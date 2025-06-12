<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_POST['type_name']) || !isset($_POST['amount'])) {
        throw new Exception('Type name and amount are required');
    }

    $type_name = trim($_POST['type_name']);
    $description = trim($_POST['description'] ?? '');
    $amount = floatval($_POST['amount']);

    if ($amount < 0) {
        throw new Exception('Amount cannot be negative');
    }

    // Check if type name already exists
    $stmt = $pdo->prepare("SELECT id FROM penalty_types WHERE type_name = ?");
    $stmt->execute([$type_name]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('Penalty type with this name already exists');
    }

    // Insert new penalty type
    $stmt = $pdo->prepare("INSERT INTO penalty_types (type_name, description, amount) VALUES (?, ?, ?)");
    $stmt->execute([$type_name, $description, $amount]);

    echo json_encode([
        'success' => true,
        'message' => 'Penalty type added successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 