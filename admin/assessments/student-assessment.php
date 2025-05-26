<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Process - Assessments | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
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
            <a class="nav-link text-primary" href="students.php">
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
    <script>
      function toggleButtonClass(button) {
        if (button.classList.contains('btn-secondary')) {
          button.classList.remove('btn-secondary');
          button.classList.add('btn-success');
        }
      }
    </script>
    <main role="main" class="main-content">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="row">
            <!-- Small table -->
            <div class="col-md-12 my-4">
              <!-- <div class="row align-items-center my-3">
                <div class="col">
                  <h2 class="page-title">Assessment Types</h2>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModel"><span
                      class="fe fe-plus fe-16 mr-3"></span>New</button>
                </div>
              </div> -->
              <div class="card shadow">

                <div class="card-body">
                  <?php
                  require_once '../settings.php'; // Include your settings file with database connection

                  // Check if the student ID is provided in the request
                  if (isset($_REQUEST['student'])) {
                    $student_id = $_REQUEST['student'];

                    // Fetch student details
                    $query_student = "SELECT * FROM students WHERE id = :student_id";
                    $stmt_student = $pdo->prepare($query_student);
                    $stmt_student->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                    $stmt_student->execute();
                    $student = $stmt_student->fetch(PDO::FETCH_ASSOC);

                    if ($student) {
                      // Fetch subjects for the student's class
                      $class_id = $student['class_id'];
                      $query_subjects = "SELECT s.id AS subject_id, s.subject, c.class FROM subjects s INNER JOIN classes c ON s.class_id = c.id WHERE s.class_id = :class_id";
                      $stmt_subjects = $pdo->prepare($query_subjects);
                      $stmt_subjects->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                      $stmt_subjects->execute();
                      $subjects = $stmt_subjects->fetchAll(PDO::FETCH_ASSOC);

                      if ($subjects) {
                  ?>
                        <h4 class="card-title">Marks Entry for
                          <?= $student['firstName'] ?>
                          <?= $student['lastName'] ?>
                          <?= $student['class'] ?>
                        </h4>
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>Subject</th>
                              <?php
                              // Fetch assessment types
                              $query_assessment_types = "SELECT * FROM assessment_types WHERE class_id = :class_id ORDER BY `assessment_types`.`assessment_id` ASC";
                              $stmt_assessment_types = $pdo->prepare($query_assessment_types);
                              $stmt_assessment_types->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                              $stmt_assessment_types->execute();
                              $assessment_types = $stmt_assessment_types->fetchAll(PDO::FETCH_ASSOC);

                              foreach ($assessment_types as $assessment_type) {
                                echo "<th>{$assessment_type['assessment_type']}</th>";
                              }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            foreach ($subjects as $subject) {
                              echo "<tr>";
                              echo "<td>{$subject['subject']}</td>";

                              foreach ($assessment_types as $assessment_type) {
                                $assessment_id = $assessment_type['assessment_id'];

                                // Fetch marks for this student and assessment type
                                $query_marks = "SELECT * FROM assessment_marks WHERE student_id = :student_id AND assessment_id = :assessment_id AND subject_id = :subject_id AND session = :session AND term = :term";
                                $stmt_marks = $pdo->prepare($query_marks);
                                $stmt_marks->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                $stmt_marks->bindParam(':subject_id', $subject['subject_id'], PDO::PARAM_INT);
                                $stmt_marks->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);
                                $stmt_marks->bindParam(':session', $session);
                                $stmt_marks->bindParam(':term', $term, PDO::PARAM_INT);
                                $stmt_marks->execute();
                                $marks = $stmt_marks->fetch(PDO::FETCH_ASSOC);

                                // Display input field to enter marks
                                echo "<td>";
                                echo "<form class='add_marks_form'>";
                                echo "<input type='hidden' name='student_id' value='{$student_id}'>";
                                echo "<input type='hidden' name='class_id' value='{$class_id}'>";
                                echo "<input type='hidden' name='subject_id' value='{$subject['subject_id']}'>";
                                echo "<input type='hidden' name='assessment_id' value='{$assessment_id}'>";
                                echo "<input type='hidden' name='session' value='{$session}'>";
                                echo "<input type='hidden' name='term' value='{$term}'>";
                                echo "<input type='number' class='form-control' name='marks' value='{$marks['mark']}' style='width: 70px; margin-bottom: 3px;'>";
                                echo "<button type='submit' class='btn btn-sm btn-secondary' style='width: 70px' onclick='toggleButtonClass(this)'>Save</button>";
                                echo "</form>";
                                echo "</td>";
                              }
                              echo "</tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                  <?php
                      } else {
                        echo "<div class='alert alert-danger'>No subjects found for the student's class.</div>";
                      }
                    } else {
                      echo "<div class='alert alert-danger'>Student not found.</div>";
                    }
                  } else {
                    // Redirect or display an error message if the student ID is not provided
                    echo "<div class='alert alert-danger'>Student ID not provided.</div>";
                  }
                  ?>


                </div>
              </div> <!-- customized table -->
            </div> <!-- end section -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->

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

      setTimeout(function() {
        popup.remove();
      }, 1000);
    }

    $(document).ready(function() {
      $('.add_marks_form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Submit form data via AJAX
        $.ajax({
          url: 'save-marks.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            // Handle the response
            if (response.success) {
              displayPopup(response.message, true);
              // Optionally, update the UI or perform any other action
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Handle errors if any
          }
        });
      });
    });
  </script>



</body>

</html>