<?php

require('../settings.php');

// Check if class and subject are set in the POST data
if (isset($_POST['category']) && isset($_POST['amount']) && isset($_POST['duration'])) {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];



    try {

            // Add the new subject
            $insertQuery = "INSERT INTO `lunch_fees` (`category`, `amount`, `duration`, `updated_by`) VALUES (:category, :amount, :duration, :note, :updated_by)";
            $insertQ = $pdo->prepare($insertQuery);
            $insertQ->bindParam(':category', $category, PDO::PARAM_INT);
            $insertQ->bindParam(':amount', $amount, PDO::PARAM_INT);
            $insertQ->bindParam(':duration', $duration, PDO::PARAM_STR);
            $insertQ->bindParam(':updated_by', $user_id, PDO::PARAM_INT);
            $insertQ->execute();

            if ($insertQ) {
                $response = ['success' => true, 'message' => 'New Expense Added Successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Operation Not Completed'];
            }
        
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error Adding New Expense: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Please enter a valid category, amount and duration!'];
}

echo json_encode($response);
