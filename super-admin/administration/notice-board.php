<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Rinda AMS - Rinda AMS</title>
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

            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
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
          <div class="col-12 mb-4">
            <div class="row align-items-center my-3 mb-5">
              <div class="col">
                <h3 class="page-title">Notice Board</h3>
              </div>
              <div class="col-auto">
                <button type="button" class="btn  btn-primary" data-toggle="modal" data-target="#newModal"><span
                    class="fe fe-plus fe-16 mr-3"></span>New</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 mb-4">
                <div class="col-12 mb-4">
                  <div class="card shadow">

                    <div class="card-body">

                      <div class="" role="alert">
                        <div class="d-flex w-100 justify-content-between mb-3">
                          <h4 class="alert-heading">Well done!</h4>
                          <span>Tue 04/07/2025</span>
                        </div>
                        <div style="max-height: 53vh; overflow-y: auto;">
                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>
                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>

                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>
                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>
                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>
                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>

                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>
                          <p>Aww yeah, you successfully read this important alert message. This example text is going to
                            run a
                            bit longer so that you can see how spacing within an alert works with this kind of content.
                          </p>
                        </div>


                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-header">
                    <div class="d-flex w-100 justify-content-between">
                      <strong class="card-title mb-0">Previous Notices</strong>
                      <span>2024/2025</span>
                    </div>
                  </div>
                  <div class="card-body">
                    <div style="max-height: 54vh; overflow-y: auto;">
                      <div class="alert alert-success" role="alert">
                        <div class="d-flex w-100 justify-content-between">
                          <span class="fe fe-bell fe-16 mr-2"></span>
                          <span>Tue 04/07/2025</span>
                        </div> A simple primary alert—check it out!
                      </div>
                      <div class="alert alert-secondary" role="alert">
                        <div class="d-flex w-100 justify-content-between">
                          <span class="fe fe-bell fe-16 mr-2"></span>
                          <span>Tue 01/03/2025</span>
                        </div> A simple primary alert—check it out!
                      </div>
                      <div class="alert alert-secondary" role="alert">
                        <div class="d-flex w-100 justify-content-between">
                          <span class="fe fe-bell fe-16 mr-2"></span>
                          <span>Tue 15/05/2025</span>
                        </div> A simple primary alert—check it out!
                      </div>
                      <div class="alert alert-secondary" role="alert">
                        <div class="d-flex w-100 justify-content-between">
                          <span class="fe fe-bell fe-16 mr-2"></span>
                          <span>Tue 18/02/2025</span>
                        </div> A simple primary alert—check it out!
                      </div>
                      <div class="alert alert-secondary" role="alert">
                        <div class="d-flex w-100 justify-content-between">
                          <span class="fe fe-bell fe-16 mr-2"></span>
                          <span>Tue 18/02/2025</span>
                        </div> A simple primary alert—check it out!
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div> <!-- end section -->

          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
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
                      <div class="col-auto">
                        <span class="fe fe-box fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Package has uploaded successfull</strong></small>
                        <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                        <small class="badge badge-pill badge-light text-muted">1m ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-download fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Widgets are updated successfull</strong></small>
                        <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                        <small class="badge badge-pill badge-light text-muted">2m ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-inbox fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Notifications have been sent</strong></small>
                        <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                        <small class="badge badge-pill badge-light text-muted">30m ago</small>
                      </div>
                    </div> <!-- / .row -->
                  </div>
                  <div class="list-group-item bg-transparent">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="fe fe-link fe-24"></span>
                      </div>
                      <div class="col">
                        <small><strong>Link was attached to menu</strong></small>
                        <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                        <small class="badge badge-pill badge-light text-muted">1h ago</small>
                      </div>
                    </div>
                  </div> <!-- / .row -->
                </div> <!-- / .list-group -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
              </div>
            </div>
          </div>
        </div>

        <!-- New Notice Modal -->
        <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newModalLabel">Add New Notice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="noticeForm" class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="subject" class="col-form-label">Subject:*</label>
                    <input type="text" class="form-control" name="subject" id="subject" required>
                  </div>

                  <div class="form-group">
                    <label for="content" class="col-form-label">Content:*</label>
                    <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
                  </div>

                  <div class="form-row align-items-end">
                    <div class="form-group col-5">
                      <label for="start_date" class="col-form-label">Start Date:*</label>
                      <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>

                    <div class="form-group col-2 text-center">
                      <div class="custom-control custom-switch mt-4">
                        <label class="custom-control-label" for="toggleEndDate">End</label>
                        <input type="checkbox" class="custom-control-input" id="toggleEndDate">

                      </div>
                    </div>

                    <div class="form-group col-5" id="endDateGroup" style="display: none;">
                      <label for="end_date" class="col-form-label">End Date:</label>
                      <input type="date" class="form-control" name="end_date" id="end_date">
                    </div>
                  </div>
                  <p>Notification settings</p>

                  <div class="form-row col-12">
                    <div class="form-group col-6" id="parents">
                      <div class="custom-control custom-switch">
                        <label class="custom-control-label" for="toggleParents">Parents</label>
                        <input type="checkbox" class="custom-control-input" id="toggleParents">
                      </div>
                      <div>
                        <label class="custom-control-label" for="parentEmail">Send Email</label>
                        <input type="checkbox" class="custom-control-input" id="parentEmail">
                      </div>
                      <div>
                        <label class="custom-control-label" for="parentWhatsApp">Send to Whatsapp</label>
                        <input type="checkbox" class="custom-control-input" id="parentWhatsApp">
                      </div>
                      <div>
                        <label class="custom-control-label" for="parentSMS">Send to SMS</label>
                        <input type="checkbox" class="custom-control-input" id="parentSMS">
                      </div>
                    </div>

                    <div class="form-group col-6" id="staffs">
                      <label class="custom-control-label" for="Staffs">Staffs</label>
                      <input type="checkbox" class="custom-control-input" id="staffs">
                      <div>
                        <label class="custom-control-label" for="parentEmail">Send Email</label>
                        <input type="checkbox" class="custom-control-input" id="parentEmail">
                      </div>
                      <div>
                        <label class="custom-control-label" for="parentWhatsApp">Send to Whatsapp</label>
                        <input type="checkbox" class="custom-control-input" id="parentWhatsApp">
                      </div>
                      <div>
                        <label class="custom-control-label" for="staffsMS">Send to SMS</label>
                        <input type="checkbox" class="custom-control-input" id="staffsMS">
                      </div>

                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" id="saveBtn">Add Notice</button>
              </div>
            </div>
          </div>
        </div>

        <script>
          // Toggle visibility of end date field based on switch
          document.getElementById('toggleEndDate').addEventListener('change', function () {
            const endDateGroup = document.getElementById('endDateGroup');
            const endDateInput = document.getElementById('end_date');

            if (this.checked) {
              endDateGroup.style.display = 'block';
              endDateInput.setAttribute('required', 'required');
            } else {
              endDateGroup.style.display = 'none';
              endDateInput.removeAttribute('required');
            }
          });
        </script>



        <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog"
          aria-labelledby="defaultModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body px-5">
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Control area</p>
                  </div>
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Activity</p>
                  </div>
                </div>
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Droplet</p>
                  </div>
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Upload</p>
                  </div>
                </div>
                <div class="row align-items-center">
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-users fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Users</p>
                  </div>
                  <div class="col-6 text-center">
                    <div class="squircle bg-primary justify-content-center">
                      <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Settings</p>
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

  <!-- add notice -->
  <!-- add fee -->
  <script>
    $(document).ready(function () {

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

      // Event listener for saving changes
      $('#saveBtn').on('click', function () {

        form = $('#newForm');
        // Perform AJAX request to update fee information in the database
        $.ajax({
          url: 'add-notice.php',
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




improve the model, i want when any of the swtcih is clicked then the options under will be visible, like when parent is
on then the options below it are visible


<!-- New Notice Modal -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newModalLabel">Add New Notice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="noticeForm" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="subject" class="col-form-label">Subject:*</label>
            <input type="text" class="form-control" name="subject" id="subject" required>
          </div>

          <div class="form-group">
            <label for="content" class="col-form-label">Content:*</label>
            <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
          </div>

          <div class="form-row align-items-end">
            <div class="form-group col-5">
              <label for="start_date" class="col-form-label">Start Date:*</label>
              <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>

            <div class="form-group col-2 text-center">
              <div class="custom-control custom-switch mt-4">
                <label class="custom-control-label" for="toggleEndDate">End</label>
                <input type="checkbox" class="custom-control-input" id="toggleEndDate">

              </div>
            </div>

            <div class="form-group col-5" id="endDateGroup" style="display: none;">
              <label for="end_date" class="col-form-label">End Date:</label>
              <input type="date" class="form-control" name="end_date" id="end_date">
            </div>
          </div>
          <p>Notification settings</p>

          <div class="form-row col-12">
            <div class="form-group col-6" id="parents">
              <div class="custom-control custom-switch">
                <label class="custom-control-label" for="toggleParents">Parents</label>
                <input type="checkbox" class="custom-control-input" id="toggleParents">
              </div>
              <div>
                <label class="custom-control-label" for="parentEmail">Send Email</label>
                <input type="checkbox" class="custom-control-input" id="parentEmail">
              </div>
              <div>
                <label class="custom-control-label" for="parentWhatsApp">Send to Whatsapp</label>
                <input type="checkbox" class="custom-control-input" id="parentWhatsApp">
              </div>
              <div>
                <label class="custom-control-label" for="parentSMS">Send to SMS</label>
                <input type="checkbox" class="custom-control-input" id="parentSMS">
              </div>
            </div>

            <div class="form-group col-6" id="staffs">
              <label class="custom-control-label" for="Staffs">Staffs</label>
              <input type="checkbox" class="custom-control-input" id="staffs">
              <div>
                <label class="custom-control-label" for="parentEmail">Send Email</label>
                <input type="checkbox" class="custom-control-input" id="parentEmail">
              </div>
              <div>
                <label class="custom-control-label" for="parentWhatsApp">Send to Whatsapp</label>
                <input type="checkbox" class="custom-control-input" id="parentWhatsApp">
              </div>
              <div>
                <label class="custom-control-label" for="staffsMS">Send to SMS</label>
                <input type="checkbox" class="custom-control-input" id="staffsMS">
              </div>

            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary w-100" id="saveBtn">Add Notice</button>
      </div>
    </div>
  </div>
</div>