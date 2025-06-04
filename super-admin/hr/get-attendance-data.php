<?php
require_once '../settings.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Get filter parameters
    $start_date = $_GET['start_date'] ?? null;
    $end_date = $_GET['end_date'] ?? null;
    $department_id = $_GET['department_id'] ?? null;
    $status = $_GET['status'] ?? null;

    // Build the base query
    $query = "SELECT a.*, s.first_name, s.last_name, d.department 
              FROM staffs_attendance a 
              JOIN staffs s ON a.staff_id = s.id 
              LEFT JOIN departments d ON s.department_id = d.id 
              WHERE 1=1";
    $params = [];

    // Add filters
    if ($start_date) {
        $query .= " AND a.date >= ?";
        $params[] = $start_date;
    }
    if ($end_date) {
        $query .= " AND a.date <= ?";
        $params[] = $end_date;
    }
    if ($department_id) {
        $query .= " AND s.department_id = ?";
        $params[] = $department_id;
    }
    if ($status) {
        $query .= " AND a.status = ?";
        $params[] = $status;
    }

    // Add ordering
    $query .= " ORDER BY a.date DESC, s.first_name";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for DataTables
    $formatted_data = [];
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

        $formatted_data[] = [
            'date' => date('M d, Y', strtotime($row['date'])),
            'employee' => htmlspecialchars($row['first_name'] . ' ' . $row['last_name']),
            'department' => htmlspecialchars($row['department']),
            'status' => '<span class="attendance-status ' . $status_class . '">' . ucfirst($row['status']) . '</span>',
            'check_in' => $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-',
            'check_out' => $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-',
            'working_hours' => $row['working_hours'] ? $row['working_hours'] . ' hrs' : '-',
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

    echo json_encode([
        'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 1,
        'recordsTotal' => count($formatted_data),
        'recordsFiltered' => count($formatted_data),
        'data' => $formatted_data
    ]);

} catch (Exception $e) {
    error_log("Error in get-attendance-data.php: " . $e->getMessage());
    echo json_encode([
        'error' => true,
        'message' => 'An error occurred while fetching attendance data'
    ]);
} 