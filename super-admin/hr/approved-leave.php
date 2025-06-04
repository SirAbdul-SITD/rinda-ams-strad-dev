<?php require('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Approved Leave | Rinda AMS</title>
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
      /* Background color with opacity */
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

    @media (max-width: 768px) {
      .desktop {
        display: none;
        min-width: 720px;
      }
    }


    @media (min-width: 768px) {
      .mobile {
        display: none;
        min-width: 720px;
      }
    }
  </style>
</head>

<body class="vertical  light  ">
  <div class="wrapper">
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
            <div class=" col-12 text-left">
              <p style="padding: 0%; margin: 0%;">
                <?= $full_name; ?>
              </p>
              <strong>
                <?= $account_type; ?>
              </strong>
            </div>
            <hr width="80%">
            <a class="dropdown-item text-muted" href="#">Profile</a>
            <a class="dropdown-item text-muted" href="#">Settings</a>
            <a class="dropdown-item" href="../logout.php">Log out</a>
          </div>
        </li>
      </ul>
    </nav>
    <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
      <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
      </a>
      <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
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

          <!-- Leave -->
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
            <li class="nav-item active">
            <a class="nav-link text-primary" href="approved-leave.php">
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

          <!-- Extras -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extras</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">Attendance</span>
                </i>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="message.php">
                <i class="fe fe-copy fe-16"></i>
                <span class="ml-3 item-text">Message</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="payroll.php">
              <i class="fe fe-dollar-sign fe-16"></i>
                <span class="ml-3 item-text">Payroll</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="penalties.php">
                <i class="fe fe-alert-triangle fe-16"></i>
                <span class="ml-3 item-text">Penalties</span>
              </a>
            </li> -->
          </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">

          <?php
          // Enable error reporting
          error_reporting(E_ALL);
          ini_set('display_errors', 1);

          // Execute SQL query
          $sql = "SELECT 
                la.id AS id,
                CONCAT(s.first_name, ' ', s.last_name) AS name,
                lc.category AS category,
                la.start_date AS start_date,
                    CASE 
                        WHEN la.start_date IS NOT NULL AND lc.days IS NOT NULL 
                        THEN DATE_ADD(la.start_date, INTERVAL lc.days DAY)
                        ELSE NULL 
                    END AS end_date,
                la.create_datetime AS apply_date,
                    la.status AS status
            FROM
                leave_applications AS la
                        LEFT JOIN
                staffs AS s ON la.staff_id = s.id
                        LEFT JOIN
                leave_categories AS lc ON la.category_id = lc.id
            WHERE
                    LOWER(la.status) = LOWER('Approved')
                ORDER BY la.create_datetime DESC";

          try {
          $stmt = $pdo->query($sql);
              $rowCount = $stmt->rowCount();
              echo "<!-- Debug: Number of rows found: " . $rowCount . " -->";
              
              if ($rowCount === 0) {
                  // Check if there are any records in the table
                  $checkSql = "SELECT COUNT(*) as total FROM leave_applications WHERE LOWER(status) = LOWER('Approved')";
                  $checkStmt = $pdo->query($checkSql);
                  $totalApproved = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
                  echo "<!-- Debug: Total approved records in table: " . $totalApproved . " -->";
              }
          } catch (PDOException $e) {
              echo "<!-- Debug: Database error: " . $e->getMessage() . " -->";
          }
          ?>

          <?php
          // Check if query was successful
          if ($stmt->rowCount() > 0) {
          ?>
            <div class="col-12">
              <h2 class="mb-2 page-title">Approved Leave Requests</h2>
              <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                  <div class="card shadow">
                    <div class="card-body">
                      <!-- table -->
                      <table class="table datatables" id="dataTable-1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Apply Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 1;
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          ?>
                            <tr data-id="<?= $row['id']; ?>">
                              <td><?= $i++; ?></td>
                              <td><?= $row['name']; ?></td>
                              <td><?= $row['category']; ?></td>
                              <td><?= date('Y-m-d', strtotime($row['start_date'])); ?></td>
                              <td><?= date('Y-m-d', strtotime($row['end_date'])); ?></td>
                              <td><?= date('Y-m-d', strtotime($row['apply_date'])); ?></td>
                              <td class="status-cell" style="color: green">
                                <?= $row['status']; ?>
                              </td>
                              <td>
                                <div class="btn-group">
                                  <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted sr-only">Action</span>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item view-reason" href="#">View Reason</a>
                                      <a class="dropdown-item terminate-action" href="#">Terminate</a>
                                  </div>
                                </div>
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
          <?php } else { ?>
            <div class="col-12">
              <h2 class="mb-2 page-title">Approved Leave Requests</h2>
              <div class="row my-4">
                <div class="col-md-12">
                  <div class="card shadow">
                    <div class="card-body">
                      <div class="text-center">No approved leave requests found.</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

        </div> <!-- .row -->
      </div> <!-- .container-fluid -->


      <!-- terminateConfirmModal -->
      <div class="modal fade" id="terminateConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to terminate this leave?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger confirm-termination">Terminate</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="defaultModalLabel">Notifications</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
              <div class="list-group list-group-flush my-n3">
                <div class="list-group-item bg-transparent">
                  <div class="row align-items-center">
                    <div class="col text-center"> <small><strong>You're well up to date</strong></small>
                      <div class="my-0 text-muted small">No notifications available</div>
                    </div>
                  </div>
                </div>
              </div> <!-- / .list-group -->
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear All</button> </div>
          </div>
        </div>
      </div>
      <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="defaultModalLabel">Control Panel</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body px-5">
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Dashboard</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../academics/" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Academics</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../lms" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">E-Learning</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../messages" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Messages</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../shop" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Shop</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center text-white">
                      <i class="fe fe-users fe-32 align-self-center"></i>
                    </div>
                    <p class="text-success">HR</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../assessments" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Assessments</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-settings fe-32 align-self-center text-muted"></i>
                    </div>
                    <p class="text-muted">Settings</p>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main> <!-- main -->
  </div> <!-- .wrapper -->
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

  <script>
    //Function to display a popup message
    function displayPopup(message, success) {
      var popup = document.createElement('div');
      popup.className = 'popup ' + (success ? 'success' : 'error');

      var iconClass = success ? 'fa fa-check-circle' : 'fa fa-times-circle';
      var icon = document.createElement('i');
      icon.className = iconClass;
      popup.appendChild(icon);

      var text = document.createElement('span');
      text.textContent = message;
      popup.appendChild(text);

      document.body.appendChild(popup);

      setTimeout(function() {
        popup.remove();
      }, 5000);
    }



    // Event delegation for actions
    document.body.addEventListener('click', function(event) {
      if (event.target.classList.contains('resume-action')) {
        event.preventDefault();
        const parentTr = event.target.closest('tr');
        const Id = parentTr.dataset.id;
        const status = 'Approved';

        // Send AJAX request to approve the request
        $.ajax({
          type: 'POST',
          url: 'change-request-status.php',
          data: {
            id: Id,
            status: status
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Remove the row from the table
              parentTr.querySelector('.status-cell').style.color = 'green';
              parentTr.querySelector('.status-cell').innerText = status;
              displayPopup(response.message, true);
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function(error, xhr) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      } else if (event.target.classList.contains('terminate-action')) {
        event.preventDefault();
        const parentTr = event.target.closest('tr');
        const Id = parentTr.dataset.id;
        const status = 'Terminated';

        // Show confirmation modal
        $('#terminateConfirmationModal').modal('show');

        // Add click event listener to the confirmation button
        $('#terminateConfirmationModal').one('click', '.confirm-termination', function() {
          // Send AJAX request to reject the request
          $.ajax({
            type: 'POST',
            url: 'change-request-status.php',
            data: {
              id: Id,
              status: status
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {

                parentTr.querySelector('.status-cell').style.color = 'red';
                parentTr.querySelector('.status-cell').innerText = status;
                displayPopup(response.message, true);
              } else {
                displayPopup(response.message, false);
              }
            },
            error: function(error, xhr) {
              displayPopup('Error occurred during request. Contact Admin', false);
            },
            complete: function() {
              // Hide the modal after action
              $('#terminateConfirmationModal').modal('hide');
            },
          });
        });
      } else if (event.target.classList.contains('view-reason')) {
        event.preventDefault();
        const parentTr = event.target.closest('tr');
        const Id = parentTr.dataset.id;

        // Send AJAX request to view the reason
        $.ajax({
          type: 'POST',
          url: 'request_reason.php',
          data: {
            id: Id
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              $('#request-reason').text(response.message.explanatory_note); // Accessing explanatory_note property
              $('#requestReasonModal').modal('show');
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function(error, xhr) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      }
    });
  </script>



  <script>
    $('#dataTable-1').DataTable({
      autoWidth: true,
      "lengthMenu": [
        [16, 32, 64, -1],
        [16, 32, 64, "All"]
      ]
    });
  </script>
  <script src="../js/apps.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
  </script>
</body>

</html>