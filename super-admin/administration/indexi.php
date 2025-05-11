<?php require_once '../settings.php'; ?>
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
                <a class="nav-link pl-3" href="fees-type.php"><span class="ml-1 item-text  text-primary">Fees
                    Type</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link pl-3" href="invoice/"><span class="ml-1 item-text">Invoices</span></a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link pl-3" href="payment-history.php"><span class="ml-1 item-text">Payment
                    History</span></a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link pl-3" href="expense.php"><span class="ml-1 item-text">Expense</span></a>
              </li>
            </ul>
          </li>

          <!-- Asset Management -->
          <li class="nav-item dropdown">
            <a href="#asset-management-elements" data-toggle="collapse" aria-expanded="false"
              class="dropdown-toggle nav-link">
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
                <a class="nav-link pl-3" href="hostel-membership.html"><span
                    class="ml-1 item-text">Membership</span></a>
              </li>
            </ul>
          </li>

          <!-- Study materials -->
          <li class="nav-item dropdown">
            <a href="#study-materials-elements" data-toggle="collapse" aria-expanded="false"
              class="dropdown-toggle nav-link">
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
            <a href="#transportation-elements" data-toggle="collapse" aria-expanded="false"
              class="dropdown-toggle nav-link">
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
                <a class="nav-link pl-3" href="transport-membership.html"><span
                    class="ml-1 item-text">Membership</span></a>
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
            <!-- widgets -->
            <div class="row my-4">
              <div class="col-md-4">
                <div class="card shadow mb-4">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col">
                        <small class="text-muted mb-1">Page Views</small>
                        <h3 class="card-title mb-0">1168</h3>
                        <p class="small text-muted mb-0"><span
                            class="fe fe-arrow-down fe-12 text-danger"></span><span>-18.9% Last week</span></p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="sparkline inlineline"></span>
                      </div>
                    </div> <!-- /. row -->
                  </div> <!-- /. card-body -->
                </div> <!-- /. card -->
              </div> <!-- /. col -->
              <div class="col-md-4">
                <div class="card shadow mb-4">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col">
                        <small class="text-muted mb-1">Conversion</small>
                        <h3 class="card-title mb-0">68</h3>
                        <p class="small text-muted mb-0"><span
                            class="fe fe-arrow-up fe-12 text-warning"></span><span>+1.9% Last week</span></p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="sparkline inlinepie"></span>
                      </div>
                    </div> <!-- /. row -->
                  </div> <!-- /. card-body -->
                </div> <!-- /. card -->
              </div> <!-- /. col -->
              <div class="col-md-4">
                <div class="card shadow mb-4">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col">
                        <small class="text-muted mb-1">Visitors</small>
                        <h3 class="card-title mb-0">108</h3>
                        <p class="small text-muted mb-0"><span
                            class="fe fe-arrow-up fe-12 text-success"></span><span>37.7% Last week</span></p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="sparkline inlinebar"></span>
                      </div>
                    </div> <!-- /. row -->
                  </div> <!-- /. card-body -->
                </div> <!-- /. card -->
              </div> <!-- /. col -->
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
                    <strong class="card-title">Top Selling</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <div class="card-body">
                    <div class="list-group list-group-flush my-n3">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-3 col-md-2">
                            <img src="./assets/products/p1.jpg" alt="..." class="thumbnail-sm">
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
                            <img src="./assets/products/p2.jpg" alt="..." class="thumbnail-sm">
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
                            <img src="./assets/products/p3.jpg" alt="..." class="thumbnail-sm">
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
                            <img src="./assets/products/p4.jpg" alt="..." class="thumbnail-sm">
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
              <div class="col-md-4">
                <div class="card shadow eq-card  mb-4">
                  <div class="card-header">
                    <strong>Region</strong>
                  </div>
                  <div class="card-body">
                    <div class="map-box my-5"
                      style="position:relative; max-width: 320px; max-height: 200px; margin:0 auto;">
                      <div id="dataMapUSA"></div>
                    </div>
                    <div class="row align-items-bottom my-2">
                      <div class="col">
                        <p class="mb-0">France</p>
                        <span class="my-0 text-muted small">+10%</span>
                      </div>
                      <div class="col-auto text-right">
                        <p class="mb-0">118</p>
                        <div class="progress mt-2" style="height: 4px;">
                          <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center my-2">
                      <div class="col">
                        <p class="mb-0">Netherlands</p>
                        <span class="my-0 text-muted small">+0.6%</span>
                      </div>
                      <div class="col-auto text-right">
                        <p class="mb-0">1008</p>
                        <div class="progress mt-2" style="height: 4px;">
                          <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center my-2">
                      <div class="col">
                        <p class="mb-0">Italy</p>
                        <span class="my-0 text-muted small">+1.6%</span>
                      </div>
                      <div class="col-auto text-right">
                        <p class="mb-0">67</p>
                        <div class="progress mt-2" style="height: 4px;">
                          <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center my-2">
                      <div class="col">
                        <p class="mb-0">Spain</p>
                        <span class="my-0 text-muted small">+118%</span>
                      </div>
                      <div class="col-auto text-right">
                        <p class="mb-0">186</p>
                        <div class="progress mt-2" style="height: 4px;">
                          <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> <!-- .col -->
              <div class="col-md-4">
                <div class="card shadow eq-card mb-4">
                  <div class="card-header">
                    <strong class="card-title">Traffic</strong>
                    <a class="float-right small text-muted" href="#!">View all</a>
                  </div>
                  <div class="card-body">
                    <div class="chart-box mb-3" style="min-height:180px;">
                      <div id="customAngle"></div>
                    </div> <!-- .col -->
                    <div class="mx-auto">
                      <div class="row align-items-center mb-2">
                        <div class="col">
                          <p class="mb-0">Direct</p>
                          <span class="my-0 text-muted small">+10%</span>
                        </div>
                        <div class="col-auto text-right">
                          <p class="mb-0">218</p>
                          <span class="dot dot-md bg-success"></span>
                        </div>
                      </div>
                      <div class="row align-items-center mb-2">
                        <div class="col">
                          <p class="mb-0">Organic Search</p>
                          <span class="my-0 text-muted small">+0.6%</span>
                        </div>
                        <div class="col-auto text-right">
                          <p class="mb-0">1002</p>
                          <span class="dot dot-md bg-warning"></span>
                        </div>
                      </div>
                      <div class="row align-items-center mb-2">
                        <div class="col">
                          <p class="mb-0">Referral</p>
                          <span class="my-0 text-muted small">+1.6%</span>
                        </div>
                        <div class="col-auto text-right">
                          <p class="mb-0">67</p>
                          <span class="dot dot-md bg-primary"></span>
                        </div>
                      </div>
                      <div class="row align-items-center">
                        <div class="col">
                          <p class="mb-0">Social</p>
                          <span class="my-0 text-muted small">+118%</span>
                        </div>
                        <div class="col-auto text-right">
                          <p class="mb-0">386</p>
                          <span class="dot dot-md bg-secondary"></span>
                        </div>
                      </div>
                    </div>
                  </div> <!-- .card-body -->
                </div> <!-- .card -->
              </div> <!-- .col-md -->
              <div class="col-md-4">
                <div class="card shadow eq-card mb-4">
                  <div class="card-header">
                    <strong>Browsers</strong>
                  </div>
                  <div class="card-body">
                    <div class="chart-box mt-3 mb-5">
                      <div id="radarChartWidget"></div>
                    </div> <!-- .col -->
                    <div class="mx-auto">
                      <div class="row align-items-center my-2">
                        <div class="col-6 col-xl-3 my-3">
                          <span class="mb-0">Safari</span>
                          <div class="progress my-2" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: 10%" aria-valuenow="10"
                              aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                        <div class="col-6 col-xl-3 my-3 text-right">
                          <span>118</span><br />
                          <span class="my-0 text-muted small">+10%</span>
                        </div>
                        <div class="col-6 col-xl-3 my-3">
                          <span class="mb-0">Chrome</span>
                          <div class="progress my-2" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: 36%" aria-valuenow="36"
                              aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                        <div class="col-6 col-xl-3 my-3 text-right">
                          <span>1008</span><br />
                          <span class="my-0 text-muted small">+36%</span>
                        </div>
                        <div class="col-6 col-xl-3 my-3">
                          <span class="mb-0">Opera</span>
                          <div class="progress my-2" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                              aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                        <div class="col-6 col-xl-3 my-3 text-right">
                          <span>67</span><br />
                          <span class="my-0 text-muted small">+1.6%</span>
                        </div>
                        <div class="col-6 col-xl-3 my-3">
                          <span class="mb-0">Edge</span>
                          <div class="progress my-2" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85"
                              aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                        <div class="col-6 col-xl-3 my-3 text-right">
                          <span>186</span><br />
                          <span class="my-0 text-muted small">+118%</span>
                        </div>
                      </div>
                    </div>
                  </div> <!-- .card-body -->
                </div> <!-- .card -->
              </div> <!-- .col -->
            </div>
          </div> <!-- /.col -->
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