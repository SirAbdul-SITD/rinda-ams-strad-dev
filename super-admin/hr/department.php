<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Departments - Staffs | Rinda AMS</title>
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
          <span>Staffs</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="staff.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Staffs Directory</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link text-primary" href="department.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Department</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="designation.php">
              <i class="fe fe-book fe-16"></i>
              <span class="ml-3 item-text">Designation</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="attendance.php">
              <i class="fe fe-calendar fe-16"></i>
              <span class="ml-3 item-text">Attendance</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="penalties.php">
              <i class="fe fe-alert-triangle fe-16"></i>
              <span class="ml-3 item-text">Penalties</span>
            </a>
          </li>

          <!-- Leave -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Leave</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="leave-application.php">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">Leave Application</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="leave-category.php">
                <i class="fe fe-copy fe-16"></i>
                <span class="ml-3 item-text">Leave Category</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="approved-leave.php">
                <i class="fe fe-server fe-16"></i>
                <span class="ml-3 item-text">Approved Leave</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pending-leave.php">
                <i class="fe fe-fast-forward fe-16"></i>
                <span class="ml-3 item-text">Pending Requests</span>
                </i>
              </a>
            </li>
          </ul>

          <!-- Extras -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extras</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">Attendance</span>
                </i>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="message.php">
                <i class="fe fe-copy fe-16"></i>
                <span class="ml-3 item-text">Message</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="payroll.php">
                <i class="fe fe-dollar-sign fe-16"></i>
                <span class="ml-3 item-text">Payroll</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-fast-forward fe-16"></i>
                <span class="ml-3 item-text">Penalties</span>
                </i>
              </a>
            </li> -->
          </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row">
              <!-- Small table -->
              <div class="col-md-12 my-4">
                <div class="row align-items-center my-3">
                  <div class="col">
                    <h2 class="page-title">Departments</h2>
                  </div>
                  <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModel"><span class="fe fe-plus fe-16 mr-3"></span>New</button>
                  </div>
                </div>
                <div class="card shadow">
                  <div class="card-body">
                    <div class="toolbar">
                      <form class="form">
                        <div class="form-row">
                          <div class="form-group col-auto mr-auto">
                            <label class="my-1 mr-2 sr-only" for="inlineFormCustomSelectPref1">Show</label>
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelectPref1">
                              <option value="">...</option>
                              <option value="1">12</option>
                              <option value="2" selected>32</option>
                              <option value="3">64</option>
                              <option value="3">128</option>
                            </select>
                          </div>
                          <div class="form-group col-auto">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" class="form-control" id="search1" value="" placeholder="Search">
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- table -->
                    <?php
                    // Query to select all departments
                    $query = "SELECT * FROM departments";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($departments) === 0) {
                      echo '<div class="text-center">None Added Yet!</div>';
                    } else {
                    ?>
                      <table class="table table-borderless table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($departments as $index => $department) : ?>
                            <tr>
                              <td>
                                <?= $index + 1 ?>
                              </td>
                              <td>
                                <p class="mb-0 text-muted">
                                  <strong class="mb-0 text-muted department-name" data-department-id="<?= $department['id'] ?>">
                                    <?= $department['department'] ?>
                                  </strong>
                                  <input type="hidden" class="department-id" value="<?= $department['id'] ?>">
                                </p>
                              </td>
                              <td>
                                <button class="btn btn-sm btn-primary edit-button" type="button"><i class="fe fe-edit"></i>
                                  Edit</button>
                                <button class="btn btn-sm btn-danger remove-button" type="button"><i class="fe fe-trash"></i>
                                  Remove</button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>

                      </table>

                    <?php } ?>
                  </div>
                </div>
              </div> <!-- customized table -->
            </div> <!-- end section -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->


      <!-- new Department-->
      <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModelLabel">Add Department</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="newForm">
                <div class="form-group">
                  <label for="department-name" class="col-form-label">Department Name:</label>
                  <input type="text" class="form-control" id="department-name" required>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-primary w-100" id="DepartmentSaveBtn">Add New
                Department</button>
            </div>
          </div>
        </div>
      </div>


      <!-- RemoveConfirmModal -->
      <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this department?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger confirm-remove">Remove</button>
            </div>
          </div>
        </div>
      </div>


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
                      <span class="fe fe-bell-off fe-24"></span>
                    </div>
                    <div class="col">
                      <small><strong>No notifications</strong></small>

                    </div>
                  </div>
                </div>
              </div> <!-- / .list-group -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
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
                    <div class="squircle bg-success justify-content-center text-white">
                      <i class="fe fe-users fe-32 align-self-center"></i>
                    </div>
                    <p class="text-success">HR</p>
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

      setTimeout(function() {
        popup.remove();
      }, 5000);
    }



    $(document).ready(function() {



      // Event listener for saving changes
      $('#DepartmentSaveBtn').on('click', function() {
        var newTitle = $('#department-name').val();

        // Perform AJAX request to update department information in the database
        $.ajax({
          url: 'add-department.php',
          type: 'POST',
          data: {
            name: newTitle,
          },
          success: function(response) {
            // Parse the JSON response
            var responseData = JSON.parse(response);
            displayPopup(responseData.message, responseData.success);
            if (responseData.success == true) {
              $('#newModal').modal('hide');
              setTimeout(function() {
                location.reload();
              }, 2000);
            }
          },
          error: function(xhr, status, error) {
            // Display error message
            displayPopup(xhr.responseText, false);
            console.error(xhr.responseText);
          }
        });
      });
    });




    function toggleEdit(element) {
      var departmentRow = $(element).closest('tr');
      var departmentName = departmentRow.find('.department-name');
      var editButton = departmentRow.find('.edit-button');
      var id = departmentRow.find('.department-id');

      if (departmentName.is('input')) {
        // Save changes
        var departmentId = id.val();
        var newValue = departmentName.val();
        $.ajax({
          url: 'update-department.php',
          type: 'POST',
          data: {
            id: departmentId,
            name: newValue
          },
          success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.success) {
              displayPopup(responseData.message, responseData.success);
              departmentName.replaceWith('<strong class="mb-0 text-muted department-name" data-department-id="' + departmentId + '">' + newValue + '</strong>');
              editButton.html('<i class="fe fe-edit"></i> Edit');
            } else {
              displayPopup(responseData.message, responseData.success);
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            displayPopup('An error occurred while updating the department.', false);
          }
        });
      } else {
        // Enable editing
        var currentValue = departmentName.text().trim();
        departmentName.replaceWith('<input type="text" class="form-control department-name" value="' + currentValue + '">');
        editButton.html('<i class="fe fe-save"></i> Save');
      }
    }

    // Event listener for Edit/Save button
    $(document).on('click', '.edit-button', function() {
      toggleEdit(this);
    });



    function removeDepartment(element) {
      var departmentRow = $(element).closest('tr');
      var departmentName = departmentRow.find('.department-name');
      var editButton = departmentRow.find('.remove-button');
      var id = departmentRow.find('.department-id').val(); // Accessing the value of the department ID

      // Show confirmation modal
      $('#confirmationModal').modal('show');

      // Add click event listener to the confirmation button
      $('.confirm-remove').off('click').on('click', function() {
        // Send AJAX request to remove the department
        $.ajax({
          type: 'POST',
          url: 'remove-department.php',
          data: {
            id: id
          }, // Pass the department ID
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Remove the row from the table
              departmentRow.remove();
              displayPopup(response.message, true);
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function(xhr, status, error) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });

        // Hide the modal after action
        $('#confirmationModal').modal('hide');
      });
    };

    // Event listener for Edit/Save button
    $(document).on('click', '.remove-button', function() {
      removeDepartment(this);
    });
  </script>





</body>

</html>