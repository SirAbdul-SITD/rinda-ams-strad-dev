<?php
require '../settings.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$payroll_id = $_POST['id'] ?? '';

if (empty($payroll_id)) {
    echo json_encode(['success' => false, 'message' => 'Payroll ID is required']);
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Get payroll details
    $query = "SELECT * FROM payroll WHERE id = ? AND status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$payroll_id]);
    $payroll = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$payroll) {
        throw new Exception('Payroll record not found or already processed');
    }
    
    // Update payroll status
    $update_query = "UPDATE payroll SET 
                    status = 'paid',
                    payment_processed_at = NOW()
                    WHERE id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$payroll_id]);
    
    // Insert payment record
    $payment_query = "INSERT INTO payments (
        payroll_id,
        amount,
        payment_date,
        payment_method,
        status,
        created_at
    ) VALUES (?, ?, NOW(), 'bank_transfer', 'completed', NOW())";
    
    $payment_stmt = $pdo->prepare($payment_query);
    $payment_stmt->execute([
        $payroll_id,
        $payroll['net_salary']
    ]);
    
    // Commit transaction
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Payment processed successfully'
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error processing payment: ' . $e->getMessage()
    ]);
} 