<?php
require_once '../settings.php'; // your PDO connection

$response = ['success' => false, 'message' => 'Unknown error occurred'];

try {
    // Sanitize inputs
    $subject = trim($_POST['subject'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $startDate = $_POST['start_date'] ?? null;
    $endDate = $_POST['end_date'] ?? null;

    if (empty($subject) || empty($content) || empty($startDate)) {
        throw new Exception("Subject, content, and start date are required.");
    }

    // Convert checkboxes to booleans (1 or 0)
    $notifyParents = isset($_POST['toggleParents']) ? 1 : 0;
    $notifyParentsEmail = isset($_POST['parentEmail']) ? 1 : 0;
    $notifyParentsWhatsApp = isset($_POST['parentWhatsApp']) ? 1 : 0;
    $notifyParentsSMS = isset($_POST['parentSMS']) ? 1 : 0;

    $notifyStaff = isset($_POST['toggleStaffs']) ? 1 : 0;
    $notifyStaffEmail = isset($_POST['staffEmail']) ? 1 : 0;
    $notifyStaffWhatsApp = isset($_POST['staffWhatsApp']) ? 1 : 0;
    $notifyStaffSMS = isset($_POST['staffSMS']) ? 1 : 0;

    // Prepare SQL insert
    $stmt = $pdo->prepare("
        INSERT INTO notices (
            subject, content, start_date, end_date,
            notify_parents, notify_parents_email, notify_parents_whatsapp, notify_parents_sms,
            notify_staff, notify_staff_email, notify_staff_whatsapp, notify_staff_sms
        ) VALUES (
            :subject, :content, :start_date, :end_date,
            :notify_parents, :notify_parents_email, :notify_parents_whatsapp, :notify_parents_sms,
            :notify_staff, :notify_staff_email, :notify_staff_whatsapp, :notify_staff_sms
        )
    ");

    $stmt->execute([
        'subject' => $subject,
        'content' => $content,
        'start_date' => $startDate,
        'end_date' => $endDate ?: null,
        'notify_parents' => $notifyParents,
        'notify_parents_email' => $notifyParentsEmail,
        'notify_parents_whatsapp' => $notifyParentsWhatsApp,
        'notify_parents_sms' => $notifyParentsSMS,
        'notify_staff' => $notifyStaff,
        'notify_staff_email' => $notifyStaffEmail,
        'notify_staff_whatsapp' => $notifyStaffWhatsApp,
        'notify_staff_sms' => $notifyStaffSMS,
    ]);

    $response = ['success' => true, 'message' => 'Notice added successfully!'];

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
