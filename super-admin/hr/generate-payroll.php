<?php
require '../settings.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$month = $_POST['month'] ?? '';
$payment_date = $_POST['payment_date'] ?? '';
$department = $_POST['department'] ?? '';

if (empty($month) || empty($payment_date)) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Get staff members based on department filter
    $staff_query = "SELECT s.*, d.department, ds.salary as basic_salary 
                   FROM staffs s 
                   JOIN departments d ON s.department_id = d.id 
                   JOIN designations ds ON s.designation_id = ds.id 
                   WHERE s.status = 'active'";
    
    if (!empty($department)) {
        $staff_query .= " AND s.department_id = ?";
    }
    
    $stmt = $pdo->prepare($staff_query);
    if (!empty($department)) {
        $stmt->execute([$department]);
    } else {
        $stmt->execute();
    }
    
    $staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $generated_count = 0;
    foreach ($staff_members as $staff) {
        // Check if payroll already exists for this staff member and month
        $check_query = "SELECT id FROM payroll 
                       WHERE staff_id = ? 
                       AND DATE_FORMAT(payment_date, '%Y-%m') = ?";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute([$staff['id'], $month]);
        
        if ($check_stmt->rowCount() > 0) {
            continue; // Skip if payroll already exists
        }
        
        // Calculate allowances
        $allowances_query = "SELECT SUM(amount) as total 
                           FROM staff_allowances 
                           WHERE staff_id = ? 
                           AND status = 'active'";
        $allowances_stmt = $pdo->prepare($allowances_query);
        $allowances_stmt->execute([$staff['id']]);
        $total_allowances = $allowances_stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        
        // Calculate deductions
        $deductions_query = "SELECT SUM(amount) as total 
                           FROM staff_deductions 
                           WHERE staff_id = ? 
                           AND status = 'active'";
        $deductions_stmt = $pdo->prepare($deductions_query);
        $deductions_stmt->execute([$staff['id']]);
        $total_deductions = $deductions_stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        
        // Calculate net salary
        $net_salary = $staff['basic_salary'] + $total_allowances - $total_deductions;
        
        // Insert payroll record
        $insert_query = "INSERT INTO payroll (
            staff_id, 
            basic_salary, 
            total_allowances, 
            total_deductions, 
            net_salary, 
            payment_date, 
            status, 
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";
        
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute([
            $staff['id'],
            $staff['basic_salary'],
            $total_allowances,
            $total_deductions,
            $net_salary,
            $payment_date
        ]);
        
        $generated_count++;
    }
    
    // Commit transaction
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => "Successfully generated payroll for $generated_count staff members"
    ]);
    
} catch (PDOException $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error generating payroll: ' . $e->getMessage()
    ]);
} 