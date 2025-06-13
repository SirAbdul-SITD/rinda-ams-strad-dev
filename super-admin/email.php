<?php
require_once 'settings.php';

// Query to get all parent emails
$query = "SELECT email FROM parents WHERE email IS NOT NULL";
$stmt = $pdo->prepare($query);
$stmt->execute();
$parentEmails = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Email details
$subject = "Congratulations";

$message = "
<!DOCTYPE html>
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
            <h2>Class Promotion Announcement</h2>
        </div>
        <div class='content'>
            <p>Dear Parent/Guardian,</p>
            <p>We are pleased to inform you that your child/ward has been successfully promoted to the next class for the upcoming academic session. This is a significant milestone, and we commend your child's/ward's hard work and dedication throughout the school year.</p>
            <p>To view your child's/ward's new class assignment and the corresponding invoice, please log in to your dashboard by following <a href='https://application.strad.africa/'>this link</a>. We kindly request that you review the invoice and ensure timely payment to secure your child's/ward's place in the new class.</p>
            <p>Thank you for your continued support and cooperation. We look forward to another successful academic year together.</p>
        </div>
        <div class='footer'>
            <p>Sincerely,</p>
            <p>The Grithall Academy</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
";

// Additional headers
$headers = 'From: Grithall Academy <noreply@strad.africa>' . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Loop through each parent email and send the email
foreach ($parentEmails as $email) {
    if (mail($email, $subject, $message, $headers)) {
        echo "Email sent successfully to $email<br>";
    } else {
        echo "Failed to send email to $email<br>";
    }
}
