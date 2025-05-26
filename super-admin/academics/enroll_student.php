<?php
require '../settings.php';

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Enroll into Islamiyyah - Academics | Rinda AMS</title>
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
            <li class="nav-item active">
              <a class="nav-link text-primary" href="enroll_student.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Enroll into Islamiyyah</span>
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
              <h2 class="page-title mb-0">Enroll an existing student into islamiyyah</h2>
              <p class="lead text-muted mb-0">Please select islamiyyah class and days</p>
            </div>
            <div class="row my-4">

              <div class="col-12">
                <div class="card shadow mb-4">
                  <div class="card-body">

                    <form id="results" method="POST">
                      <div class="modal-body">


                        <div class="row col-12">
                          <div class="col-md-12">
                            <div class="form-group mb-3">
                              <label for="dependant">Select Dependant</label>
                              <select class="form-control select1" required name="id">
                                <?php
                                $sql = "SELECT DISTINCT s.firstName, s.id, s.admission_no, CONCAT(s.firstName, ' ', s.lastName) AS full_name, c.class
                                  FROM students s
                                  INNER JOIN classes c ON s.class_id = c.id
                                  INNER JOIN parent_student p ON p.student_id = s.id
                                  WHERE s.status = 1 AND p.parent_id = :user";

                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':user', $user_id);
                                $stmt->execute();
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($students) > !0) {
                                  echo '<option value="" selected disabled>You  Have No Dependant</option>';
                                } else {
                                  echo "<option value='' selected disabled>Select Dependant</option>";
                                  foreach ($students as $student):
                                    $dependant = $student['full_name'];
                                    $dependant_id = $student['id'];
                                    echo "<option value='$dependant_id'>$dependant</option>";
                                  endforeach;
                                }
                                ?>
                              </select>
                            </div>

                          </div> <!-- /.col -->



                        </div>

                        <div class="row col-12">

                          <div class="col-md-6">
                            <div class="form-group mb-3">
                              <label for="class">Class</label>
                              <select class="form-control select1" required name="class">
                                <?php
                                $query = "SELECT * FROM classes WHERE section_id = 3";
                                $stmt = $pdo->query($query);
                                $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($classes) > !0) {
                                  echo '<option value="" selected disabled>None</option>';
                                } else {
                                  echo "<option value='' selected disabled>Select Class</option>";
                                  foreach ($classes as $class):
                                    $islamiyyah_class_id = $class['id'];
                                    $islamiyyah_class_name = $class['class'];
                                    echo "<option value='$islamiyyah_class_id'>$islamiyyah_class_name</option>";
                                  endforeach;
                                }
                                ?>
                              </select>
                            </div>

                          </div> <!-- /.col -->


                          <div class="col-md-6">
                            <div class="form-group mb-3">
                              <label for="days">Days</label>
                              <select class="form-control select1" required name="days">
                                <option value='' selected disabled>Select Days</option>
                                <option value='Weekends Only'>Weekends Only</option>
                                <option value='Weekdays & Weekends'>Weekdays & Weekends</option>
                              </select>
                            </div>
                          </div> <!-- /.col -->
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn mb-2 btn-primary w-100">Enroll In Islamiyyah</button>
                      </div>
                    </form>

                  </div> <!-- .card-body -->
                </div>
              </div> <!-- .col-md-->

            </div> <!-- .row -->

          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->

      <!-- success Modal -->
      <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header justify-content-center">
              <h5 class="modal-title text-center" id="successModalTitle">Route Fare</h5>
            </div>
            <form id="proceed-new" method="POST" action="islamiyyah.php">
              <div class="modal-body">
                <p class="text-center">Below is the fare for your route configuration, please make this payment to the
                  below account to enroll <span id="student_name"></span> on school islamiyyah</p>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="bank_name">Bank Name:</label>
                      <input type="text" name="bank_name" disabled class="form-control" required value="Jaiz Bank">
                    </div>

                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="account_name">Account Name:</label>
                      <input type="text" name="account_name" disabled class="form-control" required
                        value="Grithall Academy ltd">
                    </div>
                  </div> <!-- /.col -->
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="account_number">Account Number:</label>
                      <input type="text" name="account_number" disabled class="form-control" required
                        value="0003166996">
                    </div>

                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="payment_amount">Payment Amount:</label>
                      <input type="text" disabled name="payment_amount" id="amount" class="form-control" required>
                    </div>
                  </div> <!-- /.col -->
                </div>
              </div>
              <input type="hidden" name="student_id" id="student_id" class="form-control" required>
              <input type="hidden" name="route_id" id="route_id" class="form-control" required>
              <input type="hidden" name="amount_fare" id="amount_fare" class="form-control" required>
              <div class="modal-footer">
                <button type="submit" class="btn mb-2 btn-success w-100">Click to subscribe</button>
              </div>
            </form>
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
                <img src="../assets/images/logo.jpg">
                <div class="clock">
                  <div class="hand hour"></div>
                  <div class="hand minute"></div>
                </div>
              </div>
              <strong>Processing <span class="dot-flashing"></span></strong>
            </div>
          </div>
        </div>
      </div>






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

      setTimeout(function () {
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

  <script>
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
      }, 7000);
    }


    $(document).ready(function () {
      $('#results').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Submit form data via AJAX
        $.ajax({
          url: 'subscribe-islamiyyah-proccess.php',
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


              if (response.success) {
                displayPopup(response.message, true);

                setTimeout(function () {
                  window.location.href = 'admissions.php';
                }, 500);

              } else {
                displayPopup(response.message, false);
              }
            }, 500);
          },
          error: function (xhr, status, error) {
            $('#loadingModal').modal('hide');
            displayPopup(response.message, false);
            console.error(xhr, status, error);
            // Handle errors if any
          }
        });
      });
    });
  </script>


</body>

</html>