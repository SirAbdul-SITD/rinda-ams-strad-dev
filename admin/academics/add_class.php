<?php

require('../settings.php');

$user = 1;

// Check if class name and section are set in the POST data
if (isset($_POST['class']) && isset($_POST['section_id'])) {
    $class = $_POST['class'];
    $section_id = $_POST['section_id'];

    // Check if the class with the same name and section already exists
    $query = "SELECT c.*, s.section, s.id FROM classes c INNER JOIN sections s ON c.section_id = s.id WHERE c.class = :class AND s.section = :section_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':section_id', $section_id, PDO::PARAM_INT);
    $stmt->execute();
    $existingClass = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingClass) {
        // Class with the same name and section already exists
        $response = ['success' => false, 'message' => 'Class with the same already exist in this section.'];
    } else {
        // Add the new class
        $insertQuery = "INSERT INTO `classes` (`class`, `section_id`, `modified_by`) VALUES (:class, :section_id, :user)";
        $insertQ = $pdo->prepare($insertQuery);
        $insertQ->bindParam(':class', $class, PDO::PARAM_STR);
        $insertQ->bindParam(':section_id', $section_id, PDO::PARAM_INT);
        $insertQ->bindParam(':user', $user, PDO::PARAM_INT);
        $insertQ->execute();

        // Success message
        $response = ['success' => true, 'message' => 'New Class Added Successfully.'];
    }
} else {
    // Invalid request: Class name or section is not provided
    $response = ['success' => false, 'message' => 'Please enter a valid name and select section!'];
}

// Output the JSON response
echo json_encode($response);
?>
