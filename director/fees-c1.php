<?php
require_once 'settings.php';

$query = "SELECT 
            s.id, 
            s.class_id, 
            CONCAT(s.firstName, ' ', s.lastName) AS full_name, 
            f.id AS fee_id, 
            f.type,
            f.first_term, 
            f.second_term, 
            f.third_term, 
            f.annual 
          FROM students s 
          INNER JOIN compulsory_fees f ON s.class_id = f.class_id 
          WHERE s.status = 1 AND s.id = ";
$stmt = $pdo->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as $student) {
    $student_id = $student['id'];
    $student_name = $student['full_name'];
    $class_id = $student['class_id'];
    $fee_id = $student['fee_id'];
    $fee_type = $student['type'];
    $first_term = $student['first_term'];
    $second_term = $student['second_term'];
    $third_term = $student['third_term'];
    $annual = $student['annual'];

    // $invoice_ref = 'GHA_inv' . time();

    $terms = [$first_term, $second_term, $third_term];
    $validity = 'Per Term';

    foreach ($terms as $index => $term) {
        $amount = $term;

        $payment_term = $index + 1;

        $invoice_ref = 'GHA_inv' . time();
        
        $insertQuery = "INSERT INTO fees_invoices (fee_id, invoice_ref, student_id, class_id, type, amount, validity, session, term) 
            VALUES (:fee_id, :invoice_ref, :student_id, :class_id, :type, :amount, :validity, :session, :term)";
        $insertQ = $pdo->prepare($insertQuery);
        $insertQ->bindParam(':fee_id', $fee_id, PDO::PARAM_INT);
        $insertQ->bindParam(':invoice_ref', $invoice_ref, PDO::PARAM_STR);
        $insertQ->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $insertQ->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $insertQ->bindParam(':type', $fee_type, PDO::PARAM_STR);
        $insertQ->bindParam(':amount', $amount);
        $insertQ->bindParam(':validity', $validity, PDO::PARAM_STR);
        $insertQ->bindParam(':session', $curr_session, PDO::PARAM_STR);
        $insertQ->bindParam(':term', $payment_term, PDO::PARAM_INT);
        $insertQ->execute();
    
    }

    if ($insertQ) {
        echo 'Added for ' . $student_name ;
    }
}



?>
