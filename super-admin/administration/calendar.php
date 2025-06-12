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

// Function to add a new event
function addEvent($pdo) {
    $data = sanitizeInput($_POST);

    // Validate event type
    $validEventTypes = ['class', 'exam', 'holiday', 'meeting', 'online', 'other'];
    $eventType = in_array($data['event_type'], $validEventTypes) ? $data['event_type'] : 'other';
    
    try {
        $pdo->beginTransaction();
        
        // Insert into academic_calendar
        $stmt = $pdo->prepare("INSERT INTO academic_calendar 
                              (title, event_type, start_date, end_date, start_time, end_time, 
                               all_day, is_online, meeting_link, location, description, is_notice, readers) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $allDay = isset($data['all_day']) ? 1 : 0;
        $isOnline = isset($data['is_online']) ? 1 : 0;
        $isNotice = isset($data['is_notice']) ? 1 : 0;
        $noticeReaders = !empty($data['readers']) ? $data['readers'] : '';
        
        $stmt->execute([
            $data['title'],
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
            $noticeReaders
        ]);
        
        $eventId = $pdo->lastInsertId();
        
        // If it's a notice, also insert into notices table
        if ($isNotice) {
            $stmt = $pdo->prepare("INSERT INTO notices 
                                  (title, content, start_date, end_date, readers, posted_by, date_posted, event_id) 
                                  VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
            
            // Ensure readers is never null
            $noticeReaders = !empty($data['readers']) ? $data['readers'] : '';
            
            $stmt->execute([
                $data['title'],
                $data['description'] ?? '',
                $data['start_date'],
                $data['end_date'] ?: $data['start_date'],
                $noticeReaders,
                $_SESSION['user_name'] ?? 'Admin',
                date('Y-m-d H:i:s'),
                $eventId
            ]);
        }
        
        $pdo->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event added successfully'];
    } catch (PDOException $e) {
        $pdo->rollBack();
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
        
        // Update academic_calendar
        $stmt = $pdo->prepare("UPDATE academic_calendar SET 
                              title = ?, event_type = ?, start_date = ?, end_date = ?, 
                              start_time = ?, end_time = ?, all_day = ?, is_online = ?, 
                              meeting_link = ?, location = ?, description = ?, is_notice = ?, readers = ? 
                              WHERE id = ?");
        
        $allDay = isset($data['all_day']) ? 1 : 0;
        $isOnline = isset($data['is_online']) ? 1 : 0;
        $isNotice = isset($data['is_notice']) ? 1 : 0;
        $noticeReaders = isset($data['readers']) ? $data['readers'] : '';
        
        $stmt->execute([
            $data['title'],
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
            $noticeReaders,
            $data['id']
        ]);
        
        // Handle notice in notices table
        if ($isNotice) {
            // Check if notice already exists
            $stmt = $pdo->prepare("SELECT id FROM notices WHERE title = ? AND start_date = ?");
            $stmt->execute([$data['title'], $data['start_date']]);
            $noticeId = $stmt->fetchColumn();
            
            if ($noticeId) {
                // Update existing notice
                $stmt = $pdo->prepare("UPDATE notices SET 
                                      title = ?, content = ?, start_date = ?, end_date = ?, readers = ?, event_id = ? 
                                      WHERE id = ?");
                
                // Ensure readers is not null - use empty string if no readers selected
                $noticeReaders = !empty($data['readers']) ? $data['readers'] : '';
                
                $stmt->execute([
                    $data['title'],
                    $data['description'] ?? '',
                    $data['start_date'],
                    $data['end_date'] ?: $data['start_date'],
                    $noticeReaders,
                    $data['id'],  // Store the event_id
                    $noticeId
                ]);
            } else {
                // Insert new notice
                $stmt = $pdo->prepare("INSERT INTO notices 
                                      (title, content, start_date, end_date, readers, posted_by, date_posted, event_id) 
                                      VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
                
                // Ensure readers is not null - use empty string if no readers selected
                $noticeReaders = !empty($data['readers']) ? $data['readers'] : '';
                
                $stmt->execute([
                    $data['title'],
                    $data['description'] ?? '',
                    $data['start_date'],
                    $data['end_date'] ?: $data['start_date'],
                    $noticeReaders,
                    $_SESSION['user_name'] ?? 'Admin',
                    date('Y-m-d H:i:s'),
                    $data['id']  // Store the event_id
                ]);
            }
        } else {
            // Remove from notices if it was a notice before
            $stmt = $pdo->prepare("DELETE FROM notices WHERE title = ? AND start_date = ?");
            $stmt->execute([$data['title'], $data['start_date']]);
        }
        
        $pdo->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event updated successfully'];
    } catch (PDOException $e) {
        $pdo->rollBack();
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
        
        // Get event details before deleting
        $stmt = $pdo->prepare("SELECT title, start_date FROM academic_calendar WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($event) {
            // Delete from notices table first
            $stmt = $pdo->prepare("DELETE FROM notices WHERE title = ? AND start_date = ?");
            $stmt->execute([$event['title'], $event['start_date']]);
            
            // Then delete from academic_calendar
        $stmt = $pdo->prepare("DELETE FROM academic_calendar WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        }
        
        $pdo->commit();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event deleted successfully'];
    } catch (PDOException $e) {
        $pdo->rollBack();
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
$termStartDate = getTermStartDate($pdo);
$termDuration = getTermDuration($pdo);
$currentTermWeek = calculateTermWeek($currentDate->format('Y-m-d'), $termStartDate);

// Calculate term end date
$termEndDate = new DateTime($termStartDate);
$termEndDate->modify("+{$termDuration} months");

// Get events for different views
$todayEvents = getEvents($pdo, $currentDate->format('Y-m-d'), $currentDate->format('Y-m-d'));
$monthEvents = getEvents($pdo, $currentDate->format('Y-m-01'), $currentDate->format('Y-m-t'));
$allEvents = getEvents($pdo);

// Get the first day of the current week
$firstDayOfWeek = clone $currentDate;
$firstDayOfWeek->modify('this week');

// Get the last day of the current week
$lastDayOfWeek = clone $firstDayOfWeek;
$lastDayOfWeek->modify('+6 days');

// Get events for the current week
$weekEvents = getEvents($pdo, $firstDayOfWeek->format('Y-m-d'), $lastDayOfWeek->format('Y-m-d'));

// Function to get notices for a specific user type
function getNoticesByUserType($pdo, $userType) {
    try {
        $stmt = $pdo->prepare("SELECT n.*, ac.event_type, ac.start_time, ac.end_time, ac.all_day, ac.is_online, ac.meeting_link, ac.location 
                              FROM notices n 
                              LEFT JOIN academic_calendar ac ON n.event_id = ac.id 
                              WHERE n.readers LIKE ? 
                              ORDER BY n.date_posted DESC");
        
        $stmt->execute(['%' . $userType . '%']);
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
    }

    .event-item i {
        font-size: 0.7rem;
        margin-left: 2px;
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
    <h3 class="calendar-title">Term Week <?= $currentTermWeek ?> (<?= $firstDayOfWeek->format('M j') ?> - <?= $lastDayOfWeek->modify('+13 days')->format('M j, Y') ?>)</h3>
    <div class="term-info">
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
    
    // Display 14 days (2 weeks)
    for ($i = 0; $i < 14; $i++) {
        $day = clone $firstDayOfWeek;
        $day->add(new DateInterval("P{$i}D"));
        $dayNumber = $day->format('j');
        $isToday = $day->format('Y-m-d') === $currentDate->format('Y-m-d');
        $isPast = $day < $currentDate && !$isToday;
        
        // Get events for this day
        $dayEvents = array_filter($periodEvents, function($event) use ($day) {
            try {
                $eventStart = new DateTime($event['start_date']);
                $eventEnd = !empty($event['end_date']) ? new DateTime($event['end_date']) : $eventStart;
                $dayDate = $day->format('Y-m-d');
                
                // Only show event on start date and end date (if different from start date)
                return $eventStart->format('Y-m-d') === $dayDate || 
                       ($eventEnd->format('Y-m-d') === $dayDate && $eventEnd->format('Y-m-d') !== $eventStart->format('Y-m-d'));
            } catch (Exception $e) {
                error_log("Error processing event date: " . $e->getMessage());
                return false;
            }
        });
        
        echo '<div class="calendar-day' . ($isToday ? ' today' : '') . ($isPast ? ' past-day' : '') . '">';
        echo '<div class="day-number">' . $dayNumber . '</div>';
        
        // Display events for this day
        foreach ($dayEvents as $event) {
            try {
                $eventClass = 'event-' . $event['event_type'];
                $eventStart = new DateTime($event['start_date']);
                $isUpcoming = $eventStart > $currentDate;
                $isEndDate = !empty($event['end_date']) && 
                            (new DateTime($event['end_date']))->format('Y-m-d') === $day->format('Y-m-d');
                
                echo '<div class="event-item ' . $eventClass . ($isUpcoming ? ' upcoming-event' : '') . '" data-id="' . $event['id'] . '">';
                echo '<div class="event-title">' . htmlspecialchars($event['title']) . '</div>';
                
                // Add time if not all-day event
                if (!$event['all_day'] && !empty($event['start_time'])) {
                    echo '<div class="event-time">' . date('g:i a', strtotime($event['start_time']));
                    if (!empty($event['end_time'])) {
                        echo ' - ' . date('g:i a', strtotime($event['end_time']));
                    }
                    echo '</div>';
                }
                
                // Add icons for event type
                if ($event['all_day'] == 1) {
                    echo '<i class="fe fe-clock" title="All Day Event"></i>';
                }
                if ($event['is_online'] == 1) {
                    echo '<i class="fe fe-video" title="Online Event"></i>';
                }
                if ($event['is_notice'] == 1) {
                    echo '<i class="fe fe-bell" title="Notice Board Event"></i>';
                }
                
                // Add indicator for end date
                if ($isEndDate) {
                    echo '<i class="fe fe-flag" title="End Date"></i>';
                }
                
                echo '</div>';
            } catch (Exception $e) {
                error_log("Error displaying event: " . $e->getMessage());
                continue;
            }
        }
        
        // Show event count badge if there are events
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
                  <h3 class="month-title"><?= $currentDate->format('F Y') ?></h3>
                  
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
                    <div class="tag-input-container" id="tagInputContainer">
                        <select id="noticeReaderSelect">
                            <option value="">Select readers...</option>
                            <option value="students">Students</option>
                            <option value="parents">Parents</option>
                            <option value="staffs">Staffs</option>
                        </select>
                    </div>
                    <input type="hidden" name="readers" id="readers" value="">
                </div>
                
                <div class="form-group" id="meetingLinkGroup" style="display: none;">
                  <label for="meetingLink">Meeting Link*</label>
                  <input type="url" class="form-control" id="meetingLink" name="meeting_link" placeholder="https://meet.google.com/abc-xyz-123">
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
            width: '100%'
        });
        
      // Set today's date as default for new events
      $('#startDate').val(moment().format('YYYY-MM-DD'));
      
      // Toggle time fields based on all-day checkbox
      $('#allDayEvent').change(function() {
        if ($(this).is(':checked')) {
          $('#timeFields').hide();
          $('#startTime').val('');
          $('#endTime').val('');
        } else {
          $('#timeFields').show();
        }
      });
      
      // Toggle online meeting fields
      $('#isOnlineEvent').change(function() {
        if ($(this).is(':checked')) {
          $('#meetingLinkGroup').show();
          $('#locationGroup').hide();
          $('#eventType').val('online');
        } else {
          $('#meetingLinkGroup').hide();
          $('#locationGroup').show();
        }
      });
      
      // Change event type handler
      $('#eventType').change(function() {
        if ($(this).val() === 'online') {
          $('#isOnlineEvent').prop('checked', true).trigger('change');
        }
      });
      
        // Initialize tag input
        const tagInput = {
            container: $('#tagInputContainer'),
            select: $('#noticeReaderSelect'),
            hiddenInput: $('#readers'),
            tags: new Set(),

            init: function() {
                this.select.on('change', () => this.addTag());
                this.container.on('click', '.remove-tag', (e) => {
                    const tag = $(e.target).closest('.tag');
                    const value = tag.data('value');
                    this.removeTag(value);
                });
            },

            addTag: function() {
                const value = this.select.val();
                if (value && !this.tags.has(value)) {
                    this.tags.add(value);
                    this.renderTags();
                    this.select.val('');
                }
            },

            removeTag: function(value) {
                this.tags.delete(value);
                this.renderTags();
            },

            renderTags: function() {
                // Clear existing tags
                this.container.find('.tag').remove();
                
                // Add new tags
                this.tags.forEach(value => {
                    const tag = $(`<span class="tag" data-value="${value}">
                        ${value.charAt(0).toUpperCase() + value.slice(1)}
                        <span class="remove-tag">&times;</span>
                    </span>`);
                    this.container.prepend(tag);
                });

                // Always ensure there's a value, even if empty
                const readersValue = Array.from(this.tags).join(',');
                this.hiddenInput.val(readersValue || '');
            }
        };

        tagInput.init();

        // Toggle notice readers group
        $('#isNotice').change(function() {
            if ($(this).is(':checked')) {
                $('#noticeReadersGroup').show();
                $('#readers').prop('required', true);
            } else {
                $('#noticeReadersGroup').hide();
                $('#readers').prop('required', false);
                tagInput.tags.clear();
                tagInput.renderTags();
            }
        });

        // Handle form submission
        $('#eventForm').on('submit', function(e) {
            if ($('#isNotice').is(':checked')) {
                if (tagInput.tags.size === 0) {
                    e.preventDefault();
                    alert('Please select at least one notice reader');
                    return false;
                }
                // Ensure readers value is set before submission
                const readersValue = Array.from(tagInput.tags).join(',');
                $('#readers').val(readersValue || '');
            } else {
                // If not a notice, set empty string for readers
                $('#readers').val('');
            }
        });
        
    // Edit event button handler
$(document).on('click', '.edit-event', function(e) {
    e.stopPropagation();
    var eventId = $(this).data('id');
    
    $.ajax({
        url: 'get_event.php',
        type: 'GET',
        data: {id: eventId},
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }
            
            $('#eventModalLabel').text('Edit Event');
            $('#formAction').val('update_event');
            $('#eventId').val(response.id);
            $('#eventTitle').val(response.title);
            $('#eventType').val(response.event_type);
            $('#startDate').val(response.start_date.split(' ')[0]);
            $('#endDate').val(response.end_date ? response.end_date.split(' ')[0] : '');
            $('#startTime').val(response.start_time || '');
            $('#endTime').val(response.end_time || '');
            $('#eventLocation').val(response.location || '');
            $('#eventDescription').val(response.description || '');
            $('#allDayEvent').prop('checked', response.all_day == 1);
            $('#isOnlineEvent').prop('checked', response.is_online == 1);
            $('#meetingLink').val(response.meeting_link || '');
            
            if (response.all_day) {
                $('#timeFields').hide();
            } else {
                $('#timeFields').show();
            }
            
            if (response.is_online) {
                $('#meetingLinkGroup').show();
                $('#locationGroup').hide();
            } else {
                $('#meetingLinkGroup').hide();
                $('#locationGroup').show();
            }
                    
                    if (response.is_notice == 1) {
                        $('#isNotice').prop('checked', true).trigger('change');
                        if (response.readers) {
                            var readers = response.readers.split(',');
                            $('#readers').val(readers).trigger('change');
                        }
                    } else {
                        $('#isNotice').prop('checked', false).trigger('change');
                    }
            
            $('#eventModal').modal('show');
        },
        error: function(xhr, status, error) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    alert(response.error);
                } else {
                    alert('Error loading event: ' + error);
                }
            } catch (e) {
                alert('Server error: ' + xhr.responseText);
            }
        }
    });
});
      
      // Delete event button handler
      $(document).on('click', '.delete-event', function(e) {
        e.stopPropagation();
        var eventId = $(this).data('id');
        $('#deleteEventId').val(eventId);
        $('#deleteModal').modal('show');
      });
      
      // Reset form when modal is closed
      $('#eventModal').on('hidden.bs.modal', function() {
        $('#eventForm')[0].reset();
            $('#readers').val(null).trigger('change');
        $('#formAction').val('add_event');
        $('#eventId').val('');
        $('#eventModalLabel').text('Add New Event');
        $('#timeFields').show();
        $('#meetingLinkGroup').hide();
        $('#locationGroup').show();
            $('#noticeReadersGroup').hide();
        $('#startDate').val(moment().format('YYYY-MM-DD'));
      });
      
      // Close message alert after 5 seconds
      setTimeout(function() {
        $('.message-alert').fadeOut();
      }, 5000);
    });
  </script>
</body>
</html>