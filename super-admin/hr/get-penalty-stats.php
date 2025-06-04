<?php
require_once '../settings.php';

header('Content-Type: application/json');

try {
    // Get counts for different penalty statuses
    $query = "SELECT 
        COUNT(CASE WHEN status = 'active' THEN 1 END) as active_count,
        COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
        COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_count,
        COALESCE(SUM(CASE WHEN status = 'active' THEN amount ELSE 0 END), 0) as total_amount
        FROM penalties";
    
    $stmt = $pdo->query($query);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => [
            'active_count' => (int)$stats['active_count'],
            'pending_count' => (int)$stats['pending_count'],
            'resolved_count' => (int)$stats['resolved_count'],
            'total_amount' => (float)$stats['total_amount']
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching penalty statistics: ' . $e->getMessage()
    ]);
} 