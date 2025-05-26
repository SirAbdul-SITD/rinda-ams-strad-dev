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
    var_dump($event_type);

    
    try {
        $stmt = $pdo->prepare("INSERT INTO academic_calendar 
                              (title, event_type, start_date, end_date, start_time, end_time, 
                               all_day, is_online, meeting_link, location, description) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $data['title'],
            $data['event_type'],
            $data['start_date'],
            $data['end_date'] ?: $data['start_date'],
            $data['all_day'] ? null : $data['start_time'],
            $data['all_day'] ? null : $data['end_time'],
            $data['all_day'] ? 1 : 0,
            $data['is_online'] ? 1 : 0,
            $data['is_online'] ? $data['meeting_link'] : null,
            $data['is_online'] ? null : $data['location'],
            $data['description']
        ]);
        
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event added successfully'];
    } catch (PDOException $e) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Error adding event: ' . $e->getMessage()];
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Function to update an event
function updateEvent($pdo) {
    $data = sanitizeInput($_POST);
    
    try {
        $stmt = $pdo->prepare("UPDATE academic_calendar SET 
                              title = ?, event_type = ?, start_date = ?, end_date = ?, 
                              start_time = ?, end_time = ?, all_day = ?, is_online = ?, 
                              meeting_link = ?, location = ?, description = ? 
                              WHERE id = ?");
        
        $stmt->execute([
            $data['title'],
            $data['event_type'],
            $data['start_date'],
            $data['end_date'] ?: $data['start_date'],
            $data['all_day'] ? null : $data['start_time'],
            $data['all_day'] ? null : $data['end_time'],
            $data['all_day'] ? 1 : 0,
            $data['is_online'] ? 1 : 0,
            $data['is_online'] ? $data['meeting_link'] : null,
            $data['is_online'] ? null : $data['location'],
            $data['description'],
            $data['id']
        ]);
        
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event updated successfully'];
    } catch (PDOException $e) {
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
        $stmt = $pdo->prepare("DELETE FROM academic_calendar WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Event deleted successfully'];
    } catch (PDOException $e) {
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
        $query .= " AND start_date >= ?";
        $params[] = $startDate;
    }
    
    if ($endDate) {
        $query .= " AND (end_date <= ? OR end_date IS NULL)";
        $params[] = $endDate;
    }
    
    $query .= " ORDER BY start_date, start_time";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get current date information
$currentDate = new DateTime();
$currentYear = $currentDate->format('Y');
$currentMonth = $currentDate->format('m');
$currentDay = $currentDate->format('d');
$currentWeek = $currentDate->format('W');

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
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <link rel="stylesheet" href="../css/styles.css">
  <!-- Fonts CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <style>
   
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
    <h3 class="calendar-title">Week <?= $currentWeek ?> (<?= $firstDayOfWeek->format('M j') ?> - <?= $lastDayOfWeek->modify('+13 days')->format('M j, Y') ?>)</h3>
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
        $dayEvents = array_filter($periodEvents, function($event) use ($day, $currentDate, $isPast) {
            $eventDate = new DateTime($event['start_date']);
            $isSameDay = $eventDate->format('Y-m-d') === $day->format('Y-m-d');
            
            // For past days, only show if it's an all-day event
            if ($isPast) {
                return $isSameDay && $event['all_day'] == 1;
            }
            // For current/future days, show all events
            return $isSameDay;
        });
        
        echo '<div class="calendar-day' . ($isToday ? ' today' : '') . ($isPast ? ' past-day' : '') . '">';
        echo '<div class="day-number">' . $dayNumber . '</div>';
        
        // Display events for this day
        foreach ($dayEvents as $event) {
            $eventClass = 'event-' . $event['event_type'];
            $isUpcoming = new DateTime($event['start_date']) > $currentDate;
            
            echo '<div class="event-item ' . $eventClass . ($isUpcoming ? ' upcoming-event' : '') . '" data-id="' . $event['id'] . '">';
            echo htmlspecialchars($event['title']);
            
            // Add icon for upcoming events
            if ($isUpcoming) {
                echo ' <i class="fe fe-arrow-up-circle" title="Upcoming Event"></i>';
            }
            
            // Add all-day indicator if needed
            if ($event['all_day'] == 1) {
                echo ' <i class="fe fe-clock" title="All Day Event"></i>';
            }
            
            echo '</div>';
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
    <h3 class="calendar-title">Week <?= $currentWeek ?> (<?= $firstDayOfWeek->format('M j') ?> - <?= $lastDayOfWeek->format('M j, Y') ?>)</h3>
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
  <!-- JavaScript Libraries -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/config.js"></script>
  
  <script>
    $(document).ready(function() {
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
      
      // Edit event button handler
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
            // Check if we got an error
            if (response.error) {
                alert(response.error);
                return;
            }
            
            // Populate the form with event data
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
            
            // Toggle fields based on event type
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
            
            $('#eventModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Try to parse the response if it's JSON
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    alert(response.error);
                } else {
                    alert('Error loading event: ' + error);
                }
            } catch (e) {
                // If we can't parse as JSON, show the raw error
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
      
      // Event item click handler (for viewing details)
      $(document).on('click', '.event-item, .event-list-item', function() {
        var eventId = $(this).data('id');
        if (eventId) {
          $.ajax({
            url: 'get_event.php',
            type: 'GET',
            data: {id: eventId},
            dataType: 'json',
            success: function(event) {
              var modalContent = `
                <div class="event-details">
                  <h4>${event.title}</h4>
                  <p><strong>Type:</strong> <span class="event-type type-${event.event_type}">${event.event_type.charAt(0).toUpperCase() + event.event_type.slice(1)}</span></p>
                  <p><strong>Date:</strong> ${moment(event.start_date).format('MMMM D, YYYY')}${event.end_date && event.end_date !== event.start_date ? ' to ' + moment(event.end_date).format('MMMM D, YYYY') : ''}</p>
              `;
              
              if (!event.all_day && event.start_time) {
                modalContent += `<p><strong>Time:</strong> ${moment(event.start_time, 'HH:mm:ss').format('h:mm A')}`;
                if (event.end_time) {
                  modalContent += ` to ${moment(event.end_time, 'HH:mm:ss').format('h:mm A')}`;
                }
                modalContent += `</p>`;
              } else {
                modalContent += `<p><strong>Time:</strong> All day</p>`;
              }
              
              if (event.is_online && event.meeting_link) {
                modalContent += `<p><strong>Meeting Link:</strong> <a href="${event.meeting_link}" target="_blank">${event.meeting_link}</a></p>`;
              } else if (event.location) {
                modalContent += `<p><strong>Location:</strong> ${event.location}</p>`;
              }
              
              if (event.description) {
                modalContent += `<p><strong>Description:</strong><br>${event.description}</p>`;
              }
              
              modalContent += `</div>`;
              
              // Create a temporary modal to show details
              var detailsModal = `
                <div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Event Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        ${modalContent}
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary edit-event" data-id="${event.id}">Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
              `;
              
              $('body').append(detailsModal);
              $('#eventDetailsModal').modal('show');
              
              // Remove modal when closed
              $('#eventDetailsModal').on('hidden.bs.modal', function() {
                $(this).remove();
              });
              
              // Handle edit button in details modal
              $('.edit-event').click(function() {
                $('#eventDetailsModal').modal('hide');
                var eventId = $(this).data('id');
                $('.edit-event[data-id="' + eventId + '"]').click();
              });
            },
            error: function(xhr, status, error) {
              alert('Error loading event details: ' + error);
            }
          });
        }
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