<?php
require("../settings.php");
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$response = ['success' => false, 'message' => ''];

try {
    $required = ['class', 'subject', 'topic', 'subtopic', 'content'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $content_id = $_POST['content_id'] ?? null;
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $topic = $_POST['topic'];
    $subtopic = $_POST['subtopic'];
    $content = $_POST['content'];

    if ($content_id) {
        // Update existing content
        $stmt = $pdo->prepare("UPDATE curriculum_contents SET content = :content WHERE id = :id");
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $content_id, PDO::PARAM_INT);
    } else {
        // Insert new content
        $stmt = $pdo->prepare("INSERT INTO curriculum_contents (class, subject, topic, subtopic, content) 
                              VALUES (:class, :subject, :topic, :subtopic, :content)");
        $stmt->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
        $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Content saved successfully'];
    } else {
        throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>