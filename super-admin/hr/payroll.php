<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Payroll Management | Rinda AMS</title>
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
    .salary-card {
      transition: transform 0.2s;
    }
    .salary-card:hover {
      transform: translateY(-5px);
    }
    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 12px;
      font-weight: 600;
    }
    .status-paid {
      background-color: #e8f5e9;
      color: #2e7d32;
    }
    .status-pending {
      background-color: #fff3e0;
      color: #ef6c00;
    }
    .status-processing {
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
          <li class="nav-item">
            <a class="nav-link" href="message.php">
              <i class="fe fe-copy fe-16"></i>
              <span class="ml-3 item-text">Message</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link text-primary" href="payroll.php">
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
            <h1 class="h2 mb-2">Payroll Management</h1>
            <p class="text-muted">Manage staff salaries and payments</p>
          </div>
          <div class="col-12 col-md-auto">
            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generatePayrollModal">
                <i class="fe fe-plus fe-16 mr-2"></i>Generate Payroll
              </button>
              <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#payrollReportModal">
                <i class="fe fe-download fe-16 mr-2"></i>Download Report
              </button>
            </div>
          </div>
        </div>

        <?php
        // Fetch payroll summary
        try {
            // Total salary paid this month
            $current_month = date('Y-m');
            $query_total_salary = "SELECT SUM(net_salary) as total FROM payroll WHERE DATE_FORMAT(payment_date, '%Y-%m') = ?";
            $stmt_total_salary = $pdo->prepare($query_total_salary);
            $stmt_total_salary->execute([$current_month]);
            $total_salary = $stmt_total_salary->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // Pending payments
            $query_pending = "SELECT COUNT(*) as pending FROM payroll WHERE status = 'pending'";
            $stmt_pending = $pdo->query($query_pending);
            $pending_payments = $stmt_pending->fetch(PDO::FETCH_ASSOC)['pending'];

            // Total deductions this month
            $query_deductions = "SELECT SUM(total_deductions) as total FROM payroll WHERE DATE_FORMAT(payment_date, '%Y-%m') = ?";
            $stmt_deductions = $pdo->prepare($query_deductions);
            $stmt_deductions->execute([$current_month]);
            $total_deductions = $stmt_deductions->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // Total allowances this month
            $query_allowances = "SELECT SUM(total_allowances) as total FROM payroll WHERE DATE_FORMAT(payment_date, '%Y-%m') = ?";
            $stmt_allowances = $pdo->prepare($query_allowances);
            $stmt_allowances->execute([$current_month]);
            $total_allowances = $stmt_allowances->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

        <!-- Summary Cards -->
        <div class="row">
          <div class="col-md-3">
            <div class="card shadow mb-4 salary-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Salary Paid</h6>
                    <span class="h2 mb-0">$<?= number_format($total_salary, 2) ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-dollar-sign fe-24 text-primary"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 salary-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Pending Payments</h6>
                    <span class="h2 mb-0"><?= $pending_payments ?></span>
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
            <div class="card shadow mb-4 salary-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Deductions</h6>
                    <span class="h2 mb-0">$<?= number_format($total_deductions, 2) ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-minus-circle fe-24 text-danger"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 salary-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Allowances</h6>
                    <span class="h2 mb-0">$<?= number_format($total_allowances, 2) ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-plus-circle fe-24 text-success"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Payroll Table -->
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Recent Payroll Records</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="payrollTable">
                    <thead>
                      <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Basic Salary</th>
                        <th>Allowances</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      try {
                          $query = "SELECT p.*, s.first_name, s.last_name, d.department 
                                  FROM payroll p 
                                  JOIN staffs s ON p.staff_id = s.id 
                                  JOIN departments d ON s.department_id = d.id 
                                  ORDER BY p.payment_date DESC 
                                  LIMIT 10";
                          $stmt = $pdo->query($query);
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              $status_class = '';
                              switch ($row['status']) {
                                  case 'paid':
                                      $status_class = 'status-paid';
                                      break;
                                  case 'pending':
                                      $status_class = 'status-pending';
                                      break;
                                  case 'processing':
                                      $status_class = 'status-processing';
                                      break;
                              }
                              ?>
                              <tr>
                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                <td><?= $row['department'] ?></td>
                                <td>$<?= number_format($row['basic_salary'], 2) ?></td>
                                <td>$<?= number_format($row['total_allowances'], 2) ?></td>
                                <td>$<?= number_format($row['total_deductions'], 2) ?></td>
                                <td>$<?= number_format($row['net_salary'], 2) ?></td>
                                <td><?= date('M d, Y', strtotime($row['payment_date'])) ?></td>
                                <td>
                                  <span class="status-badge <?= $status_class ?>">
                                    <?= ucfirst($row['status']) ?>
                                  </span>
                                </td>
                                <td>
                                  <button class="btn btn-sm btn-primary view-payslip" data-id="<?= $row['id'] ?>">
                                    <i class="fe fe-eye"></i>
                                  </button>
                                  <?php if ($row['status'] == 'pending') { ?>
                                    <button class="btn btn-sm btn-success process-payment" data-id="<?= $row['id'] ?>">
                                      <i class="fe fe-check"></i>
                                    </button>
                                  <?php } ?>
                                </td>
                              </tr>
                              <?php
                          }
                      } catch (PDOException $e) {
                          echo "Error: " . $e->getMessage();
                      }
                      ?>
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

  <!-- Generate Payroll Modal -->
  <div class="modal fade" id="generatePayrollModal" tabindex="-1" role="dialog" aria-labelledby="generatePayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="generatePayrollModalLabel">Generate Payroll</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="generatePayrollForm">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="payrollMonth">Payroll Month</label>
                <input type="month" class="form-control" id="payrollMonth" required>
              </div>
              <div class="form-group col-md-6">
                <label for="paymentDate">Payment Date</label>
                <input type="date" class="form-control" id="paymentDate" required>
              </div>
            </div>
            <div class="form-group">
              <label for="department">Department</label>
              <select class="form-control" id="department">
                <option value="">All Departments</option>
                <?php
                try {
                    $query = "SELECT * FROM departments ORDER BY department";
                    $stmt = $pdo->query($query);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['department']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="generatePayrollBtn">Generate Payroll</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Payroll Report Modal -->
  <div class="modal fade" id="payrollReportModal" tabindex="-1" role="dialog" aria-labelledby="payrollReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="payrollReportModalLabel">Download Payroll Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="payrollReportForm">
            <div class="form-group">
              <label for="reportMonth">Select Month</label>
              <input type="month" class="form-control" id="reportMonth" required>
            </div>
            <div class="form-group">
              <label for="reportType">Report Type</label>
              <select class="form-control" id="reportType" required>
                <option value="summary">Summary Report</option>
                <option value="detailed">Detailed Report</option>
                <option value="department">Department-wise Report</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="downloadReportBtn">Download</button>
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
      $('#payrollTable').DataTable({
        autoWidth: true,
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ]
      });

      // Generate Payroll
      $('#generatePayrollBtn').click(function() {
        const month = $('#payrollMonth').val();
        const paymentDate = $('#paymentDate').val();
        const department = $('#department').val();

        $.ajax({
          url: 'generate-payroll.php',
          type: 'POST',
          data: {
            month: month,
            payment_date: paymentDate,
            department: department
          },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              displayPopup(data.message, true);
              $('#generatePayrollModal').modal('hide');
              setTimeout(() => location.reload(), 2000);
            } else {
              displayPopup(data.message, false);
            }
          },
          error: function() {
            displayPopup('Error generating payroll', false);
          }
        });
      });

      // Process Payment
      $('.process-payment').click(function() {
        const payrollId = $(this).data('id');
        $.ajax({
          url: 'process-payment.php',
          type: 'POST',
          data: { id: payrollId },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              displayPopup(data.message, true);
              setTimeout(() => location.reload(), 2000);
            } else {
              displayPopup(data.message, false);
            }
          },
          error: function() {
            displayPopup('Error processing payment', false);
          }
        });
      });

      // View Payslip
      $('.view-payslip').click(function() {
        const payrollId = $(this).data('id');
        window.open(`view-payslip.php?id=${payrollId}`, '_blank');
      });

      // Download Report
      $('#downloadReportBtn').click(function() {
        const month = $('#reportMonth').val();
        const type = $('#reportType').val();
        window.location.href = `download-payroll-report.php?month=${month}&type=${type}`;
      });
    });

    // Display popup message
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
  </script>
</body>
</html> 