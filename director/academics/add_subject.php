<?php

require('../settings.php');

$user = 1;

// Check if class and subject are set in the POST data
if (isset($_POST['class']) && isset($_POST['subject'])) {
    $class = $_POST['class'];
    $subject = $_POST['subject'];

    // Check if the subject with the same name already exists for the selected class
    $query = "SELECT * FROM subjects WHERE class_id = :class AND subject = :subject";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->execute();
    $existingSubject = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingSubject) {
        // Subject with the same name already exists for the selected class
        $response = ['success' => false, 'message' => 'Subject with the same name already exists for the selected class.'];
    } else {
        // Add the new subject
        $insertQuery = "INSERT INTO `subjects` (`class_id`, `subject`, `modified_by`) VALUES (:class, :subject, :user)";
        $insertQ = $pdo->prepare($insertQuery);
        $insertQ->bindParam(':subject', $subject, PDO::PARAM_STR);
        $insertQ->bindParam(':class', $class, PDO::PARAM_STR);
        $insertQ->bindParam(':user', $user, PDO::PARAM_INT);
        $insertQ->execute();

        // Success message
        $response = ['success' => true, 'message' => 'New Subject Added Successfully.'];
    }
} else {
    // Invalid request: Class or subject is not provided
    $response = ['success' => false, 'message' => 'Please enter a valid name and select subject!'];
}

// Output the JSON response
echo json_encode($response);
?>
