<?php

require('../settings.php');


$user = 1;


if (isset($_POST['section'])) {
    $section = $_POST['section'];


       // Add section
       $insertQuery = "INSERT INTO `sections` (`section`, `added_by`) VALUES (:section, :user)";
       $insertQ = $pdo->prepare($insertQuery);
       $insertQ->bindParam(':section', $section, PDO::PARAM_STR);
       $insertQ->bindParam(':user', $user, PDO::PARAM_INT);
       $insertQ->execute();

    $response = ['success' => true, 'message' => 'New Section Added Successfully.'];
// $response = ['success' => false, 'message' => 'Failed to update student data. Fatal Error'];
    // Output the JSON response
    echo json_encode($response);
}
?>
