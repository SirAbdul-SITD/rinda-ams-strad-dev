<?php
require_once('../settings.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['course_id'])) {
        die(json_encode(['success' => false, 'message' => "Course ID is required."]));
    }

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // First, get the thumbnail path to delete it later
        $stmt = $pdo->prepare("SELECT thumbnail FROM courses WHERE course_id = ?");
        $stmt->execute([$_POST['course_id']]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$course) {
            throw new Exception("Course not found.");
        }

        // Delete the course (cascading deletes will handle topics and materials)
        $stmt = $pdo->prepare("DELETE FROM courses WHERE course_id = ?");
        $stmt->execute([$_POST['course_id']]);

        // Delete the thumbnail file if it exists
        if ($course['thumbnail'] && file_exists('../../' . $course['thumbnail'])) {
            unlink('../../' . $course['thumbnail']);
        }

        // Commit transaction
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Course deleted successfully!'
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>