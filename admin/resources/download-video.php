<?php
require '../settings.php';
// Check if the video ID is provided
if (isset($_GET['id'])) {

    // Get the video ID
    $id = $_GET['id'];

    // Query the database to retrieve the video details
    $query = "SELECT * FROM files WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $video = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($video) {
        // Define the file path
        $filePath = 'file-manager/videos/' . $video['title'] . '.' . $video['extension'];

        // Check if the file exists
        if (file_exists($filePath)) {
            // Set headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));

            // Read the file and output its contents
            readfile($filePath);
            exit;
        } else {
            // File not found
            echo 'File not found.';
        }
    } else {
        // video not found
        echo 'Video not found.';
    }
} else {
    // video ID not provided
    echo 'video not provided.';
}
