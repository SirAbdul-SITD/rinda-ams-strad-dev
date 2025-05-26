<?php
// Include your database connection
require_once '../settings.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Get the POST data from the AJAX request
    $whom = $_POST['whom'];
    $sendOption = $_POST['sendOption'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    if (empty($content)) {
        echo 'Message content cannot be empty';
        exit();
    }

    if ($sendOption === 'sendToEmail') {
        // Collect all recipients into an array (since multiple 'Recipient' fields are sent)
        $recipient_ids = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'recipient') !== false) {
                $recipient_ids[] = intval($value); // Collecting all recipient ids
            }
        }

        if (!empty($recipient_ids)) {
            // Convert the recipient IDs into a format for SQL IN clause
            $recipient_ids_str = implode(',', $recipient_ids);

            // Query the database to get the emails of the parents
            if ($whom == '1') {
                $sql = "SELECT email FROM parents WHERE id NOT IN ($recipient_ids_str)";
                $result = $pdo->query($sql);
                $emails = $result->fetchAll(PDO::FETCH_COLUMN);
            } else {
                $sql = "SELECT email FROM parents WHERE id IN ($recipient_ids_str)";
                $result = $pdo->query($sql);
                $emails = $result->fetchAll(PDO::FETCH_COLUMN);
            }
            
           


            // Loop through each email and send the message
            foreach ($emails as $email) {

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
                                    <h2>$subject</h2>
                                </div>
                                <div class='content'>
                                    <p id='status-text'>
                                    $content
                                    </p>
                                </div>
                                <div class='footer'>
                                    <p>The GHA Rinda AMS Team</p>
                                    <p>You can always reply to this mail incase of any complaints or inquiry.</p>
                                </div>
                                </div>
                            </body>
                            </html>
                            ";

                // Additional headers
                $headers .= 'From: Grithall Academy <support@grithallacademy.com.ng>' . "\r\n";
                $headers .= 'Reply-To: support@grithallacademy.com.ng' . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";;


                if (mail($email, $subject, $message, $headers)) {
                    echo "Email sent to $email\n";
                } else {
                    echo "Failed to send email to $email\n";
                }
            }
        }
    }
} else {
    echo "Invalid request method.";
}
