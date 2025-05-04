<?php require_once '../settings.php' ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>All Files - Resources | Rinda AMS</title>
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

  <link rel="stylesheet" href="video-js.css">
  <script src="jquery-3.6.0.min.js"></script>
  <!-- Bootstrap CSS (if not already included) -->
  <style>
    /* Additional CSS styling for the video player */
    .video-container {
      position: relative;
      padding-top: 56.25%;

    }

    #videoPlayer {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    /* Center the play button */
    .vjs-big-play-button {
      /* top: 50%;
      left: 50%; */
      transform: translate(200%, 200%);
    }
  </style>
</head>

<body class="vertical  light  ">
  <div class="wrapper">
    <nav class="topnav navbar navbar-light">
      <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
      </button>
      <!--<form class="form-inline mr-auto searchform text-muted">-->
      <!--  <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"-->
      <!--    placeholder="Type something..." aria-label="Search">-->
      <!--</form>-->
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

          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.php">
            <span class="avatar avatar-sm mt-2">
              <img src="../assets/images/logo.jpg" size="20" alt="..." class="avatar-img rounded-circle">
            </span>
          </a>
        </div>

        <!-- Dashboard -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-folder fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
              </i>
            </a>
          </li>

          <!-- My Files -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>My Files</span>
          </p>
          <li class="nav-item">
            <a class="nav-link" href="audio.php">
              <i class="fe fe-music fe-16"></i>
              <span class="ml-3 item-text">Audio</span>
              </i>
            </a>
          </li>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="images.php">
                <i class="fe fe-image fe-16"></i>
                <span class="ml-3 item-text">Image</span>
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


            <!-- <li class="nav-item">
              <a class="nav-link" href="upload.php">
                <i class="fe fe-upload-cloud fe-16"></i>
                <span class="ml-3 item-text">Upload</span>
                </i>
              </a>
            </li> -->
          </ul>
        </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="border-top">
              <div class="file-panel mt-4">
                <div class="row align-items-center mb-4">
                  <div class="col">
                    <h3 class="page-title">All files</h3>
                  </div>
                </div>
                <!-- .row -->
                <hr class="my-4">
                <div class="row my-4 pb-4">

                  <?php
                  $type = 'video';
                  $query = "SELECT * FROM files ORDER BY files.class";
                  $stmt = $pdo->prepare($query);
                  $stmt->execute();
                  $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (count($files) === 0) {
                    echo '<p class="text-center">None added Yet!</p>';
                  } else {
                    foreach ($files as $index => $file) :

                      if ($file['type'] == 'video') {
                        # Video...
                  ?>
                        <div class="col-md-3 video-card">
                          <div class="card shadow text-center mb-4">
                            <div class="card-body file">

                              <button type="button" class="btn btn-link" data-toggle="modal" data-target="#vidModel" data-src="file-manager/videos/<?= $file['title'] ?>.<?= $file['extension'] ?>">
                                <div class="circle circle-lg bg-light my-4">
                                  <span class="fe fe-film fe-24 text-info"></span>
                                </div>
                                <div class="file-info">
                                  <span class="badge badge-light text-muted mr-2 vid-subject" id="vidsubject-<?= $file['id'] ?>"><?= $file['subject'] ?></span>
                                  <span class="badge badge-pill badge-light text-muted vid-class" id="vidclass-<?= $file['id'] ?>"><?= $file['class'] ?></span>
                                </div>
                              </button>

                              <div class="modal fade modal-full" id="vidModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="video-container">
                                        <video id="videoPlayer" class="video-js vjs-default-skin" controls preload="auto">
                                          <source src="file-manager/videos/<?= $file['title'] ?>.<?= $file['extension'] ?>" type="video/<?= $file['extension'] ?>">
                                          <!-- Other video sources if needed -->
                                        </video>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div> <!-- .card-body -->
                            <div class="card-footer bg-transparent border-0 fname">
                              <span class="vid-id d-none">
                                <?= $file['id'] ?>
                              </span>
                              <strong class="vid-title" id="vidtitle-<?= $file['id'] ?>"><?= $file['title'] ?></strong>
                            </div> <!-- .card-footer -->
                          </div> <!-- .card -->
                        </div>


                      <?php } elseif ($file['type'] == 'audio') {
                        # Audio...
                      ?>
                        <div class="col-md-3 audio-card">
                          <div class="card shadow text-center mb-4">
                            <div class="card-body file">

                              <button type="button" class="btn btn-link" data-toggle="modal" data-target="#yourModal" data-src="file-manager/audio/<?= $file['title'] ?>.<?= $file['extension'] ?>">
                                <div class="circle circle-lg bg-light my-4">
                                  <span class="fe fe-music fe-24 text-info"></span>
                                </div>
                                <div class="file-info">
                                  <span class="badge badge-light text-muted mr-2 vid-subject" id="audiosubject-<?= $file['id'] ?>"><?= $file['subject'] ?></span>
                                  <span class="badge badge-pill badge-light text-muted vid-class" id="audioclass-<?= $file['id'] ?>"><?= $file['class'] ?></span>
                                </div>
                              </button>

                              <div class="modal fade modal-full" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="audio-container">
                                        <audio id="audioPlayer" controls preload="auto">
                                          <source src="file-manager/audio/<?= $file['title'] ?>.<?= $file['extension'] ?>" type="audio/<?= $file['extension'] ?>">
                                          <!-- Other audio sources if needed -->
                                        </audio>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div> <!-- .card-body -->
                            <div class="card-footer bg-transparent border-0 fname">
                              <span class="audio-id d-none">
                                <?= $file['id'] ?>
                              </span>
                              <strong class="audio-title" id="audiotitle-<?= $file['id'] ?>"><?= $file['title'] ?></strong>
                            </div> <!-- .card-footer -->
                          </div> <!-- .card -->
                        </div>


                      <?php } elseif ($file['type'] == 'document') {
                        # Documents...
                      ?>
                        <div class="col-md-3 audio-card">
                          <div class="card shadow text-center mb-4">
                            <div class="card-body file">

                              <button type="button" class="btn btn-link" data-toggle="modal" data-target="#yourModal" data-src="file-manager/audio/<?= $file['title'] ?>.<?= $file['extension'] ?>">
                                <div class="circle circle-lg bg-light my-4">
                                  <span class="fe fe-file-text fe-24 text-info"></span>
                                </div>
                                <div class="file-info">
                                  <span class="badge badge-light text-muted mr-2 vid-subject" id="audiosubject-<?= $file['id'] ?>"><?= $file['subject'] ?></span>
                                  <span class="badge badge-pill badge-light text-muted vid-class" id="audioclass-<?= $file['id'] ?>"><?= $file['class'] ?></span>
                                </div>
                              </button>

                              <div class="modal fade modal-full" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="audio-container">
                                        <audio id="audioPlayer" controls preload="auto">
                                          <source src="file-manager/audio/<?= $file['title'] ?>.<?= $file['extension'] ?>" type="audio/<?= $file['extension'] ?>">
                                          <!-- Other audio sources if needed -->
                                        </audio>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div> <!-- .card-body -->
                            <div class="card-footer bg-transparent border-0 fname">
                              <span class="audio-id d-none">
                                <?= $file['id'] ?>
                              </span>
                              <strong class="audio-title" id="audiotitle-<?= $file['id'] ?>"><?= $file['title'] ?></strong>
                            </div> <!-- .card-footer -->
                          </div> <!-- .card -->
                        </div><!-- .col -->
                      <?php
                      } elseif ($file['type'] == 'image') {
                        # Image...
                      ?>
                        <div class="col-md-3 audio-card">
                          <div class="card shadow text-center mb-4">
                            <div class="card-body file">

                              <button type="button" class="btn btn-link" data-toggle="modal" data-target="#yourModal" data-src="file-manager/audio/<?= $file['title'] ?>.<?= $file['extension'] ?>">
                                <div class="circle circle-lg bg-light my-4">
                                  <span class="fe fe-image fe-24 text-info"></span>
                                </div>
                                <div class="file-info">
                                  <span class="badge badge-light text-muted mr-2 vid-subject" id="audiosubject-<?= $file['id'] ?>"><?= $file['subject'] ?></span>
                                  <span class="badge badge-pill badge-light text-muted vid-class" id="audioclass-<?= $file['id'] ?>"><?= $file['class'] ?></span>
                                </div>
                              </button>

                              <div class="modal fade modal-full" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="audio-container">
                                        <audio id="audioPlayer" controls preload="auto">
                                          <source src="file-manager/audio/<?= $file['title'] ?>.<?= $file['extension'] ?>" type="audio/<?= $file['extension'] ?>">
                                          <!-- Other audio sources if needed -->
                                        </audio>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div> <!-- .card-body -->
                            <div class="card-footer bg-transparent border-0 fname">
                              <span class="audio-id d-none">
                                <?= $file['id'] ?>
                              </span>
                              <strong class="audio-title" id="audiotitle-<?= $file['id'] ?>"><?= $file['title'] ?></strong>
                            </div> <!-- .card-footer -->
                          </div> <!-- .card -->
                        </div><!-- .col -->
                  <?php
                      }
                    endforeach;
                  } ?>



                  <!-- Video.js library -->
                  <script src="video.js"></script>

                  <script>
                    // Initialize Video.js player
                    document.addEventListener('DOMContentLoaded', function() {
                      var player = videojs('videoPlayer');

                      // Listen for modal close event to pause the video
                      $('#yourModal').on('hidden.bs.modal', function() {
                        player.pause();
                      });

                      // Listen for click event on the video container to toggle fullscreen
                      var videoContainer = document.querySelector('.video-container');
                      videoContainer.addEventListener('click', function() {
                        if (!player.isFullscreen()) {
                          player.requestFullscreen();
                        } else {
                          player.exitFullscreen();
                        }
                      });
                    });
                  </script>

                  <!-- end video js -->

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
                  <a href="../academics" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-award fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Academics</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../assessments/" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-check-square fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Assessments</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../curriculum/" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-book-open fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Curriculum</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-archive fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Resources</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <a href="../target" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-trending-up fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary">Target</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="../profile" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center text-white">
                      <i class="fe fe-user fe-32 align-self-center"></i>
                    </div>
                    <p class="text-secondary">Profile</p>
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