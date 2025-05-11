<?php
require_once '../settings.php';

header('Content-Type: application/json');

try {
    $query = "SELECT *, 
              DATE_FORMAT(start_date, '%Y-%m-%d') as start_date,
              TIME_FORMAT(start_time, '%H:%i:%s') as start_time,
              TIME_FORMAT(end_time, '%H:%i:%s') as end_time
              FROM academic_calendar 
              ORDER BY start_date, start_time";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($events);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>