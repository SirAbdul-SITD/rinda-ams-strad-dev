<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Student Invoices | Rinda AMS</title>
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

    .modal-shortcut .con-item:hover p {
      color: white !important;
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



          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Student Invoices</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="expenses.php">
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
            <li class="nav-item">
              <a class="nav-link" href="iep.php">
                <i class="fe fe-briefcase fe-16"></i>
                <span class="ml-3 item-text">IEP</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="shadow.php">
                <i class="fe fe-award fe-16"></i>
                <span class="ml-3 item-text">Shadow</span>
                </i>
              </a>
            </li>

          </ul>

          <!-- Hostel -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Hostel</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Hostels</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Room Types</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">
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

              <?php

              try {

                $curr_session = $_GET['session'] ?? $curr_session;


                $status = 'Paid';

                $sql = "SELECT
            s.id, 
            CONCAT(s.firstName, ' ', s.lastName) AS full_name, 
            c.class, 
            i.invoice_ref, 
            i.type, 
            i.amount, 
            i.paid_amount,
            i.validity, 
            i.session, 
            i.status,
            ps.parent_id,
            ps.student_id,
            CASE 
                WHEN i.term = 1 THEN 'First Term' 
                WHEN i.term = 2 THEN 'Second Term' 
                WHEN i.term = 3 THEN 'Third Term' 
                ELSE '' 
            END AS term
        FROM students s  
        INNER JOIN fees_invoices i ON i.student_id = s.id 
        INNER JOIN classes c ON i.class_id = c.id
        LEFT JOIN (
  SELECT student_id, MIN(parent_id) as parent_id
  FROM parent_student
  GROUP BY student_id
) ps ON ps.student_id = s.id
        WHERE s.status = 1 
        AND i.amount != 0 
        AND (i.session = :session) 
        ORDER BY i.term ASC, full_name ASC";


                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':session', $curr_session);
                // $stmt->bindParam(':status', $status);
                $stmt->execute();
                $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                // Handle database error
                echo 'Error: ' . $e->getMessage();
                die();
              }

              // Initialize summary variables
              $totalInvoices = 0;
              $totalInvoicesPaid = 0;
              $totalInvoicesUnpaid = 0;
              $totalAmountPaid = 0;
              $totalAmount = 0;


              // Loop through each invoice to calculate totals
              foreach ($invoices as $invoice) {
                $totalInvoices++;
                $totalAmountPaid += floatval($invoice['paid_amount']);
                $totalAmount += floatval($invoice['amount']);

                if ($invoice['status'] === 'Paid') {
                  $totalInvoicesPaid++;

                } else {

                  $totalInvoicesUnpaid++;

                }
              }

              $totalAmountUnpaid = $totalAmount - $totalAmountPaid;


              $formattedTotalInvoicesPaid = number_format($totalInvoicesPaid);
              $formattedTotalAmountPaid = '₦' . number_format($totalAmountPaid, 2);
              $formattedTotalInvoicesUnpaid = number_format($totalInvoicesUnpaid);
              $formattedTotalAmountUnpaid = '₦' . number_format($totalAmountUnpaid, 2);

              $sessionsQuery = "SELECT DISTINCT session FROM fees_invoices ORDER BY session DESC";
              $sessionsStmt = $pdo->prepare($sessionsQuery);
              $sessionsStmt->execute();
              $sessions = $sessionsStmt->fetchAll(PDO::FETCH_COLUMN); // returns array of sessions
              
              ?>
              <div class="col-md-12 my-4">
                <div class="row align-items-center my-3">
                  <div class="col">
                    <h3 class="page-title">Invoices</h3>
                  </div>
                  <div class="col-auto">
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="newDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                      </button>
                      <div class="dropdown-menu" aria-labelledby="newDropdown">
                        <?php foreach ($sessions as $sess): ?>
                          <a class="dropdown-item <?= ($_GET['session'] ?? '') == $sess ? 'active' : '' ?>"
                            href="?session=<?= urlencode($sess) ?>">
                            <?= htmlspecialchars($sess) ?>
                          </a>
                        <?php endforeach; ?>
                      </div>
                    </div>


                  </div>
                </div>



                <div class="row align-items-center my-3">
                  <div class="col-md-6 mb-6">
                    <div class="card shadow">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col">
                            <span class="badge badge-pill badge-success" style="background-color: #93bb84">+15.5%</span>
                            <p class="small text-muted mb-0">Total paid amount</p>
                            <p class="h2 mb-0"><?= $formattedTotalAmountPaid ?></p>
                          </div>
                          <div class="col-auto">
                            <br>
                            <p class="small text-muted mb-0">Invoices Paid</p>
                            <p class="h2 mb-0"><?= $formattedTotalInvoicesPaid ?></p>
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
                            <span class="badge badge-pill badge-success" style="background-color: #FB1010">+15.5%</span>
                            <p class="small text-muted mb-0">Total unpaid amount</p>
                            <p class="h2 mb-0"><?= $formattedTotalAmountUnpaid ?></p>
                          </div>
                          <div class="col-auto">
                            <br>
                            <p class="small text-muted mb-0">Invoices unpaid</p>
                            <p class="h2 mb-0"><?= $formattedTotalInvoicesUnpaid ?></p>
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
                              <th>First Name</th>
                              <th>Class</th>
                              <th>Type</th>
                              <th>Term</th>
                              <th>Amount</th>
                              <th>Paid</th>
                              <th>Outstanding</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php


                            foreach ($invoices as $index => $invoice): ?>
                              <tr>
                                <td>
                                  <?= $index + 1 ?>
                                </td>

                                <td>
                                  <?= $invoice['full_name'] ?>
                                </td>
                                <td>
                                  <?= $invoice['class'] ?>
                                </td>
                                <td>
                                  <?= $invoice['type'] ?>
                                </td>
                                <td>
                                  <?= $invoice['term'] ?>
                                </td>
                                <td>
                                  <?php
                                  $formatted_amount = '₦' . number_format($invoice['amount'], 2);
                                  echo
                                    $formatted_amount;
                                  ?>
                                </td>
                                <td>
                                  <?php
                                  $formatted_amount = '₦' . number_format($invoice['paid_amount'], 2);
                                  echo
                                    $formatted_amount;
                                  ?>
                                </td>
                                <td>
                                  <?php
                                  if ($invoice['status'] !== 'Paid' && $invoice['status'] !== 'Paid (Discounted)') {
                                    $defaulting_balance = $invoice['amount'] - $invoice['paid_amount'];
                                    if ($defaulting_balance == 0) {
                                      echo "<p class='text-success'>₦ " . number_format($defaulting_balance, 2) . "</p>";
                                    } else {
                                      echo "<p class='text-danger'>₦ " . number_format($defaulting_balance, 2) . "</p>";
                                    }
                                  } else {
                                    echo "<p class='text-success'>₦ 0.00</p>";
                                  }
                                  ?>
                                </td>
                                <td>
                                  <?php
                                  if ($invoice['status'] === 'Paid') {
                                    echo "<p class='text-success'>Paid in full</p>";
                                  } elseif ($invoice['status'] == 'Unpaid') {
                                    echo "<p class='text-danger'>Unpaid</p>";
                                  }  elseif ($invoice['status'] == 'Paid (Discounted)') {
                                    echo "<p class='text-success'>Paid (Discounted)</p>";
                                  } elseif ($defaulting_balance == 0) {
                                    echo "<p class='text-success'>Paid in full</p>";
                                  } else {
                                    $statusUnpaid = $invoice['status'];
                                    echo "<p class='text-warning'>$statusUnpaid</p>";
                                  }
                                  ?>
                                </td>
                                <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted sr-only">Action</span>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-right">

                                    <!-- Change Status -->
                                    <form action="update-invoice-status.php" method="POST" style="display: inline;">
                                      <input type="hidden" name="ref" value="<?= $invoice['invoice_ref'] ?>">
                                      <input type="hidden" name="student_id" value="<?= $invoice['id'] ?>">
                                      <button type="submit" class="dropdown-item">Change status</button>
                                    </form>
                                  
                                    <!-- Send Reminder -->
                                    <?php if (!empty($invoice['parent_id'])): ?>
                                      <form action="invoice-reminder.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="parent" value="<?= $invoice['parent_id'] ?>">
                                        <input type="hidden" name="student" value="<?= $invoice['id'] ?>">
                                        <button type="submit" class="dropdown-item">Send Reminder</button>
                                      </form>
                                    <?php else: ?>
                                      <button class="dropdown-item disabled" title="Student not linked to any parent">Send Reminder</button>
                                    <?php endif; ?>
                                  
                                    <!-- Parent Profile -->
                                    <?php if (!empty($invoice['parent_id'])): ?>
                                      <form action="../academics/parent.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="parent_id" value="<?= $invoice['parent_id'] ?>">
                                        <button type="submit" class="dropdown-item">Parent Profile</button>
                                      </form>
                                    <?php else: ?>
                                      <button class="dropdown-item disabled" title="Student not linked to any parent">Parent Profile</button>
                                    <?php endif; ?>
                                  
                                  </div>


                                </td>
                              </tr>
                            <?php endforeach; ?>

                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div> <!-- simple table -->
                </div> <!-- end section -->
              </div> <!-- .col-12 -->
            </div> <!-- .row -->
          </div> <!-- .container-fluid -->
          <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog"
            aria-labelledby="defaultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="defaultModalLabel">Notifications</h5> <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
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
                <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-block"
                    data-dismiss="modal" disabled>Clear All</button> </div>
              </div>
            </div>
          </div>

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
    </main> <!-- main -->
  </div> <!-- .wrapper -->


  <!-- new Modal-->
  <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newModalLabel">Add New Fee Type</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="newForm">
            <div class="form-group">
              <label for="fee-name" class="col-form-label">Fees Type:</label>
              <input type="text" class="form-control" id="fee-name" required>
            </div>
            <div class="form-group">
              <label for="fee-amount" class="col-form-label">Amount:</label>
              <input type="number" class="form-control" id="fee-amount" required>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="custom-subject">Duration</label>
                <select class="custom-select" id="custom-subject" name="subject" required>
                  <!-- Options for subject -->
                  <option selected disabled>Select</option>
                  <option value="1">One-time Payment</option>
                  <option value="2">Weekly</option>
                  <option value="3">Monthly</option>
                  <option value="4">Per Term</option>
                  <option value="5">Per session</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="custom-class">Class <span><small>optional</small></span></label>
                <select class="custom-select" id="custom-class" name="class" required>
                  <!-- Options for class -->
                  <option selected disabled>Select</option>
                  <option value="Grade 1">Grade 1</option>
                  <option value="Grade 2">Grade 2</option>
                  <option value="Grade 3">Grade 3</option>
                  <option value="Grade 4">Grade 4</option>
                  <option value="Grade 5">Grade 5</option>
                  <option value="Grade 6">Grade 6</option>
                  <option value="Grade 7">Grade 7</option>
                  <option value="Grade 8">Grade 8</option>
                  <option value="Grade 9">Grade 9</option>
                  <option value="Grade 10">Grade 10</option>
                  <option value="Grade 11">Grade 11</option>
                  <option value="Grade 12">Grade 12</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn mb-2 btn-primary w-100" id="saveBtn">Save
            Changes</button>
        </div>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(function () {

      // Event listener for saving changes
      $('#saveBtn').on('click', function () {

        var newTitle = $('#fee-name').val();
        var newAmount = $('#fee-amount').val();
        var newClass = $('#custom-class').val();
        var newSubject = $('#custom-subject').val();

        // Perform AJAX request to update fee information in the database
        $.ajax({
          url: 'add-fee.php',
          type: 'POST',
          data: {
            title: newTitle,
            class: newClass,
            subject: newSubject
          },
          success: function (response) {
            // Handle success
            console.log(response);
            // Optionally update the UI to reflect the changes
            // For example, update the title of the fee row
            $('#newModal').modal('hide');
          },
          error: function (xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>

  <!-- end new -->

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
</body>

</html>