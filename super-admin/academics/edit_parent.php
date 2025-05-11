<?php require('../settings.php');

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Edit Parent | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <!-- Include Dropzone.js library -->

  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/select2.css">
  <link rel="stylesheet" href="../css/dropzone.css">
  <link rel="stylesheet" href="../css/uppy.min.css">
  <link rel="stylesheet" href="../css/jquery.steps.css">
  <link rel="stylesheet" href="../css/jquery.timepicker.css">
  <link rel="stylesheet" href="../css/quill.snow.css">
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
              <img src="../assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <div class=" col-12 text-left">
              <p style="padding: 0%; margin: 0%;"><?= $full_name; ?></p>
              <strong><?= $account_type; ?></strong>
            </div>
            <hr width="80%">
            <a class="dropdown-item text-muted" href="#">Profile</a>
            <a class="dropdown-item text-muted" href="#">Settings</a>
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="students.php">
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
              <a class="nav-link" href="parents.php">
                <i class="fe fe-zoom-in fe-16"></i>
                <span class="ml-3 item-text">Manage Parents</span>
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
          <div class="col-12 col-lg-10">
            <h3 class="page-title">Edit Parent</h3>
            <div class="card my-4">
              <div class="card-header">

              </div>
              <div class="card-body">
                <form id="example-form" action="parent-dump.php" method="POST">
                  <div id="wizard">


                    <h3>Personal Info</h3>
                    <section>

                      <div id="fatherInfo" class="parent-info" style="display: block;">
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="firstName">First Name *</label>
                              <input id="firstName" name="firstName" type="text" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="lastName">Last Name *</label>
                              <input id="lastName" name="lastName" type="text" class="form-control required">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <!-- Email and Phone Number -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input id="email" name="email" type="email" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phoneNumber">Phone Number *</label>
                              <input id="phoneNumber" name="phoneNumber" type="tel" class="form-control required">
                            </div>
                          </div>
                        </div>
                      </div>




                      <div class="help-text text-muted">(*) Mandatory</div>
                    </section>


                    <h3>Address</h3>
                    <section>

                      <div id="motherInfo" class="parent-info">
                        <h5>Mother's Info</h5>


                        <div class="row">
                          <!-- Address and City -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="address">Address *</label>
                              <input id="address" name="address" type="text" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="country">Country *</label>
                              <select id="country" name="country" class="form-control required">
                                <option value="nigeria" selected>Nigerian</option>
                                <!-- <option value="other">Other</option> -->
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- State and Country -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="state">State *</label>
                              <select id="state" name="state" class="form-control required">
                                <option value="">Select State</option>
                                <option value="FCT">FCT</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa Ibom">Akwa Ibom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nasarawa">Nasarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                              </select>

                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="city">City *</label>
                              <select id="city" name="city" class="form-control required">
                                <option value="">Select City</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="help-text text-muted">(*) Mandatory</div>
                    </section>




                    <h3>Extras</h3>
                    <section>

                      <div id="guardianInfo" class="parent-info">

                        <div class="row">
                          <!-- Occupation and Photo -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="occupation">Occupation</label>
                              <input id="occupation" name="occupation" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="photo">Photo</label>
                              <div class="custom-file mb-3">
                                <label class="custom-file-label" for="photo">Choose Photo...</label>
                                <input type="file" class="custom-file-input" id="photo" name="photo">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="help-text text-muted">(*) Mandatory</div>
                    </section>




                    <h3>Finish</h3>
                    <section>

                      <p>Kindly review and confirm the accuracy of the provided information, ensuring it is free from
                        errors. Select "Finish" to proceed with adding a new student or "Previous" to review the input.
                      </p>

                      <!-- <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label
                        for="acceptTerms">Information is accurate.</label> -->
                    </section>




                  </div>
                </form>
              </div> <!-- .card-body -->
            </div> <!-- .card -->
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
  <script src="../js/apexcharts.custom.js"></script>
  <script src='../js/jquery.mask.min.js'></script>
  <script src='../js/select2.min.js'></script>
  <!-- <script src='../js/jquery.step.min.js'></script> -->
  <script src='../js/jquery.validate.min.js'></script>
  <script src='../js/jquery.timepicker.js'></script>
  <script src='../js/dropzone.min.js'></script>
  <script src='../js/uppy.min.js'></script>
  <script src='../js/quill.min.js'></script>
  <script>
    function toggleParentInfo(type) {
      var parentInfo = document.getElementById(type + 'Info');
      var checkbox = document.getElementById('customSwitch' + (type === 'father' ? 1 : (type === 'mother' ? 2 : 3)));
      var label = document.getElementById(type + 'Label');

      if (checkbox.checked) {
        // Add animation to slide down the parent info section
        $(parentInfo).slideDown();
        label.innerText = 'No';
      } else {
        // Add animation to slide up the parent info section
        $(parentInfo).slideUp();
        label.innerText = 'Yes';
      }
    }

    function toggleClassInfo(type) {
      var classInfo = document.getElementById(type + 'Info');
      var checkbox = document.getElementById('customSwitch4');
      var label = document.getElementById(type + 'Label');

      if (checkbox.checked) {
        // Add animation to slide down the parent info section
        $(classInfo).slideDown();
        label.innerText = 'No';
      } else {
        // Add animation to slide up the parent info section
        $(classInfo).slideUp();
        label.innerText = 'Yes';
      }
    }
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




  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
  <script>
    $(document).ready(function () {
      // Define citiesByState object
      const citiesByState = {
        "FCT": [
          "Abuja",
          "Gwagwalada",
          "Kuje",
          "Abaji",
          "Bwari",
          "Kwali"
        ],
        "Abia": [
          "Aba",
          "Umuahia",
          "Arochukwu",
          "Ohafia",
          "Bende",
          "Isuikwuato",
          "Umunneochi",
          "Ikwuano",
          "Ukwa West",
          "Ukwa East",
          "Obingwa",
          "Osisioma",
          "Isiala Ngwa North",
          "Isiala Ngwa South",
          "Ugwunagbo",
          "Ukwa East"
        ],
        "Adamawa": [
          "Yola",
          "Jimeta",
          "Mubi",
          "Ganye",
          "Hong",
          "Gombi",
          "Numan",
          "Michika",
          "Madagali",
          "Song",
          "Toungo",
          "Mayo-Belwa",
          "Fufure",
          "Demsa",
          "Jada",
          "Guyuk",
          "Fufore"
        ],
        "Akwa Ibom": [
          "Uyo",
          "Eket",
          "Ikot Ekpene",
          "Oron",
          "Ikot Abasi",
          "Etinan",
          "Abak",
          "Ibiono Ibom",
          "Itu",
          "Ika",
          "Uruan",
          "Ibesikpo Asutan",
          "Obot Akara",
          "Ikono",
          "Essien Udim",
          "Nsit Atai",
          "Nsit Ubium",
          "Ini",
          "Ukanafun",
          "Ikot Okpora"
        ],
        "Anambra": [
          "Awka",
          "Onitsha",
          "Nnewi",
          "Aguata",
          "Njikoka",
          "Idemili North",
          "Anaocha",
          "Dunukofia",
          "Idemili South",
          "Oyi",
          "Orumba North",
          "Orumba South",
          "Ekwusigo",
          "Ogbaru",
          "Anambra East",
          "Anambra West",
          "Ayamelum"
        ],
        "Bauchi": [
          "Bauchi",
          "Azare",
          "Misau",
          "Jama'are",
          "Katagum",
          "Tafawa Balewa",
          "Dass",
          "Ganjuwa",
          "Ningi",
          "Zaki",
          "Itas/Gadau",
          "Toro",
          "Alkaleri",
          "Darazo",
          "Giade",
          "Warji",
          "Damban",
          "Kirfi",
          "Bogoro",
          "Shira"
        ],
        "Bayelsa": [
          "Yenagoa",
          "Brass",
          "Sagbama",
          "Ogbia",
          "Nembe",
          "Ekeremor",
          "Kolokuma/Opokuma",
          "Southern Ijaw",
          "Brass",
          "Yenagoa",
          "Ekeremor",
          "Sagbama"
        ],
        "Benue": [
          "Makurdi",
          "Gboko",
          "Otukpo",
          "Katsina-Ala",
          "Ukum",
          "Vandeikya",
          "Gwer East",
          "Buruku",
          "Logo",
          "Kwande",
          "Agatu",
          "Guma",
          "Gwer West",
          "Tarka",
          "Oju",
          "Oturkpo",
          "Obi",
          "Konshisha",
          "Ado"
        ],
        "Borno": [
          "Maiduguri",
          "Jere",
          "Marte",
          "Gwoza",
          "Monguno",
          "Damboa",
          "Konduga",
          "Askira/Uba",
          "Bama",
          "Ngala",
          "Kaga",
          "Abadam",
          "Nganzai",
          "Magumeri",
          "Kukawa",
          "Guzamala",
          "Mobbar"
        ],
        "Cross River": [
          "Calabar",
          "Akamkpa",
          "Ikom",
          "Obudu",
          "Ogoja",
          "Obanliku",
          "Bekwarra",
          "Yala",
          "Boki",
          "Biase",
          "Abi",
          "Etung",
          "Bakassi",
          "Yakurr",
          "Ugep",
          "Okpoma"
        ],
        "Delta": [
          "Asaba",
          "Warri",
          "Ughelli",
          "Sapele",
          "Ozoro",
          "Agbor",
          "Effurun",
          "Koko",
          "Issele-Uku",
          "Abraka",
          "Ogwashi-Uku",
          "Uvwie",
          "Orerokpe",
          "Oleh",
          "Owa-Oyibu",
          "Otor-Owhe",
          "Patani",
          "Ughoton"
        ],
        "Ebonyi": [
          "Abakaliki",
          "Afikpo",
          "Onueke",
          "Izzi",
          "Ezza",
          "Ishielu",
          "Ohaukwu",
          "Onicha",
          "Ikwo",
          "Afikpo",
          "Ezzamgbo",
          "Ezza",
          "Onicha"
        ],
        "Edo": [
          "Benin City",
          "Auchi",
          "Uromi",
          "Ikpoba-Okha",
          "Igarra",
          "Ekpoma",
          "Sabongida-Ora",
          "Igueben",
          "Ubiaja",
          "Auchi",
          "Igueben",
          "Ekpoma",
          "Uromi",
          "Auchi"
        ],
        "Ekiti": [
          "Ado Ekiti",
          "Ikere Ekiti",
          "Ikole Ekiti",
          "Araromi Oke",
          "Omuo Ekiti",
          "Ijero Ekiti",
          "Ode Ekiti",
          "Ipoti Ekiti",
          "Igede Ekiti",
          "Emure Ekiti",
          "Oye Ekiti",
          "Ido Ekiti",
          "Ilawe Ekiti",
          "Ise Ekiti",
          "Ikun Ekiti",
          "Iloro Ekiti"
        ],
        "Enugu": [
          "Enugu",
          "Nsukka",
          "Agbani",
          "Awgu",
          "Udi",
          "Oji River",
          "Nsukka",
          "Enugu Ezike",
          "Nsukka",
          "Enugu Ngwo",
          "Ozalla"
        ],
        "Gombe": [
          "Gombe",
          "Kaltungo",
          "Billiri",
          "Dukku",
          "Balanga",
          "Nafada",
          "Deba",
          "Bajoga",
          "Dadin Kowa",
          "Duku",
          "Tumu",
          "Bogoro"
        ],
        "Imo": [
          "Owerri",
          "Okigwe",
          "Orlu",
          "Mbaise",
          "Oguta",
          "Orlu",
          "Nkwerre",
          "Aboh Mbaise",
          "Owerri West",
          "Isu",
          "Ngor Okpala",
          "Obowo",
          "Owerri North",
          "Ikeduru",
          "Ohaji/Egbema"
        ],
        "Jigawa": [
          "Dutse",
          "Birnin Kudu",
          "Hadejia",
          "Kazaure",
          "Gumel",
          "Kiyawa",
          "Gwaram",
          "Ringim",
          "Babura",
          "Kaugama",
          "Maigatari",
          "Gagarawa"
        ],
        "Kaduna": [
          "Kaduna",
          "Zaria",
          "Kafanchan",
          "Soba",
          "Jere",
          "Kaura",
          "Zangon Kataf",
          "Kagarko",
          "Sabon Gari",
          "Ikara",
          "Makarfi",
          "Kudan",
          "Giwa"
        ],
        "Kano": [
          "Kano",
          "Gwale",
          "Fagge",
          "Dala",
          "Nassarawa",
          "Tarauni",
          "Kumbotso",
          "Ungogo",
          "Dawakin Kudu",
          "Kura",
          "Madobi",
          "Garko",
          "Rano"
        ],
        "Katsina": [
          "Katsina",
          "Daura",
          "Funtua",
          "Malumfashi",
          "Kankia",
          "Mani",
          "Dutsin Ma",
          "Batsari",
          "Safana",
          "Danja",
          "Kafur",
          "Charanchi"
        ],
        "Kebbi": [
          "Birnin Kebbi",
          "Yauri",
          "Argungu",
          "Zuru",
          "Jega",
          "Dandi",
          "Aleiro",
          "Bunza",
          "Wasagu",
          "Augie",
          "Maiyama",
          "Bagudo"
        ],
        "Kogi": [
          "Lokoja",
          "Okene",
          "Anyigba",
          "Idah",
          "Ankpa",
          "Ogaminana",
          "Kabba",
          "Ejule",
          "Ochadamu",
          "Isanlu",
          "Idah",
          "Ajaokuta",
          "Ibaji",
          "Igalamela-Odolu",
          "Dekina",
          "Ankpa",
          "Olamaboro"
        ],
        "Kwara": [
          "Ilorin",
          "Offa",
          "Omu Aran",
          "Lafiagi",
          "Kaiama",
          "Jebba",
          "Pategi",
          "Ilorin",
          "Eruwa",
          "Bode Saadu",
          "Oke-Onigbin",
          "Owode"
        ],
        "Lagos": [
          "Lagos",
          "Ikeja",
          "Lekki",
          "Victoria Island",
          "Epe",
          "Badagry",
          "Ikorodu",
          "Ajah",
          "Surulere",
          "Apapa",
          "Mushin",
          "Yaba",
          "Ketu",
          "Agege",
          "Iyana Ipaja",
          "Maryland"
        ],
        "Nasarawa": [
          "Lafia",
          "Keffi",
          "Akwanga",
          "Nasarawa",
          "Karu",
          "Toto",
          "Wamba",
          "Nasarawa Eggon",
          "Obi",
          "Kokona",
          "Awe"
        ],
        "Niger": [
          "Minna",
          "Bida",
          "Suleja",
          "Kontagora",
          "Lapai",
          "New Bussa",
          "Wushishi",
          "Agwara",
          "Kagara",
          "Rijau",
          "Mokwa"
        ],
        "Ogun": [
          "Abeokuta",
          "Sagamu",
          "Ijebu Ode",
          "Ilaro",
          "Ota",
          "Ijebu Igbo",
          "Ifo",
          "Shagamu",
          "Ipokia",
          "Owode",
          "Odeda",
          "Idiroko"
        ],
        "Ondo": [
          "Akure",
          "Ondo",
          "Owo",
          "Ile-Oluji",
          "Igbara-Oke",
          "Irele",
          "Okitipupa",
          "Igbokoda",
          "Idanre",
          "Ikare",
          "Igbara-Oke",
          "Odigbo"
        ],
        "Osun": [
          "Osogbo",
          "Ilesa",
          "Ife",
          "Iwo",
          "Ejigbo",
          "Ikirun",
          "Ila Orangun",
          "Ijebu Jesa",
          "Ede",
          "Ilobu",
          "Oke Ila",
          "Igbona"
        ],
        "Oyo": [
          "Ibadan",
          "Ogbomoso",
          "Iseyin",
          "Saki",
          "Oyo",
          "Okeho",
          "Igboho",
          "Igbo-Ora",
          "Igboora",
          "Eruwa",
          "Ago-Are",
          "Oyo",
          "Ibarapa"
        ],
        "Plateau": [
          "Jos",
          "Bukuru",
          "Pankshin",
          "Shendam",
          "Langtang",
          "Mangu",
          "Barkin Ladi",
          "Riyom",
          "Wase",
          "Bassa",
          "Qua'an Pan"
        ],
        "Rivers": [
          "Port Harcourt",
          "Obio-Akpor",
          "Bonny",
          "Degema",
          "Eleme",
          "Opobo",
          "Okrika",
          "Oyigbo",
          "Ahoada",
          "Ogu-Bolo",
          "Andoni",
          "Ikwerre",
          "Emuoha"
        ],
        "Sokoto": [
          "Sokoto",
          "Tambuwal",
          "Goronyo",
          "Kware",
          "Wurno",
          "Isa",
          "Gada",
          "Bodinga",
          "Gwadabawa",
          "Dange-Shuni",
          "Rabah"
        ],
        "Taraba": [
          "Jalingo",
          "Wukari",
          "Bali",
          "Takum",
          "Zing",
          "Gashaka",
          "Kurmi",
          "Gassol",
          "Ibi",
          "Donga"
        ],
        "Yobe": [
          "Damaturu",
          "Nguru",
          "Potiskum",
          "Gashua",
          "Buni Yadi",
          "Geidam",
          "Yusufari",
          "Fika",
          "Nangere",
          "Bade",
          "Bursari"
        ],
        "Zamfara": [
          "Gusau",
          "Tsafe",
          "Talata Mafara",
          "Anka",
          "Kaura Namoda",
          "Maru",
          "Bakura",
          "Gummi",
          "Shinkafi",
          "Bungudu",
          "Maradun",
          "Zurmi"
        ],
        // Add cities for other states here
      };

      //Function to display a popup message
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
        }, 5000);
      }



      // Function to populate city dropdown based on selected state
      function populateCities(stateSelect, citySelect) {
        const selectedState = stateSelect.value;
        console.log('Selected State:', selectedState);
        // Clear previous options
        citySelect.innerHTML = "<option value=''>Select City</option>";
        // Populate with cities based on selected state
        if (selectedState && citiesByState[selectedState]) {
          citiesByState[selectedState].forEach(city => {
            const option = document.createElement("option");
            option.text = city;
            option.value = city;
            citySelect.appendChild(option);
          });
        }
      }
      // Initialize wizard after event listener
      $("#wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
          form.validate().settings.ignore = ":disabled,:hidden";
          return form.valid();
        },
        onFinishing: function (event, currentIndex) {
          form.validate().ignore;
          return form.valid();
        },
        onFinished: function (event, currentIndex) {
          console.log('printed');
          // Submit the form via AJAX
          $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            // beforeSend: function () {
            // $('#warningModel').modal('hide');
            // },
            success: function (response) {
              // Handle success response
              displayPopup(response.message, response.success);
              console.log(response);
            },
            error: function (xhr, status, error) {
              // Handle error
              console.error(xhr.responseText);
            }
          });
        }
      });

      // Event listener for student state dropdown change
      $('#state').on('change', function () {
        populateCities(this, document.getElementById("city"));
      });

      // Initially populate cities based on default state selection
      populateCities(document.getElementById("state"), document.getElementById("city"));
    });
  </script>
</body>

</html>