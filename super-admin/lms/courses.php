<?php require_once('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Courses Management - Admin | <?= $school_name ?></title>
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
    .card {
      border-radius: 8px;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card-icon {
      font-size: 2rem;
      opacity: 0.3;
    }

    .action-buttons .btn {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }

    .modal-xl {
      max-width: 90%;
      /* Adjust width as needed */
    }
  </style>
</head>

<body class="vertical light">
  <div class="wrapper">
    <!-- Alert Container -->
    <div class="alert-container"></div>

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
        <!-- <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p> -->
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-home fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
            </a>
          </li>
        </ul>

        <!-- LMS -->
        <!-- <p class="text-muted nav-heading mt-4 mb-1">
          <span>Learning Management</span>
        </p> -->
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="courses.php">
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
              <span class="ml-3 item-text">Curriculums</span>
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="file-manager.php">
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
                <h2 class="h5 page-title">Courses Management</h2>
              </div>
              <div class="col-auto">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">
                  <i class="fe fe-plus fe-12 mr-2"></i>Add New Course
                </button>
              </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="row mb-4">
              <?php
              // Get statistics data
              try {
                // Total Courses
                $stmt = $pdo->query("SELECT COUNT(*) as total_courses FROM courses");
                $total_courses = $stmt->fetch(PDO::FETCH_ASSOC)['total_courses'];

                // Total Students Enrolled
                $stmt = $pdo->query("SELECT COUNT(DISTINCT student_id) as total_students FROM student_courses");
                $total_students = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'] ?? 0;

              } catch (PDOException $e) {
                // Default values if query fails
                $total_courses = 0;
                $total_students = 0;
              }
              ?>

              <!-- Total Courses Card -->
              <div class="col-md-6 col-xl-6 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Courses</p>
                        <h3 class="mb-0"><?= number_format($total_courses) ?></h3>
                        <p class="mb-0 text-success">
                          <span class="text-muted">Available courses</span>
                        </p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-book fe-32 text-primary stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Students Enrolled Card -->
              <div class="col-md-6 col-xl-6 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Students Enrolled</p>
                        <h3 class="mb-0"><?= number_format($total_students) ?></h3>
                        <p class="mb-0 text-success">
                          <span class="text-muted">Active enrollments</span>
                        </p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-users fe-32 text-warning stat-card-icon"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Courses Table -->
            <div class="row">
              <div class="col-md-12 mb-4">
                <div class="card shadow">
                  <div class="card-header">
                    <strong class="card-title">All Courses</strong>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover" id="coursesTable">
                        <thead class="thead-light">
                          <tr>
                            <th>Thumbnail</th>
                            <th>Course Name</th>
                            <th>Subject</th>
                            <th>Class Level</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Get all courses
                          try {
                            $stmt = $pdo->query("
                              SELECT c.*, ct.name as curriculum_type
                              FROM courses c
                              LEFT JOIN curriculum_types ct ON c.curriculum_type_id = ct.id
                              ORDER BY c.created_at DESC
                            ");
                            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (empty($courses)) {
                              echo '<tr><td colspan="7" class="text-center text-muted">No courses found.</td></tr>';
                            } else {
                              foreach ($courses as $course) {
                                $thumbnail = !empty($course['thumbnail']) ? '../' . $course['thumbnail'] : '../assets/images/default-course.jpg';
                                echo '
                                <tr>
                                  <td><img src="' . $thumbnail . '" alt="Course thumbnail" style="max-width: 80px; border-radius: 5px;"></td>
                                  <td>' . htmlspecialchars($course['course_name'] ?? '') . '</td>
                                  <td>' . htmlspecialchars($course['subject'] ?? '') . '</td>
                                  <td>' . htmlspecialchars($course['class_level'] ?? '') . '</td>
                                  <td>' . htmlspecialchars($course['description'] ?? '') . '</td>
                                  <td>' . ucfirst($course['status'] ?? 'active') . '</td>
                                  <td class="action-buttons">
                                    <a href="course-details.php?id=' . ($course['course_id'] ?? '') . '" class="btn btn-sm btn-info">
                                      <i class="fe fe-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-primary edit-course" 
                                            data-id="' . ($course['course_id'] ?? '') . '"
                                            data-name="' . htmlspecialchars($course['course_name'] ?? '') . '"
                                            data-code="' . htmlspecialchars($course['course_code'] ?? '') . '"
                                            data-subject="' . htmlspecialchars($course['subject'] ?? '') . '"
                                            data-level="' . htmlspecialchars($course['level'] ?? '') . '"
                                            data-class="' . htmlspecialchars($course['class_level'] ?? '') . '"
                                            data-description="' . htmlspecialchars($course['description'] ?? '') . '"
                                            data-status="' . htmlspecialchars($course['status'] ?? 'active') . '"
                                            data-thumbnail="' . htmlspecialchars($course['thumbnail'] ?? '') . '"
                                            data-curriculum-type="' . htmlspecialchars($course['curriculum_type_id'] ?? '') . '">
                                      <i class="fe fe-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-course" 
                                            data-id="' . ($course['course_id'] ?? '') . '">
                                      <i class="fe fe-trash-2"></i>
                                    </button>
                                  </td>
                                </tr>';
                              }
                            }
                          } catch (PDOException $e) {
                            echo '<tr><td colspan="7" class="text-center text-muted">Unable to load courses.</td></tr>';
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

  <!-- Add Course Modal -->
  <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addCourseForm" method="post" action="save-course.php" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="courseName">Course Name *</label>
                  <input type="text" class="form-control" id="courseName" name="course_name" required>
                </div>
                <div class="form-group">
                  <label for="courseCode">Course Code *</label>
                  <input type="text" class="form-control" id="courseCode" name="course_code" required>
                </div>
                <div class="form-group">
                  <label for="curriculumType">Curriculum Type *</label>
                  <select class="form-control" id="curriculumType" name="curriculum_type_id" required>
                    <option value="">Select Type</option>
                    <?php
                    // Get curriculum types from database
                    try {
                      $stmt = $pdo->query("SELECT id, name FROM curriculum_types ORDER BY name");
                      $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      foreach ($types as $type) {
                        echo '<option value="' . $type['id'] . '">' . htmlspecialchars($type['name']) . '</option>';
                      }
                    } catch (PDOException $e) {
                      // Handle error
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="level">Level *</label>
                  <input type="text" class="form-control" id="level" name="level" required>
                </div>
                <div class="form-group">
                  <label for="thumbnail">Course Thumbnail</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" accept="image/*">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                  </div>
                  <small class="form-text text-muted">Recommended size: 600x400 pixels</small>
                  <div id="thumbnailPreview" class="preview-thumbnail d-none"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="thumbnail">Course Thumbnail</label>
              <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" accept="image/*">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="saveCourseBtn">Save Course</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Course Modal -->
  <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editCourseForm" method="post" action="update-course.php" enctype="multipart/form-data">
          <input type="hidden" id="editCourseId" name="course_id">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="editCourseName">Course Name *</label>
                  <input type="text" class="form-control" id="editCourseName" name="course_name" required>
                </div>
                <div class="form-group">
                  <label for="editCourseCode">Course Code *</label>
                  <input type="text" class="form-control" id="editCourseCode" name="course_code" required>
                </div>
                <div class="form-group">
                  <label for="editCurriculumType">Curriculum Type *</label>
                  <select class="form-control" id="editCurriculumType" name="curriculum_type_id" required>
                    <?php
                    // Get curriculum types from database
                    try {
                      $stmt = $pdo->query("SELECT id, name FROM curriculum_types ORDER BY name");
                      $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      foreach ($types as $type) {
                        echo '<option value="' . $type['id'] . '">' . htmlspecialchars($type['name']) . '</option>';
                      }
                    } catch (PDOException $e) {
                      // Handle error
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="editLevel">Level *</label>
                  <input type="text" class="form-control" id="editLevel" name="level" required>
                </div>
                <div class="form-group">
                  <label for="editThumbnail">Course Thumbnail</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="editThumbnail" name="thumbnail" accept="image/*">
                    <label class="custom-file-label" for="editThumbnail">Choose file</label>
                  </div>
                  <small class="form-text text-muted">Leave blank to keep current thumbnail</small>
                  <div id="editThumbnailPreview" class="preview-thumbnail"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="editDescription">Description</label>
              <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="editThumbnail">Course Thumbnail</label>
              <input type="file" class="form-control-file" id="editThumbnail" name="thumbnail" accept="image/*">
              <small class="form-text text-muted">Leave blank to keep current thumbnail</small>
              <div id="editThumbnailPreview" class="mt-2"></div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="updateCourseBtn">Update Course</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="deleteCourseModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteCourseModalLabel">Confirm Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteCourseForm" method="post" action="delete-course.php">
          <input type="hidden" id="deleteCourseId" name="course_id">
          <div class="modal-body">
            <p>Are you sure you want to delete this course? This action cannot be undone.</p>
            <p class="text-danger"><strong>Warning:</strong> All related topics, materials, and enrollments will also be
              deleted.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete Course</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include('./lms-footer.php'); ?>
  <!-- Scripts -->
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
  <script src="../js/select2.min.js"></script>
  <script src="../js/apps.js"></script>

  <script>
$(document).ready(function() {
    // Initialize DataTable
    $('#coursesTable').DataTable({
        autoWidth: true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });
    
    // Thumbnail preview for add course
    $('#thumbnail').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnailPreview').html('<img src="' + e.target.result + '" class="img-fluid" style="max-height: 150px;">')
                                    .removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Thumbnail preview for edit course
    $('#editThumbnail').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#editThumbnailPreview').html('<img src="' + e.target.result + '" class="img-fluid" style="max-height: 150px;">');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Edit Course Button Click
    $('.edit-course').click(function() {
        var courseId = $(this).data('id');
        var courseName = $(this).data('name');
        var courseCode = $(this).data('code');
        var subject = $(this).data('subject');
        var level = $(this).data('level');
        var classLevel = $(this).data('class');
        var description = $(this).data('description');
        var status = $(this).data('status');
        var thumbnail = $(this).data('thumbnail');
        
        $('#editCourseId').val(courseId);
        $('#editCourseName').val(courseName);
        $('#editCourseCode').val(courseCode);
        $('#editSubject').val(subject);
        $('#editLevel').val(level);
        $('#editClassLevel').val(classLevel);
        $('#editDescription').val(description);
        
        // Set thumbnail preview if exists
        if (thumbnail) {
            $('#editThumbnailPreview').html('<img src="../' + thumbnail + '" class="img-fluid" style="max-height: 150px;">');
        } else {
          $('#editThumbnailPreview').html('');
        }
        
        $('#editCourseModal').modal('show');
    });
    
    // Delete Course Button Click
    $('.delete-course').click(function() {
        var courseId = $(this).data('id');
        $('#deleteCourseId').val(courseId);
        $('#deleteCourseModal').modal('show');
    });
    
    // Form submission handling with AJAX
    $('#addCourseForm, #editCourseForm, #deleteCourseForm').submit(function(e) {
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
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.success) {
                    // Show success message with toast notification
                    showToast('success', response.message);
                    // Reload the page after 1.5 seconds to see changes
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    // Show error message
                    showToast('danger', response.message || 'An error occurred');
                }
            },
            error: function(xhr, status, error) {
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
                submitBtn.html(form.attr('id') === 'deleteCourseForm' ? 'Delete Course' : 'Save Course');
            }
        });
    });
    
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
    
    // Add toast container if it doesn't exist
    if ($('#toastContainer').length === 0) {
        $('body').append('<div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>');
    }
});
</script>
<?php require_once('./lms-footer.php'); ?>
<!-- </body>
</html> -->