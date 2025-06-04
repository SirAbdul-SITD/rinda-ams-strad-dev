<?php 
require_once '../settings.php';
require_once '../auth.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

// Get departments and designations for bulk messaging
$stmt = $pdo->query("SELECT id, department FROM departments ORDER BY department");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT id, designation FROM designations ORDER BY designation");
$designations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get staff list for individual messaging
$stmt = $pdo->query("
    SELECT s.id, CONCAT(s.first_name, ' ', s.last_name) as name, d.department 
    FROM staffs s
    LEFT JOIN departments d ON s.department_id = d.id
    ORDER BY s.first_name, s.last_name
");
$staff_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Message Center | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="../css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .card {
      border-radius: 8px;
    }
    .popup {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      z-index: 9999;
      display: flex;
      align-items: center;
      background-color: rgba(0, 10, 5, 0.8);
      color: #fff;
    }
    .popup.success {
      background-color: #4CAF50;
      color: #fff;
    }
    .popup.error {
      background-color: #F44336;
      color: white;
    }
    .popup i {
      margin-right: 5px;
    }
    .message-card {
      transition: transform 0.2s;
    }
    .message-card:hover {
      transform: translateY(-5px);
    }
    .select2-container {
      width: 100% !important;
    }
    .message-history {
      max-height: 400px;
      overflow-y: auto;
    }
    .message-item {
      border-left: 3px solid #4e73df;
      margin-bottom: 1rem;
      padding: 1rem;
      background-color: #f8f9fc;
    }
    .message-item.unread {
      border-left-color: #e74a3b;
      background-color: #fff;
    }
  </style>
</head>

