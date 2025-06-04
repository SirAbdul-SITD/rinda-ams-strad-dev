<?php
require_once '../settings.php';

try {
    // Check if messages table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'messages'");
    if ($stmt->rowCount() == 0) {
        // Create messages table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `messages` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `staff_id` int(11) NOT NULL,
                `subject` varchar(255) NOT NULL,
                `message` text NOT NULL,
                `is_read` tinyint(1) NOT NULL DEFAULT 0,
                `email_sent` tinyint(1) NOT NULL DEFAULT 0,
                `email_attempted` tinyint(1) NOT NULL DEFAULT 0,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`),
                KEY `staff_id` (`staff_id`),
                CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        echo "Messages table created successfully.\n";
    } else {
        echo "Messages table already exists.\n";
    }

    // Check if required columns exist
    $stmt = $pdo->query("SHOW COLUMNS FROM messages");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $required_columns = [
        'id', 'staff_id', 'subject', 'message', 'is_read', 
        'email_sent', 'email_attempted', 'created_at'
    ];
    
    $missing_columns = array_diff($required_columns, $columns);
    
    if (!empty($missing_columns)) {
        echo "Missing columns: " . implode(', ', $missing_columns) . "\n";
        // Add missing columns
        foreach ($missing_columns as $column) {
            switch ($column) {
                case 'is_read':
                    $pdo->exec("ALTER TABLE messages ADD COLUMN is_read tinyint(1) NOT NULL DEFAULT 0");
                    break;
                case 'email_sent':
                    $pdo->exec("ALTER TABLE messages ADD COLUMN email_sent tinyint(1) NOT NULL DEFAULT 0");
                    break;
                case 'email_attempted':
                    $pdo->exec("ALTER TABLE messages ADD COLUMN email_attempted tinyint(1) NOT NULL DEFAULT 0");
                    break;
            }
            echo "Added column: $column\n";
        }
    }

    echo "Setup completed successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 