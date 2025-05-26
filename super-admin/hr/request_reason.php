<?php
require '../settings.php';

// Check if the section value is set and not empty
if (isset($_POST['id'])) {
    // Sanitize the id value
    $id = $_POST['id'];

    // Prepare and execute a query to fetch classes based on the selected id
    $query = "SELECT explanatory_note FROM leave_applications WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $reason = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepare the response data
    $response = [];

    // Check if any reason are found
    if ($reason) {
        $response['success'] = true;
        $response['message'] = $reason;
    } else {
        $response['success'] = false;
        $response['message'] = 'No reason found';
    }

    // Return the JSON response
    echo json_encode($response);
} else {
    // If the section value is not set or empty, return an empty response
    echo json_encode(['success' => false, 'message' => 'Select Request First']);
}
?>
