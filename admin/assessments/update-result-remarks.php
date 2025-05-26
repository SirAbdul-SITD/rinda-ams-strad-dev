<?php
// update-result-info.php
header('Content-Type: application/json');

require_once '../settings.php';

function checkEmpty($input)
{
    return empty($input) ? "" : $input;
}

$student_id = checkEmpty($_POST['student_id']);
$session = checkEmpty($_POST['session']);
$term = checkEmpty($_POST['term']);
$class_teacher = checkEmpty($_POST['class_teacher']);
$primary_head = checkEmpty($_POST['primary_head']);
$islamiyya_teacher = checkEmpty($_POST['islamiyya_teacher']);
$islamiyya_head = checkEmpty($_POST['islamiyya_head']);
$school_head = checkEmpty($_POST['school_head']);

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
        $query = "UPDATE result_info SET class_teacher = :class_teacher, islamiyya_teacher = :islamiyya_teacher, islamiyya_head = :islamiyya_head, primary_head = :primary_head, school_head = :school_head WHERE session = :session AND term = :term AND student_id = :student_id";
    } else {
        // Insert new record
        $query = "INSERT INTO result_info (student_id, session, term, class_teacher, islamiyya_teacher, islamiyya_head, primary_head, school_head) VALUES (:student_id, :session, :term, :class_teacher, :islamiyya_teacher, :islamiyya_head, :primary_head, :school_head)";
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':session', $session);
    $stmt->bindParam(':term', $term);
    $stmt->bindParam(':class_teacher', $class_teacher);
    $stmt->bindParam(':islamiyya_teacher', $islamiyya_teacher);
    $stmt->bindParam(':islamiyya_head', $islamiyya_head);
    $stmt->bindParam(':primary_head', $primary_head);
    $stmt->bindParam(':school_head', $school_head);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Record saved successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