<body class="vertical light">
  <div class="wrapper">
    <!-- Top Navigation -->
    <nav class="topnav navbar navbar-light">
      <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
      </button>
      <form class="form-inline mr-auto searchform text-muted">
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
      </form>
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
            <i class="fe fe-sun fe-16"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
            <span class="fe fe-grid fe-16"></span>
          </a>
        </li>
        <li class="nav-item nav-notif">
          <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
            <span class="fe fe-bell fe-16"></span>
            <span class="dot dot-md bg-success"></span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="avatar avatar-sm mt-2">
              <img src="../assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <div class="col-12 text-left">
              <p style="padding: 0%; margin: 0%;"><?= $full_name; ?></p>
              <strong><?= $account_type; ?></strong>
            </div>
            <hr width="80%">
            <a class="dropdown-item text-muted" href="#">Profile</a>
            <a class="dropdown-item text-muted" href="#">Settings</a>
            <a class="dropdown-item" href="../logout.php">Log out</a>
          </div>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
      <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
      </a>
      <nav class="vertnav navbar navbar-light">
        <div class="w-100 mb-4 d-flex">
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
          </a>
        </div>

        <!-- Staffs Section -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Staffs</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="staff.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Staffs Directory</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="department.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Department</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="designation.php">
              <i class="fe fe-book fe-16"></i>
              <span class="ml-3 item-text">Designation</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="attendance.php">
              <i class="fe fe-calendar fe-16"></i>
              <span class="ml-3 item-text">Attendance</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="penalties.php">
              <i class="fe fe-alert-triangle fe-16"></i>
              <span class="ml-3 item-text">Penalties</span>
            </a>
          </li>
        </ul>

        <!-- Leave Section -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Leave</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="leave-application.php">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Leave Application</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="leave-category.php">
              <i class="fe fe-copy fe-16"></i>
              <span class="ml-3 item-text">Leave Category</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="approved-leave.php">
              <i class="fe fe-server fe-16"></i>
              <span class="ml-3 item-text">Approved Leave</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pending-leave.php">
              <i class="fe fe-fast-forward fe-16"></i>
              <span class="ml-3 item-text">Pending Requests</span>
            </a>
          </li>
        </ul>

        <!-- Extras Section -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Extras</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="message.php">
              <i class="fe fe-mail fe-16"></i>
              <span class="ml-3 item-text">Message</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payroll.php">
              <i class="fe fe-dollar-sign fe-16"></i>
              <span class="ml-3 item-text">Payroll</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main role="main" class="main-content">
      <div class="container-fluid">
        <!-- Page Header -->
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-12 col-md-auto">
            <h1 class="h2 mb-2">Message Center</h1>
            <p class="text-muted">Send messages and emails to staff members</p>
          </div>
          <div class="col-12 col-md-auto">
            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newMessageModal">
                <i class="fe fe-plus fe-16 mr-2"></i>New Message
              </button>
              <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#bulkMessageModal">
                <i class="fe fe-mail fe-16 mr-2"></i>Bulk Message
              </button>
            </div>
          </div>
        </div>

        <!-- Message Statistics -->
        <div class="row">
          <div class="col-md-3">
            <div class="card shadow mb-4 message-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Messages</h6>
                    <span class="h2 mb-0" id="totalMessages">0</span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-mail fe-24 text-primary"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 message-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Unread Messages</h6>
                    <span class="h2 mb-0" id="unreadMessages">0</span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-mail fe-24 text-warning"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 message-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Sent Today</h6>
                    <span class="h2 mb-0" id="sentToday">0</span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-send fe-24 text-success"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 message-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Failed Messages</h6>
                    <span class="h2 mb-0" id="failedMessages">0</span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-alert-circle fe-24 text-danger"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
          <!-- Message Status Distribution -->
          <div class="col-md-6">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Message Status Distribution</h4>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="statusChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Message Trend -->
          <div class="col-md-6">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Message Trend</h4>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="trendChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Message History -->
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Message History</h4>
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-primary" id="refreshBtn">
                    <i class="fe fe-refresh-cw"></i> Refresh
                  </button>
                  <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                    Filter
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-status="all">All Messages</a>
                    <a class="dropdown-item" href="#" data-status="unread">Unread</a>
                    <a class="dropdown-item" href="#" data-status="read">Read</a>
                    <a class="dropdown-item" href="#" data-status="sent">Sent</a>
                    <a class="dropdown-item" href="#" data-status="failed">Failed</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="messageTable">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>Recipient</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Messages will be loaded here -->
                    </tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <div class="text-muted">
                    Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> messages
                  </div>
                  <nav>
                    <ul class="pagination mb-0" id="pagination">
                      <!-- Pagination will be loaded here -->
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- New Message Modal -->
  <div class="modal fade" id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="newMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newMessageModalLabel">New Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="newMessageForm">
            <div class="form-group">
              <label for="recipient">Recipient</label>
              <select class="form-control select2" id="recipient" required>
                <option value="">Select Recipient</option>
                <?php
                foreach ($staff_list as $staff):
                  $department = $staff['department'] ? " ({$staff['department']})" : "";
                  echo "<option value='{$staff['id']}'>{$staff['name']}{$department}</option>";
                endforeach;
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" class="form-control" id="subject" required>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" rows="5" required></textarea>
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="sendEmail">
                <label class="custom-control-label" for="sendEmail">Send as email</label>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="sendMessageBtn">Send Message</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bulk Message Modal -->
  <div class="modal fade" id="bulkMessageModal" tabindex="-1" role="dialog" aria-labelledby="bulkMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkMessageModalLabel">Bulk Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="bulkMessageForm">
            <div class="form-group">
              <label for="recipientGroup">Recipient Group</label>
              <select class="form-control" id="recipientGroup" required>
                <option value="">Select Group</option>
                <option value="all">All Staff</option>
                <option value="department">By Department</option>
                <option value="designation">By Designation</option>
              </select>
            </div>
            <div class="form-group" id="departmentGroup" style="display: none;">
              <label for="department">Department</label>
              <select class="form-control select2" id="department">
                <?php
                foreach ($departments as $dept):
                  echo "<option value='{$dept['id']}'>{$dept['department']}</option>";
                endforeach;
                ?>
              </select>
            </div>
            <div class="form-group" id="designationGroup" style="display: none;">
              <label for="designation">Designation</label>
              <select class="form-control select2" id="designation">
                <?php
                foreach ($designations as $desig):
                  echo "<option value='{$desig['id']}'>{$desig['designation']}</option>";
                endforeach;
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="bulkSubject">Subject</label>
              <input type="text" class="form-control" id="bulkSubject" required>
            </div>
            <div class="form-group">
              <label for="bulkMessage">Message</label>
              <textarea class="form-control" id="bulkMessage" rows="5" required></textarea>
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="bulkSendEmail">
                <label class="custom-control-label" for="bulkSendEmail">Send as email</label>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="sendBulkMessageBtn">Send Bulk Message</button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Message Modal -->
  <div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewMessageModalLabel">View Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="message-details">
            <h4 id="messageSubject"></h4>
            <div class="message-meta mb-3">
              <small class="text-muted">
                From: <span id="messageSender"></span><br>
                To: <span id="messageRecipient"></span><br>
                Date: <span id="messageDate"></span>
              </small>
            </div>
            <div class="message-content mb-3" id="messageContent"></div>
            <div class="message-attachments" id="messageAttachments"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="deleteMessageBtn">Delete</button>
          <button type="button" class="btn btn-primary" id="editMessageBtn">Edit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Message Modal -->
  <div class="modal fade" id="editMessageModal" tabindex="-1" role="dialog" aria-labelledby="editMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMessageModalLabel">Edit Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editMessageForm">
            <input type="hidden" id="editMessageId">
            <div class="form-group">
              <label for="editSubject">Subject</label>
              <input type="text" class="form-control" id="editSubject" required>
            </div>
            <div class="form-group">
              <label for="editMessage">Message</label>
              <textarea class="form-control" id="editMessage" rows="5" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveEditBtn">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src='../js/daterangepicker.js'></script>
  <script src='../js/jquery.stickOnScroll.js'></script>
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src="../js/apps.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

  <script>
    $(document).ready(function() {
      let currentPage = 1;
      let currentStatus = 'all';
      let statusChart = null;
      let trendChart = null;

      // Initialize Select2
      $('.select2').select2({
        theme: 'bootstrap4'
      });

      // Load initial data
      loadMessageStats();
      loadMessageHistory();

      // Handle status filter
      $('.dropdown-item[data-status]').click(function(e) {
        e.preventDefault();
        currentStatus = $(this).data('status');
        currentPage = 1;
        loadMessageHistory();
      });

      // Handle refresh button
      $('#refreshBtn').click(function() {
        loadMessageStats();
        loadMessageHistory();
      });

      // Handle pagination
      $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        currentPage = $(this).data('page');
        loadMessageHistory();
      });

      // Handle view message
      $(document).on('click', '.view-message', function() {
        const messageId = $(this).data('id');
        viewMessage(messageId);
      });

      // Handle delete message
      $('#deleteMessageBtn').click(function() {
        const messageId = $('#editMessageId').val();
        if (confirm('Are you sure you want to delete this message?')) {
          deleteMessage(messageId);
        }
      });

      // Handle edit message
      $('#editMessageBtn').click(function() {
        $('#viewMessageModal').modal('hide');
        $('#editMessageModal').modal('show');
      });

      // Handle save edit
      $('#saveEditBtn').click(function() {
        const messageId = $('#editMessageId').val();
        const subject = $('#editSubject').val();
        const message = $('#editMessage').val();

        $.ajax({
          url: 'message-operations.php',
          type: 'POST',
          data: {
            action: 'update',
            message_id: messageId,
            subject: subject,
            message: message
          },
          success: function(response) {
            const data = JSON.parse(response);
            displayPopup(data.message, data.success);
            if (data.success) {
              $('#editMessageModal').modal('hide');
              loadMessageHistory();
            }
          },
          error: function() {
            displayPopup('Error updating message', false);
          }
        });
      });

      function loadMessageStats() {
        $.ajax({
          url: 'message-operations.php',
          type: 'POST',
          data: { action: 'get_stats' },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              updateStats(data.stats);
              updateCharts(data.stats);
            }
          }
        });
      }

      function loadMessageHistory() {
        $.ajax({
          url: 'message-operations.php',
          type: 'POST',
          data: {
            action: 'get_history',
            page: currentPage,
            status: currentStatus === 'all' ? '' : currentStatus
          },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              updateMessageTable(data);
              updatePagination(data);
            }
          }
        });
      }

      function viewMessage(messageId) {
        $.ajax({
          url: 'message-operations.php',
          type: 'POST',
          data: {
            action: 'view',
            message_id: messageId
          },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              displayMessage(data.message, data.attachments);
            }
          }
        });
      }

      function deleteMessage(messageId) {
        $.ajax({
          url: 'message-operations.php',
          type: 'POST',
          data: {
            action: 'delete',
            message_id: messageId
          },
          success: function(response) {
            const data = JSON.parse(response);
            displayPopup(data.message, data.success);
            if (data.success) {
              $('#viewMessageModal').modal('hide');
              loadMessageStats();
              loadMessageHistory();
            }
          }
        });
      }

      function updateStats(stats) {
        $('#totalMessages').text(stats.total);
        $('#unreadMessages').text(stats.unread);
        $('#sentToday').text(stats.sent_today);
        $('#failedMessages').text(stats.failed);
      }

      function updateCharts(stats) {
        // Status Distribution Chart
        if (statusChart) {
          statusChart.destroy();
        }
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        statusChart = new Chart(statusCtx, {
          type: 'doughnut',
          data: {
            labels: Object.keys(stats.by_status),
            datasets: [{
              data: Object.values(stats.by_status),
              backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b'
              ]
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });

        // Message Trend Chart
        if (trendChart) {
          trendChart.destroy();
        }
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        trendChart = new Chart(trendCtx, {
          type: 'line',
          data: {
            labels: stats.by_month.map(item => item.month),
            datasets: [{
              label: 'Messages',
              data: stats.by_month.map(item => item.count),
              borderColor: '#4e73df',
              tension: 0.1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }

      function updateMessageTable(data) {
        const tbody = $('#messageTable tbody');
        tbody.empty();

        data.messages.forEach(message => {
          const row = `
            <tr>
              <td>${message.subject}</td>
              <td>${message.recipient_name}</td>
              <td>${message.recipient_department}</td>
              <td>
                <span class="badge badge-${getStatusBadgeClass(message.status)}">
                  ${message.status}
                </span>
              </td>
              <td>${moment(message.created_at).format('MMM D, YYYY HH:mm')}</td>
              <td>
                <button class="btn btn-sm btn-primary view-message" data-id="${message.id}">
                  <i class="fe fe-eye"></i>
                </button>
              </td>
            </tr>
          `;
          tbody.append(row);
        });

        // Update showing info
        const start = (data.page - 1) * data.limit + 1;
        const end = Math.min(start + data.limit - 1, data.total);
        $('#showingStart').text(start);
        $('#showingEnd').text(end);
        $('#totalRecords').text(data.total);
      }

      function updatePagination(data) {
        const totalPages = Math.ceil(data.total / data.limit);
        const pagination = $('#pagination');
        pagination.empty();

        // Previous button
        pagination.append(`
          <li class="page-item ${data.page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${data.page - 1}">Previous</a>
          </li>
        `);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
          pagination.append(`
            <li class="page-item ${data.page === i ? 'active' : ''}">
              <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
          `);
        }

        // Next button
        pagination.append(`
          <li class="page-item ${data.page === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${data.page + 1}">Next</a>
          </li>
        `);
      }

      function displayMessage(message, attachments) {
        $('#messageSubject').text(message.subject);
        $('#messageSender').text(message.sender_name);
        $('#messageRecipient').text(message.recipient_name);
        $('#messageDate').text(moment(message.created_at).format('MMM D, YYYY HH:mm'));
        $('#messageContent').html(message.message.replace(/\n/g, '<br>'));
        
        // Display attachments
        const attachmentsDiv = $('#messageAttachments');
        attachmentsDiv.empty();
        if (attachments && attachments.length > 0) {
          attachmentsDiv.append('<h6>Attachments:</h6>');
          attachments.forEach(attachment => {
            attachmentsDiv.append(`
              <a href="${attachment.file_path}" class="btn btn-sm btn-outline-primary mr-2" target="_blank">
                <i class="fe fe-paperclip"></i> ${attachment.file_name}
              </a>
            `);
          });
        }

        // Set edit form values
        $('#editMessageId').val(message.id);
        $('#editSubject').val(message.subject);
        $('#editMessage').val(message.message);

        $('#viewMessageModal').modal('show');
      }

      function getStatusBadgeClass(status) {
        switch (status) {
          case 'unread': return 'warning';
          case 'read': return 'success';
          case 'sent': return 'info';
          case 'failed': return 'danger';
          default: return 'secondary';
        }
      }

      function displayPopup(message, success) {
        const popup = document.createElement('div');
        popup.className = `popup ${success ? 'success' : 'error'}`;
        
        const icon = document.createElement('i');
        icon.className = success ? 'fe fe-check-circle' : 'fe fe-x-octagon';
        popup.appendChild(icon);

        const text = document.createElement('span');
        text.textContent = message;
        popup.appendChild(text);

        document.body.appendChild(popup);

        setTimeout(() => popup.remove(), 5000);
      }
    });
  </script>
</body>
</html> 