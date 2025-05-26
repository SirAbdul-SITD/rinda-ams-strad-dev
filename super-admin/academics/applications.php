<?php require_once '../settings.php' ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Students Applications- Academics | Rinda AMS</title>
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




    .loader {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      width: 160px;
      height: 160px
    }

    .logo {
      width: 90px;
      /* Adjust the size of the logo as needed */
      height: 90px;
      /* Adjust the size of the logo as needed */
      border-radius: 50%;
      overflow: hidden;
      position: relative;
    }

    .logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .clock {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .hand {
      width: 2px;
      /* Adjust the width of the clock hands as needed */
      height: 40px;
      /* Adjust the height of the clock hands as needed */
      background-color: whitesmoke;
      /* Blue color */
      position: absolute;
      top: 50%;
      left: 50%;
      transform-origin: top;
    }

    .hour {
      animation: rotateHour 12s infinite linear;
    }

    .minute {
      height: 30px;
      /* Adjust the height of the minute hand */
      animation: rotateMinute 70s infinite linear;
    }

    @keyframes rotateHour {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes rotateMinute {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .dot-flashing {
      display: inline-block;
      width: 10px;
      height: 10px;
      background-color: green;
      /* Blue color */
      border-radius: 50%;
      animation: dot-flashing 1s infinite;
    }



    @keyframes dot-flashing {

      0%,
      10% {
        opacity: 0;
      }

      20% {
        opacity: 1;
      }

      30% {
        opacity: 0;
      }

      40% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }

      60% {
        opacity: 1;
      }

      70% {
        opacity: 0;
      }

      100% {
        opacity: 1;
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
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.php">
            <span class="avatar avatar-sm mt-2">
              <img src="../assets/images/logo.jpg" size="20" alt="..." class="avatar-img rounded-circle">
            </span>
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
            <!-- <li class="nav-item">
              <a class="nav-link" href="enroll_student.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Enroll into Islamiyyah</span>
                </i>
              </a>
            </li> -->
            <li class="nav-item active">
              <a class="nav-link text-primary" href="applications.php">
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
                <h2 class="mb-2 page-title">Applications</h2>
              </div>
              <!-- <div class="col-auto">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventModal"><span
                    class="fe fe-filter fe-12 mr-2"></span>Load All</button>
              </div> -->
            </div>

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
                          <th>Application Ref.</th>
                          <th>Applicant Name</th>
                          <th>Class Applied</th>
                          <th>Home Address</th>
                          <th>Fathers Name</th>
                          <th>Mothers Name</th>
                          <th>Applied Date</th>
                          <th>Application Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        try {
                          // Prepare SQL statement to fetch student data
                          $sql = "SELECT a.*, CONCAT(a.student_firstName, ' ', a.student_lastName) AS student_name, CONCAT(a.father_firstName, ' ', a.father_lastName) AS father_name, CONCAT(a.mother_firstName, ' ', a.mother_firstName) AS mother_name, c.class
            FROM applications a
            INNER JOIN classes c ON a.class_id = c.id";
                          $stmt = $pdo->prepare($sql);
                          $stmt->execute();
                          $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                          // Handle database error
                          echo 'Error: ' . $e->getMessage();
                          die();
                        }

                        foreach ($applications as $index => $application): ?>
                          <tr>
                            <td>
                              <?= $index + 1 ?>
                            </td>
                            <td>
                              <?= $application['ref'] ?>
                            </td>
                            <td>
                              <?= $application['student_name'] ?>
                            </td>
                            <td>
                              <?= $application['class'] ?>
                            </td>
                            <td>
                              <?= $application['student_address'] ?>
                            </td>
                            <td>
                              <?= $application['father_name'] ?>
                            </td>
                            <td>
                              <?= $application['mother_name'] ?>
                            </td>

                            <td>
                              <?= $application['apply_datetime'] ?>
                            </td>
                            <td>
                              <?= $application['status'] ?>
                            </td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <?php if ($application['status'] != 'Admitted') { ?>
                                  <a class="dropdown-item"
                                    href="update-application-status.php?ref=<?= $application['ref'] ?>">Change status</a>
                                <?php } ?>
                                <a class="dropdown-item" href="application-status.php?ref=<?= $application['ref'] ?>">View
                                  application</a>
                                <?php if ($application['status'] != 'Admitted') { ?>
                                  <form class='update_form' action="grant-admission.php" method="post">
                                    <input type='hidden' name='ref' value='<?= $application['ref'] ?>'>
                                    <input type='hidden' name='email' value='<?= $application['email'] ?>'>
                                    <input type='hidden' name='name' value='<?= $application['student_name'] ?>'>
                                    <input type='hidden' name='class' value='<?= $application['class'] ?>'>
                                    <input type='hidden' name='gender' value='<?= $application['student_gender'] ?>'>
                                    <button class="dropdown-item" type="submit">Grant Admission</button>
                                  </form>
                                <?php } ?>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>

                      </tbody>

                      <!-- <tbody>
                        <tr>
                          <td>1</td>
                          <td>Imani Lara</td>
                          <td>Grade 4</td>
                          <td>Second</td>
                          <td>2023/2024</td>
                          <td>9022 Suspendisse Rd.</td>
                          <td>Jun 8, 2019</td>
                          <td class=" text-success">Called
                            </td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Interviewed</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Called</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-danger">Cancelled</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Called</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Called</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Called</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Called</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Imani Lara</td>
                            <td>Grade 4</td>
                            <td>Second Term</td>
                            <td>2023/2024</td>
                            <td>9022 Suspendisse Rd.</td>
                            <td>Jun 8, 2019</td>
                            <td class="text-success">Called</td>
                            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Change label</a>
                                <a class="dropdown-item" href="#">View application</a>
                                <a class="dropdown-item" href="#">Grant Admission</a>
                              </div>
                            </td>
                          </tr>

                      </tbody> -->
                    </table>
                  </div>
                </div>
              </div> <!-- simple table -->
            </div> <!-- end section -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->

      <!-- Notifications modal -->
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
                <div class="col-6 text-center con-item">
                  <a href="../administration/" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary control-panel-text">Dashboard</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Academics</p>
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



      <!-- Assign Class Teacher Modal -->
      <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="varyModalLabel">Change Application Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="needs-validation change_status">
              <div class="modal-body p-4">

                <div class="form-row">
                  <div class="form-group col-12">
                    <p>Meanings to Application Status:</p>

                    <p>Initiated: Satrted application process but not yet completely filled the form. This is usually
                      handled by the system</p>
                    <p>Submitted: Completed filling sand submitted the form. This is also handled by the system</p>
                    <p>Paid: Paid the application fees and will?has been called in for interview. This is usually
                      handled manually by the management</p>
                    <p>Interviewed: Interview had been conducted successfully. All handled by the management</p>
                    <p>Admitted: Admitted into te school, now a student of Grithall Academy. Handled by the managemnt
                      also</p>
                    <p>Rejected: Admission was not successful, can contact school for furtherenquiry, handled by the
                      management</p>
                  </div>
                </div>


                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="status">status</label>
                    <select id="status" class="form-control select2" required name="status">
                      <option value=''>Select status</option>
                      <option value='Initiated'>Initiated</option>

                      <option value='Submitted'>Submitted</option>

                      <option value='Paid'>Paid</option>

                      <option value='Interviewed'>Interviewed</option>

                      <option value='Admitted'>Admitted</option>

                      <option value='Rejected'>Rejected</option>

                    </select>
                  </div>
                </div>

              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="submit" class="btn mb-2 btn-primary w-100">Update Application Status </button>
              </div>
            </form>
          </div>
        </div>
      </div> <!-- new event modal -->

      <!-- Assign Warning Modal -->
      <div class="modal fade" id="warningModel" tabindex="-1" role="dialog" aria-labelledby="warningModelTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header justify-content-center">
              <h5 class="modal-title text-center" id="warningModelTitle">Confirm Admission</h5>
            </div>
            <div class="modal-body">Are you sure you want to grant admission to this student?</div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn mb-2 btn-primary" id="link_button">Grant Admission</button>
            </div>
          </div>
        </div>
      </div>




      <!-- Loading Modal -->
      <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="card col-12 loader">
            <div class="mt-4" style="align-self: center">
              <div class="logo mb-3">
                <img src="../logo.jpg" alt="Grit Hall Academy Logo">
                <div class="clock">
                  <div class="hand hour"></div>
                  <div class="hand minute"></div>
                </div>
              </div>
              <strong>Proccessing <span class="dot-flashing"></span></strong>
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
    // Function to display a popup message
    function displayPopup(message, success) {
      var popup = document.createElement('div');
      popup.className = 'popup ' + (success ? 'success' : 'error');

      var iconClass = success ? 'fe fe-check-circle' : 'fe fe-x-octagon';
      var icon = document.createElement('i');
      icon.className = iconClass;
      popup.appendChild(icon);

      var text = document.createElement('span');
      text.textContent = message;
      popup.appendChild(text);

      document.body.appendChild(popup);

      setTimeout(function () {
        popup.remove();
      }, 3000);
    }


    // Assign Class Teacher js
    document.querySelectorAll(".change_status").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'change_application_status.php',
          data: $(this).serialize(),
          dataType: 'json',
          success: function (response) {
            $('#eventModal').modal('hide');
            if (response.success) {
              displayPopup(response.message, true);
              // Refresh the page after 2 seconds
              setTimeout(function () {
                location.reload();
              }, 3000);
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function (error, xhr) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      });
    });


    $(document).ready(function () {
      $('.update_form').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Show confirmation modal
        $('#warningModel').modal('show');

        // Add click event listener to the confirmation button
        $('#link_button').off('click').on('click', function () {
          // Submit form data via AJAX
          $.ajax({
            url: 'grant-admission.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
              $('#loadingModal').modal({
                backdrop: 'static',
                keyboard: false
              });
            },
            success: function (response) {
              setTimeout(function () {
                $('#loadingModal').modal('hide');

                // Handle the response
                if (response.success) {
                  $('#warningModel').modal('hide');
                  displayPopup(response.message, true);
                  setTimeout(function () {
                    location.reload();
                  }, 3000);
                } else {
                  displayPopup(response.message, false);
                }
              }, 500)
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
              // Handle errors if any
            }
          });

        });
      });
    });
  </script>
</body>

</html>