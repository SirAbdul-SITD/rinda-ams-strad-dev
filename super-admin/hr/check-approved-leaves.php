<?php
require_once __DIR__ . '/../settings.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check total approved leaves
    $sql = "SELECT COUNT(*) as total FROM leave_applications WHERE LOWER(status) = LOWER('Approved')";
    $stmt = $pdo->query($sql);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "Total approved leaves: " . $total . "\n";

    // Check a sample of approved leaves
    $sql = "SELECT la.*, s.first_name, s.last_name, lc.category 
            FROM leave_applications la 
            LEFT JOIN staffs s ON la.staff_id = s.id 
            LEFT JOIN leave_categories lc ON la.category_id = lc.id 
            WHERE LOWER(la.status) = LOWER('Approved') 
            LIMIT 5";
    $stmt = $pdo->query($sql);
    $leaves = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nSample approved leaves:\n";
    foreach ($leaves as $leave) {
        echo "ID: " . $leave['id'] . "\n";
        echo "Staff: " . $leave['first_name'] . " " . $leave['last_name'] . "\n";
        echo "Category: " . $leave['category'] . "\n";
        echo "Status: " . $leave['status'] . "\n";
        echo "Start Date: " . $leave['start_date'] . "\n";
        echo "-------------------\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 