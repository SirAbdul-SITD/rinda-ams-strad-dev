<?php
require_once '../settings.php'; // Include your settings file with database connection

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $student_id = $_POST['student_id'];
    $assessment_id = $_POST['assessment_id'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $marks = $_POST['marks'];
    $session = $_POST['session'];
    $term = $_POST['term'];

    // Check if assessment type exists
    $query_check_assessment_type = "SELECT * FROM assessment_types WHERE assessment_id = :assessment_id";
    $stmt_check_assessment_type = $pdo->prepare($query_check_assessment_type);
    $stmt_check_assessment_type->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);
    $stmt_check_assessment_type->execute();
    $assessment_type = $stmt_check_assessment_type->fetch(PDO::FETCH_ASSOC);

    if ($assessment_type) {
        // Check if marks already exist for this student and assessment type
        $query_check_marks = "SELECT * FROM assessment_marks WHERE student_id = :student_id AND assessment_id = :assessment_id AND session = :session AND term = :term AND subject_id = :subject_id AND class_id = :class_id";
        $stmt_check_marks = $pdo->prepare($query_check_marks);
        $stmt_check_marks->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt_check_marks->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt_check_marks->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt_check_marks->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);
        $stmt_check_marks->bindParam(':session', $session);
        $stmt_check_marks->bindParam(':term', $term, PDO::PARAM_INT);
        $stmt_check_marks->execute();
        $existing_marks = $stmt_check_marks->fetch(PDO::FETCH_ASSOC);

        if ($existing_marks) {
            // Update existing marks
            $query_update_marks = "UPDATE assessment_marks SET mark = :marks WHERE student_id = :student_id AND assessment_id = :assessment_id AND session = :session AND term = :term AND subject_id = :subject_id AND class_id = :class_id";
            $stmt_update_marks = $pdo->prepare($query_update_marks);
            $stmt_update_marks->bindParam(':marks', $marks, PDO::PARAM_INT);
            $stmt_update_marks->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt_update_marks->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);
            $stmt_update_marks->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            $stmt_update_marks->bindParam(':class_id', $class_id, PDO::PARAM_INT);
            $stmt_update_marks->bindParam(':session', $session);
            $stmt_update_marks->bindParam(':term', $term, PDO::PARAM_INT);
            $stmt_update_marks->execute();
            $response['success'] = true;
            $response['message'] = 'Marks updated successfully.';
        } else {
            // Insert new marks
            $query_insert_marks = "INSERT INTO assessment_marks (student_id, subject_id, class_id, session, term, assessment_id, mark) VALUES (:student_id, :subject_id, :class_id, :session, :term, :assessment_id, :marks)";
            $stmt_insert_marks = $pdo->prepare($query_insert_marks);
            $stmt_insert_marks->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt_insert_marks->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);
            $stmt_insert_marks->bindParam(':marks', $marks, PDO::PARAM_INT);
            $stmt_insert_marks->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            $stmt_insert_marks->bindParam(':class_id', $class_id, PDO::PARAM_INT);
            $stmt_insert_marks->bindParam(':session', $session);
            $stmt_insert_marks->bindParam(':term', $term, PDO::PARAM_INT);
            $stmt_insert_marks->execute();
            $response['success'] = true;
            $response['message'] = 'Marks saved successfully.';
        }
    } else {
        $response['message'] = 'Assessment Type not found.';
        $response['success'] = false;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
