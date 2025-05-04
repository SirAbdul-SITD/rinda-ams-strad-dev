<?php
require '../settings.php';

try {
    if (isset($_POST['class']) || isset($_POST['days']) || isset($_POST['id'])) {


        $term_id = $term;
        $id = $_POST['id'];
        $days = $_POST['days'];
        $class_id = $_POST['class'];

        


        // Fetch the applicable fee types based on the $days variable
        $fee_type_condition = ($days === 'Weekdays & Weekends') ? 'School Fees (Weekdays & Weekends)' : 'School Fees (Weekends)';

        // Adjust query to select fees based on the 'days' condition and include all other fee types
        $query = "SELECT 
                CONCAT(s.firstName, ' ', s.lastName) AS full_name, 
                s.id AS student_id, 
                i.id AS fee_id, 
                i.type,
                s.2ndClass_id,
                CASE
                    WHEN i.first_term = 0 AND i.second_term = 0 AND i.third_term = 0 THEN i.annual
                    ELSE i.first_term
                END AS first_term,
                CASE
                    WHEN i.first_term = 0 AND i.second_term = 0 AND i.third_term = 0 THEN i.annual
                    ELSE i.second_term
                END AS second_term,
                CASE
                    WHEN i.first_term = 0 AND i.second_term = 0 AND i.third_term = 0 THEN i.annual
                    ELSE i.third_term
                END AS third_term,
                i.annual 
              FROM students s 
              INNER JOIN islamiyyah_fees i ON i.class_id = :class_id 
              WHERE s.status = 1 AND s.id = :id 
              AND (i.type = :fee_type OR i.type NOT LIKE 'School Fees%')";

        $stmt = $pdo->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . implode(", ", $pdo->errorInfo()));
        } 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindParam(':fee_type', $fee_type_condition, PDO::PARAM_STR);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$students) {
            throw new Exception("No students found or invalid class ID.");
        } 
        
        if (!empty($student['2ndClass_id'])) {
            throw new Exception("Student already enrolled into islamiyyah.");
        }

        $student_id = $student['student_id'];

        $updateQuery = "UPDATE `students` SET `2ndClass_id` = :class_id WHERE `id` = :student_id";

        $updateQ = $pdo->prepare($updateQuery);
        $updateQ->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $updateQ->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $updateQ->execute();

        if ($updateQ) {
            throw new Exception("Update failed.");
        }

        $grand_total = 0;
        foreach ($students as $student) {
            $student_id = $student['student_id'];
            $student_name = $student['full_name'];
            $fee_id = $student['fee_id'];
            $fee_type = $student['type'];
            $first_term = $student['first_term'];
            $second_term = $student['second_term'];
            $third_term = $student['third_term'];
            $annual = $student['annual'];

            $invoice_ref = 'GHA_inv' . time();

            $terms = [
                1 => $first_term,
                2 => $second_term,
                3 => $third_term
            ];

            $validity = 'Per Term';

            $amounts = 0; // Initialize amounts

            // Determine which terms to process based on $term_id
            for ($i = $term_id; $i <= 3; $i++) {
                if ($term_id <= $i) {
                    $amount = $terms[$i];
                    $amounts += $amount;

                    if ($amount != 0) {
                         $insertQuery = "INSERT INTO fees_invoices (invoice_ref, student_id, class_id, type, amount, validity, session, term) 
                    VALUES (:invoice_ref, :student_id, :class_id, :type, :amount, :validity, :session, :term)";
                    $insertQ = $pdo->prepare($insertQuery);
                    if (!$insertQ) {
                        throw new Exception("Failed to prepare insert statement: " . implode(", ", $pdo->errorInfo()));
                    }
                    $insertQ->bindParam(':invoice_ref', $invoice_ref, PDO::PARAM_STR);
                    $insertQ->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                    $insertQ->bindParam(':class_id', $class_id, PDO::PARAM_INT); // Use the original class_id
                    $insertQ->bindParam(':type', $fee_type, PDO::PARAM_STR);
                    $insertQ->bindParam(':amount', $amount, PDO::PARAM_INT);
                    $insertQ->bindParam(':validity', $validity, PDO::PARAM_STR);
                    $insertQ->bindParam(':session', $curr_session, PDO::PARAM_STR);
                    $insertQ->bindParam(':term', $i, PDO::PARAM_INT);
                    $insertQ->execute();
                    }

                   
                }
            }
            $grand_total += $amounts;
        }


        echo json_encode(['success' => true, 'message' => 'Student successfuly enrolled in Islamiyyah class', 'amount' => $grand_total]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Request']);
    }
} catch (Exception $e) {
    // Rollback the transaction on error
    $pdo->rollBack();

    // Set error message
    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
}






































        // $query = "SELECT status FROM islamiyyah_members WHERE days_id = :days_id AND student_id = :student_id AND session = :session AND term = :term";
        // $stmt = $pdo->prepare($query);
        // $stmt->bindParam(':days_id', $dayss['id'], PDO::PARAM_INT);
        // $stmt->bindParam(':student_id', $id, PDO::PARAM_INT);
        // $stmt->bindParam(':session', $session, PDO::PARAM_STR);
        // $stmt->bindParam(':term', $term, PDO::PARAM_INT);
        // $stmt->execute();
        // $dayss_available = $stmt->fetchAll(PDO::FETCH_ASSOC);



        // if (count($dayss_available) > 0) {
        //     echo json_encode(['success' => false, 'message' => 'A subscription like this already exist']);
        //     exit();
        // }




        // $query = "SELECT id, CONCAT(firstName, ' ', lastName) AS  full_name FROM students WHERE id = :id";
        // $stmt = $pdo->prepare($query);
        // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        // $stmt->execute();
        // $student = $stmt->fetch(PDO::FETCH_ASSOC);
