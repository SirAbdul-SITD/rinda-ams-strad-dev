<?php
require '../settings.php';
require '../vendor/autoload.php'; // Make sure you have PhpSpreadsheet installed

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$month = $_GET['month'] ?? '';
$type = $_GET['type'] ?? 'summary';

if (empty($month)) {
    die('Month is required');
}

try {
    // Create new spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set document properties
    $spreadsheet->getProperties()
        ->setCreator('Rinda AMS')
        ->setLastModifiedBy('Rinda AMS')
        ->setTitle('Payroll Report - ' . date('F Y', strtotime($month)))
        ->setSubject('Payroll Report')
        ->setDescription('Payroll report generated on ' . date('Y-m-d H:i:s'));
    
    // Set headers based on report type
    switch ($type) {
        case 'summary':
            $headers = ['Department', 'Total Staff', 'Total Basic Salary', 'Total Allowances', 'Total Deductions', 'Net Salary'];
            $query = "SELECT 
                        d.department,
                        COUNT(DISTINCT p.staff_id) as total_staff,
                        SUM(p.basic_salary) as total_basic,
                        SUM(p.total_allowances) as total_allowances,
                        SUM(p.total_deductions) as total_deductions,
                        SUM(p.net_salary) as net_salary
                     FROM payroll p
                     JOIN staffs s ON p.staff_id = s.id
                     JOIN departments d ON s.department_id = d.id
                     WHERE DATE_FORMAT(p.payment_date, '%Y-%m') = ?
                     GROUP BY d.department
                     ORDER BY d.department";
            break;
            
        case 'detailed':
            $headers = ['Employee ID', 'Name', 'Department', 'Basic Salary', 'Allowances', 'Deductions', 'Net Salary', 'Payment Date', 'Status'];
            $query = "SELECT 
                        s.employee_id,
                        CONCAT(s.first_name, ' ', s.last_name) as name,
                        d.department,
                        p.basic_salary,
                        p.total_allowances,
                        p.total_deductions,
                        p.net_salary,
                        p.payment_date,
                        p.status
                     FROM payroll p
                     JOIN staffs s ON p.staff_id = s.id
                     JOIN departments d ON s.department_id = d.id
                     WHERE DATE_FORMAT(p.payment_date, '%Y-%m') = ?
                     ORDER BY d.department, s.employee_id";
            break;
            
        case 'department':
            $headers = ['Employee ID', 'Name', 'Designation', 'Basic Salary', 'Allowances', 'Deductions', 'Net Salary', 'Payment Date', 'Status'];
            $query = "SELECT 
                        s.employee_id,
                        CONCAT(s.first_name, ' ', s.last_name) as name,
                        ds.designation,
                        p.basic_salary,
                        p.total_allowances,
                        p.total_deductions,
                        p.net_salary,
                        p.payment_date,
                        p.status
                     FROM payroll p
                     JOIN staffs s ON p.staff_id = s.id
                     JOIN departments d ON s.department_id = d.id
                     JOIN designations ds ON s.designation_id = ds.id
                     WHERE DATE_FORMAT(p.payment_date, '%Y-%m') = ?
                     ORDER BY s.employee_id";
            break;
            
        default:
            die('Invalid report type');
    }
    
    // Set column headers
    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($column . '1', $header);
        $sheet->getColumnDimension($column)->setAutoSize(true);
        $column++;
    }
    
    // Style the header row
    $headerStyle = [
        'font' => [
            'bold' => true,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'E2E3E5',
            ],
        ],
    ];
    $sheet->getStyle('A1:' . chr(ord($column) - 1) . '1')->applyFromArray($headerStyle);
    
    // Get data
    $stmt = $pdo->prepare($query);
    $stmt->execute([$month]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add data to spreadsheet
    $row = 2;
    foreach ($data as $record) {
        $column = 'A';
        foreach ($record as $value) {
            // Format currency values
            if (in_array($value, ['basic_salary', 'total_allowances', 'total_deductions', 'net_salary'])) {
                $value = number_format($value, 2);
            }
            // Format date values
            elseif (strtotime($value) !== false) {
                $value = date('Y-m-d', strtotime($value));
            }
            $sheet->setCellValue($column . $row, $value);
            $column++;
        }
        $row++;
    }
    
    // Add totals row for summary report
    if ($type === 'summary') {
        $lastRow = $row - 1;
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->setCellValue('C' . $row, '=SUM(C2:C' . $lastRow . ')');
        $sheet->setCellValue('D' . $row, '=SUM(D2:D' . $lastRow . ')');
        $sheet->setCellValue('E' . $row, '=SUM(E2:E' . $lastRow . ')');
        $sheet->setCellValue('F' . $row, '=SUM(F2:F' . $lastRow . ')');
        
        // Style the totals row
        $sheet->getStyle('A' . $row . ':F' . $row)->getFont()->setBold(true);
    }
    
    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="payroll_report_' . $month . '_' . $type . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    // Save file to PHP output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    
} catch (Exception $e) {
    die('Error generating report: ' . $e->getMessage());
} 