<?php require_once '../settings.php';

if (isset($_POST['ref']) && isset($_POST['student_id'])) {
  $ref = $_POST['ref'];
  $student_id = $_POST['student_id'];
} else {
  header('Location: invoices.php');
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Update Invoice Status - Administration | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
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
            <a class="nav-link text-primary" href="invoices.php">
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
            <h1 class="page-title">Update Application Status</h1>
            <form class="needs-validation change_status">
              <div class="modal-body p-4">

                <div class="form-row">
                  <div class="form-group col-12">
                    <p>Invoice Status Descriptions:</p>

                    <p>Unpaid: Payment has not been made yet.</p>
                    <p>Part Payment: A portion of the amount has been paid, but not in full.</p>
                    <p>Paid (Discounted): The full amount has been paid with an approved discount applied.</p>
                    <p>Paid: The full amount has been completely paid.</p>
                    <p>Additional Payment Required: The full amount was paid previously, but the required amount has
                      increased, and additional payment is needed.</p>
                  </div>
                </div>


                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="status">Select Status</label>
                    <select id="status" class="form-control select2" required name="status">
                      <option value=''> </option>
                      <option value='Unpaid'>Unpaid</option>
                      <option value='Part Payment'>Part Payment</option>
                      <option value='Paid (Discounted)'>Paid (Discounted)</option>
                      <option value='Paid'>Paid</option>
                      <option value='Additional Payment Required'>Additional Payment Required</option>
                    </select>
                  </div>
                </div>

                <div class="form-row" id="paid-amount-row" style="display: none;">
                  <div class="form-group col-12">
                    <label for="paid-amount">Enter Paid Amount</label>
                    <input type="number" id="paid-amount" class="form-control" name="paid_amount"
                      placeholder="Enter amount paid">
                  </div>
                </div>

                <!-- Additional Payment Amount Input -->
                <div class="form-row" id="additionalPaymentRow" style="display: none;">
                  <div class="form-group col-12">
                    <label for="additional_payment_amount">Additional Payment Amount</label>
                    <input type="number" class="form-control" id="additional_payment_amount"
                      name="additional_payment_amount" placeholder="Enter additional payment amount">
                  </div>
                </div>

                <script>
                  document.getElementById('status').addEventListener('change', function () {
                    var paidAmountRow = document.getElementById('paid-amount-row');
                    var additionalPaymentRow = document.getElementById('additionalPaymentRow');


                    if (this.value === 'Part Payment' || this.value === 'Paid (Discounted)') {
                      paidAmountRow.style.display = 'block';
                    } else {
                      paidAmountRow.style.display = 'none';
                    }

                    if (this.value === 'Additional Payment Required') {
                      additionalPaymentRow.style.display = 'block';
                    } else {
                      additionalPaymentRow.style.display = 'none';
                    }
                  });
                </script>

                <input type="hidden" value="<?= $ref ?>" name="ref">
                <input type="hidden" value="<?= $student_id ?>" name="student_id">
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="submit" class="btn mb-2 btn-primary w-100">Update Status</button>
              </div>
            </form>
          </div> <!-- .col-12 -->
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
                  <div class="squircle bg-success justify-content-center">
                    <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Control area</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Admission</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                  </div>
                  <p>E-Learning</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Virtual Meetings</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Library Management</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Human Resources</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-users fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Assessments</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Settings</p>
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

      setTimeout(function () {
        popup.remove();
      }, 5000);
    }

    // Assign Class Teacher js
    document.querySelectorAll(".change_status").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'change_invoice_status.php',
          data: $(this).serialize(),
          dataType: 'json',
          success: function (response) {
            $('#eventModal').modal('hide');
            if (response.success) {
              displayPopup(response.message, true);
              // Refresh the page after 2 seconds
              setTimeout(function () {
                location.href = 'invoices.php';
              }, 2000);
            } else {
              $('#warningModel').modal('show');
            }
          },
          error: function (error, xhr) {
            console.log(error, xhr);
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      });
    });
  </script>
</body>

</html>