<?php
require_once 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $email = $_POST['email'];
    $newPassword = $_POST['password'];

    try {
      
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // SQL query to update the password
        $sql = "UPDATE super_admin SET password = :password WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        // Execute the query with the provided email and hashed password
        $stmt->execute(['password' => $hashedPassword, 'email' => $email]);

        if ($stmt->rowCount() > 0) {

            // Query to delete the token
            $delete_sql = "DELETE FROM password_reset WHERE email = :email";
            $delete_stmt = $pdo->prepare($delete_sql);
            $delete_stmt->execute(['email' => $email]);
            
            $response['success'] = true;
            $response['message'] = 'Password updated successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'No user found with the provided email, or the new password is the same as the old one';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

?>
