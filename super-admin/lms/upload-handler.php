<?php
$base_upload_dir = '/opt/lampp/htdocs/strad/super-admin/lms/uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

        $folder = basename(trim($_POST['target_folder'] ?? ''));
        if (empty($folder)) {
            die("<script>alert('No target folder specified.'); window.history.back();</script>");
        }

        $uploadDir = rtrim($base_upload_dir . $folder, '/') . '/';
        error_log("📁 Trying to create folder: $uploadDir");

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0775, true)) {
                error_log("❌ Failed to create folder: $uploadDir");
                die("<script>alert('Failed to create folder: $uploadDir'); window.history.back();</script>");
            }
        }

        $fileName = basename($_FILES['file']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            echo "<script>alert('File uploaded successfully.'); window.location.href = 'file-manager.php';</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file.'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('No file uploaded or upload error.'); window.history.back();</script>";
    }
}

?>