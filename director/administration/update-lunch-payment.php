

<?php

require('../settings.php');

$response = ['success' => false, 'message' => 'Invalid request'];

if (isset($_POST['student-id']) && isset($_POST['lunch-id']) && isset($_POST['status'])) {
    $student_id = $_POST['student-id'];
    $fee_id = $_POST['lunch-id'];
    $status = $_POST['status'];

    // Check if the subscription ID exists
    $query = "SELECT m.status, m.parent_id, m.lunch_id, f.id FROM lunch_members m INNER JOIN lunch_fees f ON f.id = m.lunch_id WHERE m.id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $fee_id, PDO::PARAM_INT);
    $stmt->execute();
    $exist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$exist) {
        $response = ['success' => false, 'message' => 'Subscription ID does not exist'];
    } elseif ($exist['status'] === $status) {
        $response = ['success' => false, 'message' => 'Payment status already set to ' . $status];
    } else {
        $parent_id = $exist['parent_id'];

        if ($status == 'Paid') {
            $date = date('Y-m-d');
        } else {
            $date = '0000-00-00';
        }

        // Update the payment status
        $updateQuery = "UPDATE `lunch_members` SET `status` = :status, `payment_date` = :date WHERE `id` = :id";
        $updateQ = $pdo->prepare($updateQuery);
        $updateQ->bindParam(':id', $fee_id, PDO::PARAM_INT);
        $updateQ->bindParam(':status', $status, PDO::PARAM_STR);
        $updateQ->bindParam(':date', $date);

        if ($updateQ->execute()) {
            if (!empty($parent_id)) {
                // Fetch the parent's email
                $sql = "SELECT email FROM parents WHERE id = :parent_id AND status = 1";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':parent_id', $parent_id);
                $stmt->execute();
                $parent = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($parent['email'])) {
                    $email = $parent['email'];
                    $comment = '';
                    if ($status == 'Unpaid') {
                        $comment = "We appreciate your trust in Grithall Academy's student lunch services. An invoice for your child/ward's lunch subscription is currently unpaid. Kindly login to your dashboard to view the status of your subscriptions and ensure to complete payments in due time to avoid payment default.";
                    } else {
                        $comment = "We appreciate your trust in Grithall Academy's student lunch services. We have received payment for your child's lunch subscription. Kindly login to your dashboard to view the status of your subscriptions.";
                    }

                    $subject = "Student Lunch Payment Update";
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
                                box-lunch: 0 0 10px rgba(0, 0, 0, 0.1);
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
                                You can follow <a href='https://parent.grithallacademy.com.ng/dashboard/lunch.php'>this link</a> and login to your dashboard to view all invoices.
                                </p>
                            </div>
                            <div class='footer'>
                                <p>Thank you,</p>
                                <p>The GHA Rinda AMS Team</p>
                                <p>This is an automated message. Please do not reply to this email.</p>
                            </div>
                        </div>
                        </body>
                        </html>";

                    // Set headers for the email
                    $headers = 'From: Grithall Academy <noreply@grithallacademy.com.ng>' . "\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                    // Send the email
                    mail($email, $subject, $message, $headers);
                }
            }

            $response = ['success' => true, 'message' => 'Payment Status Updated to ' . $status . ' Successfully'];
        } else {
            $errorInfo = $updateQ->errorInfo();
            $response = ['success' => false, 'message' => 'Failed to update payment status: ' . implode(', ', $errorInfo)];
        }
    }
    echo json_encode($response);
}
