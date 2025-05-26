<?php
// update-result-info.php
header('Content-Type: application/json');

require_once '../settings.php';

function checkEmpty($input)
{
    return empty($input) ? "" : $input;
}

$student_id = checkEmpty($_POST['student_id']);
$daysPresent = checkEmpty($_POST['daysPresent']);
$startHeight = checkEmpty($_POST['startHeight']);
$startWeight = checkEmpty($_POST['startWeight']);
$officeHeld = checkEmpty($_POST['officeHeld']);
$award = checkEmpty($_POST['award']);
$endHeight = checkEmpty($_POST['endHeight']);
$endWeight = checkEmpty($_POST['endWeight']);
$contributions = checkEmpty($_POST['contributions']);
$session = checkEmpty($_POST['session']);
$term = checkEmpty($_POST['term']);

try {
    // Check if entry exists
    $query = "SELECT COUNT(*) FROM result_info WHERE session = :session AND term = :term AND student_id = :student_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':session', $session);
    $stmt->bindParam(':term', $term);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Update existing record
        $query = "UPDATE result_info SET days_present = :daysPresent, start_height = :startHeight, start_weight = :startWeight, office_held = :officeHeld, award = :award, end_height = :endHeight, end_weight = :endWeight, contributions = :contributions WHERE session = :session AND term = :term AND student_id = :student_id";
    } else {
        // Insert new record
        $query = "INSERT INTO result_info (student_id, days_present, start_height, start_weight, office_held, award, end_height, end_weight, contributions, session, term) VALUES (:student_id, :daysPresent, :startHeight, :startWeight, :officeHeld, :award, :endHeight, :endWeight, :contributions, :session, :term)";
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':daysPresent', $daysPresent);
    $stmt->bindParam(':startHeight', $startHeight);
    $stmt->bindParam(':startWeight', $startWeight);
    $stmt->bindParam(':officeHeld', $officeHeld);
    $stmt->bindParam(':award', $award);
    $stmt->bindParam(':endHeight', $endHeight);
    $stmt->bindParam(':endWeight', $endWeight);
    $stmt->bindParam(':contributions', $contributions);
    $stmt->bindParam(':session', $session);
    $stmt->bindParam(':term', $term);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Record saved successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
