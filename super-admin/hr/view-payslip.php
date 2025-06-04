<?php
require '../settings.php';

$payroll_id = $_GET['id'] ?? '';

if (empty($payroll_id)) {
    die('Payroll ID is required');
}

try {
    // Get payroll details with staff information
    $query = "SELECT p.*, s.first_name, s.last_name, s.employee_id, 
                     d.department, ds.designation
              FROM payroll p
              JOIN staffs s ON p.staff_id = s.id
              JOIN departments d ON s.department_id = d.id
              JOIN designations ds ON s.designation_id = ds.id
              WHERE p.id = ?";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$payroll_id]);
    $payroll = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$payroll) {
        die('Payroll record not found');
    }
    
    // Get allowances details
    $allowances_query = "SELECT sa.*, a.name as allowance_name
                        FROM staff_allowances sa
                        JOIN allowances a ON sa.allowance_id = a.id
                        WHERE sa.staff_id = ? AND sa.status = 'active'";
    $allowances_stmt = $pdo->prepare($allowances_query);
    $allowances_stmt->execute([$payroll['staff_id']]);
    $allowances = $allowances_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get deductions details
    $deductions_query = "SELECT sd.*, d.name as deduction_name
                        FROM staff_deductions sd
                        JOIN deductions d ON sd.deduction_id = d.id
                        WHERE sd.staff_id = ? AND sd.status = 'active'";
    $deductions_stmt = $pdo->prepare($deductions_query);
    $deductions_stmt->execute([$payroll['staff_id']]);
    $deductions = $deductions_stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - <?= $payroll['first_name'] . ' ' . $payroll['last_name'] ?></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .payslip {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .company-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .employee-info {
            margin-bottom: 30px;
        }
        .salary-details {
            margin-bottom: 30px;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            .payslip {
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="payslip">
        <div class="company-header">
            <h2>Rinda AMS</h2>
            <p>123 Business Street, City, Country</p>
            <h3>PAYSLIP</h3>
        </div>
        
        <div class="employee-info">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Employee ID:</strong> <?= $payroll['employee_id'] ?></p>
                    <p><strong>Name:</strong> <?= $payroll['first_name'] . ' ' . $payroll['last_name'] ?></p>
                    <p><strong>Department:</strong> <?= $payroll['department'] ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <p><strong>Designation:</strong> <?= $payroll['designation'] ?></p>
                    <p><strong>Payment Date:</strong> <?= date('F d, Y', strtotime($payroll['payment_date'])) ?></p>
                    <p><strong>Status:</strong> <?= ucfirst($payroll['status']) ?></p>
                </div>
            </div>
        </div>
        
        <div class="salary-details">
            <h4>Salary Details</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-right">$<?= number_format($payroll['basic_salary'], 2) ?></td>
                    </tr>
                    
                    <?php if (!empty($allowances)): ?>
                        <tr>
                            <td colspan="2" class="bg-light"><strong>Allowances</strong></td>
                        </tr>
                        <?php foreach ($allowances as $allowance): ?>
                            <tr>
                                <td><?= $allowance['allowance_name'] ?></td>
                                <td class="text-right">$<?= number_format($allowance['amount'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($deductions)): ?>
                        <tr>
                            <td colspan="2" class="bg-light"><strong>Deductions</strong></td>
                        </tr>
                        <?php foreach ($deductions as $deduction): ?>
                            <tr>
                                <td><?= $deduction['deduction_name'] ?></td>
                                <td class="text-right">$<?= number_format($deduction['amount'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <tr class="total-row">
                        <td>Total Allowances</td>
                        <td class="text-right">$<?= number_format($payroll['total_allowances'], 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td>Total Deductions</td>
                        <td class="text-right">$<?= number_format($payroll['total_deductions'], 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td>Net Salary</td>
                        <td class="text-right">$<?= number_format($payroll['net_salary'], 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="footer">
            <p>This is a computer-generated document and does not require a signature.</p>
            <p>Generated on: <?= date('F d, Y H:i:s') ?></p>
        </div>
        
        <div class="text-center mt-4 no-print">
            <button class="btn btn-primary" onclick="window.print()">Print Payslip</button>
            <a href="payroll.php" class="btn btn-secondary">Back to Payroll</a>
        </div>
    </div>
</body>
</html> 