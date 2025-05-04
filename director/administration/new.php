<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Rinda AMS | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
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

    @media print {
      table {
        /* Reset margins and padding */
        margin: 0;
        padding: 0;

        /* Adjust width if necessary */
        width: 100%;
      }
    }

    .suggestion {
      padding: 5px;
      cursor: pointer;
    }

    .suggestion:hover {
      background-color: #f0f0f0;
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
              <p style="padding: 0%; margin: 0%;">
                <?= $full_name; ?>
              </p>
              <strong>
                <?= $account_type; ?>
              </strong>
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
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
          </a>
        </div>

        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Administrative Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <!-- Account -->
          <li class="nav-item active dropdown">
            <a href="#account-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
              <i class="fe fe-dollar-sign fe-16"></i>
              <span class="ml-3 item-text">Account</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100" id="account-elements">
              <li class="nav-item">
                <a class="nav-link pl-3" href="../fees-type.php"><span class="ml-1 item-text">Fees Type</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3 text-primary" href="index.php"><span class="ml-1 item-text">Invoices</span></a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link pl-3" href="payment-history.php"><span class="ml-1 item-text">Payment
                    History</span></a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link pl-3" href="../expense.php"><span class="ml-1 item-text">Expense</span></a>
              </li>
            </ul>
          </li>

          <!-- Asset Management -->
          <li class="nav-item dropdown">
            <a href="#asset-management-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
              <i class="fe fe-box fe-16"></i>
              <span class="ml-3 item-text">Asset Management</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100" id="asset-management-elements">
              <li class="nav-item">
                <a class="nav-link pl-3" href="vendors.php"><span class="ml-1 item-text">Vendor</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="asset-category.php"><span class="ml-1 item-text">Asset
                    Category</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="assets.php"><span class="ml-1 item-text">Asset</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="assign-assets.php"><span class="ml-1 item-text">Asset
                    Assignment</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="purchase.html"><span class="ml-1 item-text">Purchase</span></a>
              </li>
            </ul>
          </li>
          <!-- Curriculum -->
          <!-- <li class="nav-item dropdown">
            <a href="#curriculum-elements" data-toggle="collapse" aria-expanded="false"
              class="dropdown-toggle nav-link">
              <i class="fe fe-book fe-16"></i>
              <span class="ml-3 item-text">Curriculum</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100" id="curriculum-elements">
              <li class="nav-item">
                <a class="nav-link pl-3" href="curriculum-type.html"><span class="ml-1 item-text">Curriculum</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="lesson-assistant.html"><span class="ml-1 item-text">Lesson
                    Assistant</span></a>
              </li>
            </ul>
          </li> -->
          <!-- Hostel -->
          <li class="nav-item dropdown">
            <a href="#hostel-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Hostel</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100" id="hostel-elements">
              <li class="nav-item">
                <a class="nav-link pl-3" href="hostel.html"><span class="ml-1 item-text">Hostel</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="room-types.html"><span class="ml-1 item-text">Room Types</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="hostel-membership.html"><span class="ml-1 item-text">Membership</span></a>
              </li>
            </ul>
          </li>

          <!-- Study materials -->
          <li class="nav-item dropdown">
            <a href="#study-materials-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
              <i class="fe fe-archive fe-16"></i>
              <span class="ml-3 item-text">Study Materials</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100" id="study-materials-elements">
              <li class="nav-item">
                <a class="nav-link pl-3" href="upload.php"><span class="ml-1 item-text">Upload Content</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="videos.php"><span class="ml-1 item-text">Videos</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="audio.php"><span class="ml-1 item-text">Audio</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="documents.php"><span class="ml-1 item-text">Documents</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="file-manager.php"><span class="ml-1 item-text">File Manager</span></a>
              </li>
            </ul>
          </li>
          <!-- Transportation -->
          <li class="nav-item dropdown">
            <a href="#transportation-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
              <i class="fe fe-truck fe-16"></i>
              <span class="ml-3 item-text">Transportation</span>
            </a>
            <ul class="collapse list-unstyled pl-4 w-100" id="transportation-elements">
              <li class="nav-item">
                <a class="nav-link pl-3" href="drivers.html"><span class="ml-1 item-text">Drivers</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="route.html"><span class="ml-1 item-text">Route</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="vehicles.html"><span class="ml-1 item-text">Vehicle</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="transport-membership.html"><span class="ml-1 item-text">Membership</span></a>
              </li>
            </ul>
          </li>
        </ul>

      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <h2 class="page-title">Generate New Invoice</h2>
            <p class="lead text-muted"></p>

            <div class="col-md-12">
              <div class="card shadow mb-4">

                <div class="card-body">
                  <div>


                  </div>
                  <form action="upload-item.php" method="POST" class=" needs-validation" id="tinydash-dropzone" novalidate>

                    <div class="input-space">

                      <!-- Section & Class -->
                      <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="validationSelect2">Section</label>
                          <select class="form-control select2" id="validationSelect2" name='section'>
                            <option value="">Select Section</option>
                            <?php
                            $query = "SELECT * FROM sections ORDER BY `sections`.`section` ASC";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($sections) === 0) {
                              echo '<p class="text-center">None added Yet!</p>';
                            } else {
                              foreach ($sections as $section) : ?>
                                <option value="<?= $section['section']; ?>"> <?= $section['section'] ?></option>
                            <?php endforeach;
                            } ?>
                          </select>
                          <div class="invalid-feedback"> Please select a section before selecting a class. </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="studentClass">Class</label>
                          <select class="form-control select2" id="studentClass" name='class' disabled>
                            <option value="">Select Class</option>
                          </select>
                          <div class="invalid-feedback"> Please select a class before selecting a student. </div>
                        </div>
                      </div>
                      <!-- /Section & Class -->

                      <div class="form-group mb-3">
                        <label for="studentName">Student Name</label>
                        <select class="form-control select2" id="studentName" name='name' disabled>
                          <option value="">Select Student</option>
                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select a valid student name. </div>
                      </div>

                      <script>
                        // Enable/disable class select based on selected section
                        document.getElementById('validationSelect2').addEventListener('change', function() {
                          var sectionValue = this.value;
                          var classSelect = document.getElementById('studentClass');
                          var studentSelect = document.getElementById('studentName');


                          studentSelect.innerHTML = '<option value="">Select Student</option>';
                          studentSelect.disabled = true;
                          document.getElementById('studentName').disabled = true;


                          if (sectionValue === '') {
                            classSelect.innerHTML = '<option value="">Select Class</option>';
                            classSelect.disabled = true;
                            document.getElementById('address-wpalaceholder').disabled = true;
                            return;
                          }

                          var xhr = new XMLHttpRequest();
                          xhr.open('GET', 'fetch_classes.php?section=' + sectionValue, true);
                          xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                              classSelect.innerHTML = xhr.responseText;
                              classSelect.disabled = false;
                            }
                          };
                          xhr.send();
                        });

                        // Enable/disable name input based on selected class
                        document.getElementById('studentClass').addEventListener('change', function() {
                          var classValue = this.value;
                          var studentSelect = document.getElementById('studentName');

                          if (classValue === '') {
                            studentSelect.innerHTML = '<option value="">Select Student</option>';
                            studentSelect.disabled = true;
                            document.getElementById('studentName').disabled = true;
                            return;
                          }

                          var xhr = new XMLHttpRequest();
                          xhr.open('GET', 'fetch_students.php?class=' + classValue, true);
                          xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                              studentSelect.innerHTML = xhr.responseText;
                              studentSelect.disabled = false;
                            }
                          };
                          xhr.send();
                        });
                      </script>

                      <!-- /Section & Class & Name-->




                      <!-- Start Date & Due Date -->
                      <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="validationSelect2">Start Date</label>
                          <input class="form-control" type="date" name="" id="">
                          <div class="invalid-feedback"> Please select a section before selecting a class. </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="validationSelect2">Deadline</label>
                          <input class="form-control" type="date" name="" id="">
                          <div class="invalid-feedback"> Please select a section before selecting a class. </div>
                        </div>
                      </div>
                      <!-- /Start Date & Due Date -->



                      <!-- Type & Folder-->
                      <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="validationSelect27">Type</label>
                          <select class="form-control select2" id="validationSelect27" required name='folder'>
                            <option value="">Select Type</option>
                            <?php
                            $upload_status = 'allowed';
                            $query = "SELECT * FROM upload_type WHERE `status` = :status ORDER BY `upload_type`.`type` ASC";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':status', $upload_status, PDO::PARAM_STR);
                            $stmt->execute();
                            $upload_status = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($upload_status) === 0) {
                              echo '<p class="text-center">No class added Yet!</p>';
                            } else {
                              foreach ($upload_status as $type) : ?>
                                <option value="<?= $type['type']; ?>"> <?= $type['type'] ?></option>
                            <?php endforeach;
                            } ?>
                          </select>
                          <div class="invalid-feedback"> Please select a class. </div>
                        </div>






                        <div class="col-md-6 mb-3">
                          <label for="validationSelect28">Folder</label>


                          <select class="form-control select2" id="validationSelect28" required name='folder'>
                            <option value="">Select Folder</option>
                            <?php
                            $public = 'public';
                            $permission = 2;
                            $user = 'User A';

                            $query = "SELECT * FROM folders WHERE `status` = :public AND `permission` = :permission OR `added_by` = :user ORDER BY `name` ASC";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute(['public' => $public, 'permission' => $permission, 'user' => $user]);
                            $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($folders) === 0) {
                              echo '<p class="text-center">No class added Yet!</p>';
                            } else {
                              foreach ($folders as $folder) : ?>
                                <option value="<?= $folder['name']; ?>"> <?= $folder['name'] ?></option>
                            <?php endforeach;
                            } ?>
                          </select>
                          <div class="invalid-feedback"> Please select a folder. </div>
                        </div>
                      </div>
                      <!-- /.form-row -->

                      <div class="mb-3">
                        <p class="mb-2">Permission</p>
                        <div class="form-row">
                          <div class="col-md-6">
                            <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="customControlValidation23" name="permission" checked required value='1'>
                              <label class="custom-control-label" for="customControlValidation223">Private</label>
                              <p class="text-muted"> Only I & management will be able to see this. </p>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                              <input type="radio" class="custom-control-input" id="customControlValidation34" name="permission" required value='2'>
                              <label class="custom-control-label" for="customControlValidation34">Public</label>
                              <p class="text-muted"> Others will be able to see this.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="col-md-4">
                          <div class="form-group mb-3">
                            <p class="mb-3">Available To Teachers</p>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" checked class="custom-control-input" id="customSwitch1" name='students'>
                              <label class="custom-control-label" for="customSwitch1">Yes</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group mb-3">
                            <p class="mb-3">Available To Parents</p>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="customSwitch2" name='students'>
                              <label class="custom-control-label" for="customSwitch2">Yes</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group mb-3">
                            <p class="mb-3">Available To Students</p>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="customSwitch3" name='students'>
                              <label class="custom-control-label" for="customSwitch3">Yes</label>
                            </div>
                          </div>
                        </div>
                      </div>


                      <!-- upload area -->
                      <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" required name="file">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback">Please select what to upload</div>
                      </div>


                      <button class="btn btn-primary" style="margin-top: 15px; width: 100%;" type="submit">Submit
                        Upload</button>

                  </form>
                  <!-- Preview -->
                  <!-- <div class="dropzone-previews mt-3" id="file-previews"></div> -->
                  <!-- file preview template -->
                  <div class="d-none" id="uploadPreviewTemplate">
                    <div class="card mt-1 mb-0 shadow-none border">
                      <div class="p-2">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                          </div>
                          <div class="col pl-0">
                            <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                            <p class="mb-0" data-dz-size></p>
                          </div>
                          <div class="col-auto">
                            <!-- Button -->
                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                              <i class="dripicons-cross"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> <!-- .card-body -->
              </div> <!-- .card -->
            </div> <!-- .col -->
          </div>
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
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Dashboard</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
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
                  <a href="../hr/" style="text-decoration: none;">
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
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Assessments</p>
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

  <script>
    function printDiv(divId) {
      var content = document.getElementById(divId).innerHTML;
      var printWindow = window.open('', '_blank');
      printWindow.document.open();
      printWindow.document.write('<html><head><title>Print</title></head><body>' + content + '</body></html>');
      printWindow.document.close();
      printWindow.print();
    }
  </script>
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