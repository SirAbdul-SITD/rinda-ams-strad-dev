<?php

require('../settings.php');

// Check if class and subject are set in the POST data
if (isset($_POST['type']) && isset($_POST['class'])) {
    $type = $_POST['type'];
    $class = $_POST['class'];
    $first_term = $_POST['first_term'] ?? 0;
    $second_term = $_POST['second_term'] ?? 0;
    $third_term = $_POST['third_term'] ?? 0;



    try {

        if (empty($first_term) && empty($second_term) && empty($third_term)) {
            $response = ['success' => false, 'message' => "All Three Terms Can't Be Null"];
        } else {
             // Add the new subject
        $insertQuery = "INSERT INTO `compulsory_fees` (`type`, `class_id`, `first_term`, `second_term`, `third_term`, `updated_by`) VALUES (:type, :class_id, :first_term, :second_term, :third_term, :updated_by)";
        $insertQ = $pdo->prepare($insertQuery);
        $insertQ->bindParam(':type', $type, PDO::PARAM_STR);
        $insertQ->bindParam(':class_id', $class, PDO::PARAM_INT);
        $insertQ->bindParam(':first_term', $first_term, PDO::PARAM_STR);
        $insertQ->bindParam(':second_term', $second_term, PDO::PARAM_STR);
        $insertQ->bindParam(':third_term', $third_term, PDO::PARAM_STR);
        $insertQ->bindParam(':updated_by', $user_id, PDO::PARAM_INT);
        $insertQ->execute();

        if ($insertQ) {
            $response = ['success' => true, 'message' => 'New Fee Added Successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Operation Not Completed'];
        }
        }
       
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error Adding New Fee: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Please enter a valid fee type and select class!'];
}

echo json_encode($response);
?>