<?php require('../settings.php');

if (isset($_POST['parent_id']) || isset($_GET['parent_id'])) {
  $parent_id = $_POST['parent_id'] ?? $_GET['parent_id'];
} else {
  header("Location: parents.php");
  exit;
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
  <title>Parent - Academics | Rinda AMS</title>
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
            <li class="nav-item active">
              <a class="nav-link text-primary" href="parents.php">
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
                <h2 class="page-title">Parent Profile</h2>
              </div>
            </div>
            <div class="col-md-12 mb-12 my-3 " id="studentInfoWindow">
              <div class="card profile shadow">
                <div class="card-body my-4">
                  <div class="row align-items-center">

                    <?php


                    // SQL query to fetch student data based on admission number
                    $sql = "SELECT p.*,
                          (SELECT COUNT(*) FROM parent_student WHERE parent_id = p.id) AS num_dependents
                    FROM parents p
                    WHERE p.id = :parent_id AND status = 1";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':parent_id', $parent_id);
                    $stmt->execute();
                    $parent = $stmt->fetch(PDO::FETCH_ASSOC);


                    // Function to display "Nill" if value is empty
                    function displayIfEmpty($value)
                    {
                      return empty($value) ? 'Nill' : $value;
                    }

                    // Check if student data exists
                    if ($parent) {
                      // Output the student data in the form
                      ?>
                      <div class="col-4">
                        <div class="row align-items-center">
                          <div class="col-md-7">
                            <h4 class="mb-1 parent-name">
                              <?= displayIfEmpty($parent['firstName'] . ' ' . $parent['lastName']); ?>
                              <p class="mb-4"><span class="badge badge-dark">
                                  <?= displayIfEmpty($parent['occupation']); ?>
                                </span></p>
                            </h4>
                          </div>
                          <div class="col">
                          </div>
                        </div>
                      </div>
                      <div class="col-8">

                        <div class="row mb-4">
                          <div class="col-md-7">
                            <div class="row">
                              <p class="text-muted">First Name: </p>
                              <p class="parent-class">
                                <?= displayIfEmpty($parent['firstName']); ?>
                              </p>
                            </div>
                            <div class="row">
                              <p class="text-muted">Email: </p>
                              <p class="parent-gender">
                                <?= displayIfEmpty($parent['email']); ?>
                              </p>
                            </div>
                            <div class="row">
                              <p class="text-muted">Address: </p>
                              <p class="parent-address">
                                <?= displayIfEmpty($parent['address']); ?>
                              </p>
                            </div>
                            <div class="row">
                              <p class="text-muted">Occupation: </p>
                              <p class="parent-state">
                                <?= displayIfEmpty($parent['occupation']); ?>
                              </p>
                            </div>
                          </div>
                          <div class="col">
                            <div class="row">
                              <p class="text-muted">Last Name: </p>
                              <p class="parent-email">
                                <?= displayIfEmpty($parent['lastName']); ?>
                              </p>
                            </div>
                            <div class="row">
                              <p class="text-muted">Phone Number: </p>
                              <p class="parent-phone">
                                <?= displayIfEmpty($parent['phoneNumber']); ?>
                              </p>
                            </div>
                            <div class="row">
                              <p class="text-muted">State: </p>
                              <p class="parent-city">
                                <?= displayIfEmpty($parent['state']); ?>
                              </p>
                            </div>
                            <div class="row">
                              <p class="text-muted">Origin: </p>
                              <p class="parent-country">
                                <?= displayIfEmpty($parent['state_of_origin']); ?>
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="row ">
                          <div class="col-md-4 mb-2">
                            <span class="mb-0">Number of dependant(s): <span id="parent-joined">
                                <?= displayIfEmpty($parent['num_dependents']); ?>
                              </span></span>

                          </div>
                          <div class="row mb-2">
                            <form action="link-student.php" method="post">
                              <input type="hidden" name="id" value="<?= $dependent['id'] ?>">
                              <input type="hidden" name="parent_id" value="<?= $dependent['parent_id'] ?>">
                              <button type="submit" class="btn ml-2 btn-outline-primary">Send Message</button>
                            </form>

                            <form action="link-student.php" method="post">
                              <input type="hidden" name="parent_name"
                                value="<?= $parent['firstName'] . ' ' . $parent['lastName'] ?>">
                              <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
                              <button type="submit" class="btn ml-2 btn-outline-success">Manage Dependents</button>
                            </form>

                            <!-- <button type="button" class="btn mb-2 btn-outline-danger">Disable</button> -->
                          </div>
                        </div>
                      </div>
                      <?php
                    } else {
                      // If student data not found, display a message
                      echo "Parent data not found.";
                    }
                    ?>

                  </div>
                </div> <!-- / .row- -->
              </div> <!-- / .card-body - -->
              <hr>
              <?php

              try {
                // Prepare SQL statement to fetch parent-student relationships and dependent data with class names
                $sql = "SELECT ps.student_id, s.firstName AS student_first_name, s.lastName AS student_last_name, s.id, ps.parent_id, s.photo, s.admission_no, c.class
            FROM parent_student ps
            INNER JOIN students s ON ps.student_id = s.id
            INNER JOIN classes c ON s.class_id = c.id
            WHERE ps.parent_id = :parent_id AND ps.status = 1";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':parent_id', $parent_id);
                $stmt->execute();
                $dependents = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                // Handle database error
                echo 'Error: ' . $e->getMessage();
                die();
              }

              // Display the dependents
              echo '<h2 class="h5" id="task-section">Dependents</h2>';
              foreach ($dependents as $dependent) {
                //           
                ?>

                <div class="row">
                  <div class="col-12 mb-4">
                    <div class="card shadow mb-3">
                      <div class="card-body py-3">
                        <div class="row align-items-center">
                          <div class="col-auto pr-1">
                            <span class="avatar avatar-sm mt-2">
                              <?php
                              if ($student['photo'] == null) {
                                if ($student['gender'] == 'female') { ?>
                                  <img src="https://strad.africa/uploads/student-profiles/2.jpeg" alt="Profile picture"
                                    class="avatar-img rounded-circle">
                                <?php } else { ?>
                                  <img src="https://strad.africa/uploads/student-profiles/1.jpeg" alt="Profile picture"
                                    class="avatar-img rounded-circle">
                                <?php }
                              } else { ?>
                                <img src="https://strad.africa/uploads/student-profiles/<?= $student['photo'] ?>"
                                  alt="Profile picture" class="avatar-img rounded-circle">
                              <?php } ?>
                            </span>
                            </span>
                          </div>
                          <div class="col pr-0">
                            <strong><?= $dependent['student_first_name'] . ' ' . $dependent['student_last_name'] ?></strong>
                            <p class="small text-muted mb-0"><?= $dependent['class'] ?></p>
                          </div>

                          <div class="col-auto">
                            <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">
                              <span class="text-muted sr-only">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <form action="student.php" method="post">
                                <input type="hidden" name="admission_no" value="<?= $dependent['admission_no'] ?>">
                                <button type="submit" class="dropdown-item">View Student Profile</button>
                              </form>
                              <form class="unlink-form" action="student.php" method="post">
                                <input type="hidden" class="sid" name="id" value="<?= $dependent['id'] ?>">
                                <input type="hidden" class="pid" name="parent_id" value="<?= $dependent['parent_id'] ?>">
                                <button type="submit" class="dropdown-item unlink">Unlink Student</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div> <!-- / .card-body -->
                    </div> <!-- /.card -->
                  <?php } ?>
                </div> <!-- /.col -->

              </div> <!-- /.row -->


            </div> <!-- / .card- -->

          </div> <!-- / .col- -->

        </div> <!-- .col-12 -->
      </div> <!-- .row -->

  </div> <!-- .container-fluid -->



  <!-- RemoveConfirmModal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to unlink this student from this parent?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger confirm-remove">Remove</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Notification Modal -->
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

  <!-- Menu Modal -->
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

  <!-- Assign Warning Modal -->
  <div class="modal fade" id="warningModel" tabindex="-1" role="dialog" aria-labelledby="warningModelTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h5 class="modal-title text-center" id="warningModelTitle">Subject Already Assigned</h5>
        </div>
        <div class="modal-body">This Subject Is Already Assigned to another teacher, do you want to change teacher
          assign to this subject?</div>
        <div class="modal-footer">
          <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn mb-2 btn-primary" id="force_assign">Change Role</button>
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
    document.getElementById('sectionSelect').addEventListener('change', function () {
      var sectionSelect = this.value;
      var classSelect = document.getElementById('classSelect');
      var studentSelect = document.getElementById('studentSelect');

      // Clear existing options in the class select field
      classSelect.innerHTML = '<option value="" selected disabled>Select Class</option>';
      studentSelect.innerHTML = '<option value="" selected disabled>Select Student</option>';

      if (sectionSelect !== '') {
        // Make an AJAX request to fetch classes for the selected section
        $.ajax({
          type: 'POST',
          url: 'fetch_classes.php', // Update the URL to your server endpoint
          data: {
            section_id: sectionSelect
          },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              // Populate the class select field with the retrieved classes
              response.classes.forEach(function (classInfo) {
                var option = document.createElement('option');
                option.value = classInfo.id;
                option.text = classInfo.class;
                classSelect.appendChild(option);
              });
              // Enable the class select field
              classSelect.disabled = false;
            } else {
              // Handle error response
              // console.error('Failed to fetch classes:', response.message);
            }
          },
          error: function (xhr, status, error) {
            // console.error('Error occurred during request:', error);
          }
        });
      } else {
        // Disable the class select field if no section is selected
        classSelect.disabled = true;
        studentSelect.disabled = true;
      }
    });

    document.getElementById('classSelect').addEventListener('change', function () {
      var classSelect = this.value;
      var studentSelect = document.getElementById('studentSelect');

      // Clear existing options in the subject select field
      studentSelect.innerHTML = '<option value="" selected disabled>Select Student</option>';

      if (classSelect !== '') {
        // Make an AJAX request to fetch students for the selected class
        $.ajax({
          type: 'POST',
          url: 'fetch_students.php', // Update the URL to your server endpoint
          data: {
            class_id: classSelect
          },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              // Populate the student select field with the retrieved students
              response.students.forEach(function (student) {
                var option = document.createElement('option');
                option.value = student.id;
                option.text = student.firstName + " " + student.lastName;
                studentSelect.appendChild(option);
              });
              // Enable the student select field
              studentSelect.disabled = false;
            } else {
              // Handle error response
              // console.error('Failed to fetch students:', response.message);
            }
          },
          error: function (xhr, status, error) {
            // console.error('Error occurred during request:', error);
          }
        });
      } else {
        // Disable the student select field if no class is selected
        studentSelect.disabled = true;
      }
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const removeButtons = document.querySelectorAll('.unlink');



      removeButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
          console.log('clicked');
          event.preventDefault();
          const parentCard = event.target.closest('.card');
          const unlinkForm = event.target.closest('.unlink-form');
          const formData = $(unlinkForm).serialize();

          // Show confirmation modal
          $('#confirmationModal').modal('show');

          // Add click event listener to the confirmation button
          $('.confirm-remove').off('click').on('click', function () {
            // Send AJAX request to remove the subject
            $.ajax({
              type: 'POST',
              url: 'unlink-student.php',
              data: formData,
              dataType: 'json',
              success: function (response) {
                if (response.success) {
                  // Remove the row from the table
                  parentCard.remove();
                  displayPopup(response.message, true);
                } else {
                  displayPopup(response.message, false);
                }
              },
              error: function (error, xhr) {
                displayPopup('Error occurred during request. Contact Admin', false);
              },
            });

            // Hide the modal after action
            $('#confirmationModal').modal('hide');
          });
        });
      });

    });
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




    // Add class form js
    document.querySelectorAll(".add_subject_form").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'add_subject.php',
          data: $(this).serialize(),
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              displayPopup(response.message, true);
              // Refresh the page after 2 seconds
              setTimeout(function () {
                location.reload();
              }, 2000);
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


    // Assign Class Teacher js
    document.querySelectorAll(".assign_subject_form").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'assign_subject_form.php',
          data: $(this).serialize(),
          dataType: 'json',
          success: function (response) {
            $('#assignTeacher').modal('hide');
            if (response.success) {
              displayPopup(response.message, true);
              // Refresh the page after 2 seconds
              setTimeout(function () {
                location.reload();
              }, 2000);
            } else {
              $('#warningModel').modal('show');
            }
          },
          error: function (error, xhr) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      });
    });


    document.getElementById("force_assign").addEventListener("click", function () {
      $.ajax({
        type: 'POST',
        url: 'force_assign_subject_teacher.php',
        data: $('.assign_subject_form').serialize(),
        dataType: 'json',
        beforeSend: function () {
          $('#warningModel').modal('hide');
        },
        success: function (response) {
          if (response.success) {
            displayPopup(response.message, true);
            // Refresh the page after 2 seconds
            setTimeout(function () {
              location.reload();
            }, 2000);
          } else {
            displayPopup(response.message, false);
          }
        },
        error: function (xhr, status, error) {
          displayPopup('Error occurred during request. Contact Admin', false);
          // console.error('Error:', error); // Log the error to the console for debugging
        },
      });
    });


    document.querySelectorAll(".student-info-form").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        var studentInfoWindow = document.getElementById('studentInfoWindow');

        $.ajax({
          type: 'POST',
          url: 'get_student_info.php',
          data: $(this).serialize(),
          dataType: 'json',
          beforeSend: function () {
            // $('#warningModel').modal('hide');
          },
          // Update student info window with received data
          success: function (response) {
            if (response.success) {
              // Display student information
              var student = response.student;
              document.getElementById('studentName').innerText = student.firstName + ' ' + student.lastName;
              document.getElementById('student-joined').innerText = student.join_date;
              document.getElementById('studentReg').innerText = student.admission_no;
              document.getElementById('studentGender').innerText = student.gender;
              document.getElementById('studentDOB').innerText = student.dob;
              document.getElementById('studentClass').innerText = student.class;
              document.getElementById('studentAddress').innerText = student.address;
              // document.getElementById('studentParentPhone').innerText = student.parent_phone;

              // Show the student info window
              studentInfoWindow.style.display = 'block';
            } else {
              displayPopup(response.message, false);
            }

          },
          error: function (xhr, status, error) {
            studentInfoWindow.style.display = 'block';
            displayPopup('Error occurred during request. Contact Admin', false);
            // console.error('Error:', error); // Log the error to the console for debugging
          },
        });
      });
    });
  </script>
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
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
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