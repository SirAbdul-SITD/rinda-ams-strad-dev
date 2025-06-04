<?php
require_once '../settings.php';

try {
    // Create staffs_attendance table
    $pdo->exec("CREATE TABLE IF NOT EXISTS staffs_attendance (
        id INT(11) NOT NULL AUTO_INCREMENT,
        staff_id INT(11) NOT NULL,
        date DATE NOT NULL,
        status ENUM('present', 'absent', 'late') NOT NULL,
        check_in TIME,
        check_out TIME,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (staff_id) REFERENCES staffs(id) ON DELETE CASCADE
    )");

    // Add end_date column to leave_applications if it doesn't exist
    $pdo->exec("ALTER TABLE leave_applications 
                ADD COLUMN IF NOT EXISTS end_date VARCHAR(50) AFTER start_date");

    // Add department_id column to staffs if it doesn't exist
    $pdo->exec("ALTER TABLE staffs 
                ADD COLUMN IF NOT EXISTS department_id INT(11) AFTER designation_id,
                ADD FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL");

    echo "Tables and columns created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 