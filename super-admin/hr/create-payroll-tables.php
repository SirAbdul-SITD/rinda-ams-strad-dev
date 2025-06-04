<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "rinda_ams";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create payroll table
    $pdo->exec("CREATE TABLE IF NOT EXISTS payroll (
        id INT PRIMARY KEY AUTO_INCREMENT,
        staff_id INT NOT NULL,
        month DATE NOT NULL,
        basic_salary DECIMAL(10,2) NOT NULL,
        total_allowances DECIMAL(10,2) DEFAULT 0.00,
        total_deductions DECIMAL(10,2) DEFAULT 0.00,
        net_salary DECIMAL(10,2) NOT NULL,
        status ENUM('pending', 'paid') DEFAULT 'pending',
        payment_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (staff_id) REFERENCES staffs(id) ON DELETE CASCADE,
        UNIQUE KEY unique_payroll (staff_id, month)
    )");

    // Create payroll_allowances table
    $pdo->exec("CREATE TABLE IF NOT EXISTS payroll_allowances (
        id INT PRIMARY KEY AUTO_INCREMENT,
        payroll_id INT NOT NULL,
        allowance_type VARCHAR(50) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (payroll_id) REFERENCES payroll(id) ON DELETE CASCADE
    )");

    // Create payroll_deductions table
    $pdo->exec("CREATE TABLE IF NOT EXISTS payroll_deductions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        payroll_id INT NOT NULL,
        deduction_type VARCHAR(50) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (payroll_id) REFERENCES payroll(id) ON DELETE CASCADE
    )");

    // Create payroll_payments table
    $pdo->exec("CREATE TABLE IF NOT EXISTS payroll_payments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        payroll_id INT NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        payment_date DATE NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        reference_number VARCHAR(100),
        status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (payroll_id) REFERENCES payroll(id) ON DELETE CASCADE
    )");

    echo "Payroll tables created successfully!";
} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
?> 