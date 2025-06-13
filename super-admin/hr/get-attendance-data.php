<?php
// Prevent any output before JSON response
ob_start();

require_once '../settings.php';

// Set proper headers
header('Content-Type: application/json');

// Get parameters from DataTables
$draw = $_GET['draw'] ?? 1;
$start = $_GET['start'] ?? 0;
$length = $_GET['length'] ?? 10;
$search = $_GET['search'] ?? '';
$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;
$department_id = $_GET['department_id'] ?? null;
$status = $_GET['status'] ?? null;

try {
    // Build the base query
    $query = "SELECT a.*, s.first_name, s.last_name, d.department 
              FROM staffs_attendance a 
              JOIN staffs s ON a.staff_id = s.id 
              LEFT JOIN departments d ON s.department_id = d.id 
              WHERE 1=1";
    $params = [];

    // Add search condition
    if (!empty($search)) {
        $query .= " AND (s.first_name LIKE ? OR s.last_name LIKE ? OR d.department LIKE ?)";
        $searchParam = "%$search%";
        $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
    }

    // Add date range condition
    if ($start_date && $end_date) {
        $query .= " AND a.date BETWEEN ? AND ?";
        $params = array_merge($params, [$start_date, $end_date]);
    }

    // Add department filter
    if ($department_id) {
        $query .= " AND s.department_id = ?";
        $params[] = $department_id;
    }

    // Add status filter
    if ($status) {
        $query .= " AND a.status = ?";
        $params[] = $status;
    }

    // Get total records count
    $countQuery = str_replace("a.*, s.first_name, s.last_name, d.department", "COUNT(*) as total", $query);
    $stmt = $pdo->prepare($countQuery);
    $stmt->execute($params);
    $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Add ordering and limit
    $query .= " ORDER BY a.date DESC, s.first_name LIMIT ?, ?";
    $params = array_merge($params, [(int)$start, (int)$length]);

    // Execute the main query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for DataTables
    $formattedData = [];
    foreach ($data as $row) {
        $status_class = '';
        switch (strtolower($row['status'])) {
            case 'present':
                $status_class = 'status-present';
                break;
            case 'absent':
                $status_class = 'status-absent';
                break;
            case 'late':
                $status_class = 'status-late';
                break;
            case 'half-day':
                $status_class = 'status-half-day';
                break;
        }

        $formattedData[] = [
            'date' => date('M d, Y', strtotime($row['date'])),
            'employee' => htmlspecialchars($row['first_name'] . ' ' . $row['last_name']),
            'department' => htmlspecialchars($row['department'] ?? ''),
            'status' => '<span class="attendance-status ' . $status_class . '">' . ucfirst($row['status']) . '</span>',
            'check_in' => $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-',
            'check_out' => $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-',
            'working_hours' => isset($row['working_hours']) && $row['working_hours'] ? $row['working_hours'] . ' hrs' : '-',
            'actions' => '<button class="btn btn-sm btn-outline-primary edit-attendance" 
                        data-id="' . $row['id'] . '"
                        data-staff="' . $row['staff_id'] . '"
                        data-date="' . $row['date'] . '"
                        data-status="' . $row['status'] . '"
                        data-checkin="' . $row['check_in'] . '"
                        data-checkout="' . $row['check_out'] . '">
                        <i class="fe fe-edit"></i>
                        </button>'
        ];
    }

    // Clear any output buffer
    ob_clean();

    // Return JSON response
    echo json_encode([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $formattedData
    ]);

} catch (PDOException $e) {
    // Log the error
    error_log("Database Error: " . $e->getMessage());
    
    // Clear any output buffer
    ob_clean();
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'An error occurred while fetching attendance data'
    ]);
}

// End output buffering and flush
ob_end_flush(); 