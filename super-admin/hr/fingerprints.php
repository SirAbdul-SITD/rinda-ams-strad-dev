<?php require_once '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Staff Fingerprints | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
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
            <a class="nav-link" href="fingerprints.php">
              <!-- <i class="fe fe-fingerprint fe-16"></i> -->
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
          <!-- <li class="nav-item">
            <a class="nav-link" href="message.php">
              <i class="fe fe-copy fe-16"></i>
              <span class="ml-3 item-text">Message</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="payroll.php">
              <i class="fe fe-dollar-sign fe-16"></i>
              <span class="ml-3 item-text">Payroll</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-12 col-md-auto">
            <h1 class="h2 mb-2">Staff Fingerprints</h1>
            <p class="text-muted">Manage staff fingerprint registrations</p>
          </div>
          <div class="col-12 col-md-auto">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerFingerprintModal">
              <i class="fe fe-plus"></i> Register New Fingerprint
            </button>
          </div>
        </div>

        <!-- Fingerprints Table -->
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="fingerprintsTable">
                    <thead>
                      <tr>
                        <th>Staff Name</th>
                        <th>Department</th>
                        <th>Fingerprint ID</th>
                        <th>Registered On</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT f.*, s.first_name, s.last_name, d.department 
                               FROM staff_fingerprints f 
                               JOIN staffs s ON f.staff_id = s.id 
                               LEFT JOIN departments d ON s.department_id = d.id 
                               ORDER BY s.first_name";
                      $stmt = $pdo->query($query);
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                          <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                          <td><?= htmlspecialchars($row['department'] ?? '') ?></td>
                          <td><?= htmlspecialchars($row['fingerprint_id']) ?></td>
                          <td><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></td>
                          <td><?= date('M d, Y H:i', strtotime($row['updated_at'])) ?></td>
                          <td>
                            <button class="btn btn-sm btn-outline-danger delete-fingerprint" 
                                    data-id="<?= $row['id'] ?>"
                                    data-staff="<?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>">
                              <i class="fe fe-trash-2"></i>
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

  <!-- Register Fingerprint Modal -->
  <div class="modal fade" id="registerFingerprintModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register New Fingerprint</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="fingerprintForm">
            <div class="form-group">
              <label>Select Staff</label>
              <select class="form-control" id="staff_id" name="staff_id" required>
                <option value="">Select Staff Member</option>
                <?php
                $staff_query = "SELECT s.*, d.department 
                              FROM staffs s 
                              LEFT JOIN departments d ON s.department_id = d.id 
                              WHERE s.id NOT IN (SELECT staff_id FROM staff_fingerprints)
                              ORDER BY s.first_name";
                $staff_stmt = $pdo->query($staff_query);
                while ($staff = $staff_stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='" . $staff['id'] . "'>" . 
                       htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']) . 
                       ' (' . htmlspecialchars($staff['department'] ?? 'No Department') . ')' .
                       "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Fingerprint ID</label>
              <input type="text" class="form-control" id="fingerprint_id" name="fingerprint_id" required>
              <small class="form-text text-muted">
                <strong>How to get the Fingerprint ID:</strong>
                <ol class="mt-2">
                  <li>Connect the Tomprint device to your computer via USB</li>
                  <li>Open the Tomprint device management software</li>
                  <li>Log in with your admin credentials</li>
                  <li>Go to "User Management" or "Fingerprint Management"</li>
                  <li>Select the staff member and register their fingerprint</li>
                  <li>Note down the generated ID number from the device</li>
                  <li>Enter that ID number here</li>
                </ol>
              </small>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveFingerprintBtn">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/apps.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#fingerprintsTable').DataTable({
        order: [[0, 'asc']],
        pageLength: 25
      });

      // Save Fingerprint
      $('#saveFingerprintBtn').click(function() {
        var formData = $('#fingerprintForm').serialize();
        var $btn = $(this);
        $btn.prop('disabled', true);

        $.ajax({
          url: 'save-fingerprint.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              location.reload();
            } else {
              alert(response.message || 'Error saving fingerprint');
              $btn.prop('disabled', false);
            }
          },
          error: function() {
            alert('Error connecting to the server');
            $btn.prop('disabled', false);
          }
        });
      });

      // Delete Fingerprint
      $(document).on('click', '.delete-fingerprint', function() {
        if (confirm('Are you sure you want to delete this fingerprint registration?')) {
          var id = $(this).data('id');
          var $btn = $(this);
          $btn.prop('disabled', true);

          $.ajax({
            url: 'delete-fingerprint.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                location.reload();
              } else {
                alert(response.message || 'Error deleting fingerprint');
                $btn.prop('disabled', false);
              }
            },
            error: function() {
              alert('Error connecting to the server');
              $btn.prop('disabled', false);
            }
          });
        }
      });
    });
  </script>
</body>
</html> 