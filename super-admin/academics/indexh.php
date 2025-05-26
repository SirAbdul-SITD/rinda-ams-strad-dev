<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Admission | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
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
        <div class="btn-box w-100 mt-4 mb-1">
          <a href="../" class="btn mb-2 btn-primary btn-lg btn-block">
            <i class="fe fe-arrow-left fe-12 mx-2"></i><span class="small">Back To Dashboard</span>
          </a>
        </div>
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Admission</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="student-applications.php">
              <i class="fe fe-award fe-16"></i>
              <span class="ml-3 item-text">Student Applications</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-tool fe-16"></i>
              <span class="ml-3 item-text">Process Applications</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-refresh-cw fe-16"></i>
              <span class="ml-3 item-text">Completed Admissions</span>
              </i>
            </a>
          </li>

        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Students</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-plus-circle fe-16"></i>
              <span class="ml-3 item-text">Add Students</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-file-text fe-16"></i>
              <span class="ml-3 item-text">Students List</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-grid fe-16"></i>
              <span class="ml-3 item-text">Student Group</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-slash fe-16"></i>
              <span class="ml-3 item-text">Disable Students</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
              <i class="fe fe-trash-2 fe-16"></i>
              <span class="ml-3 item-text">Delete Students Record</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="upload-content.html">
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
            <div class="row align-items-center mb-2">
              <div class="col">
                <h2 class="h5 page-title">Welcome!</h2>
              </div>
              <div class="col-auto">
                <form class="form-inline">
                  <div class="form-group d-none d-lg-inline">
                    <label for="reportrange" class="sr-only">Date Ranges</label>
                    <div id="reportrange" class="px-2 py-2 text-muted">
                      <span class="small"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-sm"><span
                        class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-sm mr-2"><span
                        class="fe fe-filter fe-16 text-muted"></span></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow bg-primary text-white border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary-light">
                          <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">Students</p>
                        <span class="h3 mb-0 text-white">250</span>
                        <span class="small text-muted">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                          <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">Teachers</p>
                        <span class="h3 mb-0">69</span>
                        <span class="small text-success">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                          <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">Parents</p>
                        <span class="h3 mb-0">169</span>
                        <span class="small text-success">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-0">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                          <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                        </span>
                      </div>
                      <div class="col pr-0">
                        <p class="small text-muted mb-0">Subjects</p>
                        <span class="h3 mb-0">23</span>
                        <span class="small text-success">Total</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end section -->
            <!-- linechart -->
            <div class="my-4">
              <div id="lineChart"></div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong>Goal</strong>
                  </div>
                  <div class="card-body px-4">
                    <div class="row border-bottom">
                      <div class="col-4 text-center mb-3">
                        <p class="mb-1 small text-muted">Completions</p>
                        <span class="h3">26</span><br />
                        <span class="small text-muted">+20%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                      </div>
                      <div class="col-4 text-center mb-3">
                        <p class="mb-1 small text-muted">Goal Value</p>
                        <span class="h3">$260</span><br />
                        <span class="small text-muted">+6%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                      </div>
                      <div class="col-4 text-center mb-3">
                        <p class="mb-1 small text-muted">Conversion</p>
                        <span class="h3">6%</span><br />
                        <span class="small text-muted">-2%</span>
                        <span class="fe fe-arrow-down text-danger fe-12"></span>
                      </div>
                    </div>
                    <table class="table table-borderless mt-3 mb-1 mx-n1 table-sm">
                      <thead>
                        <tr>
                          <th class="w-50">Goal</th>
                          <th class="text-right">Conversion</th>
                          <th class="text-right">Completions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Checkout</td>
                          <td class="text-right">5%</td>
                          <td class="text-right">260</td>
                        </tr>
                        <tr>
                          <td>Add to Cart</td>
                          <td class="text-right">55%</td>
                          <td class="text-right">1260</td>
                        </tr>
                        <tr>
                          <td>Contact</td>
                          <td class="text-right">18%</td>
                          <td class="text-right">460</td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!-- .card-body -->
                </div> <!-- .card -->
              </div> <!-- .col -->
              <div class="col-md-6">
                <div class="card shadow mb-4">
                  <div class="card-header">
                    <strong class="card-title">Top Students</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <div class="card-body">
                    <div class="list-group list-group-flush my-n3">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-3 col-md-2">
                            <img src="../assets/products/p1.jpg" alt="..." class="thumbnail-sm">
                          </div>
                          <div class="col">
                            <strong>Fusion Backpack</strong>
                            <div class="my-0 text-muted small">Gear, Bags</div>
                          </div>
                          <div class="col-auto">
                            <strong>+85%</strong>
                            <div class="progress mt-2" style="height: 4px;">
                              <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-3 col-md-2">
                            <img src="../assets/products/p2.jpg" alt="..." class="thumbnail-sm">
                          </div>
                          <div class="col">
                            <strong>Luma hoodies</strong>
                            <div class="my-0 text-muted small">Jackets, Men</div>
                          </div>
                          <div class="col-auto">
                            <strong>+75%</strong>
                            <div class="progress mt-2" style="height: 4px;">
                              <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-3 col-md-2">
                            <img src="../assets/products/p3.jpg" alt="..." class="thumbnail-sm">
                          </div>
                          <div class="col">
                            <strong>Luma shorts</strong>
                            <div class="my-0 text-muted small">Shorts, Men</div>
                          </div>
                          <div class="col-auto">
                            <strong>+62%</strong>
                            <div class="progress mt-2" style="height: 4px;">
                              <div class="progress-bar" role="progressbar" style="width: 62%" aria-valuenow="62"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-3 col-md-2">
                            <img src="../assets/products/p4.jpg" alt="..." class="thumbnail-sm">
                          </div>
                          <div class="col">
                            <strong>Brown Trousers</strong>
                            <div class="my-0 text-muted small">Trousers, Women</div>
                          </div>
                          <div class="col-auto">
                            <strong>+24%</strong>
                            <div class="progress mt-2" style="height: 4px;">
                              <div class="progress-bar" role="progressbar" style="width: 24%" aria-valuenow="24"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- / .list-group -->
                  </div> <!-- / .card-body -->
                </div> <!-- .card -->
              </div> <!-- .col -->
            </div> <!-- .row -->

            <div class="row">
              <!-- Recent orders -->
              <div class="col-md-8">
                <div class="card shadow eq-card">
                  <div class="card-header">
                    <strong class="card-title">Recent Orders</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <div class="card-body">
                    <table class="table table-hover table-borderless table-striped mt-n3 mb-n1">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Company</th>
                          <th>Date</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>3224</td>
                          <th scope="col">Keith Baird</th>
                          <td>Enim Limited<br /><span class="small text-muted">901-6206 Cras Av.</span></td>
                          <td>Apr 24, 2019</td>
                          <td><span class="dot dot-lg bg-warning mr-2"></span></td>
                        </tr>
                        <tr>
                          <td>3218</td>
                          <th scope="col">Graham Price</th>
                          <td>Nunc Lectus Incorporated<br /><span class="small text-muted">Ap #705-5389 Id St.</span>
                          </td>
                          <td>May 23, 2020</td>
                          <td><span class="dot dot-lg bg-success mr-2"></span></td>
                        </tr>
                        <tr>
                          <td>2651</td>
                          <th scope="col">Reuben Orr</th>
                          <td>Nisi Aenean Eget Limited<br />
                            <span class="small text-muted">7425 Malesuada Rd.</span>
                          </td>
                          <td>Nov 4, 2019</td>
                          <td><span class="dot dot-lg bg-warning mr-2"></span></td>
                        </tr>
                        <tr>
                          <td>2636</td>
                          <th scope="col">Akeem Holder</th>
                          <td>Pellentesque Associates<br />
                            <span class="small text-muted">896 Sodales St.</span>
                          </td>
                          <td>Mar 27, 2020</td>
                          <td><span class="dot dot-lg bg-danger mr-2"></span></td>
                        </tr>
                        <tr>
                          <td>2757</td>
                          <th scope="col">Beau Barrera</th>
                          <td>Augue Incorporated<br />
                            <span class="small text-muted">4583 Id St.</span>
                          </td>
                          <td>Jan 13, 2020</td>
                          <td><span class="dot dot-lg bg-success mr-2"></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!-- .card-body -->
                </div> <!-- .card -->
              </div> <!-- / .col-md-8 -->
              <!-- Recent Activity -->
              <div class="col-md-4">
                <div class="card shadow eq-card timeline">
                  <div class="card-header">
                    <strong class="card-title">Recent Activity</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <div class="card-body" data-simplebar style="height: 360px; overflow-y: auto; overflow-x: hidden;">
                    <div class="pb-3 timeline-item item-primary">
                      <div class="pl-5">
                        <div class="mb-1 small"><strong>@Brown Asher</strong><span class="text-muted mx-2">Just create
                            new layout Index, form, table</span><strong>Tiny Admin</strong></div>
                        <p class="small text-muted">Creative Design <span class="badge badge-light">1h ago</span>
                        </p>
                      </div>
                    </div>
                    <div class="pb-3 timeline-item item-warning">
                      <div class="pl-5">
                        <div class="mb-3 small"><strong>@Fletcher Everett</strong><span class="text-muted mx-2">created
                            new group for</span><strong>Tiny Admin</strong></div>
                        <ul class="avatars-list mb-2">
                          <li>
                            <a href="#!" class="avatar avatar-sm">
                              <img alt="..." class="avatar-img rounded-circle" src="../assets/avatars/face-1.jpg">
                            </a>
                          </li>
                          <li>
                            <a href="#!" class="avatar avatar-sm">
                              <img alt="..." class="avatar-img rounded-circle" src="../assets/avatars/face-4.jpg">
                            </a>
                          </li>
                          <li>
                            <a href="#!" class="avatar avatar-sm">
                              <img alt="..." class="avatar-img rounded-circle" src="../assets/avatars/face-3.jpg">
                            </a>
                          </li>
                        </ul>
                        <p class="small text-muted">Front-End Development <span class="badge badge-light">1h ago</span>
                        </p>
                      </div>
                    </div>
                    <div class="pb-3 timeline-item item-success">
                      <div class="pl-5">
                        <div class="mb-2 small"><strong>@Kelley Sonya</strong><span class="text-muted mx-2">has
                            commented on</span><strong>Advanced table</strong></div>
                        <div class="card d-inline-flex mb-2">
                          <div class="card-body bg-light small py-2 px-3"> Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. </div>
                        </div>
                        <p class="small text-muted">Back-End Development <span class="badge badge-light">1h ago</span>
                        </p>
                      </div>
                    </div>
                  </div> <!-- / .card-body -->
                </div> <!-- / .card -->
              </div> <!-- / .col-md-3 -->
            </div> <!-- end section -->


          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->
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
                  <div class="squircle bg-success justify-content-center">
                    <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Dashboard</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Admission</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                  </div>
                  <p>E-Learning</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Messages</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Shop</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-users fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Staffs</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="assessments/" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                    </div>
                    <p>Assessments</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
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
  <script src="../js/apexcharts.index.js"></script>
  <script src='../js/jquery.mask.min.js'></script>
  <script src='../js/select2.min.js'></script>
  <script src='../js/jquery.steps.min.js'></script>
  <script src='../js/jquery.validate.min.js'></script>
  <script src='../js/jquery.timepicker.js'></script>
  <script src='../js/dropzone.min.js'></script>
  <script src='../js/uppy.min.js'></script>
  <script src='../js/quill.min.js'></script>
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
</body>

</html>