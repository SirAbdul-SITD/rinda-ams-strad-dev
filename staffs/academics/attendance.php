<?php require '../settings.php';

if (isset($_GET['reg'])) {
  $reg = $_GET['reg'];


  $query = "SELECT * FROM students WHERE reg = :reg";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['reg' => $reg]);
  $student = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Rinda AMS - Rinda AMS</title>
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
              <p style="padding: 0%; margin: 0%;"><?= $full_name; ?></p>
              <strong><?= $account_type; ?></strong>
            </div>
            <hr width="80%">
            <a class="dropdown-item" href="../settings/profile.php">Profile</a>
            <a class="dropdown-item" href="../settings">Settings</a>
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
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
          </a>
        </div>
        <!-- <div class="btn-box w-100 mt-4 mb-1">
          <a href="../" class="btn mb-2 btn-primary btn-lg btn-block">
            <i class="fe fe-arrow-left fe-12 mx-2"></i><span class="small">Back To Dashboard</span>
          </a>
        </div> -->
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
          <li class="nav-item">
            <a class="nav-link" href="students.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Students</span>
              </i>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Students</span>
              </i>
            </a>
          </li>



          <!-- Acadmics -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Academics</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="classes.php">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">Class</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="section.php">
                <i class="fe fe-copy fe-16"></i>
                <span class="ml-3 item-text">Section</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="subjects.php">
                <i class="fe fe-server fe-16"></i>
                <span class="ml-3 item-text">Subject</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="class_management.php">
                <i class="fe fe-fast-forward fe-16"></i>
                <span class="ml-3 item-text">Class Management</span>
                </i>
              </a>
            </li>
          </ul>
          <!-- Admission -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Admission</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="admit_student.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Admit New Student</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="applications.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Student Applications</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="admissions.php">
                <i class="fe fe-file-text fe-16"></i>
                <span class="ml-3 item-text">Admitted Students</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="parents.php">
                <i class="fe fe-zoom-in fe-16"></i>
                <span class="ml-3 item-text">Manage Student Parents</span>
                </i>
              </a>
            </li>

          </ul>

          <!-- Extra -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extra</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="disable-student.php">
                <i class="fe fe-slash fe-16"></i>
                <span class="ml-3 item-text">Disable Students</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="export-data.php">
                <i class="fe fe-printer fe-16"></i>
                <span class="ml-3 item-text">Students Export</span>
                </i>
              </a>
            </li>
          </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row align-items-center my-3">
              <div class="col">
                <h2 class="page-title"> <?= $student['fullname'] ?>'s Class Attendance </h2>
              </div>
              <div class="col-auto">
                <a href="students.php">
                  <button type="button" class="btn btn-primary"><span class="fe fe-corner-up-left fe-16 mr-3"></span>Students</button></a>
              </div>
            </div>

            <!-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible
              tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to
              any HTML table. </p> -->
            <div class="row my-4">

              <!-- Small table -->
              <div class="col-md-12">
                <div class="card shadow">
                  <div class="card-body">
                    <!-- table -->
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th><i class="fe fe-1 fe-arrow-down"></i> Days | Weeks <i class="fe fe-1 fe-arrow-right"></i>
                          </th>
                          <td class="text-center">1</td>
                          <td class="text-center">2</td>
                          <td class="text-center">3</td>
                          <td class="text-center">4</td>
                          <td class="text-center">5</td>
                          <td class="text-center">6</td>
                          <td class="text-center">7</td>
                          <td class="text-center">8</td>
                          <td class="text-center">9</td>
                          <td class="text-center">10</td>
                          <td class="text-center">11</td>
                          <td class="text-center">12</td>
                          <td class="text-center">13</td>
                          <td class="text-center">14</td>

                        </tr>
                      </thead>
                      <tbody>
                        <tr>



                        </tr>
                        <!-- Repeat the same pattern for the remaining months -->
                        <tr>
                          <td>Monday</td> <!-- February with 28/29 days, hence rowspan="28" -->
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td class="text-center"> - </td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                        </tr>
                        <tr>
                          <td>Tuesday</td> <!-- March with 31 days, hence rowspan="31" -->
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-x-circle" style="color: red"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>

                        </tr>
                        <tr>
                          <td>Wednesday</td> <!-- April with 30 days, hence rowspan="30" -->
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-x-circle" style="color: red"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-x-circle" style="color: red"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>

                        </tr>
                        <tr>
                          <td>Thursday</td> <!-- May with 31 days, hence -->
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td class="text-center"> - </td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-x-circle" style="color: red"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>

                        </tr>
                        <tr>
                          <td>Friday</td> <!-- June with 30 days, hence -->
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-x-circle" style="color: red"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                          <td><i class=" fe fe-3 fe-x-circle" style="color: red"></i></td>
                          <td><i class=" fe fe-3 fe-check-circle" style="color: greenyellow"></i></td>
                        </tr>
                        <tr>
                          <td>Saturday</td> <!-- July with 31 days, hence -->
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                        </tr>
                        <tr>
                          <td>Sunday</td> <!-- August with 31 days, hence -->
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                          <td class="text-center"> - </td>
                        </tr>

                      </tbody>
                    </table>

                  </div>
                </div>
              </div> <!-- simple table -->
            </div> <!-- end section -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->

      <!-- Notifications modal -->
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
                  <a href="#" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-primary">Dashboard</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;" class="text-success">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Academics</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../lms" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-primary">E-Learning</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../messages" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-primary">Messages</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../shop" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-primary">Shop</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../hr/" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center text-white">
                      <i class="fe fe-users fe-32 align-self-center"></i>
                    </div>
                    <p class="text-primary">HR</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../assessments" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-primary">Assessments</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../settings" style="text-decoration: none; decoration">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-primary">Settings</p>
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
  <script src='../js/jquery.validate.min.js'></script>
  <script>
    $('.select2').select2({
      theme: 'bootstrap4',
    });
    $('.select2-multi').select2({
      multiple: true,
      theme: 'bootstrap4',
    });
    $('.drgpicker').daterangepicker({
      singleDatePicker: true,
      timePicker: false,
      showDropdowns: true,
      locale: {
        format: 'MM/DD/YYYY'
      }
    });
    $('.time-input').timepicker({
      'scrollDefault': 'now',
      'zindex': '9999' /* fix modal open */
    });
    /** date range picker */
    if ($('.datetimes').length) {
      $('.datetimes').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
          format: 'M/DD hh:mm A'
        }
      });
    }
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);
    cb(start, end);
    $('.input-placeholder').mask("00/00/0000", {
      placeholder: "__/__/____"
    });
    $('.input-zip').mask('00000-000', {
      placeholder: "____-___"
    });
    $('.input-money').mask("#.##0,00", {
      reverse: true
    });
    $('.input-phoneus').mask('(000) 000-0000');
    $('.input-mixed').mask('AAA 000-S0S');
    $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/,
          optional: true
        }
      },
      placeholder: "___.___.___.___"
    });
    // editor
    var editor = document.getElementById('editor');
    if (editor) {
      var toolbarOptions = [
        [{
          'font': []
        }],
        [{
          'header': [1, 2, 3, 4, 5, 6, false]
        }],
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{
            'header': 1
          },
          {
            'header': 2
          }
        ],
        [{
            'list': 'ordered'
          },
          {
            'list': 'bullet'
          }
        ],
        [{
            'script': 'sub'
          },
          {
            'script': 'super'
          }
        ],
        [{
            'indent': '-1'
          },
          {
            'indent': '+1'
          }
        ], // outdent/indent
        [{
          'direction': 'rtl'
        }], // text direction
        [{
            'color': []
          },
          {
            'background': []
          }
        ], // dropdown with defaults from theme
        [{
          'align': []
        }],
        ['clean'] // remove formatting button
      ];
      var quill = new Quill(editor, {
        modules: {
          toolbar: toolbarOptions
        },
        theme: 'snow'
      });
    }
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
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