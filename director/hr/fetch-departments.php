<?php
// Include database connection
require('../settings.php');

// Query to select all departments
$query = "SELECT * FROM departments";
$stmt = $pdo->prepare($query);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output departments as JSON
echo json_encode($departments);
?>
