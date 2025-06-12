<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_POST['penalty_id']) || empty($_POST['staff_id']) || empty($_POST['penalty_type_id']) || empty($_POST['date']) || !isset($_POST['price'])) {
        throw new Exception('Penalty ID, staff, penalty type, date, and price are required');
    }

    $penalty_id = intval($_POST['penalty_id']);
    $staff_id = intval($_POST['staff_id']);
    $penalty_type_id = intval($_POST['penalty_type_id']);
    $date = $_POST['date'];
    $price = floatval($_POST['price']);
    $description = trim($_POST['description'] ?? '');

    if ($price < 0) {
        throw new Exception('Price cannot be negative');
    }

    // Check if penalty exists
    $stmt = $pdo->prepare("SELECT id FROM penalties WHERE id = ?");
    $stmt->execute([$penalty_id]);
    if ($stmt->rowCount() === 0) {
        throw new Exception('Penalty not found');
    }

    // Check if staff exists
    $stmt = $pdo->prepare("SELECT id FROM staffs WHERE id = ?");
    $stmt->execute([$staff_id]);
    if ($stmt->rowCount() === 0) {
        throw new Exception('Staff member not found');
    }

    // Check if penalty type exists
    $stmt = $pdo->prepare("SELECT id FROM penalty_types WHERE id = ?");
    $stmt->execute([$penalty_type_id]);
    if ($stmt->rowCount() === 0) {
        throw new Exception('Penalty type not found');
    }

    // Update penalty
    $stmt = $pdo->prepare("UPDATE penalties SET staff_id = ?, penalty_type_id = ?, date = ?, price = ?, description = ? WHERE id = ?");
    $stmt->execute([$staff_id, $penalty_type_id, $date, $price, $description, $penalty_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Penalty updated successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 