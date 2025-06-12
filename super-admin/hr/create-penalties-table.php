<?php
require '../settings.php';

try {
    // Create penalties table
    $pdo->exec("CREATE TABLE IF NOT EXISTS penalties (
        id INT AUTO_INCREMENT PRIMARY KEY,
        staff_id INT NOT NULL,
        penalty_type_id INT NOT NULL,
        date DATE NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (staff_id) REFERENCES staffs(id) ON DELETE CASCADE,
        FOREIGN KEY (penalty_type_id) REFERENCES penalty_types(id) ON DELETE CASCADE
    )");

    echo "Penalties table created successfully";
} catch (PDOException $e) {
    echo "Error creating penalties table: " . $e->getMessage();
}
?> 