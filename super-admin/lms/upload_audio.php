<?php
require_once('../settings.php');

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_audio') {
    try {
        // Check if file was uploaded without errors
        if (!isset($_FILES['audio_file']) || $_FILES['audio_file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No file uploaded or upload error occurred.");
        }

        $title = trim($_POST['title'] ?? '');
        $subject = trim($_POST['subject'] ?? null);
        $topic = trim($_POST['topic'] ?? null);
        $course_id = $_POST['course_id'] ?? null;
        $status = $_POST['status'] ?? 'draft';

        if (empty($title)) {
            throw new Exception("Title is required.");
        }

        // Validate file type
        $allowed_types = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3'];
        $file_type = $_FILES['audio_file']['type'];

        if (!in_array($file_type, $allowed_types)) {
            throw new Exception("Invalid file type. Only MP3, WAV, and OGG files are allowed.");
        }

        // Create upload directory if not exists
        $upload_dir = '../../uploads/audio/';
        if (!file_exists($upload_dir) && !mkdir($upload_dir, 0777, true)) {
            throw new Exception("Failed to create upload directory.");
        }

        // Generate unique filename
        $file_ext = pathinfo($_FILES['audio_file']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('audio_') . '.' . $file_ext;
        $file_path = $upload_dir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($_FILES['audio_file']['tmp_name'], $file_path)) {
            throw new Exception("Failed to move uploaded file.");
        }

        // Get file size
        $file_size = filesize($file_path);

        // Insert record into database
        $stmt = $pdo->prepare("INSERT INTO lms_audio (title, subject, topic, course_id, file_path, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $subject, $topic, $course_id, $file_path, $status]);

        if ($stmt->rowCount() <= 0) {
            throw new Exception("Failed to insert audio record into database.");
        }

        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Audio file uploaded successfully!'
        ];

    } catch (Exception $e) {
        // Log error to file and session
        file_put_contents('debug_log.txt', "[" . date('Y-m-d H:i:s') . "] Error: " . $e->getMessage() . "\n", FILE_APPEND);
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    // Redirect back to the page
    header("Location: audio.php");
    exit();
}
?>
