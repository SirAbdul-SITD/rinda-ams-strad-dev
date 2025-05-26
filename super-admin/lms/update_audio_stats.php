<?php
require_once('../settings.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['audio_id']) && isset($_POST['action'])) {
    $audio_id = (int)$_POST['audio_id'];
    $date = date('Y-m-d');
    
    try {
        // Check if record exists for today
        $stmt = $pdo->prepare("SELECT id FROM audio_stats WHERE audio_id = ? AND date = ?");
        $stmt->execute([$audio_id, $date]);
        
        if ($stmt->rowCount() > 0) {
            // Update existing record
            $stmt = $pdo->prepare("UPDATE audio_stats SET plays = plays + 1 WHERE audio_id = ? AND date = ?");
            $stmt->execute([$audio_id, $date]);
        } else {
            // Insert new record
            $stmt = $pdo->prepare("INSERT INTO audio_stats (audio_id, date, plays) VALUES (?, ?, 1)");
            $stmt->execute([$audio_id, $date]);
        }
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>