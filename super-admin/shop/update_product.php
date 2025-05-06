<?php
// Check if the form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    // Include your database connection file
    require_once '../settings.php';

    // Get the product ID from the form data
    $productId = $_POST['product_id'];

    // Retrieve other form data
    $productName = $_POST['edit-product-name'];
    $productDescription = $_POST['edit-product-description'];
    $productCategory = $_POST['edit-category']; // Corrected variable name
    $productQuantity = $_POST['edit-product-quantity'];
    $productPrice = $_POST['edit-product-price'];

    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded image
        $imageFile = $_FILES['image']['tmp_name'];
        $imageFileName = $_FILES['image']['name'];
        // Move the uploaded file to a desired location
        $uploadDirectory = '../../uploads/shop/';
        $destination = $uploadDirectory . $imageFileName;
        move_uploaded_file($imageFile, $destination);

        // Prepare and execute SQL statement to update the product
        $sql = "UPDATE products SET 
            name = :name, 
            description = :description, 
            price = :price, 
            quantity_available = :quantity, 
            category_id = :category, 
            image_url = :image_url 
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $productName);
        $stmt->bindParam(':description', $productDescription);
        $stmt->bindParam(':price', $productPrice);
        $stmt->bindParam(':category', $productCategory);
        $stmt->bindParam(':quantity', $productQuantity);
        $stmt->bindParam(':image_url', $destination);
        $stmt->bindParam(':id', $productId);
    } else {
        // If no new image was uploaded, keep the existing image

        // Prepare and execute SQL statement to update the product
        $sql = "UPDATE products SET 
            name = :name, 
            description = :description, 
            price = :price, 
            category_id = :category, 
            quantity_available = :quantity 
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $productName);
        $stmt->bindParam(':description', $productDescription);
        $stmt->bindParam(':price', $productPrice);
        $stmt->bindParam(':category', $productCategory);
        $stmt->bindParam(':quantity', $productQuantity);
        $stmt->bindParam(':id', $productId);
    }

    if ($stmt->execute()) {
        // Success response
        echo 'Product updated successfully';
    } else {
        // Error response
        echo 'Error occurred while updating product';
    }
} else {
    // If the request is not AJAX or product ID is not provided
    echo 'Invalid request';
}
?>
