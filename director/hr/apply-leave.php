<?php

require('../settings.php');

$user = 1;

// Check if designation name and department ID are set in the POST data
try {
    if (!isset($_POST['type']) || !isset($_POST['exp']) || !isset($_POST['begin']) || empty($_POST['type']) || empty($_POST['exp']) || empty($_POST['begin'])) {
        throw new Exception('Please Fill The Request Form Properly');
    }

    $type = $_POST['type'];
    $explanatory_note = $_POST['exp'];
    $start = $_POST['begin'];

    $begin =  date($start);

    // Add the new designation
    $insertQuery = "INSERT INTO `leave_applications` (`staff_id`, `category_id`, `start_date`, `explanatory_note`) VALUES (:user, :type, :begin, :note)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':type', $type, PDO::PARAM_STR);
    $insertStmt->bindParam(':begin', $begin, PDO::PARAM_STR);
    $insertStmt->bindParam(':note', $explanatory_note, PDO::PARAM_STR);
    $insertStmt->bindParam(':user', $user, PDO::PARAM_INT);
    $insertStmt->execute();

    // Success message
    $response = ['success' => true, 'message' => 'New Leave Request Submitted Successfully.'];
} catch (Exception $e) {
    // Error message
    $response = ['success' => false, 'message' => $e->getMessage()];
}

// Output the JSON response
echo json_encode($response);
?>
