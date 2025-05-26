<?php
// Start output buffering to catch any accidental output
ob_start();

require('../settings.php');
session_start();

// Set headers first to ensure JSON response
header('Content-Type: application/json');

// Check authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Initialize response
$response = ['success' => false, 'message' => ''];

try {
    // Validate required fields
    $required = ['class', 'subject', 'topic', 'subtopic', 'content', 'status'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Sanitize inputs
    $plan_id = isset($_POST['plan_id']) && $_POST['plan_id'] !== 'null' ? (int)$_POST['plan_id'] : null;
    $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $topic = filter_var($_POST['topic'], FILTER_SANITIZE_STRING);
    $subtopic = filter_var($_POST['subtopic'], FILTER_SANITIZE_STRING);
    $content = $_POST['content']; // Don't sanitize as it contains HTML
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user_id'];

    // Prepare SQL based on whether we're updating or inserting
    if ($plan_id) {
        $stmt = $pdo->prepare("UPDATE curriculum_plans SET 
                              plan = :content, 
                              status = :status 
                              WHERE id = :id");
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $plan_id, PDO::PARAM_INT);
    } else {
        $stmt = $pdo->prepare("INSERT INTO curriculum_plans 
                              (class, subject, topic, subtopic, plan, status, created_by, created_at) 
                              VALUES 
                              (:class, :subject, :topic, :subtopic, :content, :status, :user_id, NOW())");
        $stmt->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
        $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    }

    // Execute the query
    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Plan saved successfully',
            'plan_id' => $plan_id ?: $pdo->lastInsertId()
        ];
    } else {
        throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
    }

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Clean any output and send JSON
ob_end_clean();
echo json_encode($response);
exit();
?>