<?php

require('../settings.php');


$user = 1;


if (isset($_POST['teacher']) && isset($_POST['class']) && isset($_POST['position'])) {

    $teacher = $_POST['teacher'];
    $class = $_POST['class'];
    $pos = $_POST['position'];

    $query = "SELECT * FROM assigned_classes WHERE `class_id` = :class AND `pos` = :pos";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':class', $class, PDO::PARAM_INT);
    $stmt->bindParam(':pos', $pos, PDO::PARAM_INT);
    $stmt->execute();
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($classes) > 0) {
        $response = ['success' => false, 'message' => 'false'];
    } else {
        
    // Add class
    $insertQuery = "INSERT INTO `assigned_classes` (`class_id`, `teacher_id`, `pos`, `modified_by`) VALUES (:class_id, :teacher_id, :pos, :user)";
    $insertQ = $pdo->prepare($insertQuery);
    $insertQ->bindParam(':class_id', $class, PDO::PARAM_INT);
    $insertQ->bindParam(':teacher_id', $teacher, PDO::PARAM_INT);
    $insertQ->bindParam(':pos', $pos, PDO::PARAM_INT);
    $insertQ->bindParam(':user', $user, PDO::PARAM_INT);
    $insertQ->execute();

    $response = ['success' => true, 'message' => 'Class Assigned Successfully.'];
   
    }
    

    // $response = ['success' => true, 'message' => 'New Section Added Successfully.'];
    // $response = ['success' => false, 'message' => 'Failed to update student data. Fatal Error'];
    // Output the JSON response
   
}

 echo json_encode($response);
?>