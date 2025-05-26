<?php
require("../settings.php");


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get user details from session
$user_id = $_SESSION['user_id'];
$full_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Guest';
$account_type = $_SESSION['account_type'];
$gender = $_SESSION['gender'] ?? 'Male';

// Check required parameters
if (!isset($_GET['subtopic']) || !isset($_GET['class']) || !isset($_GET['subject']) || !isset($_GET['topic'])) {
    die("Missing required parameters");
}

$class = $_GET['class'];
$subject = $_GET['subject'];
$topic = $_GET['topic'];
$subtopic = $_GET['subtopic'];

// Initialize variables
$content = '';
$is_new_generation = false;
$content_id = null;

try {
    // Check if content exists in database
    $stmt = $pdo->prepare("SELECT * FROM curriculum_contents WHERE class = :class AND subject = :subject AND topic = :topic AND subtopic = :subtopic");
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
    $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
    $stmt->execute();

    $contentRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($contentRow) {
        $content = $contentRow['content'];
        $content_id = $contentRow['id'];
    } else {
        $is_new_generation = true;
        
        // Generate new content
        $userMessage = "Generate comprehensive lesson content for $class students about:\n\nTopic: $topic\nSubtopic: $subtopic\n\n" .
                     "Include detailed explanations, examples, activities, and assessments.";

        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You're an expert teacher creating detailed lesson content for $class students."
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage
                ]
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/accounts/d1e60664f7c51233c8e7a57dfac06c45/ai/run/@cf/meta/llama-3-8b-instruct",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
            throw new Exception('API Error: ' . curl_error($curl));
        }

        $responseData = json_decode($response, true);
        
        if (!isset($responseData['result']['response'])) {
            throw new Exception('Invalid API response format');
        }

        $content = $responseData['result']['response'];

        // Save to database
        $stmt = $pdo->prepare("INSERT INTO curriculum_contents (class, subject, topic, subtopic, content) 
                              VALUES (:class, :subject, :topic, :subtopic, :content)");
        $stmt->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
        $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
        
        $content_id = $pdo->lastInsertId();

        curl_close($curl);
    }
} catch (Exception $e) {
    $content = '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
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
  <title>Lesson Content - <?= htmlspecialchars("$subject: $topic") ?> | Rinda AMS</title>
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
    .editor-container {
      min-height: 500px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
    }
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255,255,255,0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .alert-auto-close {
      animation: fadeOut 5s forwards;
      animation-delay: 3s;
    }
    @keyframes fadeOut {
      to { opacity: 0; visibility: hidden; }
    }
  </style>
</head>
<body class="vertical light">
  <?php if ($is_new_generation): ?>
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
  </div>
  <?php endif; ?>

  <div class="wrapper">
    <nav class="topnav navbar navbar-light">
      <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
      </button>
      <form class="form-inline mr-auto searchform text-muted">
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Search..." aria-label="Search">
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
              <p style="padding: 0%; margin: 0%;"><?= htmlspecialchars($full_name) ?></p>
              <strong><?= htmlspecialchars($account_type) ?></strong>
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
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
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
            <a class="nav-link" href="dashboard.php">
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
      
          <li class="nav-item active">
            <a class="nav-link text-primary" href="nigerian-curriculum.php">
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
            <h2 class="page-title">Lesson Content</h2>
            <p class="text-muted"><?= htmlspecialchars("$subject - $topic - $subtopic") ?></p>

            <?php if ($is_new_generation): ?>
            <div class="alert alert-success alert-auto-close">
              <i class="fe fe-check-circle mr-2"></i> New content generated successfully!
            </div>
            <?php endif; ?>

            <div class="row mb-4">
              <div class="col-md-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h5 class="card-title mb-0">
                      <?= htmlspecialchars("$subject - $topic - $subtopic") ?>
                      <span class="badge badge-primary float-right"><?= htmlspecialchars($class) ?></span>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <button id="regenerateBtn" class="btn btn-outline-secondary">
                          <i class="fe fe-refresh-cw mr-2"></i>Regenerate Content
                        </button>
                      </div>
                      <div class="col-md-6 text-right">
                        <button id="exportPdfBtn" class="btn btn-outline-danger mr-2">
                          <i class="fe fe-download mr-2"></i>Export PDF
                        </button>
                        <button id="exportDocBtn" class="btn btn-outline-primary">
                          <i class="fe fe-download mr-2"></i>Export Word
                        </button>
                      </div>
                    </div>
                    
                    <!-- Editor container -->
                    <div id="editor" class="editor-container">
                      <?= $content ?>
                    </div>
                    
                    <div class="row mt-3">
                      <div class="col-md-12 text-right">
                        <button id="saveBtn" class="btn btn-primary">
                          <i class="fe fe-save mr-2"></i>Save Content
                        </button>
                      </div>
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

  <!-- Scripts -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/quill.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  
  <script>
    // Initialize Quill editor
    var quill = new Quill('#editor', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['link', 'image'],
          ['clean']
        ]
      }
    });

    // Hide loading overlay once content loads
    window.addEventListener('load', function() {
      setTimeout(() => {
        document.getElementById('loadingOverlay')?.remove();
        document.querySelector('.alert-auto-close')?.remove();
      }, 3000);
    });

    // Save content
    $('#saveBtn').click(function() {
      const content = quill.root.innerHTML;
      const $btn = $(this);
      
      $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
      
      $.ajax({
        url: 'save_curriculum_content.php',
        type: 'POST',
        dataType: 'json',
        data: {
          content_id: <?= $content_id ?: 'null' ?>,
          class: '<?= $class ?>',
          subject: '<?= $subject ?>',
          topic: '<?= $topic ?>',
          subtopic: '<?= $subtopic ?>',
          content: content
        },
        success: function(response) {
          if (response.success) {
            alert('Content saved successfully!');
          } else {
            alert('Error: ' + (response.message || 'Failed to save'));
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
          alert('Error saving content. Check console for details.');
        },
        complete: function() {
          $btn.prop('disabled', false).html('<i class="fe fe-save mr-2"></i>Save Content');
        }
      });
    });

    // Regenerate content
    $('#regenerateBtn').click(function() {
      if (confirm('Are you sure you want to regenerate this content? Your changes will be lost.')) {
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Regenerating...');
        
        // Show loading overlay
        $('body').append('<div class="loading-overlay" id="regenOverlay"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div>');
        
        $.ajax({
          url: 'regenerate_content.php',
          type: 'POST',
          dataType: 'json',
          data: {
            class: '<?= $class ?>',
            subject: '<?= $subject ?>',
            topic: '<?= $topic ?>',
            subtopic: '<?= $subtopic ?>'
          },
          success: function(response) {
            if (response.success) {
              quill.setContents([]);
              quill.clipboard.dangerouslyPasteHTML(response.content);
              alert('Content regenerated successfully!');
            } else {
              alert('Error: ' + (response.message || 'Failed to regenerate'));
            }
          },
          error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error regenerating content. Check console for details.');
          },
          complete: function() {
            $btn.prop('disabled', false).html('<i class="fe fe-refresh-cw mr-2"></i>Regenerate Content');
            $('#regenOverlay').remove();
          }
        });
      }
    });

    // Export to PDF
    $('#exportPdfBtn').click(function() {
      const { jsPDF } = window.jspdf;
      const content = $('#editor').html();
      
      // Create temporary div for PDF generation
      const tempDiv = document.createElement('div');
      tempDiv.style.width = '800px';
      tempDiv.style.padding = '20px';
      tempDiv.style.position = 'absolute';
      tempDiv.style.left = '-9999px';
      tempDiv.innerHTML = `
        <h1 style="text-align:center"><?= $subject ?> Lesson Content</h1>
        <h3 style="text-align:center"><?= $topic ?> - <?= $subtopic ?></h3>
        <p><strong>Class:</strong> <?= $class ?></p>
        <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
        <hr>
        ${content}
      `;
      
      document.body.appendChild(tempDiv);
      
      html2canvas(tempDiv).then(canvas => {
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 190;
        const imgHeight = canvas.height * imgWidth / canvas.width;
        
        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        pdf.save('LessonContent_<?= $subject ?>_<?= $topic ?>.pdf');
        document.body.removeChild(tempDiv);
      });
    });

    // Export to Word
    $('#exportDocBtn').click(function() {
      const content = $('#editor').html();
      const blob = new Blob([`
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
          <meta charset="UTF-8">
          <title><?= $subject ?> Lesson Content</title>
          <style>
            body { font-family: Arial, sans-serif; margin: 2cm; }
            h1, h2, h3 { color: #2c3e50; }
            table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
            table, th, td { border: 1px solid #ddd; }
            th, td { padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
          </style>
        </head>
        <body>
          <h1><?= $subject ?> Lesson Content</h1>
          <h3><?= $topic ?> - <?= $subtopic ?></h3>
          <p><strong>Class:</strong> <?= $class ?></p>
          <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
          <hr>
          ${content}
        </body>
        </html>
      `], { type: 'application/msword' });
      
      saveAs(blob, 'LessonContent_<?= $subject ?>_<?= $topic ?>.doc');
    });
  </script>
</body>
</html>