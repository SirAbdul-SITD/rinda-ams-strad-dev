<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Penalty Types | Rinda AMS</title>
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
            <h1 class="h2 mb-2">Penalty Types</h1>
            <p class="text-muted">Manage penalty types and their associated costs</p>
          </div>
          <div class="col-12 col-md-auto">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPenaltyTypeModal">
              <i class="fe fe-plus fe-16 mr-2"></i>Add New Type
            </button>
          </div>
        </div>

        <!-- Penalty Types Table -->
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" id="penaltyTypesTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Type Name</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT * FROM penalty_types ORDER BY type_name";
                      $stmt = $pdo->query($query);
                      $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                      foreach ($types as $index => $type) {
                        echo "<tr>";
                        echo "<td>" . ($index + 1) . "</td>";
                        echo "<td>" . htmlspecialchars($type['type_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($type['description']) . "</td>";
                        echo "<td>₦" . number_format($type['amount'], 2) . "</td>";
                        echo "<td>
                                <button class='btn btn-sm btn-primary edit-type' 
                                        data-id='{$type['id']}'
                                        data-name='{$type['type_name']}'
                                        data-description='{$type['description']}'
                                        data-amount='{$type['amount']}'>
                                  <i class='fe fe-edit'></i>
                                </button>
                                <button class='btn btn-sm btn-danger delete-type' 
                                        data-id='{$type['id']}'
                                        data-name='{$type['type_name']}'>
                                  <i class='fe fe-trash'></i>
                                </button>
                              </td>";
                        echo "</tr>";
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

  <!-- Add Penalty Type Modal -->
  <div class="modal fade" id="addPenaltyTypeModal" tabindex="-1" role="dialog" aria-labelledby="addPenaltyTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPenaltyTypeModalLabel">Add New Penalty Type</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="penaltyTypeForm">
            <input type="hidden" id="type_id" name="type_id">
            <div class="form-group">
              <label for="type_name">Type Name</label>
              <input type="text" class="form-control" id="type_name" name="type_name" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="amount">Amount (₦)</label>
              <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="savePenaltyType">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this penalty type? This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
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
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src="../js/apps.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#penaltyTypesTable').DataTable({
        autoWidth: true,
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ]
      });

      // Function to display popup messages
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

      // Save Penalty Type
      $('#savePenaltyType').click(function() {
        const formData = $('#penaltyTypeForm').serialize();
        const typeId = $('#type_id').val();
        const url = typeId ? 'update-penalty-type.php' : 'add-penalty-type.php';

        // Validate form
        if (!$('#type_name').val() || !$('#amount').val()) {
          displayPopup('Please fill in all required fields', false);
          return;
        }

        $.ajax({
          url: url,
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              displayPopup(response.message, true);
              $('#addPenaltyTypeModal').modal('hide');
              setTimeout(() => location.reload(), 1000);
            } else {
              displayPopup(response.message || 'Error saving penalty type', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            displayPopup('Error saving penalty type: ' + error, false);
          }
        });
      });

      // Edit Penalty Type
      $('.edit-type').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');
        const amount = $(this).data('amount');

        $('#type_id').val(id);
        $('#type_name').val(name);
        $('#description').val(description);
        $('#amount').val(amount);
        $('#addPenaltyTypeModalLabel').text('Edit Penalty Type');
        $('#savePenaltyType').text('Update');
        $('#addPenaltyTypeModal').modal('show');
      });

      // Delete Penalty Type
      let deleteTypeId = null;
      $('.delete-type').click(function() {
        deleteTypeId = $(this).data('id');
        const typeName = $(this).data('name');
        $('#deleteConfirmModal .modal-body').html(`Are you sure you want to delete the penalty type "${typeName}"? This action cannot be undone.`);
        $('#deleteConfirmModal').modal('show');
      });

      $('#confirmDelete').click(function() {
        if (deleteTypeId) {
          $.ajax({
            url: 'delete-penalty-type.php',
            type: 'POST',
            data: { type_id: deleteTypeId },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                displayPopup(response.message, true);
                $('#deleteConfirmModal').modal('hide');
                setTimeout(() => location.reload(), 1000);
              } else {
                displayPopup(response.message || 'Error deleting penalty type', false);
              }
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);
              console.error('Response:', xhr.responseText);
              displayPopup('Error deleting penalty type: ' + error, false);
            }
          });
        }
      });

      // Reset form when modal is closed
      $('#addPenaltyTypeModal').on('hidden.bs.modal', function() {
        $('#penaltyTypeForm')[0].reset();
        $('#type_id').val('');
        $('#addPenaltyTypeModalLabel').text('Add New Penalty Type');
        $('#savePenaltyType').text('Save');
      });
    });
  </script>
</body>
</html> 