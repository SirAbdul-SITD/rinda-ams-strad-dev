<?php
require_once '../settings.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception('Invalid penalty ID');
    }

    $penalty_id = intval($_POST['id']);

    // Start transaction
    $pdo->beginTransaction();

    // First check if the penalty exists and is pending
    $check_query = "SELECT id, status FROM penalties WHERE id = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$penalty_id]);
    $penalty = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penalty) {
        throw new Exception('Penalty not found');
    }

    if ($penalty['status'] !== 'pending') {
        throw new Exception('Only pending penalties can be resolved');
    }

    // Update the penalty status to resolved
    $update_query = "UPDATE penalties SET status = 'resolved' WHERE id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $result = $update_stmt->execute([$penalty_id]);

    if (!$result) {
        throw new Exception('Failed to resolve penalty');
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Penalty resolved successfully'
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