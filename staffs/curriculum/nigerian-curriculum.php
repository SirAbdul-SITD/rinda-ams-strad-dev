<?php require('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Curriculum - Rinda AMS</title>
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

        <!-- Dashboard -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
              </i>
            </a>
          </li>
          <!-- <li class="nav-item active">
        <a class="nav-link text-primary" href="#">
          <i class="fe fe-users fe-16"></i>
          <span class="ml-3 item-text">Students</span>
          </i>
        </a>
      </li> -->



          <!-- Curriculum -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Curriculum</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item">
              <a class="nav-link" href="nigerian-curriculum.php">
                <i class="fe fe-flag fe-16"></i>
                <span class="ml-3 item-text">Nigerian</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-flag fe-16"></i>
                <span class="ml-3 item-text">British</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-flag fe-16"></i>
                <span class="ml-3 item-text">American</span>
                </i>
              </a>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-refresh-cw fe-16"></i>
                <span class="ml-3 item-text">Generate</span>
                </i>
              </a>
            </li> -->
          </ul>
        </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <h2 class="page-title">Nigerian Curriculum</h2>
            <p> </p>
            <div class="row">
              <!-- simple table -->
              <div class="col-md-12 my-4">
                <div class="card shadow">
                  <div class="card-body">
                    <h5 class="card-title">NERDC Curriculum</h5>
                    <p class="card-text"></p>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Class</th>
                          <th>Category</th>
                          <th>Browse</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Primary One</td>
                          <td>Primary</td>
                          <td><a href="curriculum.php?class=Primary%201" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Primary Two</td>
                          <td>Primary</td>
                          <td><a href="curriculum.php?class=Primary%202" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <!-- Continue adding rows for Primary Three to SS3 -->
                        <!-- Example for Primary Three -->
                        <tr>
                          <td>3</td>
                          <td>Primary Three</td>
                          <td>Primary</td>
                          <td><a href="curriculum.php?class=Primary%203" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Primary Four</td>
                          <td>Primary</td>
                          <td><a href="curriculum.php?class=Primary%204" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>

                        <!-- Primary Five -->
                        <tr>
                          <td>5</td>
                          <td>Primary Five</td>
                          <td>Primary</td>
                          <td><a href="curriculum.php?class=Primary%205" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>

                        <!-- Primary Six -->
                        <tr>
                          <td>6</td>
                          <td>Primary Six</td>
                          <td>Primary</td>
                          <td><a href="curriculum.php?class=Primary%206" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>

                        <tr>
                          <td>7</td>
                          <td>Jss One</td>
                          <td>Junior Secondary</td>
                          <td><a href="curriculum.php?class=Jss%201" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <tr>
                          <td>8</td>
                          <td>Jss Two</td>
                          <td>Junior Secondary</td>
                          <td><a href="curriculum.php?class=Jss%202" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <tr>
                          <td>9</td>
                          <td>Jss Three</td>
                          <td>Junior Secondary</td>
                          <td><a href="curriculum.php?class=Jss%203" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>


                        <tr>
                          <td>10</td>
                          <td>SSS One</td>
                          <td>Senior Secondary</td>
                          <td><a href="curriculum.php?class=SSS%201" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <tr>
                          <td>11</td>
                          <td>SSSS Two</td>
                          <td>Senior Secondary</td>
                          <td><a href="curriculum.php?class=SSS%202" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                        <tr>
                          <td>12</td>
                          <td>SSS Three</td>
                          <td>Senior Secondary</td>
                          <td><a href="curriculum.php?class=SSS%203" style="text-decoration: none;">Explore <span class="fe fe-arrow-right"></span></a></td>

                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> <!-- simple table -->
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
                    <a href="../academics" style="text-decoration: none;">
                      <div class="squircle bg-secondary justify-content-center">
                        <i class="fe fe-award fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-secondary">Academics</p>
                    </a>
                  </div>
                  <div class="col-6 text-center">
                    <a href="../assessments/" style="text-decoration: none;">
                      <div class="squircle bg-secondary justify-content-center">
                        <i class="fe fe-check-square fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-secondary">Assessments</p>
                    </a>
                  </div>
                </div>
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <a href="#" style="text-decoration: none;">
                      <div class="squircle bg-success justify-content-center">
                        <i class="fe fe-book-open fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-success">Curriculum</p>
                    </a>
                  </div>
                  <div class="col-6 text-center">
                    <a href="../resources" style="text-decoration: none;">
                      <div class="squircle bg-secondary justify-content-center">
                        <i class="fe fe-archive fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-secondary">Resources</p>
                    </a>
                  </div>
                </div>
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <a href="../target" style="text-decoration: none;">
                      <div class="squircle bg-secondary justify-content-center">
                        <i class="fe fe-trending-up fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-secondary">Target</p>
                    </a>
                  </div>
                  <div class="col-6 text-center">
                    <a href="../profile" style="text-decoration: none;">
                      <div class="squircle bg-secondary justify-content-center text-white">
                        <i class="fe fe-user fe-32 align-self-center"></i>
                      </div>
                      <p class="text-secondary">Profile</p>
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