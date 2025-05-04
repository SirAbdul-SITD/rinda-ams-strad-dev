<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    include_once '../settings.php';

    // Define variables and initialize with empty values
    $categoryName = $description = "";

    // Process form data when form is submitted
    $categoryName = $_POST['name'];
    $description = $_POST['description'];
   
    // Begin a transaction
    $pdo->beginTransaction();

    try {
        // Prepare an insert statement
        $sql = "INSERT INTO product_categories (category_name, category_description) VALUES (:category_name, :category_description)";
        $stmt = $pdo->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":category_name", $categoryName);
        
        // Check if description is not null before binding
        if (!empty($description)) {
            $stmt->bindParam(":category_description", $description);
        } else {
            // If description is null, bind it as an empty string
            $stmt->bindParam(":category_description", $description, PDO::PARAM_STR);
        }

        // Execute the statement
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();
        // Set success response
        $response['success'] = true;
        $response['message'] = "Category added successfully!";

    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $pdo->rollBack();
        $response['success'] = true;
        $response['message'] = "An error occurred: " . $e->getMessage();

    }
    echo json_encode($response);
    // Close connection
    unset($pdo);
}
?>
