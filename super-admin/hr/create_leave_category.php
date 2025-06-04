<?php
require_once '../settings.php';

try {
    // Check if leave_categories table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS leave_categories (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    )");

    // Add a default leave category if it doesn't exist
    $stmt = $pdo->prepare("INSERT INTO leave_categories (name, description) 
                          SELECT 'Annual Leave', 'Regular annual leave entitlement' 
                          WHERE NOT EXISTS (SELECT 1 FROM leave_categories WHERE id = 1)");
    $stmt->execute();

    echo "Leave category created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 