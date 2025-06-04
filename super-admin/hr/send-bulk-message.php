<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['group']) || !isset($_POST['subject']) || !isset($_POST['message'])) {
        throw new Exception('Missing required fields');
    }

    $group = $_POST['group'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $send_email = isset($_POST['send_email']) ? $_POST['send_email'] : false;
    $department_id = isset($_POST['department_id']) ? $_POST['department_id'] : null;
    $designation_id = isset($_POST['designation_id']) ? $_POST['designation_id'] : null;

    // Get sender info
    $sender_id = $_SESSION['user_id'];
    $sender_name = $_SESSION['full_name'];

    // Build recipient query based on group
    $query = "SELECT id, email FROM staffs WHERE 1=1";
    $params = [];

    if ($group === 'department' && $department_id) {
        $query .= " AND department_id = ?";
        $params[] = $department_id;
    } elseif ($group === 'designation' && $designation_id) {
        $query .= " AND designation_id = ?";
        $params[] = $designation_id;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($recipients)) {
        throw new Exception('No recipients found for the selected group');
    }

    $success_count = 0;
    $failed_count = 0;

    // Send messages to each recipient
    foreach ($recipients as $recipient) {
        try {
            // Insert message into database
            $stmt = $pdo->prepare("INSERT INTO messages (sender_id, recipient_id, subject, message, status, created_at) VALUES (?, ?, ?, ?, 'unread', NOW())");
            $stmt->execute([$sender_id, $recipient['id'], $subject, $message]);
            $message_id = $pdo->lastInsertId();

            // Send email if requested
            if ($send_email && $recipient['email']) {
                // Configure email settings
                $mail->clearAddresses();
                $mail->setFrom('noreply@rindaams.com', 'Rinda AMS');
                $mail->addAddress($recipient['email']);
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->AltBody = strip_tags($message);

                if ($mail->send()) {
                    // Update message status to sent
                    $stmt = $pdo->prepare("UPDATE messages SET status = 'sent' WHERE id = ?");
                    $stmt->execute([$message_id]);
                    $success_count++;
                } else {
                    // Update message status to failed
                    $stmt = $pdo->prepare("UPDATE messages SET status = 'failed' WHERE id = ?");
                    $stmt->execute([$message_id]);
                    $failed_count++;
                }
            } else {
                $success_count++;
            }
        } catch (Exception $e) {
            $failed_count++;
            // Log error but continue with other recipients
            error_log("Failed to send message to recipient {$recipient['id']}: " . $e->getMessage());
        }
    }

    $message = "Bulk message sent successfully. ";
    if ($send_email) {
        $message .= "Emails sent: $success_count, Failed: $failed_count";
    } else {
        $message .= "Messages sent: $success_count";
    }

    echo json_encode([
        'success' => true,
        'message' => $message
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 