<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../settings.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug logging
function debug_log($message) {
    file_put_contents('audio_debug.log', date('Y-m-d H:i:s') . ' - ' . $message . "\n", FILE_APPEND);
}

define('AUDIO_BASE_PATH', '/opt/lampp/htdocs/strad/super-admin/lms/uploads/audio/');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    debug_log('POST request received');

    if (isset($_POST['action'])) {
        try {
            $action = $_POST['action'];
            debug_log("Action: $action");

            if ($action === 'upload_audio') {
                if (empty($_POST['title'])) throw new Exception("Title is required.");
                if (!isset($_FILES['audio_file']) || $_FILES['audio_file']['error'] !== UPLOAD_ERR_OK) {
                    $errorCode = $_FILES['audio_file']['error'] ?? 'No file';
                    throw new Exception("File upload error. Code: $errorCode");
                }

                $title = $_POST['title'];
                $subject = $_POST['subject'] ?? NULL;
                $topic = $_POST['topic'] ?? NULL;
                $course_id = $_POST['course_id'] ?? NULL;
                $folder_id = $_POST['folder_id'] ?? NULL;
                $status = $_POST['status'] ?? 'draft';

                $allowed_types = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3', 'audio/x-m4a'];
                $file_type = $_FILES['audio_file']['type'];
                if (!in_array($file_type, $allowed_types)) {
                    throw new Exception("Invalid file type: $file_type");
                }

                // Ensure folder info
                $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                $stmt->execute([$folder_id]);
                $folder = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$folder) throw new Exception("Invalid folder ID.");

                $folder_name = $folder['name'];
                $folder_path = AUDIO_BASE_PATH . $folder_name . '/';

                // Create folder if needed
                if (!file_exists($folder_path)) {
                    if (!mkdir($folder_path, 0777, true)) {
                        throw new Exception("Failed to create folder: $folder_path");
                    }
                }

                // File path
                $file_ext = pathinfo($_FILES['audio_file']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('audio_') . '.' . $file_ext;
                $file_path = $folder_path . $filename;

                debug_log("Saving to: $file_path");

                if (!move_uploaded_file($_FILES['audio_file']['tmp_name'], $file_path)) {
                    throw new Exception("Failed to move uploaded file.");
                }

                $file_size = filesize($file_path);

                // Insert into DB
                $stmt = $pdo->prepare("INSERT INTO lms_audio (title, subject, topic, course_id, folder_id, file_path, status, size, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$title, $subject, $topic, $course_id, $folder_id, $file_path, $status, $file_size]);

                $_SESSION['toast'] = ['type' => 'success', 'message' => 'Audio file uploaded successfully!'];
            }

            elseif ($action === 'update_audio') {
                $id = $_POST['id'];
                $title = $_POST['title'] ?? '';
                $subject = $_POST['subject'] ?? NULL;
                $topic = $_POST['topic'] ?? NULL;
                $course_id = $_POST['course_id'] ?? NULL;
                $new_folder_id = $_POST['folder_id'] ?? NULL;
                $status = $_POST['status'] ?? 'draft';

                $stmt = $pdo->prepare("SELECT file_path, folder_id FROM lms_audio WHERE id = ?");
                $stmt->execute([$id]);
                $audio = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$audio) throw new Exception("Audio file not found.");

                $current_file_path = $audio['file_path'];
                $current_folder_id = $audio['folder_id'];

                if ($new_folder_id != $current_folder_id) {
                    $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                    $stmt->execute([$new_folder_id]);
                    $new_folder = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!$new_folder) throw new Exception("New folder not found.");

                    $new_folder_path = AUDIO_BASE_PATH . $new_folder['name'] . '/';
                    if (!file_exists($new_folder_path)) {
                        if (!mkdir($new_folder_path, 0777, true)) {
                            throw new Exception("Failed to create new folder path.");
                        }
                    }

                    $current_filename = basename($current_file_path);
                    $new_file_path = $new_folder_path . $current_filename;

                    if (!rename($current_file_path, $new_file_path)) {
                        throw new Exception("Failed to move file to new folder.");
                    }

                    // Update DB
                    $stmt = $pdo->prepare("UPDATE lms_audio SET title = ?, subject = ?, topic = ?, course_id = ?, folder_id = ?, file_path = ?, status = ? WHERE id = ?");
                    $stmt->execute([$title, $subject, $topic, $course_id, $new_folder_id, $new_file_path, $status, $id]);

                    // Clean up old folder
                    $old_folder_path = dirname($current_file_path);
                    if (is_dir($old_folder_path) && count(scandir($old_folder_path)) == 2) {
                        rmdir($old_folder_path);
                    }
                } else {
                    $stmt = $pdo->prepare("UPDATE lms_audio SET title = ?, subject = ?, topic = ?, course_id = ?, status = ? WHERE id = ?");
                    $stmt->execute([$title, $subject, $topic, $course_id, $status, $id]);
                }

                $_SESSION['toast'] = ['type' => 'success', 'message' => 'Audio updated successfully.'];
            }

            elseif ($action === 'delete_audio') {
                $id = $_POST['id'];

                $stmt = $pdo->prepare("SELECT file_path, folder_id FROM lms_audio WHERE id = ?");
                $stmt->execute([$id]);
                $audio = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($audio && file_exists($audio['file_path'])) {
                    unlink($audio['file_path']);

                    $folder_path = dirname($audio['file_path']);
                    if (is_dir($folder_path) && count(scandir($folder_path)) == 2) {
                        rmdir($folder_path);
                    }
                }

                $stmt = $pdo->prepare("DELETE FROM lms_audio WHERE id = ?");
                $stmt->execute([$id]);

                $_SESSION['toast'] = ['type' => 'success', 'message' => 'Audio file deleted successfully!'];
            }

            header("Location: audio.php");
            exit();

        } catch (Exception $e) {
            debug_log("Error: " . $e->getMessage());
            $_SESSION['toast'] = ['type' => 'danger', 'message' => 'Error: ' . $e->getMessage()];
            header("Location: audio.php");
            exit();
        }
    }
}

