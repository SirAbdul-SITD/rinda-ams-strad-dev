<?php require('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Subjects - Rinda AMS</title>
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
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
              <a class="nav-link" href="students.php">
                <i class="fe fe-users fe-16"></i>
                <span class="ml-3 item-text">My Students</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="subjects.php">
                <i class="fe fe-server fe-16"></i>
                <span class="ml-3 item-text">My Subject</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="classes.php">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">My Classes</span>
                </i>
              </a>
            </li>
          </ul>
          <!-- Admission -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>General</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="all-students.php">
                <i class="fe fe-users fe-16"></i>
                <span class="ml-3 item-text">All Students</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="all-subjects.php">
                <i class="fe fe-server fe-16"></i>
                <span class="ml-3 item-text">All Subject</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="all-classes.php">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">All Classes</span>
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

          </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row align-items-center mb-2">
              <div class="col">
                <h2 class="h5 page-title">Good day <?php
                                                    if ($gender == 'Male') {
                                                      echo 'Ustadhz';
                                                    } elseif ($gender == 'Female') {
                                                      echo 'Mrs';
                                                    } ?>
                  <?= $full_name; ?>
                </h2>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow bg-primary text-white border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary-light">
                          <i class="fe fe-16 fe-user text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">My Students</p>
                        <span class="h3 mb-0 text-white"> <?php
                                                          try {
                                                            // Prepare SQL statement to fetch student data
                                                            $sql = "SELECT s.admission_no, s.id, CONCAT(s.firstName, ' ', s.lastName) AS full_name, c.class, a.teacher_id, a.class_id
            FROM students s
            INNER JOIN classes c ON s.class_id = c.id OR s.2ndClass_id = c.id
            LEFT JOIN assigned_classes a ON c.id = a.class_id
            WHERE s.status = 1 AND a.teacher_id = :user";
                                                            $stmt = $pdo->prepare($sql);
                                                            $stmt->bindParam(':user', $user_id);
                                                            $stmt->execute();
                                                            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                          } catch (PDOException $e) {
                                                            // Handle database error
                                                            echo 'Error: ' . $e->getMessage();
                                                            die();
                                                          }
                                                          if (count($students) != 0) {
                                                            echo count($students);
                                                          }
                                                          ?></span>
                        <span class="small text-muted">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                          <i class="fe fe-16 fe-book text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">My Subjects</p>
                        <span class="h3 mb-0"><?php
                                              $query = "SELECT s.*, c.class FROM subjects s INNER JOIN classes c ON s.class_id = c.id LEFT JOIN staffs u ON s.assigned = u.id WHERE s.status = 1 AND c.status = 1 AND s.assigned = :user ORDER BY s.class_id ASC";
                                              $stmt = $pdo->prepare($query);
                                              $stmt->bindParam(':user', $user_id);
                                              $stmt->execute();
                                              $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                              if (count($subjects) != 0) {
                                                echo count($subjects);
                                              }
                                              ?></span>
                        <span class="small text-success">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                          <i class="fe fe-16 fe-home text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">My Classes</p>
                        <span class="h3 mb-0"><?php
                                              try {
                                                $sql = "SELECT * FROM assigned_classes WHERE teacher_id = :user";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->bindParam(':user', $user_id);
                                                $stmt->execute();
                                                $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                              } catch (PDOException $e) {
                                                echo 'Error: ' . $e->getMessage();
                                                die();
                                              }
                                              if (count($classes) != 0) {
                                                echo count($classes);
                                              }
                                              ?></span>
                        <span class="small text-success">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                          <i class="fe fe-16 fe-users text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">All Students</p>
                        <span class="h3 mb-0"><?php
                                              try {
                                                $sql = "SELECT * FROM students WHERE status = 1";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();
                                                $allStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                              } catch (PDOException $e) {
                                                echo 'Error: ' . $e->getMessage();
                                                die();
                                              }
                                              if (count($allStudents) != 0) {
                                                echo count($allStudents);
                                              }
                                              ?></span>
                        <span class="small text-success">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end section -->
            <!--  <div class="row">
              <div class="col-md-6">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong>Account Statistics</strong>
                  </div>
                  <div class="card-body px-4">
                    <div class="row border-bottom">
                      <div class="col-4 text-center mb-3">
                        <p class="mb-1 small text-muted">Students</p>
                        <span class="h3">6%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span><br />
                      </div>
                      <div class="col-4 text-center mb-3">
                        <p class="mb-1 small text-muted">Parents</p>
                        <span class="h3">7.6%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                      </div>
                      <div class="col-4 text-center mb-3">
                        <p class="mb-1 small text-muted">Teachers</p>
                        <span class="h3">1%</span>
                        <span class="fe fe-arrow-down text-danger fe-12"></span>
                      </div>
                    </div>
                    <table class="table table-borderless mt-3 mb-1 mx-n1 table-sm">
                      <thead>
                        <tr>
                          <th class="w-50">Users</th>
                          <th class="text-right">Last Term</th>
                          <th class="text-right">Narration</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Students</td>
                          <td class="text-right">235</td>
                          <td class="text-right text-success">+15</td>
                        </tr>
                        <tr>
                          <td>Parents</td>
                          <td class="text-right">448</td>
                          <td class="text-right text-success">+21</td>
                        </tr>
                        <tr>
                          <td>Teachers</td>
                          <td class="text-right">70</td>
                          <td class="text-right text-danger">-1</td>
                        </tr>
                      </tbody>
                    </table>
                  </div> 
                </div> 
              </div> 
              
              

              Notification List 
              <div class="col-md-6">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Notification List</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <div class="card-body">
                    <div class="list-group list-group-flush my-n3">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="fe fe-box fe-24"></span>
                          </div>
                          <div class="col">
                            <small><strong>Package has uploaded successfully</strong></small>
                            <div class="my-0 text-muted small">Package is zipped and uploaded successfully to the cloud </div>
                          </div>
                          <div class="col-auto">
                            <small class="badge badge-pill badge-light text-muted">1m ago</small>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="fe fe-download fe-24"></span>
                          </div>
                          <div class="col">
                            <small><strong>Results are updated successfully</strong></small>
                            <div class="my-0 text-muted small">Primary Results have been successfully compiled and saved</div>
                          </div>
                          <div class="col-auto">
                            <small class="badge badge-pill badge-light text-muted">2m ago</small>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="fe fe-inbox fe-24"></span>
                          </div>
                          <div class="col">
                            <small><strong>Notifications have been sent</strong></small>
                            <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                          </div>
                          <div class="col-auto">
                            <small class="badge badge-pill badge-light text-muted">30m ago</small>
                          </div>
                        </div> 
                      </div>

                    </div> 
                  </div> 
                </div> 
              </div> 
            </div>
             .row -->

            <div class="row">
              <!-- Recent orders -->
              <div class="col-md-8">
                <div class="card shadow eq-card">
                  <div class="card-header">
                    <strong class="card-title">Weekly Targets</strong>
                    <a class="float-right small text-muted" href="#!">Go to targets</a>
                  </div>
                  <div class="card-body">
                    <table class="table table-hover table-borderless table-striped mt-n3 mb-n1">
                      <div class="text-center">None Added</div>
                      <!-- <thead>
                        <tr>
                          <th>#</th>
                          <th>Description</th>
                          <th>Week</th>
                          <th>Class</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        <tr>
                          <td>1</td>
                          <td>Primary 2 Text Books</td>
                          <td>14 Jul 2022</td>
                          <td>Maalik Abdurrahman</td>

                        </tr>


                      </tbody> -->
                    </table>
                  </div> <!-- .card-body -->
                </div> <!-- .card -->
              </div> <!-- / .col-md-8 -->
              <!-- Recent Activity -->
              <div class="col-md-4">
                <div class="card shadow eq-card timeline">
                  <div class="card-header">
                    <strong class="card-title">Academic Timeline</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <!-- <div class="card-body" data-simplebar>
                    <div class="pb-3 timeline-item item-success">
                      <div class="pl-5">
                        <div class="mb-2 small"><strong>Kelley Sonya</strong></div>
                        <div class="card d-inline-flex mb-2">
                          <div class="card-body bg-light small py-2 px-3" style="border-radius: 8px;"> Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. </div>
                        </div>
                        <p class="small text-muted">Week 1</p>
                      </div>
                    </div>

                    <div class="pb-3 timeline-item item-success">
                      <div class="pl-5">
                        <div class="mb-2 small"><strong>Kelley Sonya</strong></div>
                        <div class="card d-inline-flex mb-2">
                          <div class="card-body bg-light small py-2 px-3" style="border-radius: 8px;"> Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. </div>
                        </div>
                        <p class="small text-muted">Week 2</p>
                      </div>
                    </div>
                  </div> / .card-body -->
                </div> <!-- / .card -->
              </div> <!-- / .col-md-3 -->
            </div> <!-- end section -->


          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->
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
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-award fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Academics</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../assessments" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-check-square fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Assessments</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../curriculum" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-book-open fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Curriculum</p>
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
  <script src="../js/d3.min.js"></script>
  <script src="../js/topojson.min.js"></script>
  <script src="../js/datamaps.all.min.js"></script>
  <script src="../js/datamaps-zoomto.js"></script>
  <script src="../js/datamaps.custom.js"></script>
  <script src="../js/Chart.min.js"></script>
  <script>
    /* defind global options */
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
  </script>
  <script src="../js/gauge.min.js"></script>
  <script src="../js/jquery.sparkline.min.js"></script>
  <script src="../js/apexcharts.min.js"></script>
  <script src="../js/apexcharts.index.js"></script>
  <script src='../js/jquery.mask.min.js'></script>
  <script src='../js/select2.min.js'></script>
  <script src='../js/jquery.steps.min.js'></script>
  <script src='../js/jquery.validate.min.js'></script>
  <script src='../js/jquery.timepicker.js'></script>
  <script src='../js/dropzone.min.js'></script>
  <script src='../js/uppy.min.js'></script>
  <script src='../js/quill.min.js'></script>
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
    var uptarg = document.getElementById('drag-drop-area');
    if (uptarg) {
      var uppy = Uppy.Core().use(Uppy.Dashboard, {
        inline: true,
        target: uptarg,
        proudlyDisplayPoweredByUppy: false,
        theme: 'dark',
        width: 770,
        height: 210,
        plugins: ['Webcam']
      }).use(Uppy.Tus, {
        endpoint: 'https://master.tus.io/files/'
      });
      uppy.on('complete', (result) => {
        console.log('Upload complete! We’ve uploaded these files:', result.successful)
      });
    }
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