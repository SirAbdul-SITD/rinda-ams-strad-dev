<?php
require_once '../settings.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Get filter parameters
    $start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
    $end_date = $_GET['end_date'] ?? date('Y-m-d');
    $department_id = $_GET['department_id'] ?? '';
    $status = $_GET['status'] ?? '';

    // Build the query
    $query = "SELECT 
                a.date,
                s.first_name,
                s.last_name,
                d.department,
                a.status,
                a.check_in,
                a.check_out,
                TIMESTAMPDIFF(HOUR, a.check_in, a.check_out) as working_hours
              FROM staffs_attendance a
              JOIN staffs s ON a.staff_id = s.id
              LEFT JOIN departments d ON s.department_id = d.id
              WHERE a.date BETWEEN ? AND ?";

    $params = [$start_date, $end_date];

    if ($department_id) {
        $query .= " AND s.department_id = ?";
        $params[] = $department_id;
    }

    if ($status) {
        $query .= " AND a.status = ?";
        $params[] = $status;
    }

    $query .= " ORDER BY a.date DESC, s.first_name, s.last_name";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set headers for Excel download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="attendance_report.xls"');
    header('Cache-Control: max-age=0');

    // Output Excel content
    echo "Attendance Report\n";
    echo "Period: " . date('M d, Y', strtotime($start_date)) . " to " . date('M d, Y', strtotime($end_date)) . "\n\n";

    // Headers
    echo "Date\tEmployee Name\tDepartment\tStatus\tCheck In\tCheck Out\tWorking Hours\n";

    // Data rows
    foreach ($attendance_data as $row) {
        echo date('M d, Y', strtotime($row['date'])) . "\t";
        echo $row['first_name'] . ' ' . $row['last_name'] . "\t";
        echo $row['department'] . "\t";
        echo ucfirst($row['status']) . "\t";
        echo ($row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-') . "\t";
        echo ($row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-') . "\t";
        echo ($row['working_hours'] ? $row['working_hours'] . ' hrs' : '-') . "\n";
    }

} catch (Exception $e) {
    // Log the error
    error_log("Attendance report error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());

    // Return error response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error generating report: ' . $e->getMessage()
    ]);
} 