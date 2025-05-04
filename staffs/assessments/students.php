<?php require('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Students - Assessment | Rinda AMS</title>
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
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
          <li class="nav-item">
            <a class="nav-link" href="past-results.php">
              <i class="fe fe-tool fe-16"></i>
              <span class="ml-3 item-text">Edit past results</span>
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
                <h2 class="mb-2 page-title">Assigned Students</h2>
                <p class="mb-3">The following students are from classes assigned to you, Please select a students to add or update their assessment marks</p>
              </div>
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
                          <th>Admission No.</th>
                          <th>Name</th>
                          <th>Class</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        try {
                          // Prepare SQL statement to fetch student data
                          $sql = "SELECT s.admission_no, s.id, CONCAT(s.firstName, ' ', s.lastName) AS full_name, c.class, a.teacher_id, a.class_id
            FROM students s INNER JOIN classes c ON s.class_id = c.id OR s.2ndClass_id = c.id
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

                        foreach ($students as $index => $student) : ?>
                          <tr>
                            <td>
                              <?= $index + 1 ?>
                            </td>
                            <td>
                              <?= $student['admission_no'] ?>
                            </td>
                            <td>
                              <?= $student['full_name'] ?>
                            </td>
                            <td>
                              <?= $student['class'] ?>
                            </td>

                            <td>
                              <form action="student-assessment.php" method="POST">
                                <input type="hidden" name="student" value="<?= $student['id']; ?>">
                                <input type="hidden" name="class_id" value="<?= $student['class_id']; ?>">
                                <button type="submit" class="btn  w-100 btn-primary"><i class="fe fe-user-check fe-16"></i> Process student assessment</button>
                              </form>

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
                  <a href="../academics" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-award fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Academics</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-check-square fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Assessments</p>
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