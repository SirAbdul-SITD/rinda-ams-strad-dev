<?php
require('../settings.php');

if (isset($_POST['ref']) && isset($_POST['status'])) {

    $ref = $_POST['ref'];
    $status = $_POST['status'];

    try {
        $query = "SELECT * FROM applications WHERE `ref` = :ref";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':ref', $ref, PDO::PARAM_STR);
        $stmt->execute();
        $exist = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $exist['email'];



        if (!$exist) {
            $response = ['success' => false, 'message' => 'Application reference number does not exist'];
        } else {
            // Add class
            $insertQuery = "UPDATE `applications` SET `status` = :status, `modified_by` = :modified_by WHERE `ref` = :ref";
            $insertQ = $pdo->prepare($insertQuery);
            $insertQ->bindParam(':ref', $ref, PDO::PARAM_STR);
            $insertQ->bindParam(':status', $status, PDO::PARAM_STR);
            $insertQ->bindParam(':modified_by', $user_id, PDO::PARAM_INT); // Define $user_id before using it
            $insertQ->execute();

            if ($insertQ->rowCount() > 0) {

                $comment = '';
                if ($status == 'Initiated') {
                    $progress = 20;
                    $color = 'red';
                    $comment = "Thank you for initiating your application with us. We appreciate your interest. Please proceed by filling in the form to continue the application process.";
                } elseif ($status == 'Submitted') {
                    $progress = 40;
                    $color = 'black';
                    $comment = "Congratulations! Your application has been successfully submitted. To proceed further, kindly make a payment of $amount to Grithall Academy Ltd, Account Number: 0003166996 at Jaiz Bank. Thank you for choosing us.";
                } elseif ($status == 'Paid') {
                    $progress = 60;
                    $color = 'blue';
                    $comment = "We are pleased to inform you that your application fee payment has been received and confirmed. Your application is now under review. Kindly await further communication from our admission team regarding the interview date.";
                } elseif ($status == 'Interviewed') {
                    $progress = 80;
                    $color = 'gold';
                    $comment = "Great news! Your interview has been conducted successfully. Now, please await your admission status and further instructions on the class payment process. We appreciate your participation in the interview.";
                } elseif ($status == 'Admitted') {
                    $progress = 100;
                    $color = 'green';
                    $comment = "Congratulations! We are thrilled to inform you that your application has been successful, and you have been admitted to our institution. Welcome to the Grithall Academy family! Please await further details on your admission status and instructions for class payment. We look forward to having you with us.";
                } elseif ($status == 'Rejected') {
                    $progress = 100;
                    $color = 'red';
                    $comment = "We regret to inform you that your application for admission has been unsuccessful. We appreciate your interest in our institution and wish you the best in your future endeavors.";
                }


                $subject = "Student Application Update";

                $query = "SELECT email FROM parents WHERE `email` = :email";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $parent_exist = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($parent_exist) {

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
                                    <h2>Application Status: $status</h2>
                                </div>
                                <div class='content'>
                                    <p id='status-text'>
                                    $comment
                                    </p>
        
                                    
                                    <p>
                                    You can follow <a a href='https://parent.grithallacademy.com.ng/dashboard/application-status.php?ref=$ref'>this link</a> to view the progress of your application
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



                    // Send email
                    mail($email, $subject, $message, $headers);
                }



                $response = ['success' => true, 'message' => 'Application Status Updated to ' . $status . ' Successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update application status'];
            }
        }
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request'];
}

echo json_encode($response);
