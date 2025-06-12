<?php
require_once '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['id'])) {
        throw new Exception('Missing fingerprint ID');
    }

    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        throw new Exception('Invalid fingerprint ID');
    }

    // Delete the fingerprint record
    $stmt = $pdo->prepare("DELETE FROM staff_fingerprints WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 0) {
        throw new Exception('Fingerprint record not found');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Fingerprint deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 