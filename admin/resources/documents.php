<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Documents - Resourses | Rinda AMS</title>
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
  <script src="jquery-3.6.0.min.js"></script>
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
          <li class="nav-item">
            <a class="nav-link" href="index.php">
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
            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
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
          <div class="col-12 col-lg-10">
            <div class="row align-items-center my-4">
              <div class="col">
                <h3 class="page-title">Documents</h3>
              </div>
            </div>
            <?php
            $type = 'document';
            $query = "SELECT * FROM files WHERE type = :type ORDER BY `files`.`title` ASC";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['type' => $type]);
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($documents) === 0) {
              echo '<p class="text-center">None added Yet!</p>';
            } else {
            ?>
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th class="w-50">Name</th>
                    <th>Created By</th>
                    <th>Last Update</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($documents as $index => $docx) : ?>
                    <tr>
                      <td class="text-center">
                        <div class="circle circle-sm bg-light">
                          <span class="fe fe-file-text fe-16 text-muted"></span>
                        </div>
                        <span class="dot dot-md bg-secondary mr-1"></span>
                      </td>
                      <th scope="row">
                        <span class="doc-title">
                          <?= $docx['title']; ?>
                        </span> <br />
                        <span>
                          <input type="text" class="form-control d-none" value="">
                          <span class="docx-id d-none">
                            <?= $docx['id']; ?>
                          </span>
                          <button class="btn btn-primary btn-sm save-btn d-none">Save</button>
                        </span>
                        <span class="more-detail">
                          <span class="badge badge-light text-muted mr-2">
                            <?= $docx['subject']; ?>
                          </span>
                          <span class="badge badge-light text-muted">
                            <?= $docx['class']; ?>
                          </span>
                        </span>
                      </th>

                      <td class="text-muted">
                        <?= $docx['added_by']; ?>
                      </td>
                      <td class="text-muted">
                        <?= $docx['date']; ?>
                      </td>
                      <td>
                        <div class="file-action">
                          <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu m-2">
                            <a class="dropdown-item rename" href="#"><i class="fe fe-edit-3 fe-12 mr-4"></i>Rename</a>
                            <a class="dropdown-item delete" href="#"><i class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                            <a class="dropdown-item share" href="#"><i class="fe fe-share fe-12 mr-4"></i>Share</a>
                            <a class="dropdown-item download" href="download-docx.php?id=<?= $docx['id']; ?>"><i class="fe fe-download fe-12 mr-4"></i>Download</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php } ?>

            <!-- Confirm delete Modal -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalTitle">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this document?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Delete -->
            <script>
              $(document).ready(function() {
                // Event listener for the delete option
                $('.dropdown-item.delete').on('click', function(event) {
                  event.preventDefault();
                  var row = $(this).closest('tr');
                  var id = row.find('.docx-id').text();

                  // Show the confirmation modal
                  $('#confirmDeleteModal').modal('show');

                  // Event listener for the confirm delete button inside the modal
                  $('#confirmDeleteBtn').on('click', function() {
                    // Send AJAX request to delete the document
                    $.ajax({
                      url: 'delete-docx.php',
                      type: 'POST',
                      data: {
                        id: id
                      },
                      success: function(response) {
                        // Handle success
                        console.log(response);
                        // Optionally remove the row from the table
                        row.remove();
                      },
                      error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                      }
                    });

                    // Close the confirmation modal
                    $('#confirmDeleteModal').modal('hide');
                  });
                });
              });
            </script>

            <!-- renaming -->
            <script>
              $(document).ready(function() {
                $('.dropdown-item.rename').on('click', function(event) {
                  event.preventDefault();
                  var row = $(this).closest('tr');
                  var inputField = row.find('input');
                  var saveButton = row.find('.save-btn');
                  var title = row.find('.doc-title').text(); // Get the current document title
                  inputField.val(title); // Set the input field value to the current document title

                  inputField.removeClass('d-none');
                  saveButton.removeClass('d-none');
                });

                $('.save-btn').on('click', function() {
                  var row = $(this).closest('tr');
                  var id = row.find('.docx-id').text();
                  var newTitle = row.find('input[type="text"]').val();

                  $.ajax({
                    url: 'rename-docx.php',
                    type: 'POST',
                    data: {
                      id: id,
                      newTitle: newTitle
                    },
                    success: function(response) {
                      // Handle success
                      row.find('.save-btn').addClass('d-none');
                      row.find('input').addClass('d-none');
                      row.find('.doc-title').text(newTitle); // Update displayed title
                    },
                    error: function(xhr, status, error) {
                      // Handle error
                      console.error(xhr.responseText);
                    }
                  });
                });
              });
            </script>


            <!-- share -->
            <!-- Share Modal -->
            <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="shareModalTitle">Share Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Copy the link below to share this document:</p>
                    <input type="text" id="shareLink" class="form-control" readonly>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
              $(document).ready(function() {
                $('.dropdown-item.share').on('click', function() {
                  var row = $(this).closest('tr');
                  var docId = row.find('.docx-id').text();
                  var shareLink = window.location.origin + '/view-document.php?id=' + docId; // Adjust the URL as needed
                  $('#shareLink').val(shareLink);
                  $('#shareModal').modal('show');
                });
              });
            </script>

            <!-- end of share -->


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