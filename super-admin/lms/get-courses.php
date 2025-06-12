<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Unauthorized access']));
}

try {
    $pdo = getDBConnection();
    
    // Get total records
    $stmt = $pdo->query("SELECT COUNT(*) FROM courses");
    $total_records = $stmt->fetchColumn();
    
    // Get filtered records
    $search = $_POST['search']['value'] ?? '';
    $where = '';
    $params = [];
    
    if (!empty($search)) {
        $where = "WHERE course_name LIKE ? OR subject LIKE ? OR class_level LIKE ? OR description LIKE ?";
        $search_param = "%$search%";
        $params = [$search_param, $search_param, $search_param, $search_param];
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM courses $where");
    if (!empty($params)) {
        $stmt->execute($params);
    } else {
        $stmt->execute();
    }
    $filtered_records = $stmt->fetchColumn();
    
    // Get records for display
    $start = $_POST['start'] ?? 0;
    $length = $_POST['length'] ?? 10;
    $order_column = $_POST['order'][0]['column'] ?? 0;
    $order_dir = $_POST['order'][0]['dir'] ?? 'desc';
    
    // Map column index to column name
    $columns = ['course_name', 'subject', 'class_level', 'description', 'status'];
    $order_by = $columns[$order_column] ?? 'created_at';
    
    $sql = "SELECT * FROM courses $where ORDER BY $order_by $order_dir LIMIT ?, ?";
    $stmt = $pdo->prepare($sql);
    
    if (!empty($params)) {
        $params[] = (int)$start;
        $params[] = (int)$length;
        $stmt->execute($params);
    } else {
        $stmt->execute([(int)$start, (int)$length]);
    }
    
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format data for DataTables
    $data = [];
    foreach ($courses as $course) {
        $data[] = [
            'course_name' => htmlspecialchars($course['course_name'] ?? ''),
            'subject' => htmlspecialchars($course['subject'] ?? ''),
            'class_level' => htmlspecialchars($course['class_level'] ?? ''),
            'description' => htmlspecialchars($course['description'] ?? ''),
            'status' => ucfirst($course['status'] ?? 'active'),
            'actions' => sprintf(
                '<button class="btn btn-sm btn-info view-course" data-id="%d"><i class="fe fe-eye"></i></button>
                <button class="btn btn-sm btn-primary edit-course" data-id="%d"><i class="fe fe-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-course" data-id="%d"><i class="fe fe-trash-2"></i></button>',
                $course['course_id'] ?? 0,
                $course['course_id'] ?? 0,
                $course['course_id'] ?? 0
            )
        ];
    }
    
    echo json_encode([
        'draw' => intval($_POST['draw'] ?? 1),
        'recordsTotal' => $total_records,
        'recordsFiltered' => $filtered_records,
        'data' => $data
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['error' => 'Database error occurred']);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode(['error' => 'An error occurred']);
} 