<?php

require('../settings.php');

// Check if class and subject are set in the POST data
if (isset($_POST['description']) && isset($_POST['amount']) && isset($_POST['date'])) {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'] ?? null;



    try {

            // Add the new subject
            $insertQuery = "INSERT INTO `expenses` (`description`, `amount`, `date`, `note`, `updated_by`) VALUES (:description, :amount, :date, :note, :updated_by)";
            $insertQ = $pdo->prepare($insertQuery);
            $insertQ->bindParam(':description', $description, PDO::PARAM_STR);
            $insertQ->bindParam(':amount', $amount, PDO::PARAM_INT);
            $insertQ->bindParam(':date', $date, PDO::PARAM_STR);
            $insertQ->bindParam(':note', $note, PDO::PARAM_STR);
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
    $response = ['success' => false, 'message' => 'Please enter a valid description, amount and date!'];
}

echo json_encode($response);
