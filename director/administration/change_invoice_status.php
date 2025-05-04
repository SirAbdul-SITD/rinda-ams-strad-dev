<?php

require('../settings.php');



if (isset($_POST['ref']) && isset($_POST['status'])) {
    $parent_id = $_POST['parent_id'] ?? NULL;
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
        $updateQuery = "UPDATE `fees_invoices` 
                SET `status` = :status, 
                    `amount` = :amount, 
                    `paid_amount` = :paid_amount, 
                    `updated_by` = :updated_by 
                WHERE `invoice_ref` = :ref";

        $updateQ = $pdo->prepare($updateQuery);
        $updateQ->bindParam(':ref', $ref, PDO::PARAM_STR);
        $updateQ->bindParam(':status', $status, PDO::PARAM_STR);
        $updateQ->bindParam(':amount', $amount);
        $updateQ->bindParam(':paid_amount', $paid_amount);
        $updateQ->bindParam(':updated_by', $user_id, PDO::PARAM_INT);
        $updateQ->execute();


        if ($updateQ) {

            if (!empty($parent_id)) {


                // SQL query to fetch student data based on admission number
                $sql = "SELECT email FROM parents WHERE p.id = :parent_id AND status = 1";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':parent_id', $parent_id);
                $stmt->execute();
                $parent = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($parent['email'])) {
                    $email = $parent['email'];
                    $comment = '';
                    if ($status == 'Unpaid') {
                        $comment = "We appreciate your trust in Grithall Academy. Your invoice (Ref: $invoice_ref) is currently unpaid. Please ensure that the payment is made in due time to avoid payment default.";
                    } elseif ($status == 'Part Payment') {
                        $comment = "Thank you for making a partial payment towards your invoice (Ref: $invoice_ref). To complete the payment, please remit the remaining balance of ₦ $balance to Grithall Academy Ltd, Account Number: 0003166996 at Jaiz Bank.";
                    } elseif ($status == 'Paid') {
                        $comment = "We have received the full payment for your invoice (Ref: $invoice_ref). Your invoice has been cleared and status updated to paid.";
                    } elseif ($status == 'Additional Payment Required') {
                        $comment = "Thank you for your payment. However, an additional amount is required to fully cover the invoice (Ref: $invoice_ref). Please make the payment of ₦ $additional_payment_amount to Grithall Academy Ltd, Account Number: 0003166996 at Jaiz Bank as soon as possible.";
                    }


                    $subject = "Student Application Update";

                    $message = "<!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8' />
                                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                                <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f4f4f4;
                                    color: #333;
                                }
                                .container {
                                    background-color: #ffffff;
                                    padding: 20px;
                                    margin: 20px auto;
                                    border-radius: 8px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                    max-width: 600px;
                                }
                                .header {
                                    text-align: center;
                                    padding-bottom: 20px;
                                    border-bottom: 1px solid #dddddd;
                                }
                                .content {
                                    margin-top: 20px;
                                }
                                .content p {
                                    line-height: 1.6;
                                }
                                .footer {
                                    margin-top: 30px;
                                    padding-top: 20px;
                                    border-top: 1px solid #dddddd;
                                    text-align: center;
                                    font-size: 0.9em;
                                    color: #666666;
                                }
                                </style>
                            </head>
                            <body>
                            <div class='container'>
                                <div class='header'>
                                    <h2>Invoice Status: $status</h2>
                                </div>
                                <div class='content'>
                                    <p id='status-text'>
                                    $comment
                                    </p>
                                    

                                    <p>
                                    You can follow <a href='https://parent.grithallacademy.com.ng/dashboard/invoices.php'>this link</a> and login to your dashbord and view all invoices
                                    </p>
                                </div>
                                <div class='footer'>
                                    <p>Thank you,</p>
                                    <p>The GHA Rinda AMS Team</p>
                                    <p>This is an automated message. Please do not reply to this email.</p>
                                </div>
                                </div>
                            </body>
                            </html>
                            ";

                    // Additional headers
                    $headers .= 'From: Grithall Academy <noreply@grithallacademy.com.ng>' . "\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
;
                    // Send email
                    mail($email, $subject, $message, $headers);
                }
            }

            $response = ['success' => true, 'message' => 'Invoice Status Updated to ' . $status . ' Successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update invoice status'];
        }
    }
}

echo json_encode($response);
