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

        <!-- HR Navigation -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>HR Management</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="employees.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Employees</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="recruitment.php">
              <i class="fe fe-user-plus fe-16"></i>
              <span class="ml-3 item-text">Recruitment</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="attendance.php">
              <i class="fe fe-calendar fe-16"></i>
              <span class="ml-3 item-text">Attendance</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="leave.php">
              <i class="fe fe-clock fe-16"></i>
              <span class="ml-3 item-text">Leave Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payroll.php">
              <i class="fe fe-dollar-sign fe-16"></i>
              <span class="ml-3 item-text">Payroll</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="performance.php">
              <i class="fe fe-bar-chart-2 fe-16"></i>
              <span class="ml-3 item-text">Performance</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reports.php">
              <i class="fe fe-file-text fe-16"></i>
              <span class="ml-3 item-text">Reports</span>
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

        <!-- Key Metrics Cards -->
        <div class="row">
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Employees</h6>
                    <span class="h2 mb-0">248</span>
                    <span class="badge badge-success-soft ml-2">
                      <i class="fe fe-arrow-up"></i> 3.2%
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-users fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Present Today</h6>
                    <span class="h2 mb-0">235</span>
                    <span class="badge badge-success-soft ml-2">
                      <i class="fe fe-arrow-up"></i> 2.1%
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-user-check fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">On Leave</h6>
                    <span class="h2 mb-0">13</span>
                    <span class="badge badge-danger-soft ml-2">
                      <i class="fe fe-arrow-down"></i> 1.5%
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-clock fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Open Positions</h6>
                    <span class="h2 mb-0">8</span>
                    <span class="badge badge-warning-soft ml-2">
                      <i class="fe fe-arrow-up"></i> 2
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-briefcase fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Additional Metrics Row -->
        <div class="row">
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Average Attendance</h6>
                    <span class="h2 mb-0">94.8%</span>
                    <span class="badge badge-success-soft ml-2">
                      <i class="fe fe-arrow-up"></i> 1.2%
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-percent fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Pending Leaves</h6>
                    <span class="h2 mb-0">5</span>
                    <span class="badge badge-warning-soft ml-2">
                      <i class="fe fe-alert-circle"></i> New
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-calendar fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Training Programs</h6>
                    <span class="h2 mb-0">3</span>
                    <span class="badge badge-info-soft ml-2">
                      <i class="fe fe-book"></i> Active
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-book fe-24 text-muted"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Employee Turnover</h6>
                    <span class="h2 mb-0">2.1%</span>
                    <span class="badge badge-success-soft ml-2">
                      <i class="fe fe-arrow-down"></i> 0.5%
                    </span>
                  </div>
                  <div class="col-auto">
                    <span class="fe fe-refresh-cw fe-24 text-muted"></span>
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
                <canvas id="departmentChart" height="300"></canvas>
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
                <canvas id="attendanceChart" height="300"></canvas>
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
                <canvas id="genderChart" height="300"></canvas>
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
                <canvas id="ageChart" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activities and Upcoming Events -->
        <div class="row">
          <!-- Recent Activities -->
          <div class="col-md-8">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Recent Activities</h4>
              </div>
              <div class="card-body">
                <div class="list-group list-group-flush">
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-user-plus fe-24 text-primary"></span>
                      </div>
                      <div class="col">
                        <h6 class="mb-1">New Employee Onboarded</h6>
                        <p class="small text-muted mb-0">John Doe joined as Software Engineer</p>
                      </div>
                      <div class="col-auto">
                        <small class="text-muted">2 hours ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-calendar fe-24 text-success"></span>
                      </div>
                      <div class="col">
                        <h6 class="mb-1">Leave Request Approved</h6>
                        <p class="small text-muted mb-0">Sarah Smith's leave request was approved</p>
                      </div>
                      <div class="col-auto">
                        <small class="text-muted">4 hours ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-award fe-24 text-warning"></span>
                      </div>
                      <div class="col">
                        <h6 class="mb-1">Performance Review Completed</h6>
                        <p class="small text-muted mb-0">Q1 Performance reviews completed for IT Department</p>
                      </div>
                      <div class="col-auto">
                        <small class="text-muted">1 day ago</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Upcoming Events -->
          <div class="col-md-4">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Upcoming Events</h4>
              </div>
              <div class="card-body">
                <div class="list-group list-group-flush">
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <div class="calendar-date">
                          <span class="month">JUN</span>
                          <span class="day">15</span>
                        </div>
                      </div>
                      <div class="col">
                        <h6 class="mb-1">Team Building Event</h6>
                        <p class="small text-muted mb-0">Annual team building activity</p>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <div class="calendar-date">
                          <span class="month">JUN</span>
                          <span class="day">20</span>
                        </div>
                      </div>
                      <div class="col">
                        <h6 class="mb-1">HR Training Session</h6>
                        <p class="small text-muted mb-0">New HR policies training</p>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <div class="calendar-date">
                          <span class="month">JUN</span>
                          <span class="day">25</span>
                        </div>
                      </div>
                      <div class="col">
                        <h6 class="mb-1">Quarterly Review</h6>
                        <p class="small text-muted mb-0">Q2 Performance reviews</p>
                      </div>
                    </div>
                  </div>
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
        labels: ['IT', 'HR', 'Finance', 'Marketing', 'Operations'],
        datasets: [{
          data: [30, 15, 20, 25, 10],
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
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        datasets: [{
          label: 'Present',
          data: [240, 235, 242, 238, 235],
          borderColor: '#4e73df',
          tension: 0.1
        }, {
          label: 'Absent',
          data: [8, 13, 6, 10, 13],
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
        labels: ['Male', 'Female', 'Other'],
        datasets: [{
          data: [55, 42, 3],
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
        labels: ['18-25', '26-35', '36-45', '46-55', '56+'],
        datasets: [{
          label: 'Number of Employees',
          data: [45, 85, 65, 35, 18],
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