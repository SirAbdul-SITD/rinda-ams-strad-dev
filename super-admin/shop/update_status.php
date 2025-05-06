<?php
// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    include_once '../settings.php';

    // Retrieve form data
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    // Prepare and execute SQL statement to update the status
    $sql = "UPDATE orders SET status = :status WHERE id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':order_id', $orderId);


    if ($stmt->execute()) {


        // Return success message
        echo "Status updated successfully";
    } else {
        // Return error message
        echo "Error occurred while updating status";
    }
} else {
    // If the request method is not POST, return an error message
    echo "Invalid request method";
}
?>
