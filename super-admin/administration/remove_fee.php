<?php
require('../settings.php');

$user = 1;

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];


    try {
        $updateQuery = "DELETE FROM compulsory_fees WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response = ['success' => true, 'message' => 'Fee Deleted successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Fee not found or already deleted.'];
        }
    } catch (PDOException $e) {
        $response = ['success' => false, 'message' => 'Error deleting fee: ' . $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid subject.'];
}

echo json_encode($response);
?>
