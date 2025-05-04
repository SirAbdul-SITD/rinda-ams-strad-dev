<?php

require_once '../settings.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize response array
    $response = ['success' => true, 'message' => ''];


    
        if (!empty($_POST['firstName'])) {
            $requiredPrefixFields = ['lastName', 'phoneNumber', 'address', 'country', 'state', 'city'];
            
            // Check if required fields are provided
            foreach ($requiredPrefixFields as $field) {
                if (empty($_POST[$field])) {
                    $response = ['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required when ' . ucfirst(str_replace('_', ' ', $prefix)) . ' information is provided.'];
                    exit;
                }
            }

            // Insert parent data into the parents table
            $stmtInsertParent = $pdo->prepare("INSERT INTO parents (firstName, lastName, phoneNumber, address, country, state, city, email, occupation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmtInsertParent->execute([
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['phoneNumber'],
                $_POST['address'],
                $_POST['country'],
                $_POST['state'],
                $_POST['city'],
                $_POST['email'],
                $_POST['occupation'],
            ])) {
                // Handle insertion failure
                $response = ['success' => false, 'message' => 'Failed to insert parent data.'];
                exit; // Exit the loop if insertion fails
            } else {
                $response = ['success' => true, 'message' => 'A New Parent Has Been Added Successfully'];
            }
        }
    
} else {
    // If the request method is not POST, return an error response
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
