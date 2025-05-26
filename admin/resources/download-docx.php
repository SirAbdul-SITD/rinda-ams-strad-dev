<?php
require '../settings.php';
// Check if the document ID is provided
if (isset($_GET['id'])) {
    // Get the document ID
    $id = $_GET['id'];

    // Query the database to retrieve the document details
    $query = "SELECT * FROM files WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $document = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($document) {
        // Define the file path
        $filePath = 'file-manager/documents/' . $document['title'] . '.' . $document['extension'];

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
        // Document not found
        echo 'Document not found.';
    }
} else {
    // Document ID not provided
    echo 'Document not provided.';
}
