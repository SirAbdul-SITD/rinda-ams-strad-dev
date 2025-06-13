<?php require_once '../settings.php' ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>HR Dashboard | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="../css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
  <!-- Chart.js CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.css">
  <style>
    .card {
      border-radius: 8px;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .card-header {
      background-color: #f8f9fc;
      border-bottom: 1px solid #e3e6f0;
    }
    .metric-card {
      transition: transform 0.2s;
    }
    .metric-card:hover {
      transform: translateY(-5px);
    }
    .chart-container {
      position: relative;
      height: 300px;
    }
    .activity-icon {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      background-color: #f8f9fc;
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="index.php">
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
            <a class="nav-link" href="fingerprints.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Fingerprints</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="penalties.php">
              <i class="fe fe-alert-triangle fe-16"></i>
              <span class="ml-3 item-text">Penalties</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="penalties-types.php">
              <i class="fe fe-list fe-16"></i>
              <span class="ml-3 item-text">Penalty Types</span>
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
            <h1 class="h2 mb-2">HR Dashboard</h1>
            <p class="text-muted">Welcome back, <?= $full_name; ?>!</p>
          </div>
          <div class="col-12 col-md-auto">
            <div class="btn-group">
              <button type="button" class="btn btn-primary">Today</button>
              <button type="button" class="btn btn-outline-primary">This Week</button>
              <button type="button" class="btn btn-outline-primary">This Month</button>
            </div>
          </div>
        </div>

        <?php
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Fetch total employees count
        try {
            $query_total_employees = "SELECT COUNT(*) as total FROM staffs";
            $stmt_total_employees = $pdo->query($query_total_employees);
            $total_employees = $stmt_total_employees->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            echo "Error fetching total employees: " . $e->getMessage();
            $total_employees = 0;
        }

        // Fetch present employees today
        try {
            $today = date('Y-m-d');
            $query_present = "SELECT COUNT(*) as present FROM staffs_attendance WHERE date = ? AND status = 'present'";
            $stmt_present = $pdo->prepare($query_present);
            $stmt_present->execute([$today]);
            $present_today = $stmt_present->fetch(PDO::FETCH_ASSOC)['present'];
        } catch (PDOException $e) {
            echo "Error fetching present employees: " . $e->getMessage();
            $present_today = 0;
        }

        // Fetch employees on leave today
        try {
            $query_on_leave = "SELECT COUNT(*) as on_leave FROM leave_applications WHERE start_date <= ? AND end_date >= ? AND status = 'approved'";
            $stmt_on_leave = $pdo->prepare($query_on_leave);
            $stmt_on_leave->execute([$today, $today]);
            $on_leave = $stmt_on_leave->fetch(PDO::FETCH_ASSOC)['on_leave'];
        } catch (PDOException $e) {
            echo "Error fetching employees on leave: " . $e->getMessage();
            $on_leave = 0;
        }

        // Fetch pending leave requests
        try {
            $query_pending_leaves = "SELECT COUNT(*) as pending FROM leave_applications WHERE status = 'pending'";
            $stmt_pending_leaves = $pdo->query($query_pending_leaves);
            $pending_leaves = $stmt_pending_leaves->fetch(PDO::FETCH_ASSOC)['pending'];
        } catch (PDOException $e) {
            echo "Error fetching pending leaves: " . $e->getMessage();
            $pending_leaves = 0;
        }

        // Fetch department distribution
        try {
            $query_departments = "SELECT d.department as name, COUNT(s.id) as count 
                                FROM departments d 
                                LEFT JOIN staffs s ON d.id = s.department_id 
                                GROUP BY d.id";
            $stmt_departments = $pdo->query($query_departments);
            $departments = $stmt_departments->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching department distribution: " . $e->getMessage();
            $departments = [];
        }

        // Fetch attendance trend for the week
        try {
            $week_start = date('Y-m-d', strtotime('monday this week'));
            $week_end = date('Y-m-d', strtotime('sunday this week'));
            $query_attendance_trend = "SELECT date, 
                                     COUNT(CASE WHEN status = 'present' THEN 1 END) as present,
                                     COUNT(CASE WHEN status = 'absent' THEN 1 END) as absent
                                     FROM staffs_attendance 
                                     WHERE date BETWEEN ? AND ?
                                     GROUP BY date
                                     ORDER BY date";
            $stmt_attendance_trend = $pdo->prepare($query_attendance_trend);
            $stmt_attendance_trend->execute([$week_start, $week_end]);
            $attendance_trend = $stmt_attendance_trend->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching attendance trend: " . $e->getMessage();
            $attendance_trend = [];
        }

        // Fetch gender distribution
        try {
            $query_gender = "SELECT gender, COUNT(*) as count FROM staffs GROUP BY gender";
            $stmt_gender = $pdo->query($query_gender);
            $gender_distribution = $stmt_gender->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching gender distribution: " . $e->getMessage();
            $gender_distribution = [];
        }

        // Fetch age distribution
        try {
            $query_age = "SELECT 
                         CASE 
                             WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
                             WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 26 AND 35 THEN '26-35'
                             WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 36 AND 45 THEN '36-45'
                             WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 46 AND 55 THEN '46-55'
                             ELSE '56+'
                         END as age_group,
                         COUNT(*) as count
                         FROM staffs
                         WHERE dob IS NOT NULL
                         GROUP BY age_group
                         ORDER BY age_group";
            $stmt_age = $pdo->query($query_age);
            $age_distribution = $stmt_age->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching age distribution: " . $e->getMessage();
            $age_distribution = [];
        }

        // Fetch recent activities
        try {
            $query_activities = "SELECT 'leave' as type, 
                               CONCAT(s.first_name, ' ', s.last_name) as employee_name,
                               'applied for leave' as action,
                               la.create_datetime as timestamp
                               FROM leave_applications la
                               JOIN staffs s ON la.staff_id = s.id
                               WHERE la.create_datetime >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                               ORDER BY la.create_datetime DESC
                               LIMIT 5";
            $stmt_activities = $pdo->query($query_activities);
            $recent_activities = $stmt_activities->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching recent activities: " . $e->getMessage();
            $recent_activities = [];
        }
        ?>

        <!-- Key Metrics Cards -->
        <div class="row">
          <div class="col-md-3">
            <div class="card shadow mb-4 metric-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Employees</h6>
                    <span class="h2 mb-0"><?= $total_employees ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-users fe-24 text-primary"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 metric-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Present Today</h6>
                    <span class="h2 mb-0"><?= $present_today ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-user-check fe-24 text-success"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 metric-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">On Leave</h6>
                    <span class="h2 mb-0"><?= $on_leave ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-clock fe-24 text-warning"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 metric-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Pending Leaves</h6>
                    <span class="h2 mb-0"><?= $pending_leaves ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-calendar fe-24 text-danger"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
          <!-- Department Distribution -->
          <div class="col-md-6">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Department Distribution</h4>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="departmentChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Attendance Trend -->
          <div class="col-md-6">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Attendance Trend</h4>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="attendanceChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Additional Charts Row -->
        <div class="row">
          <!-- Gender Distribution -->
          <div class="col-md-6">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Gender Distribution</h4>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="genderChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Age Distribution -->
          <div class="col-md-6">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Age Distribution</h4>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="ageChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Recent Activities</h4>
              </div>
              <div class="card-body">
                <div class="list-group list-group-flush">
                  <?php foreach ($recent_activities as $activity): ?>
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <div class="activity-icon">
                          <span class="fe fe-<?= $activity['type'] == 'leave' ? 'calendar' : 'user-check' ?> fe-24 text-primary"></span>
                        </div>
                      </div>
                      <div class="col">
                        <h6 class="mb-1"><?= $activity['employee_name'] ?></h6>
                        <p class="small text-muted mb-0"><?= $activity['action'] ?></p>
                      </div>
                      <div class="col-auto">
                        <small class="text-muted"><?= date('M d, Y H:i', strtotime($activity['timestamp'])) ?></small>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

  <!-- Chart Initialization -->
  <script>
    // Department Distribution Chart
    const departmentCtx = document.getElementById('departmentChart').getContext('2d');
    new Chart(departmentCtx, {
      type: 'doughnut',
      data: {
        labels: <?= json_encode(array_column($departments, 'name')) ?>,
        datasets: [{
          data: <?= json_encode(array_column($departments, 'count')) ?>,
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

    // Attendance Trend Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode(array_column($attendance_trend, 'date')) ?>,
        datasets: [{
          label: 'Present',
          data: <?= json_encode(array_column($attendance_trend, 'present')) ?>,
          borderColor: '#4e73df',
          tension: 0.1
        }, {
          label: 'Absent',
          data: <?= json_encode(array_column($attendance_trend, 'absent')) ?>,
          borderColor: '#e74a3b',
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
      type: 'pie',
      data: {
        labels: <?= json_encode(array_column($gender_distribution, 'gender')) ?>,
        datasets: [{
          data: <?= json_encode(array_column($gender_distribution, 'count')) ?>,
          backgroundColor: [
            '#4e73df',
            '#e74a3b',
            '#36b9cc'
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

    // Age Distribution Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($age_distribution, 'age_group')) ?>,
        datasets: [{
          label: 'Number of Employees',
          data: <?= json_encode(array_column($age_distribution, 'count')) ?>,
          backgroundColor: '#4e73df'
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
  </script>
</body>

</html> 