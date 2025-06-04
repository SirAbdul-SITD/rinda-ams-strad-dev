<?php
require('../settings.php');
if (isset($_GET['class'])) {
  $class = $_GET['class'];
} else {
  throw new Exception("Error: No class selected", 1);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Curriculum - LMS | Rinda AMS</title>
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
    /* Loading overlay styles */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    
    /* Progress bar container */
    .progress-container {
      width: 80%;
      max-width: 400px;
      background-color: #f1f1f1;
      border-radius: 10px;
      margin: 20px 0;
    }
    
    /* Progress bar */
    .progress-bar {
      width: 0%;
      height: 10px;
      background-color: #4CAF50;
      border-radius: 10px;
      transition: width 0.3s ease;
    }
    
    /* Loading text */
    .loading-text {
      margin-top: 15px;
      font-size: 18px;
      color: #333;
    }
    
    /* Spinner animation */
    .spinner {
      width: 50px;
      height: 50px;
      border: 5px solid #f3f3f3;
      border-top: 5px solid #3498db;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-bottom: 20px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>

<body class="vertical  light  ">
  <!-- Loading overlay -->
  <div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="spinner"></div>
    <div class="progress-container">
      <div class="progress-bar" id="progressBar"></div>
    </div>
    <div class="loading-text">Generating lesson content...</div>
  </div>

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
        <!-- Dashboard -->
           <!-- Dashboard -->
           <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
            </a>
          </li>
        </ul>

        <!-- LMS -->
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="courses.php">
              <i class="fe fe-book fe-16"></i>
              <span class="ml-3 item-text">Courses</span>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="classes.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Classes</span>
            </a>
          </li> -->
          <li class="nav-item active">
            <a class="nav-link text-primary" href="nigerian-curriculum.php">
              <i class="fe fe-layers fe-16"></i>
              <span class="ml-3 item-text">curriculums</span>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="assignments.php">
              <i class="fe fe-edit fe-16"></i>
              <span class="ml-3 item-text">Assignments</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="chat.php">
              <i class="fe fe-refresh-cw fe-16"></i>
              <span class="ml-3 item-text">Generate</span>
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
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="videos.php">
              <i class="fe fe-film fe-16"></i>
              <span class="ml-3 item-text">Video</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="documents.php">
              <i class="fe fe-file-text fe-16"></i>
              <span class="ml-3 item-text">Documents</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="file-manager.php">
              <i class="fe fe-folder fe-16"></i>
              <span class="ml-3 item-text">File Manager</span>
            </a>
          </li>
        </ul>

        <!-- Reports -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Reports</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="reports.php">
              <i class="fe fe-pie-chart fe-16"></i>
              <span class="ml-3 item-text">Analytics</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row">
              <!-- Striped rows -->
              <div class="col-md-12 my-4">
                <h2 class="h4 mb-1">Curriculum</h2>
                <p class="mb-4"></p>
                <div class="card shadow">
                  <div class="card-body">
                    <h5 class="card-title">
                      <?= $class ?>
                    </h5>
                    <p class="card-text">Choose a subject to view its curriculum</p>
                    <div class="toolbar row mb-3">
                      <div class="col">
                        <form class="form-inline">
                          <div class="form-row">
                            <div class="form-group col-auto ml-3">
                              <label class="my-1 mr-2 sr-only" for="subjectSelect">Status</label>
                              <?php
                              // Fetch subjects for the selected class
                              $query = "SELECT DISTINCT subject FROM curriculums WHERE class = '$class'";
                              $statement = $pdo->query($query);

                              // Create select options
                              echo '<select class="custom-select my-1 mr-sm-2" id="subjectSelect">';
                              echo '<option selected>Choose Subject...</option>';

                              // Loop through the fetched subjects and add them as options
                              while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['subject'] . '">' . $row['subject'] . '</option>';
                              }

                              echo '</select>';

                              // Close the database connection
                              $pdo = null;
                              ?>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="col ml-auto">
                        <div class="dropdown float-right">
                          <div class="form-group col-auto">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" class="form-control" id="search" value="" placeholder="Search Topics" oninput="filterTopics()">
                          </div>
                        </div>
                      </div>
                    </div>
                    <table class="table table-bordered id">
                      <thead>
                        <tr role="row">
                          <th>ID</th>
                          <th>Topic</th>
                          <th>Lesson Plan</th>
                          <th>Lesson Content</th>
                        </tr>
                      </thead>
                      <tbody id="tableBody">
                        <!-- The table body will be populated dynamically using JavaScript -->
                      </tbody>
                    </table>
                    <nav aria-label="Table Paging" class="mb-0 text-muted">
                      <ul class="pagination justify-content-end mb-0">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div> <!-- end section -->
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
                    <div class="col-auto">
                      <span class="fe fe-box fe-24"></span>
                    </div>
                    <div class="col">
                      <small><strong>Package has uploaded successful</strong></small>
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
                      <small><strong>Widgets are updated successful</strong></small>
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
                  </div>
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
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
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
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">E-Learning</p>
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
    </main>
  </div>

  <?php if ($class == 'Primary 1') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = '';

        if (selectedSubject in primaryOne) {
          for (var theme in primaryOne[selectedSubject]) {
            var subjectName = selectedSubject;
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + primaryOne[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < primaryOne[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + primaryOne[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(primaryOne[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryOne[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 1') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(primaryOne[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryOne[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 1') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

  <?php } elseif ($class == 'Primary 2') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in primaryTwo) {
          for (var theme in primaryTwo[selectedSubject]) {
            var subjectName = selectedSubject;
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + primaryTwo[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < primaryTwo[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + primaryTwo[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(primaryTwo[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryTwo[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 2') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(primaryTwo[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryTwo[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 2') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      } 
      // hello

      <?php } elseif ($class == 'Primary 3') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in primaryThree) {
          for (var theme in primaryThree[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + primaryThree[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < primaryThree[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + primaryThree[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(primaryThree[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryThree[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 3') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(primaryThree[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryThree[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 3') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'Primary 4') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in primaryFour) {
          for (var theme in primaryFour[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + primaryFour[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < primaryFour[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + primaryFour[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(primaryFour[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryFour[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 4') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(primaryFour[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryFour[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 4') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'Primary 5') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in primaryFive) {
          for (var theme in primaryFive[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + primaryFive[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < primaryFive[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + primaryFive[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(primaryFive[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryFive[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 5') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(primaryFive[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primaryFive[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 5') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'Primary 6') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in primarySix) {
          for (var theme in primarySix[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + primarySix[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < primarySix[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + primarySix[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(primarySix[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primarySix[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 6') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(primarySix[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(primarySix[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Primary 6') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'Jss 1') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in jss1) {
          for (var theme in jss1[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + jss1[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < jss1[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + jss1[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(jss1[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(jss1[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Jss 1') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(jss1[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(jss1[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Jss 1') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'Jss 2') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in jss2) {
          for (var theme in jss2[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + jss2[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < jss2[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + jss2[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(jss2[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(jss2[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Jss 2') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(jss2[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(jss2[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Jss 2') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'Jss 3') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in jss3) {
          for (var theme in jss3[selectedSubject]) {
            var subjectName = selectedSubject; //
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + jss3[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < jss3[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + jss3[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(jss3[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(jss3[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Jss 3') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(jss3[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(jss3[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('Jss 3') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

   

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

    <?php } elseif ($class == 'SSS 1') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in sss1) {
          for (var theme in sss1[selectedSubject]) {
            var subjectName = selectedSubject;
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + sss1[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < sss1[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + sss1[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(sss1[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(sss1[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('SSS 1') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(sss1[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(sss1[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('SSS 1') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'SSS 2') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in sss2) {
          for (var theme in sss2[selectedSubject]) {
            var subjectName = selectedSubject;
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + sss2[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < sss2[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + sss2[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(sss2[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(sss2[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('SSS 2') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(sss2[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(sss2[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('SSS 2') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }

      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

<?php } elseif ($class == 'SSS 3') { ?>
    <script>
      // Function to populate the table based on the selected subject
      function populateTable(selectedSubject) {
        var tableBody = document.getElementById("tableBody");
        tableBody.innerHTML = ''; // Clear existing content

        if (selectedSubject in sss3) {
          for (var theme in sss3[selectedSubject]) {
            var subjectName = selectedSubject;
            // Add row for theme
            var themeRow = document.createElement("tr");
            themeRow.setAttribute("role", "group");
            themeRow.setAttribute("class", "bg-light");
            themeRow.innerHTML = '<td colspan="10"><strong>Theme: ' + sss3[selectedSubject][theme]["Topic"] + '</strong></td>';
            tableBody.appendChild(themeRow);

            // Add rows for content
            for (var i = 0; i < sss3[selectedSubject][theme]["Content"].length; i++) {
              var contentRow = document.createElement("tr");
              contentRow.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + sss3[selectedSubject][theme]["Content"][i] + '</td>' +
                '<td><a href="view-content.php?subtopic=' + encodeURIComponent(sss3[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(sss3[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('SSS 3') + '" onclick="showLoader()">View Content</a></td>' +
                '<td><a href="view-plan.php?subtopic=' + encodeURIComponent(sss3[selectedSubject][theme]["Content"][i]) + '&topic=' + encodeURIComponent(sss3[selectedSubject][theme]["Topic"]) + '&subject=' + encodeURIComponent(subjectName) + '&class=' + encodeURIComponent('SSS 3') + '" onclick="showLoader()">View Plan</a></td>';
              tableBody.appendChild(contentRow);
            }
          }
        }
      }

      // Function to filter topics based on the search input
      function filterTopics() {
        var searchInput = document.getElementById("search").value.toLowerCase();
        var tableBody = document.getElementById("tableBody");
        var rows = tableBody.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
          var topicCell = rows[i].getElementsByTagName("td")[1];
          if (topicCell) {
            var topicText = topicCell.textContent || topicCell.innerText;
            if (topicText.toLowerCase().indexOf(searchInput) > -1) {
              rows[i].style.display = "";
            } else {
              rows[i].style.display = "none";
            }
          }
        }
      }


      // Add event listener for subject selection
      document.getElementById("subjectSelect").addEventListener("change", function() {
        var selectedSubject = this.value;
        populateTable(selectedSubject);
      });

      // Initial population of the table
      populateTable("Arabic"); // Default subject (you can change this as needed)
    </script>

  <?php } ?>
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
  <script src='curriculum.js'></script>
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
    $('#dataTable-1').DataTable({
      autoWidth: true,
      "lengthMenu": [
        [16, 32, 64, -1],
        [16, 32, 64, "All"]
      ]
    });

    function showLoader() {
      // Set flag in session storage to show loader on next page
      sessionStorage.setItem('showLoader', 'true');
      
      // Show loader immediately for better UX
      document.getElementById('loadingOverlay').style.display = 'flex';
      
      // Start progress animation
      let progress = 0;
      const progressBar = document.getElementById('progressBar');
      const interval = setInterval(() => {
        progress += Math.random() * 10;
        if (progress >= 100) {
          progress = 100;
          clearInterval(interval);
        }
        progressBar.style.width = progress + '%';
      }, 300);
    }

    // For the content page (view-content.php), add this to handle the loader:
    document.addEventListener('DOMContentLoaded', function() {
      const loadingOverlay = document.getElementById('loadingOverlay');
      
      // Check if we should show loader (for content generation pages)
      if (sessionStorage.getItem('showLoader') === 'true') {
        loadingOverlay.style.display = 'flex';
        sessionStorage.removeItem('showLoader');
        
        // Start progress animation
        let progress = 0;
        const progressBar = document.getElementById('progressBar');
        const interval = setInterval(() => {
          progress += Math.random() * 10;
          if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
          }
          progressBar.style.width = progress + '%';
        }, 300);
        
        // Hide overlay when content is loaded
        window.addEventListener('load', function() {
          // Give it a little delay for better UX
          setTimeout(() => {
            loadingOverlay.style.display = 'none';
          }, 500);
        });
      }
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
</body>

</html>