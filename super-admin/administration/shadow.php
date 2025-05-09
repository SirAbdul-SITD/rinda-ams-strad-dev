<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Shadow Categories | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <!-- Date Range Picker CSS -->
  <!-- jquery -->
  <script src="jquery-3.6.0.min.js"></script>

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

        <!-- Dashboard -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">General Fees</span>
              </i>
            </a>
          </li>



          <li class="nav-item">
            <a class="nav-link" href="invoices.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Student Invoices</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="expenses.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">School Expenses</span>
              </i>
            </a>
          </li>

          <!-- Subscriptions Types -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Subscriptions</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item">
              <a class="nav-link" href="breakfast.php">
                <i class="fe fe-coffee fe-16"></i>
                <span class="ml-3 item-text">Breakfast</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="lunch.php">
                <i class="fe fe-slack fe-16"></i>
                <span class="ml-3 item-text">Lunch</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shuttle.php">
                <i class="fe fe-truck fe-16"></i>
                <span class="ml-3 item-text">Shuttle</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="iep.php">
                <i class="fe fe-briefcase fe-16"></i>
                <span class="ml-3 item-text">IEP</span>
                </i>
              </a>
            </li>

            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
                <i class="fe fe-award fe-16"></i>
                <span class="ml-3 item-text">Shadow</span>
                </i>
              </a>
            </li>

          </ul>

          <!-- Hostel -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Hostel</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Hostels</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Room Types</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Membership</span>
                </i>
              </a>
            </li>


          </ul>

          <!-- Extra -->

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
                    <h3 class="page-title">Shadow Categories</h3>
                  </div>
                  <div class="col-auto">
                    <a href="shadow-membership.php">
                      <button type="button" class="btn btn-primary"><span class="fe fe-plus fe-16 mr-3"></span>View
                        Subscribers</button></a>
                  </div>
                </div>
                <div class="row">
                  <!-- Striped rows -->
                  <div class="col-md-12 my-4">
                    <div class="card shadow">
                      <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="dataTable-1">
                          <thead>
                            <tr>

                              <th>#</th>
                              <th>Category</th>
                              <th>Amount</th>
                              <th>Duration</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            $query = "SELECT * FROM `shadow_fees` ORDER BY `shadow_fees`.`id` ASC";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            $fees_type = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($fees_type) === 0) {
                              echo '<p class="text-center">None added Yet!</p>';
                            } else {
                              foreach ($fees_type as $index => $shadow): ?>
                                    <tr>

                                      <td>
                                        <input type="hidden" value="<?= $shadow['id']; ?>" class="edit-shadow-id" ?>
                                        <input type="hidden" value="<?= $shadow['amount']; ?>" class="edit-shadow-amount" ?>
                                        <input type="hidden" value="<?= $shadow['category']; ?>" class="edit-shadow-category" ?>
                                        <input type="hidden" value="<?= $shadow['duration']; ?>" class="edit-shadow-duration" ?>

                                        <?= $index + 1 ?>
                                      </td>
                                      <td>
                                        <p class="mb-0 text-muted"><strong>
                                            <?= $shadow['category'] ?>
                                          </strong></p>
                                      </td>
                                      <td>
                                        <p class="mb-0 text-muted">
                                          <?php $formatted_amount = '₦ ' . number_format($shadow['amount'], 2);
                                          echo $formatted_amount;
                                          ?>
                                        </p>
                                      </td>

                                      <td>
                                        <p class="mb-0 text-muted">
                                          <?= $shadow['duration'] ?>
                                        </p>
                                      </td>
                                      <td>
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item edit">Edit</a>
                                          <a class="dropdown-item remove">Delete</a>
                                        </div>
                                      </td>
                                    </tr>
                                <?php endforeach;
                            } ?>

                          </tbody>

                        </table>
                      </div>
                    </div>
                  </div> <!-- customized table -->
                </div> <!-- end section -->
              </div> <!-- .col-12 -->
            </div> <!-- .row -->
          </div> <!-- .container-fluid -->



          <!-- edit Modal-->
          <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="editForm">

                    <div class="form-group">
                      <label for="edit-shadow-category" class="col-form-label">IEP Category:</label>
                      <input type="text" class="form-control" name="edit-shadow-category" id="edit-shadow-category">
                    </div>

                    <div class="form-group">
                      <label for="edit-shadow-amount" class="col-form-label">Amount:</label>
                      <input type="number" class="form-control" name="edit-shadow-amount" id="edit-shadow-amount">
                    </div>

                    <div class="form-group">
                      <label for="edit-shadow-duration" class="col-form-label">Duration:</label>
                      <select class="form-control" name="edit-shadow-duration" id="edit-shadow-duration" required>
                        <option value='Term'>Term</option>
                        <option value='Whole Session'>Whole Session</option>
                      </select>
                    </div>

                    <input type="hidden" name="edit-shadow-id" id="edit-shadow-id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn mb-2 btn-primary w-100" id="saveChangesBtn">Save
                    Changes</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end edit -->



          <!-- new Modal-->
          <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="newModalLabel">Add New</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="form-group">
                    <label for="category" class="col-form-label">Category</label>
                    <input type="text" class="form-control" name="category" required>
                  </div>


                  <div class="form-group">
                    <label for="amount" class="col-form-label">Amount:</label>
                    <input type="number" class="form-control" name="amount" required>
                  </div>


                  <div class="form-group">
                    <label for="duration" class="col-form-label">Duration:</label>
                    <select id="duration" class="form-control" name="duration" required>
                      <option value='Term'>Term</option>
                      <option value='Whole Session'>Whole Session</option>
                    </select>
                  </div>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn mb-2 btn-primary w-100" id="saveBtn">Add
                    New</button>
                </div>
              </div>
            </div>
          </div>

          <!-- end new -->


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
                  Are you sure you want to delete this fee?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-danger confirm-remove">Delete</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog"
            aria-labelledby="defaultModalLabel" aria-hidden="true">
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
                <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-block"
                    data-dismiss="modal" disabled>Clear All</button> </div>
              </div>
            </div>
          </div>
          <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog"
            aria-labelledby="defaultModalLabel" aria-hidden="true">
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
                      <!-- <a href="#" style="text-decoration: none;"> -->
                      <div class="squircle bg-success justify-content-center">
                        <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                      </div>
                      <p class="text-success">Dashboard</p>
                      <!-- </a> -->
                    </div>
                    <div class="col-6 text-center con-item">
                      <a href="../academics/" style="text-decoration: none;">
                        <div class="squircle bg-secondary justify-content-center">
                          <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                        </div>
                        <p class="text-secondary control-panel-text">Academics</p>
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

  <!-- edit fee -->
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

    $(document).ready(function () {
      // Event listener for the edit option
      $('.table').on('click', '.dropdown-item.edit', function () {
        // $('').on('click'

        var row = $(this).closest('tr');
        var feeId = row.find('.edit-shadow-id').val();
        var feeName = row.find('.edit-shadow-amount').val();
        var first_term = row.find('.edit-shadow-category').val();
        var second_term = row.find('.edit-shadow-duration').val();


        // Update form fields with retrieved data
        $('#edit-shadow-id').val(feeId);
        $('#edit-shadow-amount').val(feeName);
        $('#edit-shadow-category').val(first_term);
        $('#edit-shadow-duration').val(second_term);

        // Show the edit modal
        $('#editModal').modal('show');
      });
    });

    // Event listener for saving changes
    $('#saveChangesBtn').on('click', function () {

      form = $('#editForm');

      // Perform AJAX request to update fee information in the database
      $.ajax({
        url: 'update-shadow.php',
        type: 'POST',
        data: form.serialize(),
        success: function (response) {
          // Handle success
          console.log(response);
          displayPopup('Information updated successfully.', true);
          // Optionally update the UI to reflect the changes
          // For example, update the title of the fee row
          $('#editModal').modal('hide');
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
        error: function (xhr, status, error) {
          // Handle error
          // console.error(xhr.responseText);
        }
      });
    });
  </script>

  <!-- add fee -->
  <script>
    $(document).ready(function () {

      // Event listener for saving changes
      $('#saveBtn').on('click', function () {

        form = $('#newForm');
        // Perform AJAX request to update fee information in the database
        $.ajax({
          url: 'add-shadow.php',
          type: 'POST',
          data: form.serialize(),
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              displayPopup(response.message, true);
              // Remove the row from the table
              $('#newModal').modal('hide');
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              displayPopup(response.message, false);
            }
          },
          error: function (xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
</body>

</html>