<?php
// Tomprint API Configuration
define('TOMPRINT_API_URL', 'http://your-tomprint-server/api'); // Replace with your Tomprint server URL
define('TOMPRINT_API_KEY', 'your-api-key'); // Replace with your Tomprint API key
define('TOMPRINT_DEVICE_ID', 'your-device-id'); // Replace with your Tomprint device ID

// Attendance Settings
define('WORK_START_TIME', '09:00:00');
define('WORK_END_TIME', '17:00:00');
define('LATE_THRESHOLD', '09:15:00'); // Consider late after this time
define('EARLY_LEAVE_THRESHOLD', '16:30:00'); // Consider early leave before this time

// Database table for storing Tomprint logs
define('TOMPRINT_LOGS_TABLE', 'tomprint_logs');

// Create Tomprint logs table if not exists
function createTomprintLogsTable($pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS " . TOMPRINT_LOGS_TABLE . " (
        id INT AUTO_INCREMENT PRIMARY KEY,
        staff_id INT NOT NULL,
        log_time DATETIME NOT NULL,
        log_type ENUM('check_in', 'check_out') NOT NULL,
        device_id VARCHAR(50) NOT NULL,
        status ENUM('success', 'failed') NOT NULL,
        raw_data TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (staff_id) REFERENCES staffs(id)
    )";
    
    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
        error_log("Error creating Tomprint logs table: " . $e->getMessage());
    }
} 