<?php
require_once '../settings.php';

header('Content-Type: application/json');

// Validate required fields
$required_fields = ['staff_id', 'type', 'description', 'amount', 'date'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        echo json_encode([
            'success' => false,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
        ]);
        exit;
    }
}

// Sanitize and validate input
$staff_id = filter_var($_POST['staff_id'], FILTER_VALIDATE_INT);
$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
$amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);

// Validate staff_id
if (!$staff_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid staff ID'
    ]);
    exit;
}

// Validate amount
if ($amount === false || $amount < 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid amount'
    ]);
    exit;
}

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid date format'
    ]);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Insert new penalty
    $query = "INSERT INTO penalties (staff_id, type, description, amount, date, status, created_at) 
              VALUES (?, ?, ?, ?, ?, 'pending', CURRENT_TIMESTAMP)";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$staff_id, $type, $description, $amount, $date]);
    
    if ($stmt->rowCount() > 0) {
        $penalty_id = $pdo->lastInsertId();
        $pdo->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Penalty added successfully',
            'penalty_id' => $penalty_id
        ]);
    } else {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add penalty'
        ]);
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error adding penalty: ' . $e->getMessage()
    ]);
} 