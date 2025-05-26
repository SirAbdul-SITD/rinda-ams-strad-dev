<?php
require '../settings.php';

// Check if the section value is set and not empty
if (isset($_POST['section_id']) && !empty($_POST['section_id'])) {
    // Sanitize the section_id value
    $section_id = $_POST['section_id'];

    // Prepare and execute a query to fetch classes based on the selected section_id
    $query = "SELECT * FROM classes WHERE section_id = :section_id AND status = 1 ORDER BY class ASC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':section_id', $section_id, PDO::PARAM_STR);
    $stmt->execute();
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the response data
    $response = [];

    // Check if any classes are found
    if ($classes) {
        $response['success'] = true;
        $response['classes'] = $classes;
    } else {
        $response['success'] = false;
        $response['message'] = 'No classes found';
    }

    // Return the JSON response
    echo json_encode($response);
} else {
    // If the section value is not set or empty, return an empty response
    echo json_encode(['success' => false, 'message' => 'Select Section First']);
}
?>