// ======= GET DATA =======
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total_audio FROM lms_audio");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_audio = $row['total_audio'] ?? 0;

    $stmt = $pdo->query("SELECT SUM(plays) as total_plays FROM audio_stats WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_plays = $row['total_plays'] ?? 0;

    $stmt = $pdo->query("SELECT a.*, f.name as folder_name 
                         FROM lms_audio a 
                         LEFT JOIN folders f ON a.folder_id = f.id 
                         ORDER BY a.created_at DESC");
    $audio_files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT course_id, course_name FROM courses");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT id, name FROM folders ORDER BY name");
    $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    debug_log("Database error: " . $e->getMessage());
    $total_audio = 0;
    $total_plays = 0;
    $audio_files = [];
    $courses = [];
    $folders = [];
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
  <title>LMS Audio Management - Admin | <?= $school_name ?></title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="../css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
  <!-- Noty CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
        body {
      font-family: 'Overpass', sans-serif;
    }
    .audio-player-container {
      max-width: 100%;
      background: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
    }
    
    .audio-thumbnail {
      width: 80px;
      height: 80px;
      background: #6c757d;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 2rem;
      border-radius: 4px;
    }
    
    .audio-details {
      flex: 1;
      padding-left: 15px;
    }
    
    .audio-controls {
      display: flex;
      align-items: center;
    }
    
    .audio-progress {
      flex: 1;
      margin: 0 10px;
    }
    
    .audio-duration {
      min-width: 60px;
      text-align: right;
    }
    
    .file-upload-container {
      border: 2px dashed #dee2e6;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .file-upload-container:hover {
      border-color: #6c757d;
      background: #f8f9fa;
    }
    
    .file-upload-container.dragover {
      border-color: #007bff;
      background: rgba(0, 123, 255, 0.05);
    }
    
    .file-upload-preview {
      margin-top: 15px;
      display: none;
    }
    
    .audio-card {
      transition: all 0.3s;
    }
    
    .audio-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Fix for DataTables search box */
    .dataTables_filter input {
      margin-left: 0.5em;
      display: inline-block;
      width: auto;
    }
    
    /* Loading spinner */
    .spinner-container {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 9999;
      justify-content: center;
      align-items: center;
    }
    
    .spinner-container.show {
      display: flex;
    }
  </style>
</head>

<body class="vertical light">
  <!-- Loading spinner -->
  <div class="spinner-container" id="loadingSpinner">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  
  <div class="wrapper">
    <nav class="topnav navbar navbar-light">
      <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
      </button>
      <form class="form-inline mr-auto searchform text-muted">
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"
          placeholder="Search audio files..." aria-label="Search">
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
          <li class="nav-item">
            <a class="nav-link" href="curriculum.php">
              <i class="fe fe-layers fe-16"></i>
              <span class="ml-3 item-text">Curriculums</span>
            </a>
          </li>
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="audio.php">
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
                <h2 class="h5 page-title">Audio Management</h2>
              </div>
              <div class="col-auto">
                <button class="btn btn-primary" data-toggle="modal" data-target="#uploadAudioModal">
                  <i class="fe fe-upload mr-2"></i>Upload Audio
                </button>
              </div>
            </div>
            
            <!-- Stats Cards Row -->
            <div class="row">
              <!-- Total Audio Files Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow audio-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Audio Files</p>
                        <h3 class="mb-0"><?= number_format($total_audio) ?></h3>
                        <p class="mb-0 text-muted small">All uploaded audio</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-music fe-32 text-primary stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Total Plays Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow audio-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Plays</p>
                        <h3 class="mb-0"><?= number_format($total_plays) ?></h3>
                        <p class="mb-0 text-muted small">Last 30 days</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-headphones fe-32 text-warning stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Published Audio Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow audio-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Published</p>
                        <h3 class="mb-0">
                          <?php 
                            $stmt = $pdo->query("SELECT COUNT(*) as published FROM lms_audio WHERE status = 'published'");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo number_format($row['published'] ?? 0);
                          ?>
                        </h3>
                        <p class="mb-0 text-muted small">Publicly available</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-check-circle fe-32 text-success stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Storage Usage Card -->
              <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow audio-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Storage Used</p>
                        <h3 class="mb-0">
                          <?php
                            try {
                                $stmt = $pdo->query("SELECT ROUND(SUM(size)/1048576, 2) as total_size FROM lms_audio");
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $row['total_size'] ?? '0';
                                echo ' MB';
                            } catch (PDOException $e) {
                                echo 'N/A';
                            }
                          ?>
                        </h3>
                        <p class="mb-0 text-muted small">Audio files</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-hard-drive fe-32 text-info stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Audio Files Table -->
            <div class="row">
              <div class="col-md-12 mb-4">
                <div class="card shadow">
                  <div class="card-header">
                    <strong class="card-title">Audio Files</strong>
                  </div>
                  <div class="card-body">
                    <?php if (!empty($audio_files)): ?>
                      <div class="table-responsive">
                        <table class="table table-hover" id="audioTable">
                          <thead>
                            <tr>
                              <th>Title</th>
                              <th>Subject</th>
                              <th>Topic</th>
                              <th>Course</th>
                              <th>Folder</th>
                              <th>Status</th>
                              <th>Uploaded</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($audio_files as $audio): 
                              // Get course name
                              $course_name = '';
                              foreach ($courses as $course) {
                                if ($course['course_id'] == $audio['course_id']) {
                                  $course_name = $course['course_name'];
                                  break;
                                }
                              }
                              
                              $uploaded_time = date('M j, Y', strtotime($audio['created_at']));
                            ?>
                              <tr>
                                <td>
                                  <div class="d-flex align-items-center">
                                    <div class="audio-thumbnail mr-3">
                                      <i class="fe fe-music"></i>
                                    </div>
                                    <div>
                                      <strong><?= htmlspecialchars($audio['title']) ?></strong><br>
                                      <small class="text-muted"><?= pathinfo($audio['file_path'], PATHINFO_EXTENSION) ?></small>
                                    </div>
                                  </div>
                                </td>
                                <td><?= htmlspecialchars($audio['subject'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($audio['topic'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($course_name ?: 'N/A') ?></td>
                                <td><?= htmlspecialchars($audio['folder_name'] ?: 'Root') ?></td>
                                <td>
                                  <span class="badge badge-<?= $audio['status'] == 'published' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($audio['status']) ?>
                                  </span>
                                </td>
                                <td><?= $uploaded_time ?></td>
                                <td>
                                  <button class="btn btn-sm btn-outline-primary play-audio" 
                                          data-audio="<?= htmlspecialchars($audio['file_path']) ?>"
                                          data-title="<?= htmlspecialchars($audio['title']) ?>"
                                          data-id="<?= $audio['id'] ?>">
                                    <i class="fe fe-play"></i>
                                  </button>
                                  <button class="btn btn-sm btn-outline-secondary edit-audio" 
                                          data-id="<?= $audio['id'] ?>"
                                          data-title="<?= htmlspecialchars($audio['title']) ?>"
                                          data-subject="<?= htmlspecialchars($audio['subject'] ?? '') ?>"
                                          data-topic="<?= htmlspecialchars($audio['topic'] ?? '') ?>"
                                          data-course="<?= $audio['course_id'] ?>"
                                          data-folder="<?= $audio['folder_id'] ?>"
                                          data-status="<?= $audio['status'] ?>">
                                    <i class="fe fe-edit-2"></i>
                                  </button>
                                  <button class="btn btn-sm btn-outline-danger delete-audio" 
                                          data-id="<?= $audio['id'] ?>"
                                          data-title="<?= htmlspecialchars($audio['title']) ?>">
                                    <i class="fe fe-trash-2"></i>
                                  </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    <?php else: ?>
                      <div class="alert alert-info">
                        No audio files found. Upload your first audio file using the button above.
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Upload Audio Modal -->
  <div class="modal fade" id="uploadAudioModal" tabindex="-1" role="dialog" aria-labelledby="uploadAudioModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadAudioModalLabel">Upload Audio File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="uploadAudioForm" method="post" enctype="multipart/form-data">
          <input type="hidden" name="action" value="upload_audio">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="audioTitle">Title *</label>
                  <input type="text" class="form-control" id="audioTitle" name="title" required>
                </div>
                
                <div class="form-group">
                  <label for="audioSubject">Subject</label>
                  <input type="text" class="form-control" id="audioSubject" name="subject">
                </div>
                
                <div class="form-group">
                  <label for="audioTopic">Topic</label>
                  <input type="text" class="form-control" id="audioTopic" name="topic">
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="audioCourse">Course</label>
                  <select class="form-control" id="audioCourse" name="course_id">
                    <option value="">-- Select Course --</option>
                    <?php foreach ($courses as $course): ?>
                      <option value="<?= $course['course_id'] ?>"><?= htmlspecialchars($course['course_name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="audioFolder">Folder</label>
                  <select class="form-control" id="audioFolder" name="folder_id">
                    <option value="">-- Select Folder --</option>
                    <?php foreach ($folders as $folder): ?>
                      <option value="<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="audioStatus">Status</label>
                  <select class="form-control" id="audioStatus" name="status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label>Audio File *</label>
              <div class="file-upload-container" id="fileUploadContainer">
                <input type="file" id="audioFile" name="audio_file" accept="audio/*" style="display: none;" required>
                <div id="fileUploadContent">
                  <i class="fe fe-upload fe-24 mb-3"></i>
                  <h5>Drag and drop audio file here</h5>
                  <p class="text-muted">or click to browse files</p>
                  <p class="small text-muted">Supported formats: MP3, WAV, OGG, M4A (Max 50MB)</p>
                </div>
                <div id="fileUploadPreview" class="file-upload-preview">
                  <audio controls class="w-100"></audio>
                  <p class="mt-2 mb-0"><strong id="fileName"></strong> (<span id="fileSize"></span>)</p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="upload-btn-text">Upload Audio</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Edit Audio Modal -->
  <div class="modal fade" id="editAudioModal" tabindex="-1" role="dialog" aria-labelledby="editAudioModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editAudioModalLabel">Edit Audio Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editAudioForm" method="post">
          <input type="hidden" name="action" value="update_audio">
          <input type="hidden" name="id" id="editAudioId">
          <div class="modal-body">
            <div class="form-group">
              <label for="editAudioTitle">Title *</label>
              <input type="text" class="form-control" id="editAudioTitle" name="title" required>
            </div>
            
            <div class="form-group">
              <label for="editAudioSubject">Subject</label>
              <input type="text" class="form-control" id="editAudioSubject" name="subject">
            </div>
            
            <div class="form-group">
              <label for="editAudioTopic">Topic</label>
              <input type="text" class="form-control" id="editAudioTopic" name="topic">
            </div>
            
            <div class="form-group">
              <label for="editAudioCourse">Course</label>
              <select class="form-control" id="editAudioCourse" name="course_id">
                <option value="">-- Select Course --</option>
                <?php foreach ($courses as $course): ?>
                  <option value="<?= $course['course_id'] ?>"><?= htmlspecialchars($course['course_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <div class="form-group">
              <label for="editAudioFolder">Folder</label>
              <select class="form-control" id="editAudioFolder" name="folder_id">
                <option value="">-- Select Folder --</option>
                <?php foreach ($folders as $folder): ?>
                  <option value="<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <div class="form-group">
              <label for="editAudioStatus">Status</label>
              <select class="form-control" id="editAudioStatus" name="status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="save-btn-text">Save Changes</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Delete Audio Modal -->
  <div class="modal fade" id="deleteAudioModal" tabindex="-1" role="dialog" aria-labelledby="deleteAudioModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteAudioModalLabel">Confirm Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteAudioForm" method="post">
          <input type="hidden" name="action" value="delete_audio">
          <input type="hidden" name="id" id="deleteAudioId">
          <div class="modal-body">
            <p>Are you sure you want to delete the audio file "<strong id="deleteAudioTitle"></strong>"?</p>
            <p class="text-danger">This action cannot be undone. All associated data will be permanently removed.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <span class="delete-btn-text">Delete Permanently</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Audio Player Modal -->
  <div class="modal fade" id="audioPlayerModal" tabindex="-1" role="dialog" aria-labelledby="audioPlayerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="audioPlayerModalLabel">Audio Player</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="audio-player-container">
            <h4 id="audioPlayerTitle"></h4>
            <audio controls id="modalAudioPlayer" class="w-100">
              Your browser does not support the audio element.
            </audio>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/daterangepicker.js"></script>
  <script src="../js/jquery.stickOnScroll.js"></script>
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
  
  <script>
  $(document).ready(function () {
    // Initialize DataTable
    var table = $('#audioTable').DataTable({
      order: [[6, 'desc']],
      responsive: true,
      dom: '<"top"lf>rt<"bottom"ip>',
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search audio files...",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        paginate: {
          previous: "Previous",
          next: "Next"
        }
      }
    });

    // Show toast notification if exists
    <?php if (isset($_SESSION['toast'])): ?>
      new Noty({
        type: '<?= $_SESSION['toast']['type'] ?>',
        text: '<?= $_SESSION['toast']['message'] ?>',
        timeout: 3000,
        progressBar: true,
        layout: 'topRight'
      }).show();
      <?php unset($_SESSION['toast']); ?>
    <?php endif; ?>

    // File upload drag and drop
    const fileUploadContainer = document.getElementById('fileUploadContainer');
    const fileInput = document.getElementById('audioFile');
    const fileUploadContent = document.getElementById('fileUploadContent');
    const fileUploadPreview = document.getElementById('fileUploadPreview');
    const audioPreview = fileUploadPreview.querySelector('audio');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    if (fileUploadContainer && fileInput) {
      fileUploadContainer.addEventListener('click', () => fileInput.click());

      fileInput.addEventListener('change', function (e) {
        if (this.files.length) {
          const file = this.files[0];
          updateFilePreview(file);
        }
      });

      fileUploadContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadContainer.classList.add('dragover');
      });

      fileUploadContainer.addEventListener('dragleave', () => {
        fileUploadContainer.classList.remove('dragover');
      });

      fileUploadContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadContainer.classList.remove('dragover');

        if (e.dataTransfer.files.length) {
          fileInput.files = e.dataTransfer.files;
          updateFilePreview(e.dataTransfer.files[0]);
        }
      });

      function updateFilePreview(file) {
        const maxSize = 50 * 1024 * 1024; // 50MB
        const validTypes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3', 'audio/x-m4a'];
        
        if (!validTypes.includes(file.type)) {
          alert('Invalid file type. Please upload an audio file (MP3, WAV, OGG, M4A).');
          return;
        }
        
        if (file.size > maxSize) {
          alert('File is too large. Maximum size is 50MB.');
          return;
        }

        const fileURL = URL.createObjectURL(file);
        audioPreview.src = fileURL;
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        fileUploadContent.style.display = 'none';
        fileUploadPreview.style.display = 'block';
      }

      function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
      }
    }

    // Play audio with proper error handling
    $(document).on('click', '.play-audio', function() {
      const audioPath = $(this).data('audio'); 
      const audioTitle = $(this).data('title');
      const audioUrl = audioPath.startsWith('/') ? 
          window.location.origin + audioPath : 
          audioPath;
      
      console.log("Attempting to play:", audioUrl);
      
      $.ajax({
          url: audioUrl,
          type: 'HEAD',
          success: function() {
              const player = document.getElementById('modalAudioPlayer');
              player.src = audioUrl;
              $('#audioPlayerTitle').text(audioTitle);
              $('#audioPlayerModal').modal('show');
              
              player.play().catch(e => console.error("Play failed:", e));
          },
          error: function() {
              alert("Audio file not found at:\n" + audioUrl);
          }
      });
    });

    // Edit audio
    $(document).on('click', '.edit-audio', function() {
      const id = $(this).data('id');
      const title = $(this).data('title');
      const subject = $(this).data('subject');
      const topic = $(this).data('topic');
      const course = $(this).data('course');
      const folder = $(this).data('folder');
      const status = $(this).data('status');

      $('#editAudioId').val(id);
      $('#editAudioTitle').val(title);
      $('#editAudioSubject').val(subject);
      $('#editAudioTopic').val(topic);
      $('#editAudioCourse').val(course);
      $('#editAudioFolder').val(folder);
      $('#editAudioStatus').val(status);

      $('#editAudioModal').modal('show');
    });

    // Delete audio
    $(document).on('click', '.delete-audio', function () {
      const id = $(this).data('id');
      const title = $(this).data('title');

      $('#deleteAudioId').val(id);
      $('#deleteAudioTitle').text(title);
      $('#deleteAudioModal').modal('show');
    });

    // Reset file upload modal
    $('#uploadAudioModal').on('hidden.bs.modal', function () {
      $('#uploadAudioForm')[0].reset();
      if (fileUploadContent) fileUploadContent.style.display = 'block';
      if (fileUploadPreview) fileUploadPreview.style.display = 'none';
      if (audioPreview) audioPreview.src = '';
    });

    // AJAX form submission with loading states
    $('#uploadAudioForm, #editAudioForm, #deleteAudioForm').on('submit', function (e) {
      e.preventDefault();
      const form = $(this);
      const formData = new FormData(this);
      const submitBtn = form.find('button[type="submit"]');
      const spinner = submitBtn.find('.spinner-border');
      const btnText = submitBtn.find('.upload-btn-text, .save-btn-text, .delete-btn-text');

      // Show loading state
      btnText.addClass('d-none');
      spinner.removeClass('d-none');
      submitBtn.prop('disabled', true);
      
      // Show global loading spinner
      $('#loadingSpinner').addClass('show');

      $.ajax({
        url: form.attr('action') || window.location.href,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          window.location.reload();
        },
        error: function (xhr, status, error) {
          // Reset button states
          btnText.removeClass('d-none');
          spinner.addClass('d-none');
          submitBtn.prop('disabled', false);
          
          // Hide global loading spinner
          $('#loadingSpinner').removeClass('show');
          
          let errorMsg = 'Error: ' + error;
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
          } else if (xhr.responseText) {
            errorMsg = xhr.responseText;
          }
          
          new Noty({
            type: 'error',
            text: errorMsg,
            timeout: 5000,
            progressBar: true,
            layout: 'topRight'
          }).show();
          
          console.error('AJAX Error:', error, xhr);
        }
      });
    });
  });
</script>

</body>
</html>