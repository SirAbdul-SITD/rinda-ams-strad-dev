<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate required fields
    $required_fields = ['id', 'staff_id', 'type', 'description', 'amount', 'date', 'status'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Sanitize and validate input
    $penalty_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $staff_id = filter_var($_POST['staff_id'], FILTER_VALIDATE_INT);
    $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

    if (!$penalty_id || !$staff_id || !$amount) {
        throw new Exception('Invalid input data');
    }

    // Begin transaction
    $pdo->beginTransaction();

    // Update penalty
    $query = "UPDATE penalties SET 
              staff_id = ?, 
              type = ?, 
              description = ?, 
              amount = ?, 
              date = ?, 
              status = ?,
              updated_at = NOW()
              WHERE id = ?";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $staff_id,
        $type,
        $description,
        $amount,
        $date,
        $status,
        $penalty_id
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Penalty updated successfully'
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 