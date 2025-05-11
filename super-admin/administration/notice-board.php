<?php
require_once '../settings.php'; // your PDO connection
$today = date('Y-m-d');

// Get the latest updated notice
$latestNotice = $pdo->query("
    SELECT * FROM notices 
    ORDER BY update_datetime DESC 
    LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

// Get all active notices (excluding the latest one)
$stmt = $pdo->prepare("
   SELECT * FROM notices WHERE start_date <= CURDATE() AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY start_date DESC;
");
$stmt->execute([

]);
$otherNotices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Notice Board - Admin | Rinda AMS</title>
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

            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
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
          <div class="col-12 mb-4">
            <div class="row align-items-center my-3 mb-5">
              <div class="col">
                <h3 class="page-title">Notice Board</h3>
              </div>
              <div class="col-auto">
                <button type="button" class="btn  btn-primary" data-toggle="modal" data-target="#newModal"><span
                    class="fe fe-plus fe-16 mr-3"></span>New</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 mb-4">
                <div class="col-12 mb-4">
                  <div class="card shadow latest-notice">
                    <div class="card-body">
                      <div class="" role="alert">
                        <div class="d-flex w-100 justify-content-between mb-3">
                          <h4 class="alert-heading"><?= htmlspecialchars($latestNotice['subject']) ?></h4>
                          <span><?= date('D d/m/Y', strtotime($latestNotice['start_date'])) ?></span>
                        </div>
                        <div style="max-height: 53vh; overflow-y: auto;">
                          <p>
                            <?= nl2br(htmlspecialchars($latestNotice['content'])) ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4">
                <div class="card shadow other-notice">
                  <div class="card-header">
                    <div class="d-flex w-100 justify-content-between">
                      <strong class="card-title mb-0">Upcoming Notices</strong>
                      <!-- <span> </span> -->
                    </div>
                  </div>
                  <div class="card-body">
                    <div style="max-height: 54vh; overflow-y: auto;">
                      <?php foreach ($otherNotices as $notice): ?>
                        <div class="  mr-1 alert alert-secondary other-notice-item"
                          data-subject="<?= htmlspecialchars($notice['subject']) ?>"
                          data-content="<?= htmlspecialchars($notice['content']) ?>"
                          data-date="<?= date('D d/m/Y', strtotime($notice['start_date'])) ?>">
                          <div class="d-flex w-100 justify-content-between">
                            <span class="fe fe-bell fe-16 mr-2"></span>
                            <small><?= date('D d/m/Y', strtotime($notice['start_date'])) ?></small>
                          </div>
                          <?= htmlspecialchars($notice['subject']) ?>
                        </div>
                      <?php endforeach; ?>

                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end section -->

          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
        <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
          aria-hidden="true">
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
                      <div class="col-auto">
                        <span class="fe fe-box fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Package has uploaded successfull</strong></small>
                        <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                        <small class="badge badge-pill badge-light text-muted">1m ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-download fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Widgets are updated successfull</strong></small>
                        <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                        <small class="badge badge-pill badge-light text-muted">2m ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-inbox fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Notifications have been sent</strong></small>
                        <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                        <small class="badge badge-pill badge-light text-muted">30m ago</small>
                      </div>
                    </div> <!-- / .row -->
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-link fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Link was attached to menu</strong></small>
                        <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                        <small class="badge badge-pill badge-light text-muted">1h ago</small>
                      </div>
                    </div>
                  </div> <!-- / .row -->
                </div> <!-- / .list-group -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
              </div>
            </div>
          </div>
        </div>

        <!-- New Notice Modal -->
        <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newModalLabel">Add New Notice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="newForm" class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="subject">Subject:*</label>
                    <input type="text" class="form-control" name="subject" id="subject" required>
                  </div>

                  <div class="form-group">
                    <label for="content">Content:*</label>
                    <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
                  </div>

                  <div class="form-row align-items-end">
                    <div class="form-group col-5">
                      <label for="start_date">Start Date:*</label>
                      <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>

                    <div class="form-group col-2 text-center">
                      <div class="custom-control custom-switch mt-4">
                        <input type="checkbox" class="custom-control-input" id="toggleEndDate">
                        <label class="custom-control-label" for="toggleEndDate">End</label>
                      </div>
                    </div>

                    <div class="form-group col-5">
                      <label for="end_date">End Date:</label>
                      <input type="date" class="form-control" name="end_date" id="end_date" disabled>
                    </div>
                  </div>


                  <hr>
                  <p><strong>Notification Settings</strong></p>

                  <div class="form-row">
                    <!-- Parents Group -->
                    <div class="form-group col-6">
                      <div class="custom-control custom-switch mb-2">
                        <input type="checkbox" class="custom-control-input" id="toggleParents">
                        <label class="custom-control-label" for="toggleParents">Parents</label>
                      </div>
                      <div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="parentEmail" disabled>
                          <label class="custom-control-label" for="parentEmail">Send Email</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="parentWhatsApp" disabled>
                          <label class="custom-control-label" for="parentWhatsApp">Send to WhatsApp</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="parentSMS" disabled>
                          <label class="custom-control-label" for="parentSMS">Send to SMS</label>
                        </div>
                      </div>
                    </div>

                    <!-- Staffs Group -->
                    <div class="form-group col-6">
                      <div class="custom-control custom-switch mb-2">
                        <input type="checkbox" class="custom-control-input" id="toggleStaffs">
                        <label class="custom-control-label" for="toggleStaffs">Staffs</label>
                      </div>
                      <div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="staffEmail" disabled>
                          <label class="custom-control-label" for="staffEmail">Send Email</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="staffWhatsApp" disabled>
                          <label class="custom-control-label" for="staffWhatsApp">Send to WhatsApp</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="staffSMS" disabled>
                          <label class="custom-control-label" for="staffSMS">Send to SMS</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" id="saveBtn">Add Notice</button>
              </div>
            </div>
          </div>
        </div>

        <script>
          // End Date enable/disable
          document.getElementById('toggleEndDate').addEventListener('change', function () {
            const endInput = document.getElementById('end_date');
            endInput.disabled = !this.checked;
            this.checked ? endInput.setAttribute('required', 'required') : endInput.removeAttribute('required');
          });

          // Parents options enable/disable
          document.getElementById('toggleParents').addEventListener('change', function () {
            const enabled = this.checked;
            document.getElementById('parentEmail').disabled = !enabled;
            document.getElementById('parentWhatsApp').disabled = !enabled;
            document.getElementById('parentSMS').disabled = !enabled;
          });

          // Staffs options enable/disable
          document.getElementById('toggleStaffs').addEventListener('change', function () {
            const enabled = this.checked;
            document.getElementById('staffEmail').disabled = !enabled;
            document.getElementById('staffWhatsApp').disabled = !enabled;
            document.getElementById('staffSMS').disabled = !enabled;
          });
        </script>






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

  <!-- add notice -->
  <!-- add fee -->

  <script>
    $(document).ready(function () {
      $('.other-notice-item').on('click', function () {
        // Reset styling
        $('.other-notice-item').removeClass('alert-success').addClass('alert-secondary');

        // Highlight this one
        $(this).removeClass('alert-secondary').addClass('alert-success');

        // Get data
        const subject = $(this).data('subject');
        const content = $(this).data('content');
        const date = $(this).data('date');

        // Update main notice area
        $('.latest-notice .alert-heading').text(subject);
        $('.latest-notice span').last().text(date);
        $('.latest-notice p').html(content.replace(/\n/g, '<br>'));
      });
    });
  </script>

  <script>
    $(document).ready(function () {

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

      // Event listener for saving changes
      $('#saveBtn').on('click', function () {

        form = $('#newForm');
        // Perform AJAX request to update fee information in the database
        $.ajax({
          url: 'add-notice.php',
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
    });
  </script>
</body>

</html>