<?php
require_once '../settings.php';



// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_event':
                addEvent($pdo);
                break;
            case 'update_event':
                updateEvent($pdo);
                break;
            case 'delete_event':
                deleteEvent($pdo);
                break;
        }
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'edit_event':
            editEvent($pdo);
            break;
    }
}

// Function to add a new event
function addEvent($pdo) {
    $data = sanitizeInput($_POST);

    // Debug logging
    error_log("POST data: " . print_r($_POST, true));

    // Validate event type
    $validEventTypes = ['class', 'exam', 'holiday', 'meeting', 'online', 'other'];
    $eventType = in_array($data['event_type'], $validEventTypes) ? $data['event_type'] : 'other';
    
    try {
        $pdo->beginTransaction();
        
        // Handle notice
        $isNotice = isset($_POST['is_notice']) ? 1 : 0;
        
        // Insert into academic_calendar
        $stmt = $pdo->prepare("INSERT INTO academic_calendar 
                              (title, subject, event_type, start_date, end_date, start_time, end_time, 
                               all_day, is_online, meeting_link, location, description, is_notice) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $allDay = isset($data['all_day']) ? 1 : 0;
        $isOnline = isset($data['is_online']) ? 1 : 0;
        
        $stmt->execute([
            $data['title'],
            $data['subject'] ?? null,
            $eventType,
            $data['start_date'],
            $data['end_date'] ?: $data['start_date'],
            $allDay ? null : ($data['start_time'] ?? null),
            $allDay ? null : ($data['end_time'] ?? null),
            $allDay,
            $isOnline,
            $isOnline ? ($data['meeting_link'] ?? null) : null,
            $isOnline ? null : ($data['location'] ?? null),
            $data['description'] ?? null,
            $isNotice
        ]);
        
        $eventId = $pdo->lastInsertId();
        
        // If it's a notice, also insert into notices table
        if ($isNotice) {
            // Get selected readers
            $students = isset($_POST['readers']) && in_array('students', $_POST['readers']) ? 1 : 0;
            $staffs = isset($_POST['readers']) && in_array('staffs', $_POST['readers']) ? 1 : 0;
            $parents = isset($_POST['readers']) && in_array('parents', $_POST['readers']) ? 1 : 0;
            
            $stmt = $pdo->prepare("INSERT INTO notices 
                                  (title, subject, content, start_date, end_date, students, staffs, parents, 
                                   posted_by, date_posted, event_id) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            
            $stmt->execute([
                $data['title'],
                $data['subject'] ?? null,
                $data['description'] ?? '',
                $data['start_date'],
                $data['end_date'] ?: $data['start_date'],
                $students,
                $staffs,
                $parents,
                $_SESSION['user_name'] ?? 'Admin',
                $eventId
            ]);
        }
        
        $pdo->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event added successfully'];
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error in addEvent: " . $e->getMessage());
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Error adding event: ' . $e->getMessage()];
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Function to update an event
function updateEvent($pdo) {
    $data = sanitizeInput($_POST);
    
    // Validate event type
    $validEventTypes = ['class', 'exam', 'holiday', 'meeting', 'online', 'other'];
    $eventType = in_array($data['event_type'], $validEventTypes) ? $data['event_type'] : 'other';
    
    try {
        $pdo->beginTransaction();
        
        // Handle notice
        $isNotice = isset($_POST['is_notice']) ? 1 : 0;
        
        // Update academic_calendar
        $stmt = $pdo->prepare("UPDATE academic_calendar SET 
                              title = ?, subject = ?, event_type = ?, start_date = ?, end_date = ?, 
                              start_time = ?, end_time = ?, all_day = ?, is_online = ?, 
                              meeting_link = ?, location = ?, description = ?, is_notice = ? 
                              WHERE id = ?");
        
        $allDay = isset($data['all_day']) ? 1 : 0;
        $isOnline = isset($data['is_online']) ? 1 : 0;
        
        $stmt->execute([
            $data['title'],
            $data['subject'] ?? null,
            $eventType,
            $data['start_date'],
            $data['end_date'] ?: $data['start_date'],
            $allDay ? null : ($data['start_time'] ?? null),
            $allDay ? null : ($data['end_time'] ?? null),
            $allDay,
            $isOnline,
            $isOnline ? ($data['meeting_link'] ?? null) : null,
            $isOnline ? null : ($data['location'] ?? null),
            $data['description'] ?? null,
            $isNotice,
            $data['id']
        ]);
        
        // Handle notice in notices table
        if ($isNotice) {
            // Get selected readers
            $students = isset($_POST['readers']) && in_array('students', $_POST['readers']) ? 1 : 0;
            $staffs = isset($_POST['readers']) && in_array('staffs', $_POST['readers']) ? 1 : 0;
            $parents = isset($_POST['readers']) && in_array('parents', $_POST['readers']) ? 1 : 0;
            
            // Check if notice already exists
            $stmt = $pdo->prepare("SELECT id FROM notices WHERE event_id = ?");
            $stmt->execute([$data['id']]);
            $noticeId = $stmt->fetchColumn();
            
            if ($noticeId) {
                // Update existing notice
                $stmt = $pdo->prepare("UPDATE notices SET 
                                      title = ?, subject = ?, content = ?, start_date = ?, end_date = ?, 
                                      students = ?, staffs = ?, parents = ? 
                                      WHERE event_id = ?");
                
                $stmt->execute([
                    $data['title'],
                    $data['subject'] ?? null,
                    $data['description'] ?? '',
                    $data['start_date'],
                    $data['end_date'] ?: $data['start_date'],
                    $students,
                    $staffs,
                    $parents,
                    $data['id']
                ]);
            } else {
                // Insert new notice
                $stmt = $pdo->prepare("INSERT INTO notices 
                                      (title, subject, content, start_date, end_date, students, staffs, parents, 
                                       posted_by, date_posted, event_id) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
                
                $stmt->execute([
                    $data['title'],
                    $data['subject'] ?? null,
                    $data['description'] ?? '',
                    $data['start_date'],
                    $data['end_date'] ?: $data['start_date'],
                    $students,
                    $staffs,
                    $parents,
                    $_SESSION['user_name'] ?? 'Admin',
                    $data['id']
                ]);
            }
        } else {
            // Remove from notices if it was a notice before
            $stmt = $pdo->prepare("DELETE FROM notices WHERE event_id = ?");
            $stmt->execute([$data['id']]);
        }
        
        $pdo->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event updated successfully'];
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error in updateEvent: " . $e->getMessage());
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Error updating event: ' . $e->getMessage()];
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Function to delete an event
function deleteEvent($pdo) {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid event ID'];
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    try {
        $pdo->beginTransaction();
        
        // Delete from notices table first (using event_id)
        $stmt = $pdo->prepare("DELETE FROM notices WHERE event_id = ?");
        $stmt->execute([$_POST['id']]);
        
        // Then delete from academic_calendar
        $stmt = $pdo->prepare("DELETE FROM academic_calendar WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        
        $pdo->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event deleted successfully'];
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Error in deleteEvent: " . $e->getMessage());
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Error deleting event: ' . $e->getMessage()];
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Function to sanitize input data
function sanitizeInput($data) {
    $sanitized = [];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $sanitized[$key] = sanitizeInput($value);
        } else {
            $sanitized[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
    }
    return $sanitized;
}

// Function to get events for a specific date range
function getEvents($pdo, $startDate = null, $endDate = null) {
    $query = "SELECT * FROM academic_calendar WHERE 1=1";
    $params = [];
    
    if ($startDate) {
        $query .= " AND (start_date <= ? OR end_date >= ?)";
        $params[] = $endDate;
        $params[] = $startDate;
    }
    
    $query .= " ORDER BY start_date, start_time";
    
    try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $events;
    } catch (PDOException $e) {
        error_log("Error fetching events: " . $e->getMessage());
        return [];
    }
}

// Function to calculate term week number based on start date
function calculateTermWeek($date, $termStartDate) {
    $start = new DateTime($termStartDate);
    $current = new DateTime($date);
    $diff = $start->diff($current);
    $days = $diff->days;
    return floor($days / 7) + 1;
}

// Function to get term start date from first event
function getTermStartDate($pdo) {
    try {
        $stmt = $pdo->query("SELECT MIN(start_date) as first_date FROM academic_calendar");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['first_date'] ?: date('Y-m-d');
    } catch (PDOException $e) {
        return date('Y-m-d');
    }
}

// Function to get term duration in months
function getTermDuration($pdo) {
    try {
        $stmt = $pdo->query("SELECT value FROM settings WHERE setting_key = 'term_duration'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['value'] ?: 3; // Default to 3 months if not set
    } catch (PDOException $e) {
        return 3;
    }
}

// Get current date information
$currentDate = new DateTime();

// Handle week navigation
$weekOffset = isset($_GET['week']) ? intval($_GET['week']) : 0;
$currentDate->modify($weekOffset . ' weeks');

// Handle month navigation
$monthOffset = isset($_GET['month']) ? intval($_GET['month']) : 0;
$currentDate->modify($monthOffset . ' months');

$termStartDate = getTermStartDate($pdo);
$termDuration = getTermDuration($pdo);
$currentTermWeek = calculateTermWeek($currentDate->format('Y-m-d'), $termStartDate);

// Calculate term end date
$termEndDate = new DateTime($termStartDate);
$termEndDate->modify("+{$termDuration} months");

// Get the first day of the current week
$firstDayOfWeek = clone $currentDate;
$firstDayOfWeek->modify('this week');

// Get the last day of the current week
$lastDayOfWeek = clone $firstDayOfWeek;
$lastDayOfWeek->modify('+6 days');

// Get events for different views
$todayEvents = getEvents($pdo, $currentDate->format('Y-m-d'), $currentDate->format('Y-m-d'));
$monthEvents = getEvents($pdo, $currentDate->format('Y-m-01'), $currentDate->format('Y-m-t'));
$allEvents = getEvents($pdo);

// Get events for the current week
$weekEvents = getEvents($pdo, $firstDayOfWeek->format('Y-m-d'), $lastDayOfWeek->format('Y-m-d'));

// Function to get notices for a specific user type
function getNoticesByUserType($pdo, $userType) {
    try {
        $stmt = $pdo->prepare("SELECT n.*, ac.event_type, ac.start_time, ac.end_time, ac.all_day, ac.is_online, ac.meeting_link, ac.location 
                              FROM notices n 
                              LEFT JOIN academic_calendar ac ON n.event_id = ac.id 
                              WHERE n." . $userType . " = 1 
                              ORDER BY n.date_posted DESC");
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching notices: " . $e->getMessage());
        return [];
    }
}

// Function to get all notices (for admin)
function getAllNotices($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT n.*, ac.event_type, ac.start_time, ac.end_time, ac.all_day, ac.is_online, ac.meeting_link, ac.location 
                              FROM notices n 
                              LEFT JOIN academic_calendar ac ON n.event_id = ac.id 
                              ORDER BY n.date_posted DESC");
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching notices: " . $e->getMessage());
        return [];
    }
}

function editEvent($pdo) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid event ID']);
        exit();
    }
    
    try {
        // Get event details
        $stmt = $pdo->prepare("SELECT * FROM academic_calendar WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$event) {
            throw new Exception('Event not found');
        }
        
        // Get notice details if it's a notice
        if ($event['is_notice']) {
            $stmt = $pdo->prepare("SELECT students, staffs, parents FROM notices WHERE event_id = ?");
            $stmt->execute([$id]);
            $notice = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($notice) {
                $event['students'] = (int)$notice['students'];
                $event['staffs'] = (int)$notice['staffs'];
                $event['parents'] = (int)$notice['parents'];
            } else {
                $event['students'] = 0;
                $event['staffs'] = 0;
                $event['parents'] = 0;
            }
        }
        
        // Return event data as JSON
        header('Content-Type: application/json');
        echo json_encode($event);
        exit();
    } catch (Exception $e) {
        error_log("Error in editEvent: " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Academic Calendar">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Academic Calendar - Admin | Rinda AMS</title>
  
  <!-- Core CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
  <!-- Icons -->
  <link rel="stylesheet" href="../css/feather.css">
  
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <!-- Custom styles -->
  <style>
    .select2-container--default .select2-selection--multiple {
      border: 1px solid #d1d3e2;
      border-radius: 0.35rem;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
      border-color: #bac8f3;
      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #4e73df;
      border: none;
      color: #fff;
      border-radius: 3px;
      padding: 2px 8px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      color: #fff;
      margin-right: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #fff;
      background: rgba(255,255,255,0.2);
    }
    .tag-input-container {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 5px;
        min-height: 38px;
        background: #fff;
    }
    .tag-input-container:focus-within {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .tag-input-container .tag {
        display: inline-block;
        background: #4e73df;
        color: #fff;
        padding: 2px 8px;
        border-radius: 3px;
        margin: 2px;
        font-size: 0.875rem;
    }
    .tag-input-container .tag .remove-tag {
        margin-left: 5px;
        cursor: pointer;
        font-size: 0.875rem;
    }
    .tag-input-container .tag .remove-tag:hover {
        color: #fff;
        opacity: 0.8;
    }
    .tag-input-container select {
        border: none;
        outline: none;
        padding: 2px;
        margin: 2px;
        min-width: 100px;
    }
    .tag-input-container select:focus {
        outline: none;
    }
    .calendar-day {
        position: relative;
        min-height: 100px;
        padding: 3px;
        border: 1px solid #e3e6f0;
        font-size: 0.8rem;
    }

    .event-item {
        margin: 1px 0;
        padding: 2px 4px;
        border-radius: 3px;
        font-size: 0.75rem;
        cursor: pointer;
        background: #f8f9fc;
        border-left: 2px solid #4e73df;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-title {
        font-weight: 500;
        margin-bottom: 1px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-time {
        font-size: 0.7rem;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-count-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #4e73df;
        color: white;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        text-align: center;
        line-height: 16px;
        font-size: 0.7rem;
    }

    .event-class { border-left-color: #4e73df; }
    .event-exam { border-left-color: #e74a3b; }
    .event-holiday { border-left-color: #1cc88a; }
    .event-meeting { border-left-color: #f6c23e; }
    .event-online { border-left-color: #36b9cc; }
    .event-other { border-left-color: #858796; }

    .upcoming-event {
        background: #eaecf4;
    }

    .today {
        background: #f8f9fc;
        border: 2px solid #4e73df;
    }

    .past-day {
        background: #f8f9fc;
        opacity: 0.7;
    }

    .day-number {
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 2px;
        padding: 2px 4px;
        border-radius: 50%;
        display: inline-block;
    }

    .day-number.today-circle {
        background: #4e73df;
        color: white;
    }

    .event-item i {
        font-size: 0.7rem;
        margin-left: 2px;
    }

    .checkbox-group {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }
    
    .checkbox-group .form-check {
        margin-right: 20px;
        margin-bottom: 0;
    }
    
    .checkbox-group .form-check:last-child {
        margin-right: 0;
    }
    
    .btn-link {
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }
    
    .btn-link:hover {
        transform: scale(1.2);
        color: #4e73df !important;
    }
    
    .calendar-title, .month-title {
        font-weight: 600;
        color: #2e59d9;
    }
    
    .term-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
  </style>
</head>

<body class="vertical light">
  <div class="wrapper">
    <!-- Header and sidebar code would go here -->
    <?php require_once('admin-header.php'); ?>
    <main role="main" class="main-contentc">
      <div class="container-fluid">
        <!-- Message Alert -->
        <?php if (isset($_SESSION['message'])): ?>
          <div class="message-alert">
            <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show" role="alert">
              <?= $_SESSION['message']['text'] ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
          <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row">
              <div class="col-md-12 my-4">
                <div class="row align-items-center mb-4">
                  <div class="col">
                    <h2 class="page-title">Academic Calendar</h2>
                  </div>
                  <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventModal">
                      <i class="fe fe-plus"></i> Add Event
                    </button>
                  </div>
                </div>
                
                <!-- Today's Calendar View -->
                <div class="calendar-container">
  <div class="calendar-header">
    <h3 class="calendar-title text-center mb-2">Term Week <?= $currentTermWeek ?> (<?= $firstDayOfWeek->format('M j') ?> - <?= $lastDayOfWeek->format('M j, Y') ?>)</h3>
    <div class="d-flex justify-content-center align-items-center mb-3">
      <button class="btn btn-link text-dark p-0 mx-2" id="prevWeek" title="Previous Week">
        <i class="fe fe-chevron-left"></i>
      </button>
      <button class="btn btn-link text-dark p-0 mx-2" id="nextWeek" title="Next Week">
        <i class="fe fe-chevron-right"></i>
      </button>
    </div>
    <div class="term-info text-center">
      <span class="term-duration">Term Duration: <?= $termDuration ?> months</span>
      <span class="term-period">(<?= date('M j, Y', strtotime($termStartDate)) ?> - <?= $termEndDate->format('M j, Y') ?>)</span>
    </div>
  </div>
  
  <div class="calendar-week">
    <div class="calendar-day-header">Mon</div>
    <div class="calendar-day-header">Tue</div>
    <div class="calendar-day-header">Wed</div>
    <div class="calendar-day-header">Thu</div>
    <div class="calendar-day-header">Fri</div>
    <div class="calendar-day-header">Sat</div>
    <div class="calendar-day-header">Sun</div>
  </div>
  
  <div class="calendar-days">
    <?php
    // Reset the lastDayOfWeek after modifying it for the title
    $lastDayOfWeek = clone $firstDayOfWeek;
    $lastDayOfWeek->modify('+13 days');
    
    // Get all events for this two-week period
    $periodEvents = getEvents($pdo, $firstDayOfWeek->format('Y-m-d'), $lastDayOfWeek->format('Y-m-d'));
    
    // Get today's date for comparison
    $today = new DateTime();
    $todayFormatted = $today->format('Y-m-d');
    
    // Display 14 days (2 weeks)
    for ($i = 0; $i < 14; $i++) {
        $day = clone $firstDayOfWeek;
        $day->add(new DateInterval("P{$i}D"));
        $dayNumber = $day->format('j');
        $dayFormatted = $day->format('Y-m-d');
        $isToday = $dayFormatted === $todayFormatted;
        $isPast = $day < $today && !$isToday;
        
        // Get events for this day
        $dayEvents = array_filter($periodEvents, function($event) use ($day) {
            try {
                $eventStart = new DateTime($event['start_date']);
                $eventEnd = !empty($event['end_date']) ? new DateTime($event['end_date']) : $eventStart;
                $dayDate = $day->format('Y-m-d');
                
                return $eventStart->format('Y-m-d') === $dayDate || 
                       ($eventEnd->format('Y-m-d') === $dayDate && $eventEnd->format('Y-m-d') !== $eventStart->format('Y-m-d'));
            } catch (Exception $e) {
                error_log("Error processing event date: " . $e->getMessage());
                return false;
            }
        });
        
        echo '<div class="calendar-day' . ($isToday ? ' today' : '') . ($isPast ? ' past-day' : '') . '">';
        echo '<div class="day-number' . ($isToday ? ' today-circle' : '') . '">' . $dayNumber . '</div>';
        
        // Display events for this day
        foreach ($dayEvents as $event) {
            try {
                $eventClass = 'event-' . $event['event_type'];
                $eventStart = new DateTime($event['start_date']);
                $isUpcoming = $eventStart > $today;
                $isEndDate = !empty($event['end_date']) && 
                            (new DateTime($event['end_date']))->format('Y-m-d') === $dayFormatted;
            
                echo '<div class="event-item ' . $eventClass . ($isUpcoming ? ' upcoming-event' : '') . '" data-id="' . $event['id'] . '">';
                echo '<div class="event-title">' . htmlspecialchars($event['title']) . '</div>';
                
                if (!$event['all_day'] && !empty($event['start_time'])) {
                    echo '<div class="event-time">' . date('g:i a', strtotime($event['start_time']));
                    if (!empty($event['end_time'])) {
                        echo ' - ' . date('g:i a', strtotime($event['end_time']));
                    }
                    echo '</div>';
                }
                
                if ($event['all_day'] == 1) {
                    echo '<i class="fe fe-clock" title="All Day Event"></i>';
                }
                if ($event['is_online'] == 1) {
                    echo '<i class="fe fe-video" title="Online Event"></i>';
                }
                if ($event['is_notice'] == 1) {
                    echo '<i class="fe fe-bell" title="Notice Board Event"></i>';
                }
                
                if ($isEndDate) {
                    echo '<i class="fe fe-flag" title="End Date"></i>';
                }
            
                echo '</div>';
            } catch (Exception $e) {
                error_log("Error displaying event: " . $e->getMessage());
                continue;
            }
        }
        
        if (count($dayEvents) > 0) {
            echo '<div class="event-count-badge">' . count($dayEvents) . '</div>';
        }
        
        echo '</div>';
    }
    ?>
  </div>
</div>
                
                <!-- All Events Section -->
                <div class="calendar-container">
                  <h3 class="month-title">All Events</h3>
                  
                  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; margin-bottom: 20px;">
                    <?php
                    // Group events by type for quick view
                    $eventTypes = ['class', 'exam', 'holiday', 'meeting', 'online', 'other'];
                    foreach ($eventTypes as $type) {
                        $typeEvents = array_filter($allEvents, function($event) use ($type) {
                            return $event['event_type'] === $type;
                        });
                        
                        if (!empty($typeEvents)) {
                            $eventClass = 'event-' . $type;
                            echo '<div class="event-item ' . $eventClass . '">';
                            echo ucfirst($type) . ' (' . count($typeEvents) . ')';
                            echo '</div>';
                        }
                    }
                    ?>
                  </div>
                </div>
                
                <!-- Current Month Section -->
                <div class="calendar-container">
                  <h3 class="month-title text-center mb-2"><?= $currentDate->format('F Y') ?></h3>
                  
                  <ul class="event-list">
                    <?php
                    if (empty($monthEvents)) {
                        echo '<li class="event-list-item">No events scheduled for this month</li>';
                    } else {
                        foreach ($monthEvents as $event) {
                            $eventDate = new DateTime($event['start_date']);
                            $eventClass = 'type-' . $event['event_type'];
                            
                            echo '<li class="event-list-item" data-id="' . $event['id'] . '">';
                            echo '<div class="event-date">' . $eventDate->format('M j') . '</div>';
                            echo '<div class="event-title">' . htmlspecialchars($event['title']) . '<span class="event-type ' . $eventClass . '">' . ucfirst($event['event_type']) . '</span></div>';
                            
                            if (!$event['all_day'] && $event['start_time']) {
                                $timeDisplay = date('g:i a', strtotime($event['start_time']));
                                if ($event['end_time']) {
                                    $timeDisplay .= ' - ' . date('g:i a', strtotime($event['end_time']));
                                }
                                echo '<div class="event-time">' . $timeDisplay . '</div>';
                            } else {
                                echo '<div class="event-time">All day</div>';
                            }
                            
                            echo '<div class="event-actions">';
                            echo '<button class="btn btn-sm btn-outline-primary edit-event" data-id="' . $event['id'] . '"><i class="fe fe-edit"></i></button>';
                            echo '<button class="btn btn-sm btn-outline-danger delete-event" data-id="' . $event['id'] . '"><i class="fe fe-trash"></i></button>';
                            echo '</div>';
                            echo '</li>';
                        }
                    }
                    ?>
                  </ul>
                </div>
                
                <!-- Week View -->
                <div class="calendar-container">
  <div class="calendar-header">
    <h3 class="calendar-title">Term Week <?= $currentTermWeek ?> (<?= $firstDayOfWeek->format('M j') ?> - <?= $lastDayOfWeek->format('M j, Y') ?>)</h3>
  </div>
  
  <div class="calendar-week">
    <?php
    // Get today's date for comparison
    $today = new DateTime();
    $todayFormatted = $today->format('Y-m-d');
    
    // Display week days with day numbers
    $weekStart = clone $firstDayOfWeek;
    for ($i = 0; $i < 30; $i++) {
        $day = clone $weekStart;
        $day->add(new DateInterval("P{$i}D"));
        $isToday = ($day->format('Y-m-d') === $todayFormatted);
        
        echo '<div class="calendar-day-header' . ($isToday ? ' today' : '') . '">';
        echo '<div class="day-name">' . $day->format('D') . '</div>';
        echo '<div class="day-number' . ($isToday ? ' today-circle' : '') . '">' . $day->format('j') . '</div>';
        echo '</div>';
    }
    ?>
  </div>
</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Event Modal -->
      <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="eventModalLabel">Add New Event</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="eventForm" method="post">
              <input type="hidden" name="action" id="formAction" value="add_event">
              <input type="hidden" name="id" id="eventId" value="">
              
              <div class="modal-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="eventTitle">Event Title*</label>
                    <input type="text" class="form-control" id="eventTitle" name="title" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="eventType">Event Type*</label>
                    <select class="form-control" id="eventType" name="event_type" required>
                      <option value="class">Class</option>
                      <option value="exam">Exam</option>
                      <option value="holiday">Holiday</option>
                      <option value="meeting">Meeting</option>
                      <option value="online">Online Event</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="eventSubject">Subject</label>
                  <input type="text" class="form-control" id="eventSubject" name="subject" placeholder="Enter subject (optional)">
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="startDate">Start Date*</label>
                    <input type="date" class="form-control" id="startDate" name="start_date" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="endDate">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                  </div>
                </div>
                
                <div class="form-row" id="timeFields">
                  <div class="form-group col-md-6">
                    <label for="startTime">Start Time</label>
                    <input type="time" class="form-control" id="startTime" name="start_time">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="endTime">End Time</label>
                    <input type="time" class="form-control" id="endTime" name="end_time">
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="allDayEvent" name="all_day">
                    <label class="custom-control-label" for="allDayEvent">All Day Event</label>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="isOnlineEvent" name="is_online">
                    <label class="custom-control-label" for="isOnlineEvent">Online Event</label>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="isNotice" name="is_notice">
                    <label class="custom-control-label" for="isNotice">Add to Notice Board</label>
                  </div>
                </div>
                
                <div class="form-group" id="noticeReadersGroup" style="display: none;">
                    <label>Notice Readers*</label>
                    <div class="d-flex align-items-center">
                        <div class="form-check mr-4">
                            <input type="checkbox" class="form-check-input" name="readers[]" value="students" id="studentsCheck">
                            <label class="form-check-label" for="studentsCheck">Students</label>
                        </div>
                        <div class="form-check mr-4">
                            <input type="checkbox" class="form-check-input" name="readers[]" value="staffs" id="staffsCheck">
                            <label class="form-check-label" for="staffsCheck">Staffs</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="readers[]" value="parents" id="parentsCheck">
                            <label class="form-check-label" for="parentsCheck">Parents</label>
                        </div>
                    </div>
                    <small class="form-text text-muted">Select at least one reader group</small>
                </div>
                
                <div class="form-group" id="meetingLinkGroup" style="display: none;">
                  <label for="meetingLink">Meeting Link*</label>
                  <input type="url" class="form-control" id="meetingLink" name="meeting_link" placeholder="https://meet.google.com/abc-xyz-123">
                  <small class="form-text text-muted">Enter the meeting link (e.g., Google Meet, Zoom, etc.)</small>
                </div>
                
                <div class="form-group" id="locationGroup">
                  <label for="eventLocation">Location</label>
                  <input type="text" class="form-control" id="eventLocation" name="location" placeholder="Building/Room Number">
                </div>
                
                <div class="form-group">
                  <label for="eventDescription">Description</label>
                  <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Event</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="deleteForm" method="post">
              <input type="hidden" name="action" value="delete_event">
              <input type="hidden" name="id" id="deleteEventId" value="">
              
              <div class="modal-body">
                Are you sure you want to delete this event? This action cannot be undone.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete Event</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>

  <?php
require_once('admin-footer.php');
?>
  <!-- Core JS -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/config.js"></script>
  
  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Custom JS -->
  <script>
    // Add stickOnScroll function
    $.fn.stickOnScroll = function() {
        var $this = $(this);
        var offset = $this.offset();
        var topOffset = offset ? offset.top : 0;
        
        $(window).scroll(function() {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > topOffset) {
                $this.addClass('sticky');
            } else {
                $this.removeClass('sticky');
            }
        });
    };

    $(document).ready(function() {
        // Initialize Select2
        $('#noticeReaderSelect').select2({
            placeholder: "Select readers...",
            allowClear: true,
            width: '100%',
            multiple: true
        }).on('change', function() {
            const selectedValues = $(this).val() || [];
            const readersValue = selectedValues.join(',');
            $('#readers').val(readersValue);
            console.log('Selected readers value:', readersValue);
        });
        
        // Toggle notice readers group
        $('#isNotice').change(function() {
            if ($(this).is(':checked')) {
                $('#noticeReadersGroup').show();
                // Remove required attribute from individual checkboxes
                $('input[name="readers[]"]').prop('required', false);
            } else {
                $('#noticeReadersGroup').hide();
                $('input[name="readers[]"]').prop('checked', false);
            }
        });
        
        // Handle form submission
        $('#eventForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default submission
            
            // Handle readers validation for notices
            if ($('#isNotice').is(':checked')) {
                const selectedReaders = $('input[name="readers[]"]:checked').length;
                if (selectedReaders === 0) {
                    alert('Please select at least one notice reader');
                    return false;
                }
            }
            
            // Now submit the form
            this.submit();
        });
        
        // Reset form when modal is closed
        $('#eventModal').on('hidden.bs.modal', function() {
            $('#eventForm')[0].reset();
            $('#formAction').val('add_event');
            $('#eventId').val('');
            $('#eventModalLabel').text('Add New Event');
            $('#timeFields').show();
            $('#meetingLinkGroup').hide();
            $('#locationGroup').show();
            $('#noticeReadersGroup').hide();
            $('#startDate').val(moment().format('YYYY-MM-DD'));
        });
        
        // Initialize form with today's date
        $('#startDate').val(moment().format('YYYY-MM-DD'));
        
        // Handle edit button click
        $(document).on('click', '.edit-event', function() {
            const eventId = $(this).data('id');
            
            // Show loading state
            $('#eventModalLabel').text('Loading...');
            $('#eventModal').modal('show');
            
            // Fetch event details
            $.ajax({
                url: 'calendar.php?action=edit_event&id=' + eventId,
                method: 'GET',
                dataType: 'json',
                success: function(event) {
                    if (event.error) {
                        alert(event.error);
                        $('#eventModal').modal('hide');
                        return;
                    }
                    
                    // Populate form fields
                    $('#eventId').val(event.id);
                    $('#eventTitle').val(event.title);
                    $('#eventSubject').val(event.subject);
                    $('#eventType').val(event.event_type);
                    $('#startDate').val(event.start_date);
                    $('#endDate').val(event.end_date);
                    $('#startTime').val(event.start_time);
                    $('#endTime').val(event.end_time);
                    $('#eventLocation').val(event.location);
                    $('#meetingLink').val(event.meeting_link);
                    $('#eventDescription').val(event.description);
                    
                    // Handle all day checkbox
                    if (event.all_day == 1) {
                        $('#allDayEvent').prop('checked', true);
                        $('#timeFields').hide();
                    } else {
                        $('#allDayEvent').prop('checked', false);
                        $('#timeFields').show();
                    }
                    
                    // Handle online meeting checkbox
                    if (event.is_online == 1) {
                        $('#isOnlineEvent').prop('checked', true);
                        $('#meetingLinkGroup').show();
                        $('#meetingLink').prop('required', true);
                        $('#locationGroup').hide();
                    } else {
                        $('#isOnlineEvent').prop('checked', false);
                        $('#meetingLinkGroup').hide();
                        $('#meetingLink').prop('required', false);
                        $('#locationGroup').show();
                    }
                    
                    // Handle notice checkbox and readers
                    if (event.is_notice == 1) {
                        $('#isNotice').prop('checked', true);
                        $('#noticeReadersGroup').show();
                        
                        // Set reader checkboxes
                        $('#studentsCheck').prop('checked', event.students === 1);
                        $('#staffsCheck').prop('checked', event.staffs === 1);
                        $('#parentsCheck').prop('checked', event.parents === 1);
                    } else {
                        $('#isNotice').prop('checked', false);
                        $('#noticeReadersGroup').hide();
                        $('#studentsCheck').prop('checked', false);
                        $('#staffsCheck').prop('checked', false);
                        $('#parentsCheck').prop('checked', false);
                    }
                    
                    // Update form action and modal title
                    $('#formAction').val('update_event');
                    $('#eventModalLabel').text('Edit Event');
                },
                error: function(xhr, status, error) {
                    console.error('Error loading event:', error);
                    alert('Error loading event details. Please try again.');
                    $('#eventModal').modal('hide');
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.delete-event', function() {
            const eventId = $(this).data('id');
            $('#deleteEventId').val(eventId);
            $('#deleteModal').modal('show');
        });

        // Handle delete form submission
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            this.submit();
        });

        // Handle online event checkbox
        $('#isOnlineEvent').change(function() {
            if ($(this).is(':checked')) {
                $('#meetingLinkGroup').show();
                $('#meetingLink').prop('required', true);
                $('#locationGroup').hide();
            } else {
                $('#meetingLinkGroup').hide();
                $('#meetingLink').prop('required', false);
                $('#locationGroup').show();
            }
        });

        // Handle week navigation
        $('#prevWeek').click(function() {
            const currentUrl = new URL(window.location.href);
            const currentWeek = parseInt(currentUrl.searchParams.get('week') || '0');
            currentUrl.searchParams.set('week', currentWeek - 1);
            window.location.href = currentUrl.toString();
        });

        $('#nextWeek').click(function() {
            const currentUrl = new URL(window.location.href);
            const currentWeek = parseInt(currentUrl.searchParams.get('week') || '0');
            currentUrl.searchParams.set('week', currentWeek + 1);
            window.location.href = currentUrl.toString();
        });

        // Handle month navigation
        $('#prevMonth').click(function() {
            const currentUrl = new URL(window.location.href);
            const currentMonth = parseInt(currentUrl.searchParams.get('month') || '0');
            currentUrl.searchParams.set('month', currentMonth - 1);
            window.location.href = currentUrl.toString();
        });

        $('#nextMonth').click(function() {
            const currentUrl = new URL(window.location.href);
            const currentMonth = parseInt(currentUrl.searchParams.get('month') || '0');
            currentUrl.searchParams.set('month', currentMonth + 1);
            window.location.href = currentUrl.toString();
        });
    });
  </script>
</body>
</html>