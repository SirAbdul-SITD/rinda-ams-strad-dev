<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Attendance | Rinda AMS</title>
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

    .attendance-status {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 12px;
      font-weight: 500;
    }

    .status-present {
      background-color: #e8f5e9;
      color: #2e7d32;
    }

    .status-absent {
      background-color: #ffebee;
      color: #c62828;
    }

    .status-late {
      background-color: #fff3e0;
      color: #ef6c00;
    }

    .status-half-day {
      background-color: #e3f2fd;
      color: #1565c0;
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
          <li class="nav-item active">
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
              <li class="nav-item">
            <a class="nav-link" href="message.php">
              <i class="fe fe-copy fe-16"></i>
              <span class="ml-3 item-text">Message</span>
                </a>
              </li>
              <li class="nav-item">
            <a class="nav-link" href="payroll.php">
              <i class="fe fe-dollar-sign fe-16"></i>
              <span class="ml-3 item-text">Payroll</span>
            </a>
          </li>
              <!-- <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fe fe-fast-forward fe-16"></i>
              <span class="ml-3 item-text">Penalties</span>
            </a>
          </li> -->
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main role="main" class="main-content">
      <div class="container-fluid">
        <!-- Page Header -->
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-12 col-md-auto">
            <h1 class="h2 mb-2">Attendance Management</h1>
            <p class="text-muted">Mark and manage staff attendance</p>
              </div>
          <div class="col-12 col-md-auto">
            <div class="btn-group">
              <button type="button" class="btn btn-primary" id="markAttendanceBtn">Mark Attendance</button>
              <button type="button" class="btn btn-outline-primary" id="generateReportBtn">Generate Report</button>
            </div>
              </div>
            </div>

        <!-- Filters -->
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-body">
                <form id="filterForm" class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Date Range</label>
                      <input type="text" class="form-control" id="dateRange">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Department</label>
                      <select class="form-control" id="departmentFilter">
                        <option value="">All Departments</option>
                        <?php
                        $dept_query = "SELECT * FROM departments ORDER BY department";
                        $dept_stmt = $pdo->query($dept_query);
                        while ($dept = $dept_stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo "<option value='" . $dept['id'] . "'>" . htmlspecialchars($dept['department']) . "</option>";
                        }
                        ?>
                          </select>
                        </div>
                      </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                        <option value="half-day">Half Day</option>
                          </select>
                        </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Attendance Table -->
        <div class="row">
              <div class="col-md-12">
                <div class="card shadow">
                  <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="attendanceTable">
                      <thead>
                        <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Working Hours</th>
                        <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $query = "SELECT a.*, s.first_name, s.last_name, d.department 
                               FROM staffs_attendance a 
                               JOIN staffs s ON a.staff_id = s.id 
                               LEFT JOIN departments d ON s.department_id = d.id 
                               ORDER BY a.date DESC, s.first_name";
                      $stmt = $pdo->query($query);
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $status_class = '';
                        switch (strtolower($row['status'])) {
                          case 'present':
                            $status_class = 'status-present';
                            break;
                          case 'absent':
                            $status_class = 'status-absent';
                            break;
                          case 'late':
                            $status_class = 'status-late';
                            break;
                          case 'half-day':
                            $status_class = 'status-half-day';
                            break;
                        }
                        ?>
                        <tr>
                          <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                          <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                          <td><?= htmlspecialchars($row['department']) ?></td>
                          <td><span class="attendance-status <?= $status_class ?>"><?= ucfirst($row['status']) ?></span></td>
                          <td><?= $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-' ?></td>
                          <td><?= $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
                          <td><?= $row['working_hours'] ? $row['working_hours'] . ' hrs' : '-' ?></td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary edit-attendance" 
                                    data-id="<?= $row['id'] ?>"
                                    data-staff="<?= $row['staff_id'] ?>"
                                    data-date="<?= $row['date'] ?>"
                                    data-status="<?= $row['status'] ?>"
                                    data-checkin="<?= $row['check_in'] ?>"
                                    data-checkout="<?= $row['check_out'] ?>">
                              <i class="fe fe-edit"></i>
                            </button>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Mark Attendance Modal -->
  <div class="modal fade" id="markAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="markAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
          <h5 class="modal-title" id="markAttendanceModalLabel">Mark Attendance</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
          <form id="attendanceForm">
            <input type="hidden" id="attendance_id" name="attendance_id">
            <div class="form-group">
              <label>Date</label>
              <input type="date" class="form-control" id="attendance_date" name="date" required>
                    </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                  </tr>
                </thead>
                <tbody id="attendanceStaffList">
                  <?php
                  $staff_query = "SELECT s.*, d.department 
                                 FROM staffs s 
                                 LEFT JOIN departments d ON s.department_id = d.id 
                                 ORDER BY s.first_name";
                  $staff_stmt = $pdo->query($staff_query);
                  while ($staff = $staff_stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                      <td>
                        <?= htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']) ?>
                        <input type="hidden" name="staff_ids[]" value="<?= $staff['id'] ?>">
                      </td>
                      <td><?= htmlspecialchars($staff['department']) ?></td>
                      <td>
                        <select class="form-control" name="status[<?= $staff['id'] ?>]" required>
                          <option value="present">Present</option>
                          <option value="absent">Absent</option>
                          <option value="late">Late</option>
                          <option value="half-day">Half Day</option>
                        </select>
                      </td>
                      <td>
                        <input type="time" class="form-control" name="check_in[<?= $staff['id'] ?>]">
                      </td>
                      <td>
                        <input type="time" class="form-control" name="check_out[<?= $staff['id'] ?>]">
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </form>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveAttendanceBtn">Save Attendance</button>
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
  <script src='../js/jquery.dataTables.min.js'></script>
  <script src='../js/dataTables.bootstrap4.min.js'></script>
  <script src="../js/apps.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: 'get-attendance-data.php',
          type: 'GET',
          data: function(d) {
            var dateRange = $('#dateRange').val();
            var dates = dateRange.split(' - ');
            return {
              draw: d.draw,
              start: d.start,
              length: d.length,
              search: d.search.value,
              start_date: dates[0] ? moment(dates[0]).format('YYYY-MM-DD') : null,
              end_date: dates[1] ? moment(dates[1]).format('YYYY-MM-DD') : null,
              department_id: $('#departmentFilter').val(),
              status: $('#statusFilter').val()
            };
          }
        },
        columns: [
          { data: 'date' },
          { data: 'employee' },
          { data: 'department' },
          { data: 'status' },
          { data: 'check_in' },
          { data: 'check_out' },
          { data: 'working_hours' },
          { data: 'actions' }
        ],
        order: [[0, 'desc']],
        pageLength: 25
      });

      // Initialize Date Range Picker
      $('#dateRange').daterangepicker({
        opens: 'left',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
      });

      // Mark Attendance Button Click
      $('#markAttendanceBtn').click(function() {
        $('#attendance_id').val('');
        $('#attendance_date').val(moment().format('YYYY-MM-DD'));
        $('#markAttendanceModal').modal('show');
      });

      // Edit Attendance Button Click
      $(document).on('click', '.edit-attendance', function() {
        var id = $(this).data('id');
        var date = $(this).data('date');
        var status = $(this).data('status');
        var checkin = $(this).data('checkin');
        var checkout = $(this).data('checkout');

        $('#attendance_id').val(id);
        $('#attendance_date').val(date);
        $(`select[name="status[${id}]"]`).val(status);
        $(`input[name="check_in[${id}]"]`).val(checkin);
        $(`input[name="check_out[${id}]"]`).val(checkout);

        $('#markAttendanceModal').modal('show');
      });

      // Save Attendance
      $('#saveAttendanceBtn').click(function() {
        var formData = $('#attendanceForm').serialize();
        
        // Disable the save button to prevent double submission
        var $saveBtn = $(this);
        $saveBtn.prop('disabled', true);
        
        $.ajax({
          url: 'save-attendance.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              displayPopup(response.message, true);
              $('#markAttendanceModal').modal('hide');
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              displayPopup(response.message || 'Error saving attendance', false);
              $saveBtn.prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            
            var errorMessage = 'An error occurred while saving attendance';
            try {
              var response = JSON.parse(xhr.responseText);
              if (response.message) {
                errorMessage = response.message;
              }
            } catch (e) {
              console.error('Error parsing response:', e);
            }
            
            displayPopup(errorMessage, false);
            $saveBtn.prop('disabled', false);
          }
        });
      });

      // Handle status change to show/hide time inputs
      $(document).on('change', 'select[name^="status"]', function() {
        var status = $(this).val();
        var row = $(this).closest('tr');
        var checkInInput = row.find('input[name^="check_in"]');
        var checkOutInput = row.find('input[name^="check_out"]');

        if (status === 'absent') {
          checkInInput.prop('disabled', true).val('');
          checkOutInput.prop('disabled', true).val('');
        } else {
          checkInInput.prop('disabled', false);
          checkOutInput.prop('disabled', false);
        }
      });

      // Initialize time inputs based on initial status
      $('select[name^="status"]').each(function() {
        $(this).trigger('change');
      });

      // Add displayPopup function if not exists
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

      // Generate Report Button Click
      $('#generateReportBtn').click(function() {
        var dateRange = $('#dateRange').val();
        var department = $('#departmentFilter').val();
        var status = $('#statusFilter').val();
        
        // Parse date range
        var dates = dateRange.split(' - ');
        var startDate = moment(dates[0]).format('YYYY-MM-DD');
        var endDate = moment(dates[1]).format('YYYY-MM-DD');
        
        // Build report URL with parameters
        var reportUrl = 'generate-attendance-report.php?' + $.param({
          start_date: startDate,
          end_date: endDate,
          department_id: department,
          status: status
        });
        
        // Open report in new window/tab
        window.open(reportUrl, '_blank');
      });

      // Filter Form Submit
      $('#filterForm').submit(function(e) {
        e.preventDefault();
        $('#attendanceTable').DataTable().ajax.reload();
      });
    });
  </script>
</body>

</html>