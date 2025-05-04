<?php
require_once '../settings.php';

// Get last admission number and increment
$sqlCheckAdmission = "SELECT admission_no FROM `students` ORDER BY `students`.`id` DESC LIMIT 1";
$stmtCheckAdmission = $pdo->prepare($sqlCheckAdmission);
$stmtCheckAdmission->execute();
$existingAdmissions = $stmtCheckAdmission->fetch(PDO::FETCH_ASSOC);

if ($existingAdmissions) {
    $last_admission_no = $existingAdmissions['admission_no'];
} else {
    $last_admission_no = "GHA/2017/0000";
}

$prefix = "GHA/2017/";
$numeric_part = substr($last_admission_no, strlen($prefix)); // Get the numeric part
$numeric_part = (int)$numeric_part + 1; // Increment
$numeric_part = str_pad($numeric_part, 4, '0', STR_PAD_LEFT); // Pad with leading zeros
$new_admission_no = $prefix . $numeric_part;
