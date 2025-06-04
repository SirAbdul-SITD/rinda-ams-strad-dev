<?php
require '../settings.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if month and report type are provided
if (!isset($_GET['month']) || !isset($_GET['report_type'])) {
    die('Missing required parameters');
}

$month = $_GET['month'];
$report_type = $_GET['report_type'];

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator('Rinda AMS')
    ->setLastModifiedBy('Rinda AMS')
    ->setTitle('Penalty Report - ' . date('F Y', strtotime($month)))
    ->setSubject('Penalty Report')
    ->setDescription('Penalty report generated on ' . date('Y-m-d H:i:s'));

// Set headers
$sheet->setCellValue('A1', 'Employee Name');
$sheet->setCellValue('B1', 'Department');
$sheet->setCellValue('C1', 'Type');
$sheet->setCellValue('D1', 'Description');
$sheet->setCellValue('E1', 'Amount');
$sheet->setCellValue('F1', 'Date');
$sheet->setCellValue('G1', 'Status');
$sheet->setCellValue('H1', 'Created At');
$sheet->setCellValue('I1', 'Resolved At');

// Style the header row
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4A90E2'],
    ],
];
$sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

// Build the query based on report type
$query = "SELECT p.*, s.first_name, s.last_name, d.department 
          FROM penalties p 
          JOIN staffs s ON p.staff_id = s.id 
          JOIN departments d ON s.department_id = d.id 
          WHERE DATE_FORMAT(p.date, '%Y-%m') = ?";

if ($report_type === 'active') {
    $query .= " AND p.status = 'active'";
} elseif ($report_type === 'pending') {
    $query .= " AND p.status = 'pending'";
} elseif ($report_type === 'resolved') {
    $query .= " AND p.status = 'resolved'";
}

$query .= " ORDER BY p.date DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$month]);
    $penalties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add data rows
    $row = 2;
    foreach ($penalties as $penalty) {
        $sheet->setCellValue('A' . $row, $penalty['first_name'] . ' ' . $penalty['last_name']);
        $sheet->setCellValue('B' . $row, $penalty['department']);
        $sheet->setCellValue('C' . $row, ucfirst($penalty['type']));
        $sheet->setCellValue('D' . $row, $penalty['description']);
        $sheet->setCellValue('E' . $row, $penalty['amount']);
        $sheet->setCellValue('F' . $row, date('M d, Y', strtotime($penalty['date'])));
        $sheet->setCellValue('G' . $row, ucfirst($penalty['status']));
        $sheet->setCellValue('H' . $row, date('M d, Y H:i', strtotime($penalty['created_at'])));
        $sheet->setCellValue('I' . $row, $penalty['resolved_at'] ? date('M d, Y H:i', strtotime($penalty['resolved_at'])) : '');
        $row++;
    }

    // Auto-size columns
    foreach (range('A', 'I') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="penalty_report_' . $month . '_' . $report_type . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Save file to PHP output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} catch (PDOException $e) {
    die('Error generating report: ' . $e->getMessage());
} 