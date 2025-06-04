<?php
require_once '../settings.php';

try {
    // Get existing departments
    $stmt = $pdo->query("SELECT id, department FROM departments");
    $existing_departments = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    if (empty($existing_departments)) {
        throw new Exception("No departments found. Please add departments first.");
    }

    // Add sample staff
    $staff = [
        [
            'John', 'Doe', 'Male', '1990-05-15', 'john.doe@example.com', array_key_first($existing_departments),
            'Single', '1234567890', '9876543210', '123 Main St', '456 Home St',
            'B.Tech Computer Science', '5 years', 50000.00, 'Permanent'
        ],
        [
            'Jane', 'Smith', 'Female', '1988-08-20', 'jane.smith@example.com', array_key_first($existing_departments),
            'Married', '2345678901', '8765432109', '789 Work St', '321 Home St',
            'MBA HR', '8 years', 45000.00, 'Permanent'
        ],
        [
            'Mike', 'Johnson', 'Male', '1995-03-10', 'mike.j@example.com', array_key_first($existing_departments),
            'Single', '3456789012', '7654321098', '456 Office St', '789 Home St',
            'M.Com', '3 years', 40000.00, 'Contract'
        ]
    ];

    $stmt = $pdo->prepare("
        INSERT INTO staffs (
            first_name, last_name, gender, dob, email, department_id,
            marital_status, mobile_number, emergency_contact, current_address, permanent_address,
            qualifications, experience, salary, contract_type, status, created_at
        ) VALUES (
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, 1, NOW()
        )
    ");

    foreach ($staff as $employee) {
        $stmt->execute($employee);
    }

    // Add sample attendance records
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    
    $attendance = [
        [1, $today, 'present', '09:00:00', '17:00:00'],
        [2, $today, 'present', '08:55:00', '17:05:00'],
        [3, $today, 'late', '09:15:00', '17:30:00'],
        [1, $yesterday, 'present', '09:00:00', '17:00:00'],
        [2, $yesterday, 'absent', null, null],
        [3, $yesterday, 'present', '09:00:00', '17:00:00']
    ];

    $stmt = $pdo->prepare("
        INSERT INTO staffs_attendance (staff_id, date, status, check_in, check_out)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($attendance as $record) {
        $stmt->execute($record);
    }

    // Add sample leave applications
    $leaves = [
        [1, 1, '2024-03-20', '2024-03-22', 'Family emergency', 'approved'],
        [2, 1, '2024-03-25', '2024-03-26', 'Medical appointment', 'pending'],
        [3, 1, '2024-03-15', '2024-03-15', 'Personal work', 'approved']
    ];

    $stmt = $pdo->prepare("
        INSERT INTO leave_applications (
            staff_id, category_id, start_date, end_date, explanatory_note, status, create_datetime
        ) VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");

    foreach ($leaves as $leave) {
        $stmt->execute($leave);
    }

    echo "Sample data added successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 