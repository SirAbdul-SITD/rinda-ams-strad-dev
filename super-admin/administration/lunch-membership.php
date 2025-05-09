<?php
require_once('../settings.php');

if (isset($_POST['lunch_id'], $_POST['student_id'], $_POST['amount_fare'])) {

  $lunch_id = $_POST['lunch_id'];
  $student_id = $_POST['student_id'];
  $fee = $_POST['amount_fare'];

  // Check if the subscription already exists
  $query = "SELECT status 
            FROM lunch_members 
            WHERE lunch_id = :lunch_id AND student_id = :student_id AND session = :session AND term = :term";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':lunch_id', $lunch_id);
  $stmt->bindParam(':student_id', $student_id);
  $stmt->bindParam(':session', $curr_session);
  $stmt->bindParam(':term', $term);
  $stmt->execute();
  $member_available = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($member_available) > 0) {
  } else {

    $insertQuery = "INSERT INTO `lunch_members` (`lunch_id`, `parent_id`, `student_id`, `fee`, session, term) VALUES (:lunch_id, :parent_id, :student_id, :fee, :session, :term)";
    $insertQ = $pdo->prepare($insertQuery);
    $insertQ->bindParam(':lunch_id', $lunch_id, PDO::PARAM_INT);
    $insertQ->bindParam(':parent_id', $user_id, PDO::PARAM_INT);
    $insertQ->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $insertQ->bindParam(':session', $curr_session);
    $insertQ->bindParam(':term', $term);
    $insertQ->bindParam(':fee', $fee);
    $insertQ->execute();
  }
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
  <title>Lunch Subscribers | Grithal Academy</title>
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
            <li class="nav-item active">
              <a class="nav-link text-primary" href="lunch.php">
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


          </ul>

          <!-- Extras -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extras</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="calendar.php">
                <i class="fe fe-calendar fe-16"></i>
                <span class="ml-3 item-text">Academic Calendar</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="notice-board.php">
                <i class="fe fe-bell fe-16"></i>
                <span class="ml-3 item-text">Notice Board</span>
                </i>
              </a>
            </li>
          </ul>
          <!-- Hostel -->
          <p class=" nav-heading mt-4 mb-1">
            <span>Hostel</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link " href="hostel.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Hostels</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="room-types.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Room Types</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="hostel-membership.php">
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
                    <h3 class="page-title">School Lunch Subscribers</h3>
                  </div>
                  <div class="col-auto">
                    <a href="lunch.php">
                      <button type="button" class="btn btn-primary"><span class="fe fe-plus fe-16 mr-3"></span>Manage
                        Lunch Categories</button></a>
                  </div>
                </div>
                <div class="card shadow">
                  <div class="card-body">
                    <!-- table -->
                    <table class="table table-borderless table-hover">
                      <thead>
                        <tr>

                          <th>#</th>
                          <th>Dependant</th>
                          <th>Fee</th>
                          <th>Duration</th>
                          <th>Payment Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $query = "SELECT s.admission_no, CONCAT(s.firstName, ' ', s.lastName) AS full_name, m.id, m.student_id, m.parent_id, m.lunch_id, m.status, m.paid_amount, m.payment_date, r.duration, r.amount FROM students s INNER JOIN lunch_members m ON m.student_id = s.id INNER JOIN lunch_fees r ON r.id = m.lunch_id WHERE s.status = 1 AND m.session = :session AND m.term = :term";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':session', $curr_session);
                        $stmt->bindParam(':term', $term);
                        $stmt->execute();
                        $lunchs = $stmt->fetchAll(PDO::FETCH_ASSOC);



                        if (count($lunchs) > 0) {
                          // Loop through each lunch and display it in the table
                          foreach ($lunchs as $index => $lunch) {
                            echo "<tr>";
                            $l_membership_id = $lunch['id'];
                            $l_student_id = $lunch['student_id'];
                            $l_status = $lunch['status'];

                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . $lunch['full_name'] . "</td>";
                            $formatted_amount = '₦ ' . number_format($lunch['amount'], 2);
                            echo "<td>" . $formatted_amount . "</td>";
                            echo "<td>" . $lunch['duration'] . "</td>";
                            if ($lunch['payment_date'] == '0000-00-00') {
                              echo "<td>Not Paid</td>";
                            } else {
                              echo "<td>" . $lunch['payment_date'] . "</td>";
                            }


                            if ($l_status === 'Unpaid') {
                              echo "<td class='text-danger'>" . $l_status . "</td>";
                            } elseif ($l_status === 'Paid') {
                              echo "<td class='text-success'>" . $l_status . "</td>";
                            } else {
                              echo "<td class='text-muted'>" . $l_status . "</td>";
                            }
                            ;
                            $admission_no = $lunch['admission_no'];
                            $parent_id = $lunch['parent_id'];
                            echo "<td>
                             <input type='hidden' value='$l_membership_id' class='lunch-id' ?>
                            <input type='hidden' value='$l_status' class='lunch-status' ?>
                            <input type='hidden' value='$l_student_id' class='student-id' ?>
                                    <button class='btn btn-sm dropdown-toggle more-horizontal' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                      <span class='text-muted sr-only'>Action</span>
                                    </button>
                                    <div class='dropdown-menu dropdown-menu-right'>
                                      <a class='dropdown-item p-status'>Update Payment Status</a>
                                      <a href='../academics/student.php?admission_no=$admission_no' class='dropdown-item student'>Student Profile</a>
                                      <a href='../academics/parent.php?parent_id=$parent_id' class='dropdown-item parent'>Parent Profile</a>
                                    </div>
                                  </td>";
                            echo "</tr>";
                          }
                        } else {
                          // If no lunchs are found, display a message
                          echo "<tr><td colspan='12' class='text-center'>None Subscribed.</td></tr>";
                        }
                        ?>


                      </tbody>
                    </table>
                  </div>
                </div>
              </div> <!-- customized table -->
            </div> <!-- end section -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->




      <!-- PaymentConfirmModal -->
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
              Are you sure you want to update this payment status from <span id="prev-status"></span> to <span
                id='new-status'></span>?
            </div>
            <form id="updateForm">
              <input type="hidden" id="update-status" name="status" value="">
              <input type="hidden" id="update-student-id" name="student-id" value="">
              <input type="hidden" id="update-lunch-id" name="lunch-id" value="">
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
              <button type="button" class="btn btn-success confirm-update">Yes, Proceed</button>
            </div>
          </div>
        </div>
      </div>



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
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src='js/daterangepicker.js'></script>
  <script src='js/jquery.stickOnScroll.js'></script>
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src='js/jquery.dataTables.min.js'></script>
  <script src='js/dataTables.bootstrap4.min.js'></script>
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
      $('.table').on('click', '.dropdown-item.p-status', function () {
        // $('').on('click'

        var row = $(this).closest('tr');
        var lunch_Id = row.find('.lunch-id').val();
        var lunch_status = row.find('.lunch-status').val();
        var student_id = row.find('.student-id').val();

        if (lunch_status == 'Paid') {
          l_status = 'Unpaid'
        } else {
          l_status = 'Paid'
        }

        // Update form fields with retrieved data
        $('#update-student-id').val(student_id);
        $('#update-lunch-id').val(lunch_Id);
        $('#update-status').val(l_status);
        $('#prev-status').text(lunch_status);
        $('#new-status').text(l_status);

        // Show the edit modal
        $('#confirmationModal').modal('show');

      });
    });

    // Event listener for saving changes
    $('.confirm-update').on('click', function () {

      form = $('#updateForm');

      // Perform AJAX request to update fee information in the database
      $.ajax({
        url: 'update-lunch-payment.php',
        type: 'POST',
        data: form.serialize(),
        success: function (response) {
          // Handle success
          // console.log(response);


          displayPopup('Payment status updated successfully.', true);

          $('#confirmationModal').modal('hide');
          setTimeout(function () {
            location.reload();
          }, 1000);


        },
        error: function (xhr, status, error) {
          //Handle error
          // console.error(xhr, status, error);
        }
      });
    });
  </script>

</body>

</html>