<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Teacher Contacts - Messages | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
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
          <a class="nav-link text-muted my-2" href="../#" data-toggle="modal" data-target=".modal-shortcut">
            <span class="fe fe-grid fe-16"></span>
          </a>
        </li>
        <li class="nav-item nav-notif">
          <a class="nav-link text-muted my-2" href="../#" data-toggle="modal" data-target=".modal-notif">
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
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chats.php.php">
              <i class="fe fe-message-circle fe-16"></i>
              <span class="ml-3 item-text">Live Chats</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="notifications.php">
              <i class="fe fe-navigation fe-16"></i>
              <span class="ml-3 item-text">Notifications</span>
              </i>
            </a>
          </li>



          <!-- Contacts -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Contacts</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="parent-contacts.php">
                <i class="fe fe-users fe-16"></i>
                <span class="ml-3 item-text">Parent Contacts</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="teacher-contacts.php">
                <i class="fe fe-user-check fe-16"></i>
                <span class="ml-3 item-text">Teachers Contacts</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="staff-contacts.php">
                <i class="fe fe-book fe-16"></i>
                <span class="ml-3 item-text">Staff Contact</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="student-contacts.php">
                <i class="fe fe-smile fe-16"></i>
                <span class="ml-3 item-text">Students Contact</span>
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
              <a class="nav-link" href="notice-log.php">
                <i class="fe fe-file-text fe-16"></i>
                <span class="ml-3 item-text">Rinda Notice Log</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="chat-log.php">
                <i class="fe fe-file-text fe-16"></i>
                <span class="ml-3 item-text">Rinda Chats Log</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="rinda-message-settings.php">
                <i class="fe fe-tool fe-16"></i>
                <span class="ml-3 item-text">Rinda Message Settings</span>
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
            <div class="row align-items-center my-4">
              <div class="col">
                <h2 class="h3 mb-0 page-title">Teacher Contacts</h2>
              </div>
              <div class="col-auto"><input class="form-control" type="search" name="search" id="searchInput" placeholder="Search Contacts">

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    var searchInput = document.getElementById('searchInput');

                    searchInput.addEventListener('keyup', function() {
                      var searchValue = searchInput.value.trim();

                      // Send an AJAX request to fetch search results
                      fetchSearchResults(searchValue);
                    });
                  });

                  function fetchSearchResults(searchValue) {
                    // Make an AJAX request to fetch search results
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                        // Update the table with the search results
                        updateTable(JSON.parse(this.responseText));
                      }
                    };
                    xhr.open("GET", "search-orders.php?search=" + encodeURIComponent(searchValue), true);
                    xhr.send();
                  }

                  function updateTable(data) {
                    var tableBody = document.querySelector("#dataTable-1 tbody");
                    tableBody.innerHTML = '';

                    data.forEach(function(order) {
                      var newRow = document.createElement('tr');
                      newRow.innerHTML = `
            <td>${order.order_ref}</td>
            <td>${order.purchase_date}</td>
            <td>${order.name}</td>
            <td>${order.phone}</td>
            <td>${order.total}</td>
            <td>${order.payment}</td>
            <td><span class="dot dot-lg bg-${order.status === 'Completed' ? 'success' : 'warning'} mr-2"></span> ${order.status}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item view-items-link" data-order-id="${order.id}" href="#">View Items</a>
                        <a class="dropdown-item change-status-link" data-order-id="${order.id}" href="#">Change label</a>
                        <a class="dropdown-item" href="#">Send Receipt</a>
                    </div>
                </div>
            </td>
        `;
                      tableBody.appendChild(newRow);
                    });
                  }
                </script>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-4.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Bass Wendy </strong>
                      <p class="small text-muted mb-0">Accumsan Consulting</p>
                      <p class="small"><span class="badge badge-light text-muted">New York, USA</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-success mr-1"></span> Online </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Leblanc Yoshio</strong>
                      <p class="small text-muted mb-0">Tristique Ltd</p>
                      <p class="small"><span class="badge badge-light text-muted">United Kingdom</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-secondary mr-1"></span> Offline </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-5.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Higgins Uriah</strong>
                      <p class="small text-muted mb-0">Suspendisse LLC</p>
                      <p class="small"><span class="badge badge-light text-muted">Canada</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-success mr-1"></span> Online </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-3.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Brown Asher</strong>
                      <p class="small text-muted mb-0">Orci Luctus Et Inc.</p>
                      <p class="small"><span class="badge badge-dark">USA</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-success mr-1"></span> Online </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-4.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Bass Wendy </strong>
                      <p class="small text-muted mb-0">Accumsan Consulting</p>
                      <p class="small"><span class="badge badge-light text-muted">New York, USA</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-success mr-1"></span> Online </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Leblanc Yoshio</strong>
                      <p class="small text-muted mb-0">Tristique Ltd</p>
                      <p class="small"><span class="badge badge-light text-muted">United Kingdom</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-secondary mr-1"></span> Offline </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-5.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Higgins Uriah</strong>
                      <p class="small text-muted mb-0">Suspendisse LLC</p>
                      <p class="small"><span class="badge badge-light text-muted">Canada</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-success mr-1"></span> Online </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-3">
                <div class="card shadow mb-4">
                  <div class="card-body text-center">
                    <div class="avatar avatar-lg mt-4">
                      <a href="">
                        <img src="../assets/avatars/face-3.jpg" alt="..." class="avatar-img rounded-circle">
                      </a>
                    </div>
                    <div class="card-text my-2">
                      <strong class="card-title my-0">Brown Asher</strong>
                      <p class="small text-muted mb-0">Orci Luctus Et Inc.</p>
                      <p class="small"><span class="badge badge-dark">USA</span></p>
                    </div>
                  </div> <!-- ./card-text -->
                  <div class="card-footer">
                    <div class="row align-items-center justify-content-between">
                      <div class="col-auto">
                        <small>
                          <span class="dot dot-lg bg-success mr-1"></span> Online </small>
                      </div>
                      <div class="col-auto">
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chats</a>
                            <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Notifications</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.card-footer -->
                </div>
              </div> <!-- .col -->
              <div class="col-md-9">
              </div> <!-- .col -->
            </div> <!-- .row -->
            <nav aria-label="Table Paging" class="my-3">
              <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->
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
                  <a href="../academics" style="text-decoration: none;">
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
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Messages</p>
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