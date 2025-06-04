<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Penalties Management | Rinda AMS</title>
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
    .penalty-card {
      transition: transform 0.2s;
    }
    .penalty-card:hover {
      transform: translateY(-5px);
    }
    .status-badge {
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 12px;
      font-weight: 600;
    }
    .status-active {
      background-color: #e8f5e9;
      color: #2e7d32;
    }
    .status-pending {
      background-color: #fff3e0;
      color: #ef6c00;
    }
    .status-resolved {
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="penalties.php">
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
          <!-- <li class="nav-item active">
            <a class="nav-link text-primary" href="penalties.php">
              <i class="fe fe-alert-triangle fe-16"></i>
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
            <h1 class="h2 mb-2">Penalties Management</h1>
            <p class="text-muted">Manage staff penalties and disciplinary actions</p>
          </div>
          <div class="col-12 col-md-auto">
            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPenaltyModal">
                <i class="fe fe-plus fe-16 mr-2"></i>Add Penalty
              </button>
              <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#penaltyReportModal">
                <i class="fe fe-download fe-16 mr-2"></i>Download Report
              </button>
            </div>
          </div>
        </div>

        <?php
        // Fetch penalties summary
        try {
            // Total active penalties
            $query_active = "SELECT COUNT(*) as active FROM penalties WHERE status = 'active'";
            $stmt_active = $pdo->query($query_active);
            $active_penalties = $stmt_active->fetch(PDO::FETCH_ASSOC)['active'];

            // Total pending penalties
            $query_pending = "SELECT COUNT(*) as pending FROM penalties WHERE status = 'pending'";
            $stmt_pending = $pdo->query($query_pending);
            $pending_penalties = $stmt_pending->fetch(PDO::FETCH_ASSOC)['pending'];

            // Total resolved penalties
            $query_resolved = "SELECT COUNT(*) as resolved FROM penalties WHERE status = 'resolved'";
            $stmt_resolved = $pdo->query($query_resolved);
            $resolved_penalties = $stmt_resolved->fetch(PDO::FETCH_ASSOC)['resolved'];

            // Total penalty amount for resolved penalties only
            $query_amount = "SELECT SUM(amount) as total FROM penalties WHERE status = 'resolved'";
            $stmt_amount = $pdo->query($query_amount);
            $total_amount = $stmt_amount->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

        <!-- Summary Cards -->
        <div class="row">
          <div class="col-md-3">
            <div class="card shadow mb-4 penalty-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Active Penalties</h6>
                    <span class="h2 mb-0"><?= $active_penalties ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-alert-triangle fe-24 text-danger"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 penalty-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Pending Penalties</h6>
                    <span class="h2 mb-0"><?= $pending_penalties ?></span>
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
            <div class="card shadow mb-4 penalty-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Resolved Penalties</h6>
                    <span class="h2 mb-0"><?= $resolved_penalties ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="activity-icon">
                      <span class="fe fe-check-circle fe-24 text-success"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card shadow mb-4 penalty-card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted mb-2">Total Resolved Amount</h6>
                    <span class="h2 mb-0">₦<?= number_format($total_amount, 2) ?></span>
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
        </div>

        <!-- Penalties Table -->
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h4 class="card-title">Recent Penalties</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="penaltiesTable">
                    <thead>
                      <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      try {
                          $query = "SELECT p.*, s.first_name, s.last_name, d.department 
                                  FROM penalties p 
                                  JOIN staffs s ON p.staff_id = s.id 
                                  JOIN departments d ON s.department_id = d.id 
                                  ORDER BY p.id DESC 
                                  LIMIT 10";
                          $stmt = $pdo->query($query);
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              $status_class = '';
                              switch ($row['status']) {
                                  case 'active':
                                      $status_class = 'status-active';
                                      break;
                                  case 'pending':
                                      $status_class = 'status-pending';
                                      break;
                                  case 'resolved':
                                      $status_class = 'status-resolved';
                                      break;
                              }
                              ?>
                              <tr>
                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                <td><?= $row['department'] ?></td>
                                <td><?= ucfirst($row['type']) ?></td>
                                <td><?= $row['description'] ?></td>
                                <td>₦<?= number_format($row['amount'], 2) ?></td>
                                <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                <td>
                                  <span class="status-badge <?= $status_class ?>">
                                    <?= ucfirst($row['status']) ?>
                                  </span>
                                </td>
                                <td>
                                  <button class="btn btn-sm btn-primary view-penalty" data-id="<?= $row['id'] ?>">
                                    <i class="fe fe-eye"></i>
                                  </button>
                                  <?php if ($row['status'] == 'pending') { ?>
                                    <button class="btn btn-sm btn-success resolve-penalty" data-id="<?= $row['id'] ?>">
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

  <!-- Add Penalty Modal -->
  <div class="modal fade" id="addPenaltyModal" tabindex="-1" role="dialog" aria-labelledby="addPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPenaltyModalLabel">Add New Penalty</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addPenaltyForm">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="staff">Staff Member</label>
                <select class="form-control select2" id="staff" required>
                  <option value="">Select Staff Member</option>
                  <?php
                  try {
                      $query = "SELECT s.id, s.first_name, s.last_name, s.email, d.department 
                              FROM staffs s 
                              LEFT JOIN departments d ON s.department_id = d.id 
                              WHERE s.status = 1
                              ORDER BY s.first_name, s.last_name";
                      $stmt = $pdo->query($query);
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          $department = $row['department'] ? " ({$row['department']})" : "";
                          echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}{$department}</option>";
                      }
                  } catch (PDOException $e) {
                      echo "Error: " . $e->getMessage();
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="type">Penalty Type</label>
                <select class="form-control" id="type" required>
                  <option value="">Select Type</option>
                  <option value="late">Late Arrival</option>
                  <option value="absent">Absence</option>
                  <option value="misconduct">Misconduct</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" rows="3" required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" step="0.01" required>
              </div>
              <div class="form-group col-md-6">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" required>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="savePenaltyBtn">Save Penalty</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Penalty Report Modal -->
  <div class="modal fade" id="penaltyReportModal" tabindex="-1" role="dialog" aria-labelledby="penaltyReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="penaltyReportModalLabel">Download Penalty Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="penaltyReportForm">
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

  <!-- Edit Penalty Modal -->
  <div class="modal fade" id="editPenaltyModal" tabindex="-1" role="dialog" aria-labelledby="editPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPenaltyModalLabel">Edit Penalty</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editPenaltyForm">
            <input type="hidden" id="edit_penalty_id">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="edit_staff_id">Staff Member</label>
                <select class="form-control select2" id="edit_staff_id" required>
                  <option value="">Select Staff Member</option>
                  <?php
                  try {
                      $query = "SELECT s.id, s.first_name, s.last_name, s.email, d.department 
                              FROM staffs s 
                              LEFT JOIN departments d ON s.department_id = d.id 
                              WHERE s.status = 1
                              ORDER BY s.first_name, s.last_name";
                      $stmt = $pdo->query($query);
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          $department = $row['department'] ? " ({$row['department']})" : "";
                          echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}{$department}</option>";
                      }
                  } catch (PDOException $e) {
                      echo "Error: " . $e->getMessage();
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="edit_type">Penalty Type</label>
                <select class="form-control" id="edit_type" required>
                  <option value="">Select Type</option>
                  <option value="late">Late Arrival</option>
                  <option value="absent">Absence</option>
                  <option value="misconduct">Misconduct</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="edit_description">Description</label>
              <textarea class="form-control" id="edit_description" rows="3" required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="edit_amount">Amount</label>
                <input type="number" class="form-control" id="edit_amount" step="0.01" required>
              </div>
              <div class="form-group col-md-6">
                <label for="edit_date">Date</label>
                <input type="date" class="form-control" id="edit_date" required>
              </div>
            </div>
            <div class="form-group">
              <label for="edit_status">Status</label>
              <select class="form-control" id="edit_status" required>
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="resolved">Resolved</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="updatePenaltyBtn">Update Penalty</button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Penalty Modal -->
  <div class="modal fade" id="viewPenaltyModal" tabindex="-1" role="dialog" aria-labelledby="viewPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewPenaltyModalLabel">Penalty Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="text-muted mb-3">Staff Information</h6>
              <div class="form-group">
                <label>Full Name:</label>
                <input type="text" class="form-control" id="view_staff_name" readonly>
              </div>
              <div class="form-group">
                <label>Department:</label>
                <input type="text" class="form-control" id="view_department" readonly>
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input type="text" class="form-control" id="view_staff_email" readonly>
              </div>
              <div class="form-group">
                <label>Phone:</label>
                <input type="text" class="form-control" id="view_staff_phone" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <h6 class="text-muted mb-3">Penalty Information</h6>
              <div class="form-group">
                <label>Type:</label>
                <input type="text" class="form-control" id="view_type" readonly>
              </div>
              <div class="form-group">
                <label>Description:</label>
                <textarea class="form-control" id="view_description" rows="3" readonly></textarea>
              </div>
              <div class="form-group">
                <label>Amount:</label>
                <input type="text" class="form-control" id="view_amount" readonly>
              </div>
              <div class="form-group">
                <label>Date:</label>
                <input type="text" class="form-control" id="view_date" readonly>
              </div>
              <div class="form-group">
                <label>Status:</label>
                <input type="text" class="form-control" id="view_status" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  <script src="../js/select2.min.js"></script>

  <script>
    $(document).ready(function() {
      // Debug: Check if staff dropdown is populated
      console.log('Staff dropdown options:', $('#staff option').length);
      
      // Debug: Log when modal is shown
      $('#addPenaltyModal').on('show.bs.modal', function () {
        console.log('Modal is being shown');
        console.log('Staff dropdown options in modal:', $('#staff option').length);
      });

      // Initialize DataTable
      const penaltiesTable = $('#penaltiesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: 'get-penalties.php',
          type: 'POST',
          data: function(d) {
            return $.extend({}, d, {
              // Add any additional parameters here if needed
            });
          },
          error: function(xhr, error, thrown) {
            console.error('DataTables error:', error, thrown);
            console.error('Response:', xhr.responseText);
            displayPopup('Error loading penalties data. Please try again.', false);
          },
          dataSrc: function(json) {
            if (json.error) {
              console.error('Server error:', json.error);
              displayPopup(json.error, false);
              return [];
            }
            return json.data;
          }
        },
        columns: [
          { 
            data: 'staff_name',
            name: 'staff_name'
          },
          { 
            data: 'department',
            name: 'department'
          },
          { 
            data: 'type',
            name: 'type',
            render: function(data) {
              return data ? data.charAt(0).toUpperCase() + data.slice(1) : '';
            }
          },
          { 
            data: 'description',
            name: 'description'
          },
          { 
            data: 'amount',
            name: 'amount',
            render: function(data) {
              return data ? '₦' + parseFloat(data).toFixed(2) : '₦0.00';
            }
          },
          { 
            data: 'date',
            name: 'date',
            render: function(data) {
              return data ? moment(data).format('MMM D, YYYY') : '';
            }
          },
          { 
            data: 'status',
            name: 'status',
            render: function(data) {
              if (!data) return '';
              let badgeClass = '';
              switch(data) {
                case 'active':
                  badgeClass = 'status-active';
                  break;
                case 'pending':
                  badgeClass = 'status-pending';
                  break;
                case 'resolved':
                  badgeClass = 'status-resolved';
                  break;
              }
              return `<span class="status-badge ${badgeClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
            }
          },
          {
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
              if (!row.id) return '';
              let buttons = `
                <button class="btn btn-sm btn-info view-penalty" data-id="${row.id}" title="View Details">
                  <i class="fe fe-eye"></i>
                </button>`;
              
              if (row.status === 'pending') {
                buttons += `
                  <button class="btn btn-sm btn-success resolve-penalty" data-id="${row.id}" title="Approve Penalty">
                    <i class="fe fe-check"></i>
                  </button>`;
              }
              
              buttons += `
                <button class="btn btn-sm btn-danger delete-penalty" data-id="${row.id}" title="Delete Penalty">
                  <i class="fe fe-trash-2"></i>
                </button>`;
              
              return buttons;
            }
          }
        ],
        order: [[0, 'desc']], // Order by first column (ID) in descending order
        pageLength: 10,
        language: {
          search: "",
          searchPlaceholder: "Search penalties...",
          processing: '<i class="fe fe-loader fe-spin"></i> Loading...',
          emptyTable: "No penalties found",
          zeroRecords: "No matching penalties found",
          error: "Error loading data. Please try again."
        }
      });

      // Handle Add Penalty form submission
      $('#savePenaltyBtn').on('click', function() {
        // Get form values
        const staffId = $('#staff').val();
        const type = $('#type').val();
        const description = $('#description').val();
        const amount = $('#amount').val();
        const date = $('#date').val();

        // Validate form
        if (!staffId || !type || !description || !amount || !date) {
            displayPopup('Please fill in all required fields', false);
            return;
        }

        // Send AJAX request
        $.ajax({
            url: 'add-penalty.php',
            type: 'POST',
            data: {
                staff_id: staffId,
                type: type,
                description: description,
                amount: amount,
                date: date
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayPopup(response.message, true);
                    $('#addPenaltyModal').modal('hide');
                    // Reset form
                    $('#addPenaltyForm')[0].reset();
                    // Refresh page after 2 seconds
                    setTimeout(() => location.reload(), 2000);
                } else {
                    displayPopup(response.message, false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                displayPopup('Error adding penalty. Please try again.', false);
            }
        });
      });

      // Handle View Penalty
      $(document).on('click', '.view-penalty', function() {
        const penaltyId = $(this).data('id');
        $.ajax({
          url: 'get-penalty.php',
          type: 'POST',
          data: { id: penaltyId },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              const penalty = response.penalty;
              // Populate the view modal with penalty and staff details
              $('#view_staff_name').val(penalty.staff_name);
              $('#view_department').val(penalty.department);
              $('#view_staff_email').val(penalty.email);
              $('#view_staff_phone').val(penalty.phone);
              $('#view_type').val(penalty.type.charAt(0).toUpperCase() + penalty.type.slice(1));
              $('#view_description').val(penalty.description);
              $('#view_amount').val('₦' + parseFloat(penalty.amount).toFixed(2));
              $('#view_date').val(moment(penalty.date).format('MMM D, YYYY'));
              $('#view_status').val(penalty.status.charAt(0).toUpperCase() + penalty.status.slice(1));
              
              // Show the view modal
              $('#viewPenaltyModal').modal('show');
            } else {
              displayPopup(response.message || 'Error fetching penalty details', false);
            }
          },
          error: function() {
            displayPopup('Error fetching penalty details', false);
          }
        });
      });

      // Handle Resolve Penalty
      $(document).on('click', '.resolve-penalty', function() {
        const penaltyId = $(this).data('id');
        const confirmDialog = `
          <div class="modal fade" id="confirmResolveModal" tabindex="-1" role="dialog" aria-labelledby="confirmResolveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmResolveModalLabel">Confirm Resolution</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure you want to resolve this penalty?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-success" id="confirmResolveBtn">Resolve</button>
                </div>
              </div>
            </div>
          </div>`;

        // Remove existing modal if any
        $('#confirmResolveModal').remove();
        
        // Add modal to body
        $('body').append(confirmDialog);
        
        // Show modal
        $('#confirmResolveModal').modal('show');
        
        // Handle confirm button click
        $('#confirmResolveBtn').off('click').on('click', function() {
          $.ajax({
            url: 'resolve-penalty.php',
            type: 'POST',
            data: { id: penaltyId },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                displayPopup(response.message, true);
                $('#confirmResolveModal').modal('hide');
                // Refresh the page after successful resolution
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else {
                displayPopup(response.message || 'Error resolving penalty', false);
              }
            },
            error: function() {
              displayPopup('Error resolving penalty', false);
            },
            complete: function() {
              $('#confirmResolveModal').modal('hide');
            }
          });
        });
      });

      // Handle Delete Penalty
      $(document).on('click', '.delete-penalty', function() {
        const penaltyId = $(this).data('id');
        const confirmDialog = `
          <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this penalty? This action cannot be undone.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
              </div>
            </div>
          </div>`;

        // Remove existing modal if any
        $('#confirmDeleteModal').remove();
        
        // Add modal to body
        $('body').append(confirmDialog);
        
        // Show modal
        $('#confirmDeleteModal').modal('show');
        
        // Handle confirm button click
        $('#confirmDeleteBtn').off('click').on('click', function() {
          $.ajax({
            url: 'delete-penalty.php',
            type: 'POST',
            data: { id: penaltyId },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                displayPopup(response.message, true);
                penaltiesTable.ajax.reload();
              } else {
                displayPopup(response.message || 'Error deleting penalty', false);
              }
            },
            error: function() {
              displayPopup('Error deleting penalty', false);
            },
            complete: function() {
              $('#confirmDeleteModal').modal('hide');
            }
          });
        });
      });

      // Download Report
      $('#downloadReportBtn').click(function() {
        const month = $('#reportMonth').val();
        const type = $('#reportType').val();
        window.location.href = `download-penalty-report.php?month=${month}&type=${type}`;
      });

      // Initialize Select2 for all select elements
      $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
      });

      // Handle edit button click
      $(document).on('click', '.edit-penalty', function() {
        const penaltyId = $(this).data('id');
        
        // Fetch penalty details
        $.ajax({
          url: 'get-penalty.php',
          type: 'POST',
          data: { id: penaltyId },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              const penalty = response.penalty;
              
              // Populate form fields
              $('#edit_penalty_id').val(penalty.id);
              $('#edit_staff_id').val(penalty.staff_id).trigger('change');
              $('#edit_type').val(penalty.type);
              $('#edit_description').val(penalty.description);
              $('#edit_amount').val(penalty.amount);
              $('#edit_date').val(penalty.date);
              $('#edit_status').val(penalty.status);
              
              // Show modal
              $('#editPenaltyModal').modal('show');
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function() {
            displayPopup('Error fetching penalty details', false);
          }
        });
      });

      // Handle edit form submission
      $('#editPenaltyForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
          url: 'update-penalty.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              displayPopup('Penalty updated successfully', true);
              $('#editPenaltyModal').modal('hide');
              // Refresh the penalties table
              location.reload();
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function() {
            displayPopup('Error updating penalty', false);
          }
        });
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