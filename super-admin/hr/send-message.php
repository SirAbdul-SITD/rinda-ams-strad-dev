<?php
require '../settings.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['recipient_id']) || !isset($_POST['subject']) || !isset($_POST['message'])) {
        throw new Exception('Missing required fields');
    }

    $recipient_id = $_POST['recipient_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $send_email = isset($_POST['send_email']) ? $_POST['send_email'] : false;

    // Get sender info
    $sender_id = $_SESSION['user_id'];
    $sender_name = $_SESSION['full_name'];

    // Get recipient email if needed
    $recipient_email = null;
    if ($send_email) {
        $stmt = $pdo->prepare("SELECT email FROM staffs WHERE id = ?");
        $stmt->execute([$recipient_id]);
        $recipient_email = $stmt->fetchColumn();
    }

    // Insert message into database
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, recipient_id, subject, message, status, created_at) VALUES (?, ?, ?, ?, 'unread', NOW())");
    $stmt->execute([$sender_id, $recipient_id, $subject, $message]);

    // Send email if requested
    if ($send_email && $recipient_email) {
        // Configure email settings
        $mail->setFrom('noreply@rindaams.com', 'Rinda AMS');
        $mail->addAddress($recipient_email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        if ($mail->send()) {
            // Update message status to sent
            $message_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("UPDATE messages SET status = 'sent' WHERE id = ?");
            $stmt->execute([$message_id]);
        } else {
            // Update message status to failed
            $message_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("UPDATE messages SET status = 'failed' WHERE id = ?");
            $stmt->execute([$message_id]);
            throw new Exception('Failed to send email');
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Message sent successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 