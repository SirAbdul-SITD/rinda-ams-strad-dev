<?php
require_once '../settings.php';

// Check if the category ID is provided
if (isset($_POST["id"])) {
    // Retrieve the category ID from the POST request
    $id = $_POST["id"];

    try {
        // Prepare SQL statement to delete the category
        $sql = "DELETE FROM product_categories WHERE category_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            $response = array(
                "success" => true,
                "message" => "Category removed successfully."
            );
        } else {
            $response = array(
                "success" => false,
                "message" => "No category found with the provided name."
            );
        }
    } catch (PDOException $e) {
        $response = array(
            "success" => false,
            "message" => "Error removing category: " . $e->getMessage()
        );
    }
} else {
    $response = array(
        "success" => false,
        "message" => "Category not provided."
    );
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
