<?php
require_once '../settings.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Log incoming data
    error_log("Received POST data: " . print_r($_POST, true));

    // Validate required fields
    if (!isset($_POST['date']) || empty($_POST['date'])) {
        throw new Exception('Date is required');
    }

    if (!isset($_POST['staff_ids']) || !is_array($_POST['staff_ids'])) {
        throw new Exception('Staff data is required');
    }

    // Start transaction
    $pdo->beginTransaction();

    $date = $_POST['date'];
    $staff_ids = $_POST['staff_ids'];
    $statuses = $_POST['status'] ?? [];
    $check_ins = $_POST['check_in'] ?? [];
    $check_outs = $_POST['check_out'] ?? [];
    $attendance_id = $_POST['attendance_id'] ?? null;

    // Function to calculate working hours
    function calculateWorkingHours($check_in, $check_out) {
        if (!$check_in || !$check_out) {
            return null;
        }
        
        $check_in_time = strtotime($check_in);
        $check_out_time = strtotime($check_out);
        
        if ($check_in_time === false || $check_out_time === false) {
            return null;
        }
        
        $diff = $check_out_time - $check_in_time;
        return round($diff / 3600, 2); // Convert seconds to hours
    }

    // If editing existing attendance
    if ($attendance_id) {
        // Validate attendance record exists
        $check_stmt = $pdo->prepare("SELECT id FROM staffs_attendance WHERE id = ?");
        $check_stmt->execute([$attendance_id]);
        if (!$check_stmt->fetch()) {
            throw new Exception('Attendance record not found');
        }

        $status = $statuses[$attendance_id] ?? 'absent';
        $check_in = ($status === 'absent') ? null : ($check_ins[$attendance_id] ?? null);
        $check_out = ($status === 'absent') ? null : ($check_outs[$attendance_id] ?? null);
        $working_hours = calculateWorkingHours($check_in, $check_out);

        $stmt = $pdo->prepare("UPDATE staffs_attendance SET 
            status = ?, 
            check_in = ?, 
            check_out = ?
            WHERE id = ?");
        
        $stmt->execute([
            $status,
            $check_in,
            $check_out,
            $attendance_id
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception('Failed to update attendance record');
        }
    } else {
        // Insert new attendance records
        $stmt = $pdo->prepare("INSERT INTO staffs_attendance 
            (staff_id, date, status, check_in, check_out) 
            VALUES (?, ?, ?, ?, ?)");

        foreach ($staff_ids as $staff_id) {
            // Validate staff exists
            $check_stmt = $pdo->prepare("SELECT id FROM staffs WHERE id = ?");
            $check_stmt->execute([$staff_id]);
            if (!$check_stmt->fetch()) {
                throw new Exception("Staff ID {$staff_id} not found");
            }

            $status = $statuses[$staff_id] ?? 'absent';
            
            // For absent status, set check-in and check-out to null
            if ($status === 'absent') {
                $check_in = null;
                $check_out = null;
            } else {
                $check_in = $check_ins[$staff_id] ?? null;
                $check_out = $check_outs[$staff_id] ?? null;

                // Validate time format if provided
                if ($check_in && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $check_in)) {
                    throw new Exception("Invalid check-in time format for staff ID {$staff_id}");
                }
                if ($check_out && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $check_out)) {
                    throw new Exception("Invalid check-out time format for staff ID {$staff_id}");
                }
            }

            $stmt->execute([
                $staff_id,
                $date,
                $status,
                $check_in,
                $check_out
            ]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Failed to insert attendance record for staff ID {$staff_id}");
            }
        }
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Attendance saved successfully'
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log the error
    error_log("Attendance save error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 