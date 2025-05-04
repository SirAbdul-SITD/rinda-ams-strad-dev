<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include "../settings.php";

    // Define variables and initialize with empty values
    $name = $class = $subject = $folder = $type = $permission = $file = $student = "";

    // Processing form data when form is submitted
    $name = $_POST["name"];
    $class = $_POST["class"];
    $subject = $_POST["subject"];
    $folder = $_POST["folder"];
    $type = $_POST["type"];
    $permission = $_POST["permission"];
    $file = $_FILES["file"];
    $student = $_FILES["student"];

    // Get file details
    $fileName = $file["name"];
    $fileTmpName = $file["tmp_name"];
    $fileSize = $file["size"];
    $fileError = $file["error"];
    $fileType = $file["type"];


    // if ($fileType == ) {
    //     # code...
    // } else {
    //     # code...
    // }























    // Extract file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Define allowed file extensions
    $allowedExtensions = array("png", "jpg", "jpeg", "gif", "txt");

    // Check if the uploaded file has a valid extension
    if (in_array($fileExt, $allowedExtensions)) {
        // Generate a unique filename to avoid overwriting existing files
        $newFileName = uniqid("", true) . "." . $fileExt;

        // Specify the directory to save uploaded files
        $uploadDir = "upload/"; // Update with your desired directory

        // Move the uploaded file to the specified directory
        $uploadPath = $uploadDir . $newFileName;
        move_uploaded_file($fileTmpName, $uploadPath);

        // Prepare and execute the SQL query to insert data into the files table
        $sql = "INSERT INTO files (title, extension, subject, class, added_by, type, folder, permission, students, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$newFileName, $fileExt, $subject, $class, $name, $fileType, $folder, $permission, "on"]);

        // Close the database connection
        $pdo = null;

        // Redirect to a success page or display a success message
        header("Location: index.php");
        exit();
    } else {
        // If the uploaded file has an invalid extension, show an error message
        echo "Invalid file format. Please upload a PNG, JPG, JPEG, or GIF file.";
    }
}
