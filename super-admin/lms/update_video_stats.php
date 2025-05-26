<?php
require_once('../settings.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) {
    try {
        $stmt = $pdo->prepare("UPDATE lms_videos SET views = views + 1 WHERE id = ?");
        $stmt->execute([$_POST['video_id']]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>