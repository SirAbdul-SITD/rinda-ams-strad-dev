<?php

require('../settings.php');

$user = 1; 

if (isset($_POST['teacher']) && isset($_POST['subject'])) {

    $teacher = $_POST['teacher'];
    $subject = $_POST['subject'];

    $updateQuery = "UPDATE `subjects` SET `assigned` = :teacher_id, `modified_by` = :user WHERE `id` = :subject_id";
    
        $updateQ = $pdo->prepare($updateQuery);
        $updateQ->bindParam(':subject_id', $subject, PDO::PARAM_INT);
        $updateQ->bindParam(':teacher_id', $teacher, PDO::PARAM_INT);
        $updateQ->bindParam(':user', $user, PDO::PARAM_INT);
        $updateQ->execute();

    $response = ['success' => true, 'message' => 'Subject Assigned Successfully.'];

} else {
    $response = ['success' => false, 'message' => 'Subject Assigned not Successful.'];
}

// Output the JSON response
echo json_encode($response);

?>
