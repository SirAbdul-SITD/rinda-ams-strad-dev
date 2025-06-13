<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (empty($_POST['staff_id']) || empty($_POST['type_id']) || empty($_POST['date'])) {
        throw new Exception('Staff, penalty type, and date are required');
    }

    $staff_id = intval($_POST['staff_id']);
    $type_id = intval($_POST['type_id']);
    $date = $_POST['date'];
    $description = trim($_POST['description'] ?? '');

    // Check if staff exists
    $stmt = $pdo->prepare("SELECT id FROM staffs WHERE id = ?");
    $stmt->execute([$staff_id]);
    if ($stmt->rowCount() === 0) {
        throw new Exception('Staff member not found');
    }

    // Get penalty type and its amount
    $stmt = $pdo->prepare("SELECT id, amount FROM penalty_types WHERE id = ?");
    $stmt->execute([$type_id]);
    if ($stmt->rowCount() === 0) {
        throw new Exception('Penalty type not found');
    }
    $penalty_type = $stmt->fetch(PDO::FETCH_ASSOC);
    $amount = floatval($penalty_type['amount']);

    // Check if penalty_type_id column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM penalties LIKE 'penalty_type_id'");
    if ($stmt->rowCount() === 0) {
        // Column doesn't exist, use type column instead
        $stmt = $pdo->prepare("INSERT INTO penalties (staff_id, type, date, amount, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$staff_id, $type_id, $date, $amount, $description]);
    } else {
        // Get the type name for the type column
        $stmt = $pdo->prepare("SELECT type_name FROM penalty_types WHERE id = ?");
        $stmt->execute([$type_id]);
        $type_name = $stmt->fetch(PDO::FETCH_ASSOC)['type_name'];

        // Column exists, use both penalty_type_id and type
        $stmt = $pdo->prepare("INSERT INTO penalties (staff_id, penalty_type_id, type, date, amount, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$staff_id, $type_id, $type_name, $date, $amount, $description]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Penalty added successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 