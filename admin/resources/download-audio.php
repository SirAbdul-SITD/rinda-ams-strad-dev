<?php
require '../settings.php';
// Check if the audio ID is provided
if (isset($_GET['id'])) {


    // Get the audio ID
    $id = $_GET['id'];

    // Query the database to retrieve the audio details
    $query = "SELECT * FROM files WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $audio = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($audio) {
        // Define the file path
        $filePath = 'file-manager/audio/' . $audio['title'] . '.' . $audio['extension'];

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
        // audio not found
        echo 'Audio not found.';
    }
} else {
    // audio ID not provided
    echo 'Audio not provided.';
}
