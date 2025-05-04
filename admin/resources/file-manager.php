<?php require '../settings.php'; ?>
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
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Search Files..." aria-label="Search">
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
            <a class="dropdown-item" href="../settings/profile.php">Profile</a>
            <a class="dropdown-item" href="../settings">Settings</a>
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
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
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
          <!-- <li class="nav-item active">
        <a class="nav-link text-primary" href="#">
          <i class="fe fe-users fe-16"></i>
          <span class="ml-3 item-text">Students</span>
          </i>
        </a>
      </li> -->



          <!-- Curriculum -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Curriculum</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <i class="fe fe-globe fe-16"></i>
                <span class="ml-3 item-text">Default</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="nigerian-curriculum.php">
                <i class="fe fe-flag fe-16"></i>
                <span class="ml-3 item-text">Nigerian</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-flag fe-16"></i>
                <span class="ml-3 item-text">British</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-flag fe-16"></i>
                <span class="ml-3 item-text">American</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fe fe-refresh-cw fe-16"></i>
                <span class="ml-3 item-text">Generate</span>
                </i>
              </a>
            </li>
          </ul>
          <!-- Lesson Materials -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Lesson Materials</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item">
              <a class="nav-link" href="audio.php">
                <i class="fe fe-music fe-16"></i>
                <span class="ml-3 item-text">Audio</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="videos.php">
                <i class="fe fe-film fe-16"></i>
                <span class="ml-3 item-text">Video</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="documents.php">
                <i class="fe fe-file-text fe-16"></i>
                <span class="ml-3 item-text">Documents</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="file-manager.php">
                <i class="fe fe-folder fe-16"></i>
                <span class="ml-3 item-text">File Manager</span>
                </i>
              </a>
            </li>

          </ul>

          <!-- Extra -->
          <!-- <p class="text-muted nav-heading mt-4 mb-1">
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
        </li> -->
        </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="row align-items-center my-3">
              <div class="col">
                <h3 class="page-title">File Manager</h3>
              </div>
            </div>
            <div class="file-container border-top">
              <div class="file-panel mt-4">
                <?php
                $query = "SELECT * FROM files WHERE folder IS NULL ORDER BY `date` ASC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($files) === 0) {
                  // echo '<p class="text-center">None added Yet!</p>';
                } else {
                  echo '<h6 class="mb-3">Files</h6>';
                  echo '<div class="row my-4">';
                  foreach ($files as $index => $file) : ?>
                    <div class="col-md-3">
                      <div class="card shadow text-center mb-4">
                        <div class="card-body file">
                          <div class="file-action">
                            <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="text-muted sr-only">Action</span>
                            </button>
                            <div class="dropdown-menu m-2">
                              <a class="dropdown-item" href="#"><i class="fe fe-chevrons-right fe-12 mr-4"></i>Move</a>
                              <a class="dropdown-item" href="#"><i class="fe fe-copy fe-12 mr-4"></i>Copy</a>
                            </div>
                          </div>
                          <div class="circle circle-lg bg-secondary my-4">
                            <?php if ($file['type'] == 'image') {
                              echo '<span class="fe fe-image fe-24 text-white"></span>';
                            } elseif ($file['type'] == 'document') {
                              echo '<span class="fe fe-file-text fe-24 text-white"></span>';
                            } elseif ($file['type'] == 'audio') {
                              echo '<span class="fe fe-music fe-24 text-white"></span>';
                            } elseif ($file['type'] == 'video') {
                              echo '<span class="fe fe-film fe-24 text-white"></span>';
                            }
                            ?>
                          </div>
                        </div> <!-- .card-body -->
                        <div class="card-footer bg-transparent border-0 fname">
                          <strong><span class="dot dot-md bg-success mr-2"></span>
                            <?= $file['title'] ?>
                          </strong>
                        </div> <!-- .card-footer -->
                      </div> <!-- .card -->
                    </div> <!-- .col -->

                <?php endforeach;
                }; ?>
              </div> <!-- .row -->


              <hr class="my-4">
              <div class="row align-items-center mb-4">
                <div class="col">
                  <strong>Folders</strong>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-sm">
                    <i class="fe fe-16 fe-grid text-primary"></i>
                  </button>
                  <button type="button" class="btn btn-sm">
                    <i class="fe fe-16 fe-list text-muted"></i>
                  </button>
                </div>
              </div>
              <div class="row">

                <?php
                $query = "SELECT * FROM folders ORDER BY `folders`.`name` ASC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($folders) === 0) {
                  echo '<p class="text-center">None added Yet!</p>';
                } else {
                  foreach ($folders as $index => $folder) : ?>

                    <div class="col-md-6 col-lg-4">
                      <div class="card shadow mb-4">
                        <div class="card-body file-list">
                          <div class="d-flex align-items-center">
                            <div class="circle circle-md bg-secondary">
                              <span class="fe fe-folder fe-16 text-white"></span>
                            </div>
                            <div class="flex-fill ml-4 fname">
                              <strong>
                                <?= $folder['name']; ?>
                              </strong><br />
                              <span class="badge badge-light text-muted">
                                <?php
                                $folderName = $folder['name']; // Renamed variable for clarity
                                $query = "SELECT * FROM files WHERE folder = :folder";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute(['folder' => $folderName]);
                                $folderCount = $stmt->rowCount(); // Count the number of rows returned by the query
                                echo $folderCount;
                                ?>
                                files
                              </span>
                              <?php
                              $label = ($folder['permission'] == 'public') ? '<i class="fe fe-users fe-12 ml-2 text-muted"></i>' : '<span class="dot dot-md bg-success ml-2"></span>';
                              echo $label;
                              ?>
                            </div>
                            <div class="file-action">
                              <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted sr-only">Action</span>
                              </button>
                              <div class="dropdown-menu m-2">
                                <a class="dropdown-item" href="#"><i class="fe fe-chevrons-right fe-12 mr-4"></i>Move</a>
                                <a class="dropdown-item" href="#"><i class="fe fe-copy fe-12 mr-4"></i>Copy</a>
                                <a class="dropdown-item" href="#"><i class="fe fe-edit-3 fe-12 mr-4"></i>Rename</a>
                                <a class="dropdown-item" href="#"><i class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                                <a class="dropdown-item" href="#"><i class="fe fe-share fe-12 mr-4"></i>Share</a>
                                <a class="dropdown-item" href="#"><i class="fe fe-download fe-12 mr-4"></i>Download</a>
                              </div>
                            </div>
                          </div>
                        </div> <!-- .card-body -->
                      </div> <!-- .card -->
                    </div> <!-- .col -->

                <?php endforeach;
                } ?>
              </div> <!-- .row -->
            </div> <!-- .file-panel -->
          </div> <!-- .file-container -->
        </div> <!-- .col -->
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
              <div class="squircle bg-success justify-content-center">
                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
              </div>
              <p>Control area</p>
            </div>
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-activity fe-32 align-self-center text-white"></i>
              </div>
              <p>Admission</p>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
              </div>
              <p>E-Learning</p>
            </div>
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
              </div>
              <p>Virtual Meetings</p>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
              </div>
              <p>Library Management</p>
            </div>
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
              </div>
              <p>Human Resources</p>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-users fe-32 align-self-center text-white"></i>
              </div>
              <p>Assessments</p>
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