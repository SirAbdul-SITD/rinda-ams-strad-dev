<?php

// Include your database connection file
require('../settings.php');

// Check if the designation ID is provided in the GET request
if (isset($_GET['designationId'])) {
    $designationId = $_GET['designationId'];

    try {
        // Query to fetch the salary amount based on the designation ID
        $query = "SELECT salary FROM designations WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $designationId, PDO::PARAM_INT);
        $stmt->execute();
        $designation = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($designation) {
            // Return the salary amount as JSON response
            echo json_encode($designation['salary']);
        } else {
            // Designation not found
            echo json_encode(''); // Return empty string if designation not found
        }
    } catch (PDOException $e) {
        // Error occurred
        echo json_encode(''); // Return empty string if error occurs
    }
} else {
    // Designation ID not provided in the request
    echo json_encode(''); // Return empty string if designation ID not provided
}
