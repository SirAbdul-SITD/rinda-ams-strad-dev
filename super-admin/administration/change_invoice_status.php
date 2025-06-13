<?php

require('../settings.php');




if (isset($_POST['ref']) && isset($_POST['status'])) {
    $student_id = $_POST['student_id'];
    $ref = $_POST['ref'];
    $status = $_POST['status'];



    $query = "SELECT * FROM fees_invoices WHERE `invoice_ref` = :ref";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ref', $ref, PDO::PARAM_STR);
    $stmt->execute();
    $exist = $stmt->fetch(PDO::FETCH_ASSOC);

    $amount = $exist['amount'];
    $paid_amount = empty($_POST['paid_amount']) ? $exist['paid_amount'] : $_POST['paid_amount'];
    $additional_payment_amount = $_POST['additional_payment_amount'];

    if (count($exist) < 1) {
        $response = ['success' => false, 'message' => 'Invoice reference number does not exist'];
    } elseif (($status == 'Paid (Discounted)' || $status == 'Part Payment') && $_POST['paid_amount'] === NULL) {
        $response = ['success' => false, 'message' => 'You must specify the paid amount'];
    } elseif ($status == 'Additional Payment Required' && empty($_POST['additional_payment_amount'])) {
        $response = ['success' => false, 'message' => 'You must specify the additional payment amount'];
    } else {

        if ($status == 'Additional Payment Required') {
            $amount += $additional_payment_amount;
        } elseif ($status == 'Paid') {
            $paid_amount = $amount;
        }

        $balance = $amount - $paid_amount;

        // Update invoice status and related fields 
        if ($status == 'Unpaid') {
            $paid_amount = 0;
            $updateQuery = "UPDATE `fees_invoices` 
                SET `status` = :status, 
                    `amount` = :amount, 
                    `paid_amount` = :paid_amount, 
                    `updated_by` = :updated_by 
                WHERE `invoice_ref` = :ref";
        } else {
            $updateQuery = "UPDATE `fees_invoices` 
                SET `status` = :status, 
                    `amount` = :amount, 
                    `paid_amount` = :paid_amount, 
                    `updated_by` = :updated_by 
                WHERE `invoice_ref` = :ref";

        }

        $updateQ = $pdo->prepare($updateQuery);
        $updateQ->bindParam(':ref', $ref, PDO::PARAM_STR);
        $updateQ->bindParam(':status', $status, PDO::PARAM_STR);
        $updateQ->bindParam(':amount', $amount);
        $updateQ->bindParam(':paid_amount', $paid_amount);
        $updateQ->bindParam(':updated_by', $user_id, PDO::PARAM_INT);
        $updateQ->execute();


        if ($updateQ) {

            if (!empty($student_id)) {
                // SQL query to get parent emails linked to the student
                $sql = "SELECT p.email 
                FROM parent_student ps 
                INNER JOIN parents p ON p.id = ps.parent_id 
                WHERE ps.student_id = :student_id AND p.status = 1";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':student_id', $student_id);
                $stmt->execute();
                $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($parents as $parent) {
                    if (!empty($parent['email'])) {
                        $email = $parent['email'];
                        $comment = '';

                        // Email content based on status
                        if ($status == 'Unpaid') {
                            $comment = "We appreciate your trust in Grithall Academy. Your invoice (Ref: $invoice_ref) is currently unpaid. Please ensure that the payment is made in due time to avoid payment default.";
                        } elseif ($status == 'Part Payment') {
                            $comment = "Thank you for making a partial payment towards your invoice (Ref: $invoice_ref). To complete the payment, please remit the remaining balance of ₦$balance to Grithall Academy Ltd, Account Number: 0003166996 at Jaiz Bank.";
                        } elseif ($status == 'Paid') {
                            $comment = "We have received the full payment for your invoice (Ref: $invoice_ref). Your invoice has been cleared and status updated to paid.";
                        } elseif ($status == 'Additional Payment Required') {
                            $comment = "Thank you for your payment. However, an additional amount is required to fully cover the invoice (Ref: $invoice_ref). Please make the payment of ₦$additional_payment_amount to Grithall Academy Ltd, Account Number: 0003166996 at Jaiz Bank as soon as possible.";
                        }

                        $subject = "Student Invoice Status: $status";

                        $message = "<!DOCTYPE html>
                        <html lang='en'>
                        <head><meta charset='UTF-8'><style>/* (style omitted for brevity) */</style></head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <h2>Invoice Status: $status</h2>
                                </div>
                                <div class='content'>
                                    <p>$comment</p>
                                    <p>You can follow <a href='https://parent.strad.africa/dashboard/invoices.php'>this link</a> to log in and view all invoices.</p>
                                </div>
                                <div class='footer'>
                                    <p>Thank you,</p>
                                    <p>The GHA Rinda AMS Team</p>
                                    <p>This is an automated message. Please do not reply to this email.</p>
                                </div>
                            </div>
                        </body>
                        </html>";

                        // Headers
                        $headers = 'From: Grithall Academy <noreply@strad.africa>' . "\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                        // Send email
                        mail($email, $subject, $message, $headers);
                    }
                }
            }

            $response = ['success' => true, 'message' => 'Invoice Status Updated to ' . $status . ' Successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update invoice status'];
        }
    }
}

echo json_encode($response);
