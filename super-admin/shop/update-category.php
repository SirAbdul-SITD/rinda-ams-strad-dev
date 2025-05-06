<?php
require_once '../settings.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the id, name, and description from the form
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];

    // Validate input
    if (empty($id) || empty($name) || empty($description)) {
        // Handle empty fields
        $response = array(
            "success" => false,
            "message" => "All fields are required."
        );
    } else {
        try {
            // Prepare SQL statement to update category
            $sql = "UPDATE product_categories SET category_name=?, category_description=? WHERE category_id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $description, $id]);

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                $response = array(
                    "success" => true,
                    "message" => "Category updated successfully."
                );
            } else {
                $response = array(
                    "success" => false,
                    "message" => "No category found with the provided ID."
                );
            }
        } catch (PDOException $e) {
            $response = array(
                "success" => false,
                "message" => "Error updating category: " . $e->getMessage()
            );
        }
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>