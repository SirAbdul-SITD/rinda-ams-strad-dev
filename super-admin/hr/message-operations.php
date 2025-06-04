<?php
require_once '../settings.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Log the incoming request
    error_log("Message operation request: " . print_r($_POST, true));

    $action = $_POST['action'] ?? '';
    
    if (empty($action)) {
        throw new Exception('No action specified');
    }

    switch ($action) {
        case 'send_message':
            handleSendMessage();
            break;
        case 'send_bulk':
            handleBulkMessage();
            break;
        case 'get_stats':
            getMessageStats();
            break;
        case 'get_history':
            getMessageHistory();
            break;
        case 'view':
            viewMessage();
            break;
        case 'delete':
            deleteMessage();
            break;
        case 'update':
            updateMessage();
            break;
        default:
            throw new Exception('Invalid action: ' . $action);
    }
} catch (Exception $e) {
    error_log("Error in message-operations.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'debug_info' => [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}

function handleSendMessage() {
    global $pdo;
    
    // Validate required fields
    $staff_id = $_POST['recipient'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $message = $_POST['message'] ?? null;
    $send_email = isset($_POST['send_email']) ? true : false;

    if (!$staff_id || !$subject || !$message) {
        throw new Exception('All fields are required');
    }

    // Get staff email
    $stmt = $pdo->prepare("SELECT email, first_name, last_name FROM staffs WHERE id = ?");
    $stmt->execute([$staff_id]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        throw new Exception('Staff not found');
    }

    // Start transaction
    $pdo->beginTransaction();

    try {
        // Insert message into database
        $stmt = $pdo->prepare("INSERT INTO messages (staff_id, subject, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$staff_id, $subject, $message]);
        $message_id = $pdo->lastInsertId();

        // Send email if requested
        if ($send_email && $staff['email']) {
            $to = $staff['email'];
            $headers = "From: noreply@rindaams.com\r\n";
            $headers .= "Reply-To: noreply@rindaams.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $email_body = "
                <html>
                <body>
                    <h2>{$subject}</h2>
                    <p>{$message}</p>
                    <hr>
                    <p>This is an automated message from Rinda AMS.</p>
                </body>
                </html>
            ";

            $email_sent = mail($to, $subject, $email_body, $headers);
            
            // Update message status
            $stmt = $pdo->prepare("UPDATE messages SET email_sent = ?, email_attempted = 1 WHERE id = ?");
            $stmt->execute([$email_sent ? 1 : 0, $message_id]);
        }

        $pdo->commit();
        echo json_encode([
            'success' => true,
            'message' => 'Message sent successfully'
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function handleBulkMessage() {
    global $pdo;
    
    // Validate required fields
    $group_type = $_POST['recipientGroup'] ?? null;
    $subject = $_POST['bulkSubject'] ?? null;
    $message = $_POST['bulkMessage'] ?? null;
    $send_email = isset($_POST['bulkSendEmail']) ? true : false;
    $department_id = $_POST['department'] ?? null;
    $designation_id = $_POST['designation'] ?? null;

    if (!$group_type || !$subject || !$message) {
        throw new Exception('All fields are required');
    }

    // Build query based on group type
    $query = "SELECT id, email, first_name, last_name FROM staffs WHERE status = 1";
    $params = [];

    switch ($group_type) {
        case 'department':
            if (!$department_id) {
                throw new Exception('Department is required');
            }
            $query .= " AND department_id = ?";
            $params[] = $department_id;
            break;
        case 'designation':
            if (!$designation_id) {
                throw new Exception('Designation is required');
            }
            $query .= " AND designation_id = ?";
            $params[] = $designation_id;
            break;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $staff_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($staff_list)) {
        throw new Exception('No staff members found for the selected group');
    }

    // Start transaction
    $pdo->beginTransaction();

    try {
        $success_count = 0;
        $email_success_count = 0;

        foreach ($staff_list as $staff) {
            // Insert message
            $stmt = $pdo->prepare("INSERT INTO messages (staff_id, subject, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$staff['id'], $subject, $message]);
            $message_id = $pdo->lastInsertId();
            $success_count++;

            // Send email if requested
            if ($send_email && $staff['email']) {
                $to = $staff['email'];
                $headers = "From: noreply@rindaams.com\r\n";
                $headers .= "Reply-To: noreply@rindaams.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $email_body = "
                    <html>
                    <body>
                        <h2>{$subject}</h2>
                        <p>{$message}</p>
                        <hr>
                        <p>This is an automated message from Rinda AMS.</p>
                    </body>
                    </html>
                ";

                if (mail($to, $subject, $email_body, $headers)) {
                    $stmt = $pdo->prepare("UPDATE messages SET email_sent = 1 WHERE id = ?");
                    $stmt->execute([$message_id]);
                    $email_success_count++;
                }
            }
        }

        $pdo->commit();
        echo json_encode([
            'success' => true,
            'message' => "Message sent to {$success_count} staff members" . 
                        ($send_email ? " ({$email_success_count} emails sent)" : "")
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function getMessageStats() {
    global $pdo;
    
    // Get total messages
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM messages");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get unread messages
    $stmt = $pdo->query("SELECT COUNT(*) as unread FROM messages WHERE is_read = 0");
    $unread = $stmt->fetch(PDO::FETCH_ASSOC)['unread'];

    // Get messages sent today
    $stmt = $pdo->query("SELECT COUNT(*) as sent_today FROM messages WHERE DATE(created_at) = CURDATE()");
    $sent_today = $stmt->fetch(PDO::FETCH_ASSOC)['sent_today'];

    // Get failed messages
    $stmt = $pdo->query("SELECT COUNT(*) as failed FROM messages WHERE email_sent = 0 AND email_attempted = 1");
    $failed = $stmt->fetch(PDO::FETCH_ASSOC)['failed'];

    // Get messages by status
    $stmt = $pdo->query("
        SELECT 
            CASE 
                WHEN is_read = 0 THEN 'unread'
                WHEN email_sent = 1 THEN 'sent'
                WHEN email_attempted = 1 THEN 'failed'
                ELSE 'read'
            END as status,
            COUNT(*) as count
        FROM messages
        GROUP BY status
    ");
    $by_status = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $by_status[$row['status']] = $row['count'];
    }

    // Get messages by month
    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') as month,
            COUNT(*) as count
        FROM messages
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY month
        ORDER BY month
    ");
    $by_month = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'stats' => [
            'total' => $total,
            'unread' => $unread,
            'sent_today' => $sent_today,
            'failed' => $failed,
            'by_status' => $by_status,
            'by_month' => $by_month
        ]
    ]);
}

function getMessageHistory() {
    global $pdo;
    
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $status = $_POST['status'] ?? '';

    // Build query
    $query = "
        SELECT m.*, 
               CONCAT(s.first_name, ' ', s.last_name) as recipient_name,
               d.department as recipient_department
        FROM messages m
        JOIN staffs s ON m.staff_id = s.id
        LEFT JOIN departments d ON s.department_id = d.id
        WHERE 1=1
    ";
    $params = [];

    if ($status) {
        switch ($status) {
            case 'unread':
                $query .= " AND m.is_read = 0";
                break;
            case 'read':
                $query .= " AND m.is_read = 1";
                break;
            case 'sent':
                $query .= " AND m.email_sent = 1";
                break;
            case 'failed':
                $query .= " AND m.email_attempted = 1 AND m.email_sent = 0";
                break;
        }
    }

    // Get total count
    $count_query = str_replace("m.*, CONCAT(s.first_name, ' ', s.last_name) as recipient_name, d.department as recipient_department", "COUNT(*) as total", $query);
    $stmt = $pdo->prepare($count_query);
    $stmt->execute($params);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get paginated results
    $query .= " ORDER BY m.created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'messages' => $messages,
        'total' => $total,
        'page' => $page,
        'limit' => $limit
    ]);
}

function viewMessage() {
    global $pdo;
    
    $message_id = $_POST['message_id'] ?? null;
    if (!$message_id) {
        throw new Exception('Message ID is required');
    }

    $stmt = $pdo->prepare("
        SELECT m.*, 
               CONCAT(s.first_name, ' ', s.last_name) as recipient_name,
               d.department as recipient_department
        FROM messages m
        JOIN staffs s ON m.staff_id = s.id
        LEFT JOIN departments d ON s.department_id = d.id
        WHERE m.id = ?
    ");
    $stmt->execute([$message_id]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$message) {
        throw new Exception('Message not found');
    }

    // Mark as read
    $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
    $stmt->execute([$message_id]);

    echo json_encode([
        'success' => true,
        'message' => $message
    ]);
}

function deleteMessage() {
    global $pdo;
    
    $message_id = $_POST['message_id'] ?? null;
    if (!$message_id) {
        throw new Exception('Message ID is required');
    }

    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$message_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Message deleted successfully'
    ]);
}

function updateMessage() {
    global $pdo;
    
    $message_id = $_POST['message_id'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $message = $_POST['message'] ?? null;

    if (!$message_id || !$subject || !$message) {
        throw new Exception('All fields are required');
    }

    $stmt = $pdo->prepare("UPDATE messages SET subject = ?, message = ? WHERE id = ?");
    $stmt->execute([$subject, $message, $message_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Message updated successfully'
    ]);
} 