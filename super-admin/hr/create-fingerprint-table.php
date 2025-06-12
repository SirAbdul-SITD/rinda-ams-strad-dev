<?php
require_once '../settings.php';

try {
    // Create staff_fingerprints table
    $sql = "CREATE TABLE IF NOT EXISTS staff_fingerprints (
        id INT PRIMARY KEY AUTO_INCREMENT,
        staff_id INT NOT NULL,
        fingerprint_id VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (staff_id) REFERENCES staffs(id) ON DELETE CASCADE,
        UNIQUE KEY unique_fingerprint (fingerprint_id)
    )";

    $pdo->exec($sql);
    echo "Staff fingerprints table created successfully\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
} 