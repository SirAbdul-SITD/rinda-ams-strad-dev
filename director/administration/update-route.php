<?php




require('../settings.php');


if (isset($_POST['edit-route-id']) && isset($_POST['edit-route-fare'])) {

    $id = $_POST['edit-route-id'];
    $amount = $_POST['edit-route-fare'] ?? 0;

    // Fetch the class's section
    $query = "SELECT id FROM routes WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        $updateQuery = "UPDATE routes SET fare = :amount, updated_by = :user_id WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':amount', $amount);
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt->execute();

        $response = ['success' => true, 'message' => 'Information updated successfully.'];
    } 
    else {
        $response = ['success' => false, 'message' => 'IEP Not Found.'];
    }

    
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
    
}

// Output the JSON response
echo json_encode($response);

// Assuming you have already established a database connection

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Retrieve form data
//     $route_id = $_POST['edit-route-id'];
//     $new_fare = $_POST['edit-route-fare'];

//     // Prepare and execute update query for the fare
//     $query = "UPDATE routes SET fare = :new_fare WHERE id = :route_id";
//     $stmt = $pdo->prepare($query);
//     $stmt->bindParam(':new_fare', $new_fare);
//     $stmt->bindParam(':route_id', $route_id);
//     $stmt->execute();

//     // Calculate new fares for other categories and types based on your rules
//     $weekdays_bothways = $new_fare;
//     $weekends_bothways = ($new_fare * 2) / 5;
//     $weekdays_oneway = $new_fare / 2;
//     $weekends_oneway = ($new_fare * 2) / 5;

//     // Prepare and execute update queries for other fares
//     $query_weekdays_bothways = "UPDATE routes SET Fare = :weekdays_bothways WHERE id = :route_id AND Category = 'Weekdays' AND Type = 'Both-ways'";
//     $stmt_weekdays_bothways = $pdo->prepare($query_weekdays_bothways);
//     $stmt_weekdays_bothways->bindParam(':weekdays_bothways', $weekdays_bothways);
//     $stmt_weekdays_bothways->bindParam(':route_id', $route_id);
//     $stmt_weekdays_bothways->execute();

//     // Repeat the process for other fare categories and types...

//     // Redirect to a success page or display a success message
//     header("Location: success.php");
//     exit();
// }


?>
