<?php
require '../settings.php';
// Check if the section value is set and not empty
if (isset($_GET['section']) && !empty($_GET['section'])) {
    // Sanitize the section value
    $section = $_GET['section'];

    // Prepare and execute a query to fetch classes based on the selected section
    $query = "SELECT * FROM classes WHERE section = :section ORDER BY class ASC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':section', $section, PDO::PARAM_STR);
    $stmt->execute();
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any classes are found
    if ($classes) {
        // Generate HTML options for the classes
        $options = '<option value="">Select Class</option>';
        foreach ($classes as $class) {
            $options .= '<option value="' . $class['class'] . '">' . $class['class'] . '</option>';
        }
        // Return the HTML options
        echo $options;
    } else {
        // If no classes are found, return a default message
        echo '<option value="">No classes found</option>';
    }
} else {
    // If the section value is not set or empty, return an empty option
    echo '<option value="">Select Section First</option>';
}
?>
