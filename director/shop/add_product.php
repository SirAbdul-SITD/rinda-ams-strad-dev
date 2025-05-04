<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    include_once '../settings.php';

    // Define variables and initialize with empty values
    $productName = $productQuantity = $productCategory = $productDescription = $productPrice = $productImage = "";

    // Process form data when form is submitted
    $productName = $_POST['add-product-name'];
    $productDescription = $_POST['add-product-description'];
    $productQuantity = $_POST['add-product-quantity'];
    $productCategory = $_POST['add-product-category'];
    $productPrice = $_POST['add-product-price'];

    // Begin a transaction
    $pdo->beginTransaction();

    try {
        // Prepare an insert statement
        $sql = "INSERT INTO products (name, description, price, category_id, quantity_available) VALUES (:name, :description, :price, :category_id, :quantity_available)";
        $stmt = $pdo->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":name", $productName);
        $stmt->bindParam(":description", $productDescription);
        $stmt->bindParam(":price", $productPrice);
        $stmt->bindParam(":category_id", $productCategory);
        $stmt->bindParam(":quantity_available", $productQuantity);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Get the last inserted product ID
            $lastProductId = $pdo->lastInsertId();

            // Check if file is uploaded
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Generate a unique filename using the product ID
                $productImageName = $lastProductId . '_' . $_FILES['image']['name'];

                // Move the uploaded file to the upload directory with the new filename
                move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/' . $productImageName);

                // Update the image URL in the database
                $updateSql = "UPDATE products SET image_url = :image_url WHERE id = :product_id";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->bindParam(":image_url", $productImageName);
                $updateStmt->bindParam(":product_id", $lastProductId);
                $updateStmt->execute();
            }

            // Commit the transaction
            $pdo->commit();

            // Redirect to success page
            echo "New product added successfully";
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $pdo->rollBack();
        echo "An error occurred: " . $e->getMessage();
    }

    // Close connection
    unset($pdo);
}
?>
