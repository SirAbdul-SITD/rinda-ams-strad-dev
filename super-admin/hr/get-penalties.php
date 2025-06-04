<?php
require_once '../settings.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log errors with more details
function logError($message, $context = []) {
    $logMessage = date('Y-m-d H:i:s') . " - " . $message;
    if (!empty($context)) {
        $logMessage .= " - Context: " . json_encode($context);
    }
    error_log($logMessage);
}

try {
    // Get parameters from DataTables
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    $order_column = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 5;
    $order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';

    // Log request parameters
    logError("Request parameters", [
        'draw' => $draw,
        'start' => $start,
        'length' => $length,
        'search' => $search,
        'order_column' => $order_column,
        'order_dir' => $order_dir
    ]);

    // Define columns
    $columns = [
        'staff_name' => 'CONCAT(s.first_name, " ", s.last_name)',
        'department' => 'd.department',
        'type' => 'p.type',
        'description' => 'p.description',
        'amount' => 'p.amount',
        'date' => 'p.date',
        'status' => 'p.status'
    ];

    // Base query
    $query = "FROM penalties p 
              JOIN staffs s ON p.staff_id = s.id 
              LEFT JOIN departments d ON s.department_id = d.id";

    // Add search condition if search term exists
    $where = [];
    $params = [];
    if (!empty($search)) {
        $where[] = "(CONCAT(s.first_name, ' ', s.last_name) LIKE ? OR p.type LIKE ? OR p.description LIKE ? OR d.department LIKE ?)";
        $search_param = "%$search%";
        $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
    }

    // Add where clause if conditions exist
    if (!empty($where)) {
        $query .= " WHERE " . implode(' AND ', $where);
    }

    // Get total records
    $total_query = "SELECT COUNT(*) as total " . $query;
    logError("Total records query", ['query' => $total_query, 'params' => $params]);
    
    $stmt = $pdo->prepare($total_query);
    $stmt->execute($params);
    $total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get filtered records count
    $filtered_records = $total_records;

    // Add order by clause
    if (isset($columns[array_keys($columns)[$order_column]])) {
        $order_column_name = array_keys($columns)[$order_column];
        $query .= " ORDER BY " . $columns[$order_column_name] . " " . $order_dir;
    } else {
        // Default ordering if column index is invalid
        $query .= " ORDER BY p.date DESC";
    }

    // Add limit clause - using integers directly instead of placeholders
    $query .= " LIMIT " . (int)$start . ", " . (int)$length;

    // Get filtered records
    $data_query = "SELECT p.id, 
                          p.staff_id,
                          CONCAT(s.first_name, ' ', s.last_name) as staff_name,
                          d.department,
                          p.type,
                          p.description,
                          p.amount,
                          p.date,
                          p.status " . $query;

    logError("Data query", ['query' => $data_query, 'params' => $params]);

    $stmt = $pdo->prepare($data_query);
    $stmt->execute($params);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare response
    $response = [
        "draw" => $draw,
        "recordsTotal" => $total_records,
        "recordsFiltered" => $filtered_records,
        "data" => $records
    ];

    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    // Log detailed error information
    logError("Database error", [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
    
    // Send error response with more details
    header('Content-Type: application/json');
    echo json_encode([
        "draw" => isset($draw) ? $draw : 1,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => "Database error: " . $e->getMessage()
    ]);
} catch (Exception $e) {
    // Log detailed error information
    logError("General error", [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
    
    // Send error response with more details
    header('Content-Type: application/json');
    echo json_encode([
        "draw" => isset($draw) ? $draw : 1,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => "Error: " . $e->getMessage()
    ]);
} 