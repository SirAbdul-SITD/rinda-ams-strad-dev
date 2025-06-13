<?php
require '../settings.php';

try {
    // Read the SQL file
    $sql = file_get_contents('update_penalties_table.sql');
    
    // Split the SQL file into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    // Execute each statement
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    echo "Database structure updated successfully!";
} catch (PDOException $e) {
    echo "Error updating database structure: " . $e->getMessage();
}
?> 