<?php require_once '../settings.php' ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Past Results - Assessments | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
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
      <!--<form class="form-inline mr-auto searchform text-muted">-->
      <!--  <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"-->
      <!--    placeholder="Type something..." aria-label="Search">-->
      <!--</form>-->
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

          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.php">
            <span class="avatar avatar-sm mt-2">
              <img src="../assets/images/logo.jpg" size="20" alt="..." class="avatar-img rounded-circle">
            </span>
          </a>
        </div>

        <!-- Assessments -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Assessment</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="subjects.php">
              <i class="fe fe-check-circle fe-16"></i>
              <span class="ml-3 item-text">Mark by subject</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="students.php">
              <i class="fe fe-user-check fe-16"></i>
              <span class="ml-3 item-text">Mark by student</span>
              </i>
            </a>
          </li>
        </ul>


        <!-- Questions -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Questions</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="question-bank.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Bank</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="generate.php">
              <i class="fe fe-sliders fe-16"></i>
              <span class="ml-3 item-text">Generate</span>
              </i>
            </a>
          </li>
        </ul>


        <!-- Remarks -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Results</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="add-remarks.php">
              <i class="fe fe-edit-3 fe-16"></i>
              <span class="ml-3 item-text">Process result</span>
              </i>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-tool fe-16"></i>
              <span class="ml-3 item-text">Edit past results</span>
              </i>
            </a>
          </li>
        </ul>

      </nav>
    </aside>
    <script>
      function toggleButtonClass(button) {
        if (button.classList.contains('btn-secondary')) {
          button.classList.remove('btn-secondary');
          button.classList.add('btn-success');
        }
      }
    </script>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="w-50 mx-auto text-center justify-content-center py-5 my-5">
              <h2 class="page-title mb-0">Edit Past Results</h2>
              <p class="lead text-muted mb-0">Please select an option below to modify past student results.</p>
            </div>
            <div class="row my-4">
              <div class="col-6">
                <div class="card shadow mb-4">
                  <div class="card-body">

                    <form id="view-past-result" method="POST" action="past-subjects.php">
                      <div class="modal-body">
                        <div class="row col-12">
                          <div class="col-md-6">
                            <div class="form-group mb-3">
                              <label for="session">Session</label>
                              <select class="form-control select1" required name="session">
                                <?php
                                $query = "SELECT session FROM sessions ORDER BY session DESC";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $db_sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($db_sessions) < 1) {
                                  echo '<option value="" selected disabled>No Previous Session Exist</option>';
                                } else {
                                  echo "<option value='' selected>Select Session</option>";
                                  foreach ($db_sessions as $db_session) :
                                    $past_sessions = $db_session['session'];
                                    echo "<option value='$past_sessions'>$past_sessions Session</option>";
                                  endforeach;
                                }
                                ?>
                              </select>
                            </div>

                          </div> <!-- /.col -->
                          <div class="col-md-6">
                            <div class="form-group mb-3">
                              <label for="term">Term</label>
                              <select class="form-control select1" required name="term">
                                <option value="" selected disabled>Select Term</option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                              </select>
                            </div>
                          </div> <!-- /.col -->
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn mb-2 btn-success w-100">Modify Subject Marks</button>
                      </div>
                    </form>
                  </div> <!-- .card-body -->
                </div>
              </div> <!-- .col-md-->
              <div class="col-6">
                <div class="card shadow mb-4">
                  <div class="card-body">

                    <form id="view-past-result" method="POST" action="past-students.php">
                      <div class="modal-body">
                        <div class="row col-12">
                          <div class="col-md-6">
                            <div class="form-group mb-3">
                              <label for="session">Session</label>
                              <select class="form-control select1" required name="session">
                                <?php
                                $query = "SELECT session FROM sessions ORDER BY session DESC";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $db_sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($db_sessions) < 1) {
                                  echo '<option value="" selected disabled>No Previous Session Exist</option>';
                                } else {
                                  echo "<option value='' selected>Select Session</option>";
                                  foreach ($db_sessions as $db_session) :
                                    $past_sessions = $db_session['session'];
                                    echo "<option value='$past_sessions'>$past_sessions Session</option>";
                                  endforeach;
                                }
                                ?>
                              </select>
                            </div>

                          </div> <!-- /.col -->
                          <div class="col-md-6">
                            <div class="form-group mb-3">
                              <label for="term">Term</label>
                              <select class="form-control select1" required name="term">
                                <option value="" selected disabled>Select Term</option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                              </select>
                            </div>
                          </div> <!-- /.col -->
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn mb-2 btn-success w-100">Modify Student Marks</button>
                      </div>
                    </form>
                  </div> <!-- .card-body -->
                </div>
              </div> <!-- .col-md-->

            </div> <!-- .row -->

          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->
      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
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
              <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear All</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Menu Modal -->
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
                    <div class="squircle bg-secondary justify-content-center text-white">
                      <i class="fe fe-users fe-32 align-self-center"></i>
                    </div>
                    <p class="text-white">HR</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../assessments" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Assessments</p>
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

  <script>
    function setCookie(name, value) {
      document.cookie = name + "=" + value + "; path=/";

      setTimeout(function() {
        window.location.href = 'choose-templates.php';
      }, 1);
    }
  </script>
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