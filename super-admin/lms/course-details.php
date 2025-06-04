<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php 
require_once('../settings.php');


// Check if course ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: courses.php');
    exit();
}

$courseId = $_GET['id'];

// Get course details
try {
    $stmt = $pdo->prepare("
        SELECT c.*, ct.name as curriculum_type 
        FROM courses c
        JOIN curriculum_types ct ON c.curriculum_type_id = ct.id
        WHERE c.course_id = ?
    ");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        header('Location: courses.php');
        exit();
    }

    // Get topics for this course
    $stmt = $pdo->prepare("
        SELECT * FROM course_topics 
        WHERE course_id = ?
        ORDER BY `order` ASC, created_at ASC
    ");
    $stmt->execute([$courseId]);
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get materials for each topic
    foreach ($topics as &$topic) {
        $stmt = $pdo->prepare("
            SELECT * FROM course_materials 
            WHERE topic_id = ?
            ORDER BY `order` ASC, created_at ASC
        ");
        $stmt->execute([$topic['id']]);
        $topic['materials'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($topic); // Break the reference

} catch (PDOException $e) {
    die("Error fetching course details: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_topic'])) {
        // Add new topic
        try {
            $stmt = $pdo->prepare("
                INSERT INTO course_topics 
                (course_id, title, description, `order`) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $courseId,
                $_POST['topic_title'],
                $_POST['topic_description'] ?? null,
                $_POST['topic_order'] ?? 0
            ]);
            header("Location: course-details.php?id=$courseId");
            exit();
        } catch (PDOException $e) {
            $topicError = "Error adding topic: " . $e->getMessage();
        }
      } elseif (isset($_POST['add_material'])) {
        // Add new material
        try {
            // Validate topic_id exists and is a positive integer
            if (empty($_POST['topic_id']) || !ctype_digit($_POST['topic_id'])) {
                throw new Exception("Invalid topic ID specified");
            }
            $topic_id = (int)$_POST['topic_id'];
            
            $uploadPath = null;
            $externalUrl = null;
            
            // Get course folder path (relative to the root)
            $courseFolder = './uploads/courses/' . preg_replace('/[^a-zA-Z0-9-_]/', '_', $course['course_name']) . '_' . $courseId;
            
            if ($_POST['material_type'] != 'link' && !empty($_FILES['material_file']['name'])) {
                // Create course folder if it doesn't exist
                if (!file_exists($courseFolder)) {
                    if (!mkdir($courseFolder, 0777, true)) {
                        throw new Exception("Failed to create course folder: " . $courseFolder);
                    }
                }
                
                // Create subfolder by material type if it doesn't exist
                $typeFolder = $courseFolder . '/' . $_POST['material_type'] . 's';
                if (!file_exists($typeFolder)) {
                    if (!mkdir($typeFolder, 0777, true)) {
                        throw new Exception("Failed to create material type folder: " . $typeFolder);
                    }
                }
                
                $fileExt = pathinfo($_FILES['material_file']['name'], PATHINFO_EXTENSION);
                $fileName = 'material_' . time() . '_' . uniqid() . '.' . $fileExt;
                $targetPath = $typeFolder . '/' . $fileName;
                
                if (move_uploaded_file($_FILES['material_file']['tmp_name'], $targetPath)) {
                    // Store relative path (from the root) in database
                    $uploadPath = 'uploads/courses/' . preg_replace('/[^a-zA-Z0-9-_]/', '_', $course['course_name']) . '_' . $courseId . '/' . $_POST['material_type'] . 's/' . $fileName;
                } else {
                    throw new Exception("Failed to upload material file. Check folder permissions.");
                }
            } elseif ($_POST['material_type'] == 'link') {
                $externalUrl = $_POST['external_url'];
            }
            
            $stmt = $pdo->prepare("
                INSERT INTO course_materials 
                (topic_id, title, type, file_path, external_url, description, duration, `order`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $topic_id, // Use the validated integer value
                $_POST['material_title'],
                $_POST['material_type'],
                $uploadPath,
                $externalUrl,
                $_POST['material_description'] ?? null,
                $_POST['duration'] ?? null,
                $_POST['material_order'] ?? 0
            ]);
            
            header("Location: course-details.php?id=$courseId");
            exit();
        } catch (PDOException $e) {
            $materialError = "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            $materialError = $e->getMessage();
        }
    }
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
  <title><?= htmlspecialchars($course['course_name']) ?> - Admin | <?= $school_name ?></title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
  <style>
    .course-header {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 30px;
    }
    .course-thumbnail-lg {
      width: 100%;
      max-height: 300px;
      object-fit: cover;
      border-radius: 8px;
    }
    .topic-card {
      margin-bottom: 20px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .topic-card:hover {
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .topic-header {
      cursor: pointer;
      padding: 15px;
      background-color: #f1f1f1;
      border-radius: 8px 8px 0 0;
    }
    .material-item {
      padding: 10px;
      border-bottom: 1px solid #eee;
    }
    .material-item:last-child {
      border-bottom: none;
    }
    .material-icon {
      font-size: 1.5rem;
      margin-right: 10px;
    }
    .video-icon { color: #ff0000; }
    .pdf-icon { color: #d32f2f; }
    .audio-icon { color: #1976d2; }
    .link-icon { color: #4caf50; }
    .document-icon { color: #607d8b; }
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1100;
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
              <?php } else { ?><!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load the stickOnScroll plugin -->
<script src="path/to/jquery.stickOnScroll.js"></script>

<!-- Then your app code -->
<script src="js/apps.js"></script>

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
            <a class="nav-link text-primary" href="index.php">
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
            <a class="nav-link" href="classes.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Classes</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="nigerian-curriculum.php">
              <i class="fe fe-layers fe-16"></i>
              <span class="ml-3 item-text">curriculums</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="assignments.php">
              <i class="fe fe-edit fe-16"></i>
              <span class="ml-3 item-text">Assignments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
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

  <div class="wrapper">
    
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row align-items-center mb-4">
              <div class="col">
                <h2 class="h5 page-title">Course Details</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="courses.php">Courses</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($course['course_name']) ?></li>
                  </ol>
                </nav>
              </div>
              <div class="col-auto">
                <a href="courses.php" class="btn btn-secondary">
                  <i class="fe fe-arrow-left fe-12 mr-2"></i>Back to Courses
                </a>
              </div>
            </div>
            
            <div class="course-header">
              <div class="row">
                <div class="col-md-3">
                  <img src="<?= $course['thumbnail'] ? './' . htmlspecialchars($course['thumbnail']) : '../assets/images/default-course.jpg' ?>" 
                       alt="Course thumbnail" class="course-thumbnail-lg img-fluid">
                </div>
                <div class="col-md-9">
                  <h1><?= htmlspecialchars($course['course_name']) ?></h1>
                  <p class="lead"><?= htmlspecialchars($course['course_code']) ?></p>
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Curriculum Type:</strong> <?= htmlspecialchars($course['curriculum_type']) ?></p>
                      <p><strong>Level:</strong> <?= htmlspecialchars($course['level']) ?></p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Created:</strong> <?= date('M j, Y', strtotime($course['created_at'])) ?></p>
                      <p><strong>Last Updated:</strong> <?= date('M j, Y', strtotime($course['updated_at'])) ?></p>
                    </div>
                  </div>
                  <div class="mt-3">
                    <a href="edit-course.php?id=<?= $courseId ?>" class="btn btn-primary mr-2">
                      <i class="fe fe-edit fe-12 mr-2"></i>Edit Course
                    </a>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteCourseModal">
                      <i class="fe fe-trash-2 fe-12 mr-2"></i>Delete Course
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Course Description -->
            <div class="card shadow mb-4">
              <div class="card-header">
                <h3 class="card-title">Description</h3>
              </div>
              <div class="card-body">
                <?= $course['description'] ? nl2br(htmlspecialchars($course['description'])) : '<p class="text-muted">No description provided.</p>' ?>
              </div>
            </div>
            
            <!-- Course Topics -->
            <div class="card shadow mb-4">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Course Topics</h3>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addTopicModal">
                  <i class="fe fe-plus fe-12 mr-2"></i>Add Topic
                </button>
              </div>
              <div class="card-body">
                <?php if (empty($topics)): ?>
                  <p class="text-muted">No topics added yet.</p>
                <?php else: ?>
                  <div class="accordion" id="topicsAccordion">
                    <?php foreach ($topics as $topic): ?>
                      <div class="topic-card card mb-2">
                        <div class="topic-header d-flex justify-content-between align-items-center" 
                             id="topicHeading<?= $topic['id'] ?>" 
                             data-toggle="collapse" 
                             data-target="#topicCollapse<?= $topic['id'] ?>" 
                             aria-expanded="true" 
                             aria-controls="topicCollapse<?= $topic['id'] ?>">
                          <h4 class="mb-0"><?= htmlspecialchars($topic['title']) ?></h4>
                          <div>
                            <span class="badge badge-light"><?= count($topic['materials']) ?> materials</span>
                            <i class="fe fe-chevron-down"></i>
                          </div>
                        </div>
                        
                        <div id="topicCollapse<?= $topic['id'] ?>" class="collapse" aria-labelledby="topicHeading<?= $topic['id'] ?>" data-parent="#topicsAccordion">
                          <div class="card-body">
                            <?php if ($topic['description']): ?>
                              <p><?= nl2br(htmlspecialchars($topic['description'])) ?></p>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                              <h5>Materials</h5>
                              <button class="btn btn-sm btn-success" 
                                      data-toggle="modal" 
                                      data-target="#addMaterialModal"
                                      data-topic-id="<?= $topic['id'] ?>"
                                      data-topic-title="<?= htmlspecialchars($topic['title']) ?>">
                                <i class="fe fe-plus fe-12 mr-1"></i>Add Material
                              </button>
                            </div>
                            
                            <?php if (empty($topic['materials'])): ?>
                              <p class="text-muted">No materials added for this topic.</p>
                            <?php else: ?>
                              <div class="list-group">
                                <?php foreach ($topic['materials'] as $material): ?>
                                  <div class="material-item list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                      <?php 
                                      $iconClass = '';
                                      $icon = '';
                                      switch ($material['type']) {
                                        case 'video':
                                          $iconClass = 'video-icon';
                                          $icon = 'fe fe-film';
                                          break;
                                        case 'pdf':
                                          $iconClass = 'pdf-icon';
                                          $icon = 'fe fe-file-text';
                                          break;
                                        case 'audio':
                                          $iconClass = 'audio-icon';
                                          $icon = 'fe fe-music';
                                          break;
                                        case 'link':
                                          $iconClass = 'link-icon';
                                          $icon = 'fe fe-link';
                                          break;
                                        default:
                                          $iconClass = 'document-icon';
                                          $icon = 'fe fe-file';
                                      }
                                      ?>
                                      <div class="material-icon <?= $iconClass ?>">
                                        <i class="<?= $icon ?>"></i>
                                      </div>
                                      <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($material['title']) ?></h6>
                                        <small class="text-muted">
                                          <?php if ($material['type'] == 'link'): ?>
                                            <a href="<?= htmlspecialchars($material['external_url']) ?>" target="_blank">
                                              <?= htmlspecialchars($material['external_url']) ?>
                                            </a>
                                          <?php else: ?>
                                            <?= ucfirst($material['type']) ?> 
                                            <?php if ($material['duration']): ?>
                                              • <?= $material['duration'] ?> min
                                            <?php endif; ?>
                                          <?php endif; ?>
                                        </small>
                                      </div>
                                      <div>
                                        <?php if ($material['type'] != 'link' && $material['file_path']): ?>
                                          <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                             class="btn btn-sm btn-outline-success mr-1" 
                                             target="_blank">
                                            <i class="fe fe-download"></i>
                                          </a>
                                        <?php endif; ?>
                                        <a href="#" class="btn btn-sm btn-outline-primary mr-1 edit-material"
                                           data-id="<?= $material['id'] ?>"
                                           data-title="<?= htmlspecialchars($material['title']) ?>"
                                           data-type="<?= $material['type'] ?>"
                                           data-file-path="<?= htmlspecialchars($material['file_path'] ?? '') ?>"
                                           data-external-url="<?= htmlspecialchars($material['external_url'] ?? '') ?>"
                                           data-description="<?= htmlspecialchars($material['description'] ?? '') ?>"
                                           data-duration="<?= $material['duration'] ?? '' ?>"
                                           data-order="<?= $material['order'] ?? '' ?>">
                                          <i class="fe fe-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger delete-material"
                                           data-id="<?= $material['id'] ?>">
                                          <i class="fe fe-trash-2"></i>
                                        </a>
                                      </div>
                                    </div>
                                    <?php if ($material['description']): ?>
                                      <div class="mt-2">
                                        <p class="mb-0 small"><?= nl2br(htmlspecialchars($material['description'])) ?></p>
                                      </div>
                                    <?php endif; ?>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Add Topic Modal -->
  <div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog" aria-labelledby="addTopicModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document"> <!-- Changed to modal-lg for larger size -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTopicModalLabel">Add New Topic</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="">
          <input type="hidden" name="add_topic" value="1">
          <div class="modal-body">
            <div class="form-group">
              <label for="topicTitle">Topic Title *</label>
              <input type="text" class="form-control" id="topicTitle" name="topic_title" required>
            </div>
            <div class="form-group">
              <label for="topicDescription">Description</label>
              <textarea class="form-control" id="topicDescription" name="topic_description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="topicOrder">Order</label>
              <input type="number" class="form-control" id="topicOrder" name="topic_order" min="0" value="0">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Topic</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add Material Modal -->
  <div class="modal fade" id="addMaterialModal" tabindex="-1" role="dialog" aria-labelledby="addMaterialModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document"> <!-- Changed to modal-lg for larger size -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addMaterialModalLabel">Add Material to <span id="materialTopicTitle"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="add_material" value="1">
          <input type="hidden" name="topic_id" id="materialTopicId">

          <div class="modal-body">
            <div class="form-group">
              <label for="materialTitle">Material Title *</label>
              <input type="text" class="form-control" id="materialTitle" name="material_title" required>
            </div>
            <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d H:i:s'); ?>">

            <div class="form-group">
              <label for="materialType">Type *</label>
              <select class="form-control" id="materialType" name="material_type" required>
                <option value="">Select Type</option>
                <option value="video">Video</option>
                <option value="pdf">PDF</option>
                <option value="audio">Audio</option>
                <option value="link">External Link</option>
                <option value="document">Document</option>
              </select>
            </div>
            <div class="form-group" id="fileUploadGroup">
              <label for="materialFile">File *</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="materialFile" name="material_file">
                <label class="custom-file-label" for="materialFile">Choose file</label>
              </div>
            </div>
            <div class="form-group d-none" id="externalUrlGroup">
              <label for="externalUrl">External URL *</label>
              <input type="url" class="form-control" id="externalUrl" name="external_url">
            </div>
            <div class="form-group">
              <label for="duration">Duration (minutes)</label>
              <input type="number" class="form-control" id="duration" name="duration" min="1">
            </div>
            <div class="form-group">
              <label for="materialDescription">Description</label>
              <textarea class="form-control" id="materialDescription" name="material_description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="materialOrder">Order</label>
              <input type="number" class="form-control" id="materialOrder" name="material_order" min="0" value="0">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Material</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Material Modal -->
  <div class="modal fade" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMaterialModalLabel">Edit Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="update-material.php" enctype="multipart/form-data">
          <input type="hidden" name="material_id" id="editMaterialId">
          <input type="hidden" name="course_id" value="<?= $courseId ?>">
          <div class="modal-body">
            <div class="form-group">
              <label for="editMaterialTitle">Material Title *</label>
              <input type="text" class="form-control" id="editMaterialTitle" name="material_title" required>
            </div>
            <div class="form-group">
              <label for="editMaterialType">Type *</label>
              <select class="form-control" id="editMaterialType" name="material_type" required>
                <option value="video">Video</option>
                <option value="pdf">PDF</option>
                <option value="audio">Audio</option>
                <option value="link">External Link</option>
                <option value="document">Document</option>
              </select>
            </div>
            <div class="form-group" id="editFileUploadGroup">
              <label for="editMaterialFile">File</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="editMaterialFile" name="material_file">
                <label class="custom-file-label" for="editMaterialFile">Choose new file (leave blank to keep current)</label>
              </div>
              <small class="form-text text-muted" id="currentFilePath"></small>
            </div>
            <div class="form-group d-none" id="editExternalUrlGroup">
              <label for="editExternalUrl">External URL *</label>
              <input type="url" class="form-control" id="editExternalUrl" name="external_url">
            </div>
            <div class="form-group">
              <label for="editDuration">Duration (minutes)</label>
              <input type="number" class="form-control" id="editDuration" name="duration" min="1">
            </div>
            <div class="form-group">
              <label for="editMaterialDescription">Description</label>
              <textarea class="form-control" id="editMaterialDescription" name="material_description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="editMaterialOrder">Order</label>
              <input type="number" class="form-control" id="editMaterialOrder" name="material_order" min="0">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Material</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Material Modal -->
  <div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog" aria-labelledby="deleteMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteMaterialModalLabel">Confirm Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="delete-material.php">
          <input type="hidden" name="material_id" id="deleteMaterialId">
          <input type="hidden" name="course_id" value="<?= $courseId ?>">
          <div class="modal-body">
            <p>Are you sure you want to delete this material?</p>
            <p class="text-danger"><strong>Note:</strong> This action cannot be undone.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete Material</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Course Modal -->
  <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteCourseModalLabel">Confirm Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="delete-course.php">
          <input type="hidden" name="course_id" value="<?= $courseId ?>">
          <div class="modal-body">
            <p>Are you sure you want to delete the course "<?= htmlspecialchars($course['course_name']) ?>"?</p>
            <p class="text-danger"><strong>Warning:</strong> This will also delete all topics and materials associated with this course.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete Course</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toastContainer" style="position: fixed; bottom: 20px; right: 20px; z-index: 1100;"></div>
<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load the stickOnScroll plugin -->
<script src="path/to/jquery.stickOnScroll.js"></script>

<!-- Then your app code -->
<script src="js/apps.js"></script>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/apps.js"></script>
  
  <script>
    $(document).ready(function() {
      // Handle material type change in add modal
      $('#materialType').change(function() {
        if ($(this).val() === 'link') {
          $('#fileUploadGroup').addClass('d-none');
          $('#externalUrlGroup').removeClass('d-none');
          $('#externalUrl').prop('required', true);
          $('#materialFile').prop('required', false);
        } else {
          $('#fileUploadGroup').removeClass('d-none');
          $('#externalUrlGroup').addClass('d-none');
          $('#externalUrl').prop('required', false);
          $('#materialFile').prop('required', true);
        }
      });
      
      // Handle material type change in edit modal
      $('#editMaterialType').change(function() {
        if ($(this).val() === 'link') {
          $('#editFileUploadGroup').addClass('d-none');
          $('#editExternalUrlGroup').removeClass('d-none');
          $('#editExternalUrl').prop('required', true);
        } else {
          $('#editFileUploadGroup').removeClass('d-none');
          $('#editExternalUrlGroup').addClass('d-none');
          $('#editExternalUrl').prop('required', false);
        }
      });
      
      // Handle add material modal opening
      $('#addMaterialModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var topicId = button.data('topic-id');
        var topicTitle = button.data('topic-title');
        
        var modal = $(this);
        modal.find('#materialTopicId').val(topicId);
        modal.find('#materialTopicTitle').text(topicTitle);
        
        // Reset form
        modal.find('form')[0].reset();
        $('#fileUploadGroup').removeClass('d-none');
        $('#externalUrlGroup').addClass('d-none');
        $('#externalUrl').prop('required', false);
        $('#materialFile').prop('required', true);
      });
      
      // Handle edit material button click
      $(document).on('click', '.edit-material', function(e) {
        e.preventDefault();
        
        var materialId = $(this).data('id');
        var materialTitle = $(this).data('title');
        var materialType = $(this).data('type');
        var filePath = $(this).data('file-path');
        var externalUrl = $(this).data('external-url');
        var description = $(this).data('description');
        var duration = $(this).data('duration');
        var order = $(this).data('order');
        
        $('#editMaterialId').val(materialId);
        $('#editMaterialTitle').val(materialTitle);
        $('#editMaterialType').val(materialType);
        $('#editDuration').val(duration);
        $('#editMaterialDescription').val(description);
        $('#editMaterialOrder').val(order);
        
        if (materialType === 'link') {
          $('#editFileUploadGroup').addClass('d-none');
          $('#editExternalUrlGroup').removeClass('d-none');
          $('#editExternalUrl').val(externalUrl);
        } else {
          $('#editFileUploadGroup').removeClass('d-none');
          $('#editExternalUrlGroup').addClass('d-none');
          $('#currentFilePath').text('Current file: ' + (filePath || 'None'));
        }
        
        $('#editMaterialModal').modal('show');
      });

      // Handle delete material button click
      $(document).on('click', '.delete-material', function(e) {
        e.preventDefault();
        
        var materialId = $(this).data('id');
        $('#deleteMaterialId').val(materialId);
        $('#deleteMaterialModal').modal('show');
      });
      
      // Custom file input
      $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
      
      // Handle form submissions with AJAX
      $('#editMaterialModal form, #deleteMaterialModal form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(form[0]); // Use FormData to handle file uploads
        var submitBtn = form.find('button[type="submit"]');
        
        // Disable submit button to prevent multiple submissions
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
        
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showToast('success', response.message);
                    // Redirect after 1.5 seconds
                    setTimeout(function() {
                        window.location.href = response.redirect || 'course-details.php?id=<?= $courseId ?>';
                    }, 1500);
                } else {
                    // Show error message
                    showToast('danger', response.message);
                }
            },
            error: function(xhr) {
                var errorMessage = 'An error occurred';
                try {
                    var response = JSON.parse(xhr.responseText);
                    errorMessage = response.message || errorMessage;
                } catch (e) {
                    errorMessage = xhr.statusText || errorMessage;
                }
                showToast('danger', errorMessage);
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.html(form.attr('id').includes('delete') ? 'Delete Material' : 'Update Material');
            }
        });
      });
      
      // Show error messages if they exist
      <?php if (isset($topicError)): ?>
        showToast('danger', '<?= addslashes($topicError) ?>');
      <?php endif; ?>
      
      <?php if (isset($materialError)): ?>
        showToast('danger', '<?= addslashes($materialError) ?>');
        $('#addMaterialModal').modal('show');
      <?php endif; ?>
      
      // Toast notification function
      function showToast(type, message) {
          var toast = $('<div class="toast align-items-center text-white bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
                       '<div class="d-flex">' +
                       '<div class="toast-body">' + message + '</div>' +
                       '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                       '</div></div>');
          
          $('#toastContainer').append(toast);
          var bsToast = new bootstrap.Toast(toast[0]);
          bsToast.show();
          
          // Remove toast after it hides
          toast.on('hidden.bs.toast', function() {
              $(this).remove();
          });
      }
    });
    console.log("Setting topic_id:", topicId);

  </script>
</body>
</html>