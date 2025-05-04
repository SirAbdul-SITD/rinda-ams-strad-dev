<?php

require('../settings.php');

$user = 1; 

if (isset($_POST['teacher']) && isset($_POST['class']) && isset($_POST['position'])) {

    $teacher = $_POST['teacher'];
    $class = $_POST['class'];
    $pos = $_POST['position'];

    $updateQuery = "UPDATE assigned_classes SET teacher_id = :teacher_id, modified_by = :user WHERE class_id = :class_id AND pos = :pos";
    

    $updateQ = $pdo->prepare($updateQuery);
    $updateQ->bindParam(':class_id', $class, PDO::PARAM_INT);
    $updateQ->bindParam(':teacher_id', $teacher, PDO::PARAM_INT);
    $updateQ->bindParam(':pos', $pos, PDO::PARAM_INT);
    $updateQ->bindParam(':user', $user, PDO::PARAM_INT);
    $updateQ->execute();

    $response = ['success' => true, 'message' => 'Class Assigned Successfully.'];

} else {
    $response = ['success' => false, 'message' => 'Class Assigned not Successful.'];
}

// Output the JSON response
echo json_encode($response);

?>
