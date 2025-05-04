<?php
require_once '../settings.php';
$ds = DIRECTORY_SEPARATOR;
$storeFolder = '../../uploads/student-profiles';

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $originalFilename = $_FILES['file']['name'];
    $Filename = $_SESSION['photo_id'];
    
    // Rename the file
    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION); // Get the file extension
    $newFilename = $Filename . '.' . $extension; // Generate a unique filename
    
    // Set the target directory
    $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;
    
    // Set the target file path with the new filename
    $targetFile = $targetPath . $newFilename;
    
    // Move the uploaded file to the target directory with the new filename
    move_uploaded_file($tempFile, $targetFile);


    // Construct the SQL query
    $updateQuery = "UPDATE `students` SET `photo` = :photo WHERE id = :id";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':id', $Filename, PDO::PARAM_INT);
    $stmt->bindParam(':photo', $newFilename, PDO::PARAM_STR);
    $stmt->execute();
}
?>
