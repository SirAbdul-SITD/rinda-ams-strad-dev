<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Rinda AMS | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
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

    @media print {
      table {
        /* Reset margins and padding */
        margin: 0;
        padding: 0;

        /* Adjust width if necessary */
        width: 100%;
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
          <?php
          // Retrieve invoice data from the database
          $invoiceId = $_GET['id']; // Assuming you pass the invoice ID via GET parameter
          $query = "SELECT * FROM invoice WHERE id = :id";
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':id', $invoiceId, PDO::PARAM_INT);
          $stmt->execute();
          $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

          // Retrieve invoice items data from the database
          $query = "SELECT * FROM invoice_item WHERE invoice_id = :invoice_id";
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
          $stmt->execute();
          $invoiceItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Retrieve student name
          $studentId = $invoice['student_id'];
          $query = "SELECT * FROM students WHERE id = :id";
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
          $stmt->execute();
          $student = $stmt->fetch(PDO::FETCH_ASSOC);

          // Function to calculate the total amount of invoice items
          function calculateTotalAmount($invoiceId)
          {
            global $pdo; // Assuming $pdo is your PDO database connection object
          
            // Prepare SQL query to sum the total amount of invoice items
            $stmt = $pdo->prepare("SELECT SUM(amount) AS total_amount FROM invoice_item WHERE invoice_id = :invoice_id");
            $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['total_amount'] ?? 0;
          }

          // Function to calculate the total paid amount
          function calculatePaidAmount($invoiceId)
          {
            global $pdo; // Assuming $pdo is your PDO database connection object
          
            // Prepare SQL query to sum the total paid amount
            $stmt = $pdo->prepare("SELECT SUM(amount) AS total_paid FROM invoice_item WHERE invoice_id = :invoice_id AND status = 'paid'");
            $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['total_paid'] ?? 0;
          }
          ?>

          <div class="col-12 col-lg-10 col-xl-8">
            <div class="row align-items-center mb-4">
              <div class="col">
                <h2 class="h5 page-title"><small class="text-muted text-uppercase">Invoice</small><br />#
                  <?= $invoice['invoice_number'] ?>
                </h2>
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-secondary" onclick="printDiv('invoice')">Print</button>
                <button type="button" class="btn btn-primary">Pay</button>
              </div>
            </div>
            <div class="card shadow">
              <div class="card-body p-5" id="invoice">
                <div class="row mb-4">
                  <div class="col-12 text-center mb-4">
                    <img src="../assets/images/logo.svg" class="navbar-brand-img brand-sm mx-auto mb-4" alt="...">
                    <h2 class="mb-0 text-uppercase">Invoice</h2>
                    <p class="text-muted">
                      <?= $school_name ?>
                    </p>
                  </div>
                  <div class="col-md-5">
                    <p class="mb-4">
                    <p class="small text-muted text-uppercase mb-2">Invoice from</p>
                    <strong>
                      <?= $school_name ?>
                    </strong><br /> <br />
                    <?= $school_address ?> <br />
                    </p>
                  </div>

                  <div class="col-md-2"></div>

                  <div class="col-md-5">
                    <p class="mb-4">
                    <p class="small text-muted text-uppercase mb-2">Invoice To</p>
                    <strong>
                      <?= $invoice['student_name'] ?>
                    </strong><br /> <br />
                    <?= $student['address'] ?> <br />

                    </p>
                  </div>
                </div> <!-- /.row -->
                <div class="row mb-4">

                  <div class="col-md-7">

                    <p>
                      <span class="small text-muted text-uppercase">Invoice #</span><br />
                      <strong>
                        <?= $invoice['invoice_number'] ?>
                      </strong>
                    </p>
                  </div>
                  <div class="col-md-5">

                    <p>
                      <small class="small text-muted text-uppercase">Due date</small><br />
                      <strong>
                        <?= $invoice['due_date'] ?>
                      </strong>
                    </p>
                  </div>
                </div> <!-- /.row -->
                <table class="table table-borderless table-striped align-self-center">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Description</th>
                      <th scope="col" class="text-right">Amount</th>
                      <th scope="col" class="text-right">Qty</th>
                      <th scope="col" class="text-right">Total</th>
                      <th scope="col" class="text-right">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($invoiceItems as $index => $item): ?>
                        <tr>
                          <th scope="row">
                            <?= $index + 1 ?>
                          </th>
                          <td>
                            <?= $item['description'] ?>
                          </td>
                          <td class="text-right">
                            <?= '$' . number_format($item['unit_price'], 2) ?>
                          </td>
                          <td class="text-right">
                            <?= $item['quantity'] ?>
                          </td>
                          <td class="text-right">
                            <?= '$' . number_format($item['unit_price'] * $item['quantity'], 2) ?>
                          </td>
                          <td>
                            <?php
                            if ($item['status'] == 'paid') {
                              $status = 'Paid';
                              $badgeClass = 'badge-success';
                            } else {
                              $status = 'Pending';
                              $badgeClass = 'badge-warning';
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                          </td>

                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="row mt-5">
                  <div class="col-2 text-center">
                    <!-- <img src="../assets/images/qrcode.svg" class="navbar-brand-img brand-sm mx-auto my-4" alt="..."> -->
                  </div>
                  <div class="col-md-5">
                    <!-- <p class="text-muted small">
                      <strong>Note :</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam hendrerit
                      nisi sed sollicitudin pellentesque. Nunc posuere purus rhoncus pulvinar aliquam.
                    </p> -->
                  </div>
                  <?php
                  // Assuming $totalAmount, $paidAmount, and $balance are defined or calculated somewhere in your PHP code
                  $totalAmount = calculateTotalAmount($invoiceId); // Example function to calculate total amount
                  $paidAmount = calculatePaidAmount($invoiceId); // Example function to calculate paid amount
                  $balance = $totalAmount - $paidAmount; // Calculate the balance
                  ?>

                  <div class="col-md-5">
                    <div class="text-right mr-2">
                      <p class="mb-2 h6">
                        <span class="text-muted">Invoice Total : </span>
                        <strong>$
                          <?= number_format($totalAmount, 2) ?>
                        </strong>
                      </p>
                      <p class="mb-2 h6">
                        <span class="text-muted">Total Paid : </span>
                        <strong>$
                          <?= number_format($paidAmount, 2) ?>
                        </strong>
                      </p>
                      <p class="mb-2 h6">
                        <span class="text-muted">Total Outstanding: </span>
                        <span>$
                          <?= number_format($balance, 2) ?>
                        </span>
                      </p>
                    </div>
                  </div>

                </div> <!-- /.row -->
              </div> <!-- /.card-body -->
            </div> <!-- /.card -->

          </div> <!-- /.col-12 -->

        </div> <!-- .row -->
      </div> <!-- .container-fluid -->
      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
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
            <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"
                disabled>Clear All</button> </div>
          </div>
        </div>
      </div>
      <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
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

  <script>
    function printDiv(divId) {
      var content = document.getElementById(divId).innerHTML;
      var printWindow = window.open('', '_blank');
      printWindow.document.open();
      printWindow.document.write('<html><head><title>Print</title></head><body>' + content + '</body></html>');
      printWindow.document.close();
      printWindow.print();
    }
  </script>
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