<?php
require_once '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['staff_id']) || !isset($_POST['fingerprint_id'])) {
        throw new Exception('Missing required fields');
    }

    $staff_id = filter_var($_POST['staff_id'], FILTER_VALIDATE_INT);
    $fingerprint_id = trim($_POST['fingerprint_id']);

    if (!$staff_id || empty($fingerprint_id)) {
        throw new Exception('Invalid input data');
    }

    // Check if staff exists
    $stmt = $pdo->prepare("SELECT id FROM staffs WHERE id = ?");
    $stmt->execute([$staff_id]);
    if (!$stmt->fetch()) {
        throw new Exception('Staff member not found');
    }

    // Check if fingerprint ID is already registered
    $stmt = $pdo->prepare("SELECT id FROM staff_fingerprints WHERE fingerprint_id = ?");
    $stmt->execute([$fingerprint_id]);
    if ($stmt->fetch()) {
        throw new Exception('This fingerprint ID is already registered');
    }

    // Insert new fingerprint record
    $stmt = $pdo->prepare("
        INSERT INTO staff_fingerprints (staff_id, fingerprint_id)
        VALUES (?, ?)
    ");
    $stmt->execute([$staff_id, $fingerprint_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Fingerprint registered successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 