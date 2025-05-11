<?php require_once '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Expenses - Admin | Rinda AMS</title>
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

    .modal-shortcut .con-item {
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .modal-shortcut .con-item:hover {
      transform: scale(1.05);
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

    .filter-btn {
      margin-right: 10px;
    }

    .filter-form .form-group {
      margin-bottom: 15px;
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
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"
          placeholder="Type something..." aria-label="Search">
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
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="avatar avatar-sm mt-2">
              <?php
              if ($gender == 'Female') { ?>
                <img src="../../uploads/staff-profiles/2.jpeg" alt="..." class="avatar-img rounded-circle">
              <?php } else { ?>
                <img src="../../uploads/staff-profiles/1.jpeg" alt="..." class="avatar-img rounded-circle">
              <?php } ?>
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
            <a class="dropdown-item" href="../profile">Profile</a>
            <a class="dropdown-item" href="../profile/settings.php">Settings</a>
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
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
          </a>
        </div>

        <!-- Dashboard -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">General Fees</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="invoices.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Student Invoices</span>
              </i>
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">School Expenses</span>
              </i>
            </a>
          </li>

          <!-- Subscriptions Types -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Subscriptions</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item">
              <a class="nav-link" href="breakfast.php">
                <i class="fe fe-coffee fe-16"></i>
                <span class="ml-3 item-text">Breakfast</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="lunch.php">
                <i class="fe fe-slack fe-16"></i>
                <span class="ml-3 item-text">Lunch</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shuttle.php">
                <i class="fe fe-truck fe-16"></i>
                <span class="ml-3 item-text">Shuttle</span>
                </i>
              </a>
            </li>

          </ul>

          <!-- Extras -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extras</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="calendar.php">
                <i class="fe fe-calendar fe-16"></i>
                <span class="ml-3 item-text">Academic Calendar</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="notice-board.php">
                <i class="fe fe-bell fe-16"></i>
                <span class="ml-3 item-text">Notice Board</span>
                </i>
              </a>
            </li>
          </ul>
          <!-- Hostel -->
          <p class=" nav-heading mt-4 mb-1">
            <span>Hostel</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link " href="hostel.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Hostels</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="room-types.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Room Types</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="hostel-membership.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Membership</span>
                </i>
              </a>
            </li>

          </ul>

          <!-- Extra -->

      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row">
              <!-- Small table -->
              <div class="col-md-12 my-4">
                <div class="row align-items-center my-3">
                  <div class="col">
                    <h3 class="page-title">Expenses</h3>
                  </div>
                  <div class="col-auto">
                    <button type="button" class="btn btn-secondary filter-btn" data-toggle="modal"
                      data-target="#filterModal">
                      <span class="fe fe-filter fe-16 mr-2"></span>Filter
                    </button>
                    <button type="button" class="btn  btn-primary" data-toggle="modal" data-target="#newModal">
                      <span class="fe fe-plus fe-16 mr-2"></span>New
                    </button>
                  </div>
                </div>

                <div class="row align-items-center my-3">
                  <div class="col-md-6 mb-6">
                    <div class="card shadow">
                      <div class="card-body">
                        <div class="row align-items-center mb-6">
                          <div class="col">
                            <?php
                            // Get total expenses
                            $query = "SELECT SUM(amount) as total FROM expenses";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            $totalExpenses = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                            // Get this month's expenses
                            $currentMonth = date('m');
                            $currentYear = date('Y');
                            $query = "SELECT SUM(amount) as total FROM expenses WHERE MONTH(date) = :month AND YEAR(date) = :year";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':month', $currentMonth, PDO::PARAM_INT);
                            $stmt->bindParam(':year', $currentYear, PDO::PARAM_INT);
                            $stmt->execute();
                            $monthlyExpenses = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                            // Calculate percentage (avoid division by zero)
                            $percentage = ($totalExpenses > 0) ? round(($monthlyExpenses / $totalExpenses) * 100, 2) : 0;
                            ?>
                            <span class="badge badge-pill badge-success" style="background-color: #93bb84">
                              <?= $percentage ?>%
                            </span>
                            <p class="small text-muted mb-0">Total paid amount</p>
                            <p class="h2 mb-0">
                              ₦<?= number_format($totalExpenses, 2) ?>
                            </p>
                          </div>
                          <div class="col-auto">
                            <br>
                            <p class="small text-muted mb-0">Expenses Count</p>
                            <p class="h2 mb-0">
                              <?php
                              $query = "SELECT COUNT(*) as count FROM expenses";
                              $stmt = $pdo->prepare($query);
                              $stmt->execute();
                              $result = $stmt->fetch(PDO::FETCH_ASSOC);
                              echo $result['count'];
                              ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-6">
                    <div class="card shadow">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col">
                            <?php
                            // Calculate percentage of monthly vs total
                            $monthlyPercentage = ($totalExpenses > 0) ? round(($monthlyExpenses / $totalExpenses) * 100, 2) : 0;
                            ?>
                            <span class="badge badge-pill badge-success" style="background-color: #FB1010">
                              <?= $monthlyPercentage ?>%
                            </span>
                            <p class="small text-muted mb-0">This Month's Expenses</p>
                            <p class="h2 mb-0">
                              ₦<?= number_format($monthlyExpenses, 2) ?>
                            </p>
                          </div>
                          <div class="col-auto">
                            <br>
                            <p class="small text-muted mb-0">This Month's Count</p>
                            <p class="h2 mb-0">
                              <?php
                              $query = "SELECT COUNT(*) as count FROM expenses WHERE MONTH(date) = :month AND YEAR(date) = :year";
                              $stmt = $pdo->prepare($query);
                              $stmt->bindParam(':month', $currentMonth, PDO::PARAM_INT);
                              $stmt->bindParam(':year', $currentYear, PDO::PARAM_INT);
                              $stmt->execute();
                              $result = $stmt->fetch(PDO::FETCH_ASSOC);
                              echo $result['count'];
                              ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!-- Striped rows -->
                  <div class="col-md-12 my-4">
                    <div class="card shadow">
                      <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="dataTable-1">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Description</th>
                              <th>Amount</th>
                              <th>Date</th>
                              <th>Additional Note</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT * FROM `expenses`";

                            // Check if filter parameters are set
                            if (isset($_GET['start_date']) && !empty($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['end_date'])) {
                              $start_date = $_GET['start_date'];
                              $end_date = $_GET['end_date'];
                              $query .= " WHERE date BETWEEN :start_date AND :end_date";
                            }

                            $stmt = $pdo->prepare($query);

                            if (isset($start_date) && isset($end_date)) {
                              $stmt->bindParam(':start_date', $start_date);
                              $stmt->bindParam(':end_date', $end_date);
                            }

                            $stmt->execute();
                            $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (!$expenses) {
                              implode($expenses);
                              echo '<p class="text-center">None added Yet!</p>';
                            } else {
                              foreach ($expenses as $index => $expense): ?>
                                <tr>
                                  <td><?= $index + 1 ?></td>
                                  <td>
                                    <p class="mb-0"><strong><?= $expense['description'] ?></strong></p>
                                  </td>
                                  <td>
                                    <p class="mb-0 text-muted">
                                      <?php $formatted_amount = '₦' . number_format($expense['amount'], 2);
                                      echo $formatted_amount;
                                      ?>
                                    </p>
                                  </td>
                                  <td class="text-muted"><?= $expense['date'] ?></td>
                                  <td class="text-muted"><?= $expense['note'] ?></td>
                                </tr>
                              <?php endforeach;
                            } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div> <!-- simple table -->
                </div> <!-- end section -->
              </div> <!-- .col-12 -->
            </div> <!-- .row -->
          </div> <!-- .container-fluid -->

          <!-- Notifications Modal -->
          <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog"
            aria-labelledby="defaultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item bg-transparent">
                      <div class="row align-items-center">
                        <div class="col text-center">
                          <small><strong>You're well up to date</strong></small>
                          <div class="my-0 text-muted small">No notifications available</div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- / .list-group -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear
                    All</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Shortcut Modal -->
          <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog"
            aria-labelledby="defaultModalLabel" aria-hidden="true">
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
                      <!-- <a href="#" style="text-decoration: none;"> -->
                      <div class="squircle bg-success justify-content-center">
                        <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-success">Dashboard</p>
                      <!-- </a> -->
                    </div>
                    <div class="col-6 text-center con-item">
                      <a href="../academics/" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center">
                          <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                        </div>
                        <p class="text-secondary control-panel-text">Academics</p>
                      </a>
                    </div>
                  </div>
                  <div class="row align-items-center">
                    <div class="col-6 text-center con-item">
                      <a href="../lms" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center">
                          <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                        </div>
                        <p class="text-secondary control-panel-text">E-Learning</p>
                      </a>
                    </div>
                    <div class="col-6 text-center con-item">
                      <a href="../messages" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center">
                          <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                        </div>
                        <p class="text-secondary control-panel-text">Messages</p>
                      </a>
                    </div>
                  </div>
                  <div class="row align-items-center">
                    <div class="col-6 text-center con-item">
                      <a href="../shop" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center">
                          <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                        </div>
                        <p class="text-secondary control-panel-text">Shop</p>
                      </a>
                    </div>
                    <div class="col-6 text-center con-item">
                      <a href="../hr/" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center text-white">
                          <i class="fe fe-users fe-32 align-self-center"></i>
                        </div>
                        <p class="text-secondary control-panel-text">HR</p>
                      </a>
                    </div>
                  </div>
                  <div class="row align-items-center">
                    <div class="col-6 text-center con-item">
                      <a href="../assessments" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center">
                          <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                        </div>
                        <p class="text-secondary control-panel-text">Assessments</p>
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

          <!-- New Expense Modal -->
          <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="newModalLabel">Add New Expense</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="newForm" class="need-validation">
                    <div class="form-group">
                      <label for="fee-name" class="col-form-label">Description:*</label>
                      <input type="text" class="form-control" name="description" required>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-6">
                        <label for="fee-name" class="col-form-label">Amount:*</label>
                        <input type="number" class="form-control" name="amount" required>
                      </div>
                      <div class="form-group col-6">
                        <label for="first_term" class="col-form-label">Date:*</label>
                        <input type="date" class="form-control" name="date" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="third_term" class="col-form-label">Additional Note:</label>
                      <textarea name="note" class="form-control"></textarea>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn mb-2 btn-primary w-100" id="saveBtn">Add Expense</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Filter Modal -->
          <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="filterModalLabel">Filter Expenses</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="filterForm" method="GET" action="">
                    <div class="form-group">
                      <label for="start_date">Start Date:</label>
                      <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="form-group">
                      <label for="end_date">End Date:</label>
                      <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" id="applyFilter">Apply Filter</button>
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

  <script>
    $(document).ready(function () {
      // Function to display a popup message
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

        setTimeout(function () {
          popup.remove();
        }, 5000);
      }

      // Event listener for saving changes
      $('#saveBtn').on('click', function () {
        form = $('#newForm');
        // Perform AJAX request to update fee information in the database
        $.ajax({
          url: 'add-expense.php',
          type: 'POST',
          data: form.serialize(),
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              displayPopup(response.message, true);
              // Remove the row from the table
              $('#newModal').modal('hide');
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function (xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
          }
        });
      });

      // Apply filter button click handler
      $('#applyFilter').on('click', function () {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        if (startDate && endDate) {
          // Submit the form to reload the page with filter parameters
          $('#filterForm').submit();
        } else {
          alert('Please select both start and end dates');
        }
      });

      // Set default dates in filter modal (current month)
      var today = new Date();
      var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
      var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

      // Format dates as YYYY-MM-DD
      var formatDate = function (date) {
        var d = new Date(date),
          month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
      };

      $('#start_date').val(formatDate(firstDay));
      $('#end_date').val(formatDate(lastDay));
    });
  </script>
</body>

</html>