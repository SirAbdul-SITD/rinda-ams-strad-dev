<?php
require_once '../settings.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    echo "<h2>Database Connection Test</h2>";
    
    // Test database connection
    echo "Testing database connection...<br>";
    $pdo->query("SELECT 1");
    echo "✓ Database connection successful<br><br>";
    
    // Check if staffs table exists
    echo "Checking staffs table...<br>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'staffs'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Staffs table exists<br>";
        
        // Check staffs table structure
        $stmt = $pdo->query("DESCRIBE staffs");
        echo "<br>Staffs table structure:<br>";
        echo "<pre>";
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        echo "</pre>";
    } else {
        echo "✗ Staffs table does not exist!<br>";
    }
    
    // Check if messages table exists
    echo "<br>Checking messages table...<br>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'messages'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Messages table exists<br>";
        
        // Check messages table structure
        $stmt = $pdo->query("DESCRIBE messages");
        echo "<br>Messages table structure:<br>";
        echo "<pre>";
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        echo "</pre>";
    } else {
        echo "✗ Messages table does not exist!<br>";
    }
    
    // Check PHP configuration
    echo "<br><h2>PHP Configuration</h2>";
    echo "PHP Version: " . phpversion() . "<br>";
    echo "PDO Extension: " . (extension_loaded('pdo') ? '✓ Loaded' : '✗ Not loaded') . "<br>";
    echo "PDO MySQL Extension: " . (extension_loaded('pdo_mysql') ? '✓ Loaded' : '✗ Not loaded') . "<br>";
    echo "Mail Function: " . (function_exists('mail') ? '✓ Available' : '✗ Not available') . "<br>";
    
    // Check file permissions
    echo "<br><h2>File Permissions</h2>";
    $files_to_check = [
        '../settings.php',
        'message-operations.php',
        'message.php'
    ];
    
    foreach ($files_to_check as $file) {
        echo "$file: " . (file_exists($file) ? '✓ Exists' : '✗ Missing') . " - ";
        echo "Permissions: " . substr(sprintf('%o', fileperms($file)), -4) . "<br>";
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "<br>";
    echo "Error Code: " . $e->getCode() . "<br>";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "<br>";
} 