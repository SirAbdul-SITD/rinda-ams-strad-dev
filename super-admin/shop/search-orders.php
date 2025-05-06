<?php
require_once '../settings.php';

if (isset($_GET['search'])) {
    // Sanitize the search input to prevent SQL injection
    $search = htmlspecialchars($_GET['search']);

    // Prepare SQL statement to search for orders
    $sql = "SELECT * FROM orders WHERE order_ref LIKE ? OR purchase_date LIKE ? OR name LIKE ? OR phone LIKE ? OR total LIKE ?  OR payment LIKE ?  OR status LIKE ? ORDER BY id DESC";

    // Execute the query with wildcard search (%)
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);

    // Fetch all matching orders as an associative array
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send JSON response with search results
    header('Content-Type: application/json');
    echo json_encode($orders);
    exit();
} else {
    // No search query provided
    echo json_encode([]);
}
?>
