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

    // Delete the penalty
    $query = "DELETE FROM penalties WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$penalty_id]);

    if (!$result) {
        throw new Exception('Failed to delete penalty');
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Penalty deleted successfully'
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