<?php
// Include database configuration
include_once '../settings.php';

// Check if order ID is provided
if (isset($_POST['order_id'])) {
  $orderId = $_POST['order_id'];

  // Prepare and execute SQL query to fetch order items
  $stmt = $pdo->prepare("SELECT o.*, p.* FROM order_items o INNER JOIN products p ON o.product_id = p.id WHERE order_id = :order_id");
  $stmt->bindParam(':order_id', $orderId);
  $stmt->execute();
  
  // Fetch order items
  $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  // Initialize total sum
  $totalSum = 0;

  // Output order items
  foreach ($orderItems as $item) {
    echo "<p>{$item['quantity']} - {$item['name']} = $ {$item['price_at_purchase']}</p>";
    // Add the price of the current item to the total sum
    $totalSum += $item['price_at_purchase'];
  }

  // Output total sum
  echo "<p>Total = $ {$totalSum}</p>";
} else {
  echo "Invalid request";
}

?>
