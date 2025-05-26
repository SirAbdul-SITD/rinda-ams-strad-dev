<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set PDO to throw exceptions
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


require_once('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>LMS Dashboard - Admin | <?= $school_name ?></title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <!-- Chart CSS -->
  <link rel="stylesheet" href="../css/chart.min.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="../css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
  <style>
    .card {
      border-radius: 8px;
      transition: transform 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .progress-sm {
      height: 0.5rem;
    }
    
    .stat-card-icon {
      font-size: 2rem;
      opacity: 0.3;
    }
    
    .recent-activity-item {
      border-left: 3px solid;
      position: relative;
      padding-left: 1.5rem;
      margin-bottom: 1.5rem;
    }
    
    .recent-activity-item:before {
      content: '';
      position: absolute;
      left: -8px;
      top: 0;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: 2px solid #fff;
    }
    
    .chart-container {
      position: relative;
      height: 250px;
    }
    
    .video-thumbnail {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
    }
    
    .audio-icon {
      font-size: 1.5rem;
      color: #6c757d;
    }
    
    @media (max-width: 768px) {
      .chart-container {
        height: 200px;
      }
    }
  </style>
</head>

<body class="vertical light">
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
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="avatar avatar-sm mt-2">
              <?php if ($gender == 'Female') { ?>
                <img src="../../uploads/staff-profiles/2.jpeg" alt="..." class="avatar-img rounded-circle">
              <?php } else { ?>
                <img src="../../uploads/staff-profiles/1.jpeg" alt="..." class="avatar-img rounded-circle">
              <?php } ?>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <div class="col-12 text-left">
              <p style="padding: 0%; margin: 0%;"><?= $full_name; ?></p>
              <strong><?= $account_type; ?></strong>
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
        <div class="w-100 mb-4 d-flex">
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15" />
              </g>
            </svg>
          </a>
        </div>

        <!-- Dashboard -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="dashboard.php">
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
          <li class="nav-item">
            <a class="nav-link" href="nigerian-curriculum.php">
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
            <div class="row align-items-center mb-4">
              <div class="col">
                <h2 class="h5 page-title">Learning Management Dashboard</h2>
              </div>
              <div class="col-auto">
                <button class="btn btn-primary">Export Report</button>
              </div>
            </div>
            
            <!-- Stats Cards Row -->
            <div class="row">
             
            <?php
// Get statistics data
try {
  // Total published videos
  $stmt = $pdo->query("SELECT COUNT(*) as total FROM videos WHERE status = 'published'");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_videos = $row['total'] ?? 0;

  // Total video views (assuming there's a 'views' column in `videos`)
  $stmt = $pdo->query("SELECT SUM(views) as total_views FROM videos WHERE status = 'published'");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $video_views = $row['total_views'] ?? 0;

  // Total Audio Uploaded
  $stmt = $pdo->query("SELECT COUNT(*) as total_audio FROM lms_audio WHERE status = 'published'");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_audio = $row['total_audio'] ?? 0;

  // Total Audio Plays (last 30 days from `audio_stats`)
  $stmt = $pdo->query("SELECT SUM(plays) as audio_plays FROM audio_stats WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $audio_plays = $row['audio_plays'] ?? 0;

  // Total Courses
  $stmt = $pdo->query("SELECT COUNT(*) as total_courses FROM courses");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_courses = $row['total_courses'] ?? 0;

  // Total Curriculum
  $stmt = $pdo->query("SELECT COUNT(*) as total_curriculum FROM curriculums");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_curriculum = $row['total_curriculum'] ?? 0;

  $stmt = $pdo->query("SELECT SUM(views) as video_views_30 FROM video_stats WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $video_views_30 = $row['video_views_30'] ?? 0;

} catch (PDOException $e) {

  $total_videos = 0;
  $video_views = 0;
  $total_audio = 0;
  $audio_plays = 0;
  $total_courses = 0;
  $total_curriculum = 0;
  $video_views_30 = 0;

  echo "Error: " . $e->getMessage();
}
?>

              
              <!-- Video Tutorials Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Video Tutorials</p>
                        <h3 class="mb-0"><?= number_format($total_videos) ?></h3>
<p class="mb-0 text-success">
  <span class="text-muted"><?= number_format($video_views) ?> views</span>
</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-film fe-32 text-primary stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Audio Uploads Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Audio Uploads</p>
                        <h3 class="mb-0"><?= number_format($total_audio) ?></h3>
                        <p class="mb-0 text-success">
                          <span class="text-muted"><?= number_format($audio_plays) ?> plays</span>
                        </p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-music fe-32 text-warning stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Courses Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Courses</p>
                        <h3 class="mb-0"><?= number_format($total_courses) ?></h3>
                        <p class="mb-0 text-success">
                          <span class="text-muted">Available courses</span>
                        </p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-layers fe-32 text-info stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Curriculum Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Curriculum</p>
                        <h3 class="mb-0"><?= number_format($total_curriculum) ?></h3>
                        <p class="mb-0 text-success">
                          <span class="text-muted">Learning materials</span>
                        </p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-file-text fe-32 text-danger stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            

<div class="row">

  <div class="col-md-8 mb-4">
    <div class="card shadow">
      <div class="card-header">
        <strong class="card-title">Content Activity Analysis</strong>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="activityChart"></canvas>
        </div>
      </div>
    </div>
  </div>

<?php
$stmt_videos = $pdo->query("SELECT DATE(watched_at) as date, SUM(watched_duration) as total_views FROM lms_video_stats WHERE watched_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) GROUP BY DATE(watched_at)");
$video_data = [];
while ($row = $stmt_videos->fetch(PDO::FETCH_ASSOC)) {
    $video_data[] = $row;
}


$stmt_audio = $pdo->query("SELECT DATE(listened_at) as date, SUM(listened_duration) as total_plays 
                           FROM lms_audio_stats 
                           WHERE listened_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                           GROUP BY DATE(listened_at)");
$audio_data = [];
while ($row = $stmt_audio->fetch(PDO::FETCH_ASSOC)) {
    $audio_data[] = $row;
}



?>


              
             <!-- Recent Video Uploads -->
             <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-header">
                    <strong class="card-title">Recent Video Uploads</strong>
                  </div>
                  <div class="card-body">
                    <?php
                   
                    try {
                      $stmt = $pdo->query("
                        SELECT id, title, extension, subject, class, date as created_at
                        FROM videos
                        ORDER BY date DESC
                        LIMIT 2
                      ");
                      $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                      if (empty($videos)) {
                        echo '<p class="text-muted">No recent videos found.</p>';
                      } else {
                        foreach ($videos as $video) {
                          $time_ago = time_elapsed_string($video['created_at']);
                          $thumbnail = '../assets/images/video-thumbnail.jpg'; // Default thumbnail
                          
                          echo '
                          <div class="recent-activity-item" style="border-left-color: var(--primary);">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <img src="' . $thumbnail . '" class="video-thumbnail" alt="Thumbnail">
                              </div>
                              <div class="col">
                                <div class="d-flex justify-content-between">
                                  <strong>' . htmlspecialchars($video['title']) . '</strong>
                                  <small class="text-muted">' . $time_ago . '</small>
                                </div>
                                <p class="small text-muted mb-0">
                                  <i class="fe fe-film mr-1 text-primary"></i>
                                  ' . htmlspecialchars($video['subject']) . ' - ' . htmlspecialchars($video['class']) . '
                                </p>
                              </div>
                            </div>
                          </div>';
                        }
                      }
                    } catch (PDOException $e) {
                      echo '<p class="text-muted">Unable to load recent videos.</p>';
                    }
                    
                    // Function to format time ago
                    function time_elapsed_string($datetime, $full = false) {
                      $now = new DateTime;
                      $ago = new DateTime($datetime);
                      $diff = $now->diff($ago);
                    
                      $weeks = floor($diff->d / 7);
                      $diff->d -= $weeks * 7;
                    
                      $string = array(
                        'y' => 'year',
                        'm' => 'month',
                        'w' => $weeks,
                        'd' => $diff->d,
                        'h' => $diff->h,
                        'i' => $diff->i,
                        's' => $diff->s,
                      );
                    
                      foreach ($string as $k => &$v) {
                        if ($v) {
                          $v = $v . ' ' . $k . ($v > 1 ? 's' : '');
                        } else {
                          unset($string[$k]);
                        }
                      }
                    
                      if (!$full) $string = array_slice($string, 0, 1);
                      return $string ? implode(', ', $string) . ' ago' : 'just now';
                    }
                    
                    ?>
                  </div>
                </div>
              </div>
            </div>
         
             <!-- Top Audio Uploads Row -->
            <!-- Top Audio Uploads Row -->
<div class="row">
  <div class="col-md-12 mb-4">
    <div class="card shadow">
      <div class="card-header">
        <strong class="card-title">Top Audio Uploads</strong>
      </div>
      <div class="card-body">
        <?php
        // Get top audio uploads
        try {
          $stmt = $pdo->query("
            SELECT id, title, subject, topic, course_id, status, created_at
            FROM lms_audio
            ORDER BY created_at DESC
            LIMIT 2
          ");
          $audio_uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          if (empty($audio_uploads)) {
            echo '<p class="text-muted">No audio uploads found.</p>';
          } else {
            foreach ($audio_uploads as $audio) {
              $time_ago = time_elapsed_string($audio['created_at']);
              echo '
              <div class="row align-items-center mb-4">
                <div class="col-auto">
                  <div class="avatar avatar-md">
                    <span class="avatar-title rounded-circle bg-primary text-white">
                      <i class="fe fe-music"></i>
                    </span>
                  </div>
                </div>
                <div class="col">
                 <strong>' . htmlspecialchars($audio['title'] ?? '') . '</strong>
<p class="small text-muted mb-0">Subject: ' . htmlspecialchars($audio['subject'] ?? '') . '</p>
<p class="small text-muted mb-0">Topic: ' . htmlspecialchars($audio['topic'] ?? '') . '</p>
<p class="small text-muted mb-0">' 
  . 'Course ID: ' . htmlspecialchars($audio['course_id'] ?? '') . ' - '
  . htmlspecialchars($audio['status'] ?? '') . '</p>

                </div>
                <div class="col-md-4">
                  <small class="text-muted">Uploaded ' . $time_ago . '</small>
                </div>
              </div>';
            }
          }
        } catch (PDOException $e) {
          echo '<p class="text-muted">Unable to load audio uploads.</p>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

            
            <!-- Recent Courses Created Row -->
            <div class="row">
              <div class="col-md-12 mb-4">
                <div class="card shadow">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col">
                        <strong class="card-title">Recent Courses Created</strong>
                      </div>
                      <div class="col-auto">
                        <a href="courses.php" class="btn btn-sm btn-primary">View All</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Curriculum Type</th>
                            <th>Level</th>
                            <th>Created At</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Get recent courses
                          try {
                            $stmt = $pdo->query("
                              SELECT course_id, course_name, course_code, curriculum_type_id, level, created_at
                              FROM courses
                              ORDER BY created_at DESC
                              LIMIT 4
                            ");
                            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if (empty($courses)) {
                              echo '<tr><td colspan="6" class="text-center text-muted">No courses found.</td></tr>';
                            } else {
                              foreach ($courses as $course) {
                                $created_at = date('M j, Y', strtotime($course['created_at']));
                                echo '
                                <tr>
                                  <td>' . htmlspecialchars($course['course_name']) . '</td>
                                  <td>' . htmlspecialchars($course['course_code']) . '</td>
                                  <td>' . htmlspecialchars($course['curriculum_type']?? 'N/A') . '</td>
                                  <td>' . htmlspecialchars($course['level']) . '</td>
                                  <td>' . $created_at . '</td>
                                  <td>
                                    <a href="course-details.php?id=' . $course['course_id'] . '" class="btn btn-sm btn-outline-primary">
                                      View
                                    </a>
                                  </td>
                                </tr>';
                              }
                            }
                          } catch (PDOException $e) {
                            echo '<tr><td colspan="6" class="text-center text-muted">Unable to load courses.</td></tr>';
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal Notifications -->
  <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog"
    aria-labelledby="defaultModalLabel" aria-hidden="true">
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
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear All</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Shortcut -->
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
              <div class="squircle bg-success justify-content-center">
                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
              </div>
              <p class="text-success">Dashboard</p>
            </div>
            <div class="col-6 text-center con-item">
              <a href="../academiics/" style="text-decoration: none;">
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

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/daterangepicker.js"></script>
  <script src="../js/jquery.stickOnScroll.js"></script>
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src="../js/chart.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/apps.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
// Get the video and audio data from PHP
const videoData = <?php echo json_encode($video_data); ?>;
const audioData = <?php echo json_encode($audio_data); ?>;

// Extract the dates, views, and plays for the chart
const labels = videoData.map(item => item.date);
const videoViews = videoData.map(item => item.total_views);
const audioPlays = audioData.map(item => item.total_plays);

// Create the chart
const ctx = document.getElementById('activityChart').getContext('2d');
const activityChart = new Chart(ctx, {
  type: 'line', // You can change this to 'bar', 'pie', etc.
  data: {
    labels: labels, // Dates
    datasets: [{
        label: 'Video Views',
        data: videoViews, // Video views data
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: true,
        tension: 0.4
      },
      {
        label: 'Audio Plays',
        data: audioPlays, // Audio plays data
        borderColor: 'rgba(153, 102, 255, 1)',
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        fill: true,
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true
      }
    },
    plugins: {
      legend: {
        position: 'top',
      },
      tooltip: {
        mode: 'index',
        intersect: false,
      }
    }
  }
});
</script>

  <script>
    // Video/Audio Activity Chart
    document.addEventListener("DOMContentLoaded", function() {
      var ctx = document.getElementById('activityChart').getContext('2d');
      
      // Fetch data via AJAX
      $.ajax({
        url: 'get-content-stats.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          var activityChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.labels,
              datasets: [
                {
                  label: 'Video Views',
                  data: data.video_views,
                  backgroundColor: 'rgba(54, 162, 235, 0.7)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Audio Plays',
                  data: data.audio_plays,
                  backgroundColor: 'rgba(255, 159, 64, 0.7)',
                  borderColor: 'rgba(255, 159, 64, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                      return value;
                    }
                  }
                }
              },
              plugins: {
                legend: {
                  position: 'top',
                },
                tooltip: {
                  mode: 'index',
                  intersect: false,
                }
              },
              interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
              }
            }
          });
        },
        error: function() {
          // Fallback data if AJAX fails
          var fallbackData = {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            video_views: [120, 190, 150, 220],
            audio_plays: [80, 110, 95, 130]
          };
          
          var activityChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: fallbackData.labels,
              datasets: [
                {
                  label: 'Video Views',
                  data: fallbackData.video_views,
                  backgroundColor: 'rgba(54, 162, 235, 0.7)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Audio Plays',
                  data: fallbackData.audio_plays,
                  backgroundColor: 'rgba(255, 159, 64, 0.7)',
                  borderColor: 'rgba(255, 159, 64, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                     
                  return value;
                }
              }
            }
          },
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              mode: 'index',
              intersect: false,
            }
          },
          interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
          }
        }
      });
      
   
    });
  </script>
</body>
</html>