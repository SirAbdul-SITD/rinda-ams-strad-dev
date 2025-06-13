<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../settings.php');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set the upload directory
$upload_dir = '/opt/lampp/htdocs/strad/super-admin/lms/uploads/documents/';

// Create upload directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Debug logging
function debug_log($message) {
    file_put_contents('document_debug.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'add_document') {
                // Validate input
                if (empty($_POST['title']) || empty($_FILES['document_file']['name']) || empty($_POST['folder_id'])) {
                    throw new Exception("All fields are required");
                }

                // Handle file upload
                $folder_id = (int)$_POST['folder_id'];
                $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                $stmt->execute([$folder_id]);
                $folder = $stmt->fetchColumn();

                if (!$folder) {
                    throw new Exception("Invalid folder selected");
                }

                $folder_path = $upload_dir . $folder . '/';
                if (!file_exists($folder_path)) {
                    mkdir($folder_path, 0777, true);
                }

                $file_name = $_FILES['document_file']['name'];
                $file_tmp = $_FILES['document_file']['tmp_name'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $unique_name = uniqid('doc_') . '.' . $file_ext;
                $file_path = $folder_path . $unique_name;

                if (!move_uploaded_file($file_tmp, $file_path)) {
                    throw new Exception("Failed to move uploaded file");
                }

                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO lms_documents 
                    (title, subject, class, added_by, file_path, file_name, file_type, file_size, folder_id, date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['title'],
                    $_POST['subject'] ?? null,
                    $_POST['class'] ?? null,
                    $_SESSION['user_id'] ?? null,
                    $file_path,
                    $file_name,
                    $_FILES['document_file']['type'],
                    $_FILES['document_file']['size'],
                    $folder_id,
                    date('Y-m-d')
                ]);

                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Document added successfully!'
                ];
            } elseif ($_POST['action'] === 'update_document') {
                // Validate input
                if (empty($_POST['id']) || empty($_POST['title']) || empty($_POST['folder_id'])) {
                    throw new Exception("All fields are required");
                }

                // Get the current document details
                $stmt = $pdo->prepare("SELECT file_path, folder_id FROM lms_documents WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $document = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$document) {
                    throw new Exception("Document not found");
                }

                $old_folder_id = $document['folder_id'];
                $new_folder_id = (int)$_POST['folder_id'];

                if ($old_folder_id !== $new_folder_id) {
                    // Get folder names
                    $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                    $stmt->execute([$old_folder_id]);
                    $old_folder = $stmt->fetchColumn();

                    $stmt->execute([$new_folder_id]);
                    $new_folder = $stmt->fetchColumn();

                    if (!$new_folder) {
                        throw new Exception("Invalid folder selected");
                    }

                    $old_path = $document['file_path'];
                    $new_folder_path = $upload_dir . $new_folder . '/';

                    if (!file_exists($new_folder_path)) {
                        mkdir($new_folder_path, 0777, true);
                    }

                    $new_path = $new_folder_path . basename($old_path);

                    // Move the file if the folder is updated
                    if (!rename($old_path, $new_path)) {
                        throw new Exception("Failed to move document to the new folder");
                    }
                } else {
                    $new_path = $document['file_path'];
                }

                // Update the database
                $stmt = $pdo->prepare("UPDATE lms_documents SET 
                    title = ?, 
                    subject = ?, 
                    class = ?, 
                    folder_id = ?, 
                    file_path = ? 
                    WHERE id = ?");
                $stmt->execute([
                    $_POST['title'],
                    $_POST['subject'] ?? null,
                    $_POST['class'] ?? null,
                    $new_folder_id,
                    $new_path,
                    $_POST['id']
                ]);

                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Document updated successfully!'
                ];
            } elseif ($_POST['action'] === 'delete_document') {
                // Delete document
                if (empty($_POST['id'])) {
                    throw new Exception("Document ID missing");
                }
                
                // First get the file path to delete the physical file
                $stmt = $pdo->prepare("SELECT file_path FROM lms_documents WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $document = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($document && file_exists($document['file_path'])) {
                    if (!unlink($document['file_path'])) {
                        throw new Exception("Failed to delete document file from server");
                    }
                }
                
                // Then delete from database
                $stmt = $pdo->prepare("DELETE FROM lms_documents WHERE id = ?");
                $success = $stmt->execute([$_POST['id']]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Document deleted successfully!'
                ];
            } elseif ($_POST['action'] === 'add_note') {
                // Add note
                if (empty($_POST['note_title']) || empty($_POST['note_content'])) {
                    throw new Exception("Note title and content are required");
                }
                
                $stmt = $pdo->prepare("INSERT INTO lms_notes 
                    (title, content, created_by, created_at, folder) 
                    VALUES (?, ?, ?, NOW(), ?)");
                
                $success = $stmt->execute([
                    $_POST['note_title'],
                    $_POST['note_content'],
                    $_SESSION['user_id'] ?? null,
                    $_POST['folder'] ?? 'General'
                ]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Note added successfully!'
                ];
            } elseif ($_POST['action'] === 'update_note') {
                // Update note
                if (empty($_POST['note_id']) || empty($_POST['note_title']) || empty($_POST['note_content'])) {
                    throw new Exception("Required fields missing");
                }
                
                $stmt = $pdo->prepare("UPDATE lms_notes SET 
                    title = ?, 
                    content = ?, 
                    folder = ?,
                    updated_at = NOW()
                    WHERE id = ?");
                
                $success = $stmt->execute([
                    $_POST['note_title'],
                    $_POST['note_content'],
                    $_POST['folder'] ?? 'General',
                    $_POST['note_id']
                ]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Note updated successfully!'
                ];
            } elseif ($_POST['action'] === 'delete_note') {
                // Delete note
                if (empty($_POST['note_id'])) {
                    throw new Exception("Note ID missing");
                }
                
                $stmt = $pdo->prepare("DELETE FROM lms_notes WHERE id = ?");
                $success = $stmt->execute([$_POST['note_id']]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Note deleted successfully!'
                ];
            }
            
            header("Location: documents.php");
            exit();
        }
    } catch (Exception $e) {
        debug_log("Error: " . $e->getMessage());
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => $e->getMessage()
        ];
        header("Location: documents.php");
        exit();
    }
}

// Get document data
try {
    // Total documents count
    $total_documents = $pdo->query("SELECT COUNT(*) FROM lms_documents")->fetchColumn();
    
    // Total notes count
    $total_notes = $pdo->query("SELECT COUNT(*) FROM lms_notes")->fetchColumn();
    
    // Total storage used
    $total_storage = $pdo->query("SELECT SUM(file_size) FROM lms_documents")->fetchColumn() ?? 0;
    
    // Get all documents
    $documents = $pdo->query("SELECT d.*, f.name as folder_name 
                             FROM lms_documents d
                             LEFT JOIN folders f ON d.folder_id = f.id
                             ORDER BY d.date DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all notes
    $notes = $pdo->query("SELECT * FROM lms_notes ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    // Get classes for dropdown
    $classes = $pdo->query("SELECT DISTINCT class FROM lms_documents WHERE class IS NOT NULL ORDER BY class")->fetchAll(PDO::FETCH_COLUMN);
    
    // Get subjects for dropdown
    $subjects = $pdo->query("SELECT DISTINCT subject FROM lms_documents WHERE subject IS NOT NULL ORDER BY subject")->fetchAll(PDO::FETCH_COLUMN);
    
    // Get folders for dropdown
    $folders = $pdo->query("SELECT id, name FROM folders ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $total_documents = 0;
    $total_notes = 0;
    $total_storage = 0;
    $documents = [];
    $notes = [];
    $classes = [];
    $subjects = [];
    $folders = [];
    
    debug_log("Database error: " . $e->getMessage());
}

// Function to get file icon based on type
function getFileIcon($type) {
    if (strpos($type, 'pdf') !== false) {
        return 'fe fe-file-text text-danger';
    } elseif (strpos($type, 'word') !== false || strpos($type, 'document') !== false) {
        return 'fe fe-file-text text-primary';
    } elseif (strpos($type, 'excel') !== false || strpos($type, 'spreadsheet') !== false) {
        return 'fe fe-file-text text-success';
    } elseif (strpos($type, 'powerpoint') !== false || strpos($type, 'presentation') !== false) {
        return 'fe fe-file-text text-warning';
    } elseif (strpos($type, 'image') !== false) {
        return 'fe fe-image text-info';
    } else {
        return 'fe fe-file text-secondary';
    }
}

// Function to format file size
function formatSize($bytes) {
    if ($bytes == 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
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
  <title>Document Management | <?= $school_name ?></title>
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
  <!-- Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@300;400;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Overpass', sans-serif; }
    .document-card, .note-card { transition: all 0.3s; }
    .document-card:hover, .note-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .document-icon { font-size: 2.5rem; }
    .note-content { max-height: 150px; overflow: hidden; text-overflow: ellipsis; }
    .file-upload-container { border: 2px dashed #dee2e6; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s; }
    .file-upload-container:hover { border-color: #6c757d; background: #f8f9fa; }
    .file-upload-container.dragover { border-color: #007bff; background: rgba(0, 123, 255, 0.05); }
    .file-upload-preview { margin-top: 15px; display: none; }
    .spinner-container { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; }
    .spinner-container.show { display: flex; }
    .folder-badge { cursor: pointer; }
    .folder-badge:hover { opacity: 0.8; }
    .tab-content { padding: 20px 0; }
    .preview-container { max-height: 500px; overflow-y: auto; }
    .document-preview { width: 100%; height: 500px; border: none; }
    .note-preview { white-space: pre-wrap; }
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
          placeholder="Search documents..." aria-label="Search">
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
            <a class="nav-link" href="nigerian-curriculum.php">
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="documents.php">
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
                <h2 class="h5 page-title">Document Management</h2>
              </div>
              <div class="col-auto">
                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fe fe-plus mr-2"></i>Add New
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addDocumentModal">
                      <i class="fe fe-upload mr-2"></i>Upload Document
                    </a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addNoteModal">
                      <i class="fe fe-edit-2 mr-2"></i>Create Note
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="card shadow document-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Documents</p>
                        <h3 class="mb-0"><?= number_format($total_documents) ?></h3>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-file-text fe-32 text-primary"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-4">
                <div class="card shadow document-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Notes</p>
                        <h3 class="mb-0"><?= number_format($total_notes) ?></h3>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-edit-2 fe-32 text-warning"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-4">
                <div class="card shadow document-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Storage Used</p>
                        <h3 class="mb-0"><?= formatSize($total_storage) ?></h3>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-hard-drive fe-32 text-success"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Tabs for Documents and Notes -->
            <div class="row">
              <div class="col-12">
                <div class="card shadow">
                  <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="documentTabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="true">
                          <i class="fe fe-file-text mr-2"></i>Documents
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">
                          <i class="fe fe-edit-2 mr-2"></i>Notes
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="documentTabsContent">
                      <!-- Documents Tab -->
                      <div class="tab-pane fade show active" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                        <?php if (!empty($documents)): ?>
                          <div class="table-responsive">
                            <table class="table table-hover" id="documentTable">
                              <thead>
                                <tr>
                                  <th>Title</th>
                                  <th>Type</th>
                                  <th>Subject</th>
                                  <th>Class</th>
                                  <th>Folder</th>
                                  <th>Date</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($documents as $doc): ?>
                                  <tr>
                                    <td>
                                      <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                          <i class="<?= getFileIcon($doc['file_type']) ?> document-icon"></i>
                                        </div>
                                        <div>
                                          <strong><?= htmlspecialchars($doc['title']) ?></strong><br>
                                          <small class="text-muted"><?= htmlspecialchars($doc['file_name']) ?></small>
                                        </div>
                                      </div>
                                    </td>
                                    <td><?= htmlspecialchars(explode('/', $doc['file_type'])[1] ?? 'file') ?></td>
                                    <td><?= htmlspecialchars($doc['subject'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($doc['class'] ?? 'N/A') ?></td>
                                    <td>
                                      <span class="badge badge-secondary folder-badge"><?= htmlspecialchars($doc['folder_name'] ?? 'General') ?></span>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($doc['date'])) ?></td>
                                    <td>
                                      <button class="btn btn-sm btn-outline-primary view-document" 
                                        data-id="<?= $doc['id'] ?>"
                                        data-title="<?= htmlspecialchars($doc['title']) ?>"
                                        data-path="<?= htmlspecialchars($doc['file_path']) ?>"
                                        data-type="<?= htmlspecialchars($doc['file_type']) ?>">
                                        <i class="fe fe-eye"></i>
                                      </button>
                                      <button class="btn btn-sm btn-outline-secondary edit-document" 
                                        data-id="<?= $doc['id'] ?>"
                                        data-title="<?= htmlspecialchars($doc['title']) ?>"
                                        data-subject="<?= htmlspecialchars($doc['subject'] ?? '') ?>"
                                        data-class="<?= htmlspecialchars($doc['class'] ?? '') ?>"
                                        data-folder-id="<?= htmlspecialchars($doc['folder_id'] ?? '') ?>">
                                        <i class="fe fe-edit-2"></i>
                                      </button>
                                      <button class="btn btn-sm btn-outline-danger delete-document" 
                                        data-id="<?= $doc['id'] ?>"
                                        data-title="<?= htmlspecialchars($doc['title']) ?>">
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
                            No documents found. Upload your first document using the button above.
                          </div>
                        <?php endif; ?>
                      </div>
                      
                      <!-- Notes Tab -->
                      <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        <?php if (!empty($notes)): ?>
                          <div class="table-responsive">
                            <table class="table table-hover" id="noteTable">
                              <thead>
                                <tr>
                                  <th>Title</th>
                                  <th>Content</th>
                                  <th>Folder</th>
                                  <th>Created</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($notes as $note): ?>
                                  <tr>
                                    <td>
                                      <strong><?= htmlspecialchars($note['title']) ?></strong>
                                    </td>
                                    <td>
                                      <div class="note-content">
                                        <?= htmlspecialchars(substr($note['content'], 0, 100)) ?>
                                        <?php if (strlen($note['content']) > 100): ?>...<?php endif; ?>
                                      </div>
                                    </td>
                                    <td>
                                      <span class="badge badge-secondary folder-badge"><?= htmlspecialchars($note['folder'] ?? 'General') ?></span>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($note['created_at'])) ?></td>
                                    <td>
                                      <button class="btn btn-sm btn-outline-primary view-note" 
                                        data-id="<?= $note['id'] ?>"
                                        data-title="<?= htmlspecialchars($note['title']) ?>"
                                        data-content="<?= htmlspecialchars($note['content']) ?>">
                                        <i class="fe fe-eye"></i>
                                      </button>
                                      <button class="btn btn-sm btn-outline-secondary edit-note" 
                                        data-id="<?= $note['id'] ?>"
                                        data-title="<?= htmlspecialchars($note['title']) ?>"
                                        data-content="<?= htmlspecialchars($note['content']) ?>"
                                        data-folder="<?= htmlspecialchars($note['folder'] ?? '') ?>">
                                        <i class="fe fe-edit-2"></i>
                                      </button>
                                      <button class="btn btn-sm btn-outline-danger delete-note" 
                                        data-id="<?= $note['id'] ?>"
                                        data-title="<?= htmlspecialchars($note['title']) ?>">
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
                            No notes found. Create your first note using the button above.
                          </div>
                        <?php endif; ?>
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

  <!-- Add Document Modal -->
  <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="addDocumentModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addDocumentModalLabel">Upload New Document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addDocumentForm" method="post" enctype="multipart/form-data">
          <input type="hidden" name="action" value="add_document">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="documentTitle">Title *</label>
                  <input type="text" class="form-control" id="documentTitle" name="title" required>
                </div>
                
                <div class="form-group">
                  <label for="documentSubject">Subject</label>
                  <input type="text" class="form-control" id="documentSubject" name="subject" list="subjectList">
                  <datalist id="subjectList">
                    <?php foreach ($subjects as $subject): ?>
                      <option value="<?= htmlspecialchars($subject) ?>">
                    <?php endforeach; ?>
                  </datalist>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="documentClass">Class</label>
                  <input type="text" class="form-control" id="documentClass" name="class" list="classList">
                  <datalist id="classList">
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= htmlspecialchars($class) ?>">
                    <?php endforeach; ?>
                  </datalist>
                </div>
                
                <div class="form-group">
                  <label for="documentFolder">Folder *</label>
                  <select class="form-control" id="documentFolder" name="folder_id" required>
                    <?php foreach ($folders as $folder): ?>
                      <option value="<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label>Document File *</label>
              <div class="file-upload-container" id="documentUploadContainer">
                <input type="file" id="documentFile" name="document_file" style="display: none;" required>
                <div id="documentUploadContent">
                  <i class="fe fe-upload fe-24 mb-3"></i>
                  <h5>Drag and drop document here</h5>
                  <p class="text-muted">or click to browse files</p>
                  <p class="small text-muted">Supported formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, PNG, GIF (Max 50MB)</p>
                </div>
                <div id="documentUploadPreview" class="file-upload-preview">
                  <p class="mt-2 mb-0"><strong id="documentFileName"></strong> (<span id="documentFileSize"></span>)</p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Upload Document</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Edit Document Modal -->
  <div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDocumentModalLabel">Edit Document Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editDocumentForm" method="post">
          <input type="hidden" name="action" value="update_document">
          <input type="hidden" name="id" id="editDocumentId">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDocumentTitle">Title *</label>
              <input type="text" class="form-control" id="editDocumentTitle" name="title" required>
            </div>
            
            <div class="form-group">
              <label for="editDocumentSubject">Subject</label>
              <input type="text" class="form-control" id="editDocumentSubject" name="subject">
            </div>
            
            <div class="form-group">
              <label for="editDocumentClass">Class</label>
              <input type="text" class="form-control" id="editDocumentClass" name="class">
            </div>
            
            <div class="form-group">
              <label for="editDocumentFolder">Folder *</label>
              <select class="form-control" id="editDocumentFolder" name="folder_id" required>
                <?php foreach ($folders as $folder): ?>
                  <option value="<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Save Changes</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Delete Document Modal -->
  <div class="modal fade" id="deleteDocumentModal" tabindex="-1" role="dialog" aria-labelledby="deleteDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteDocumentModalLabel">Confirm Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteDocumentForm" method="post">
          <input type="hidden" name="action" value="delete_document">
          <input type="hidden" name="id" id="deleteDocumentId">
          <div class="modal-body">
            <p>Are you sure you want to delete the document "<strong id="deleteDocumentTitle"></strong>"?</p>
            <p class="text-danger">This action cannot be undone. The file will be permanently removed.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <span class="submit-btn-text">Delete Permanently</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- View Document Modal -->
  <div class="modal fade" id="viewDocumentModal" tabindex="-1" role="dialog" aria-labelledby="viewDocumentModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewDocumentModalLabel">Document Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="preview-container">
            <iframe id="documentPreview" class="document-preview" frameborder="0"></iframe>
            <div id="imagePreview" style="display: none;">
              <img src="" id="previewImage" class="img-fluid">
            </div>
            <div id="textPreview" class="note-preview" style="display: none;"></div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" id="downloadDocument" class="btn btn-primary">
            <i class="fe fe-download mr-2"></i>Download
          </a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add Note Modal -->
  <div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog" aria-labelledby="addNoteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addNoteModalLabel">Create New Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addNoteForm" method="post">
          <input type="hidden" name="action" value="add_note">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="noteTitle">Title *</label>
                  <input type="text" class="form-control" id="noteTitle" name="note_title" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="noteFolder">Folder</label>
                  <input type="text" class="form-control" id="noteFolder" name="folder" list="folderList">
                  <datalist id="folderList">
                    <?php foreach ($folders as $folder): ?>
                      <option value="<?= htmlspecialchars($folder['name']) ?>">
                    <?php endforeach; ?>
                  </datalist>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="noteContent">Content *</label>
              <textarea class="form-control" id="noteContent" name="note_content" rows="10" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Save Note</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Edit Note Modal -->
  <div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editNoteForm" method="post">
          <input type="hidden" name="action" value="update_note">
          <input type="hidden" name="note_id" id="editNoteId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="editNoteTitle">Title *</label>
                  <input type="text" class="form-control" id="editNoteTitle" name="note_title" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="editNoteFolder">Folder</label>
                  <input type="text" class="form-control" id="editNoteFolder" name="folder" list="folderList">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="editNoteContent">Content *</label>
              <textarea class="form-control" id="editNoteContent" name="note_content" rows="10" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Update Note</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Delete Note Modal -->
  <div class="modal fade" id="deleteNoteModal" tabindex="-1" role="dialog" aria-labelledby="deleteNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteNoteModalLabel">Confirm Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteNoteForm" method="post">
          <input type="hidden" name="action" value="delete_note">
          <input type="hidden" name="note_id" id="deleteNoteId">
          <div class="modal-body">
            <p>Are you sure you want to delete the note "<strong id="deleteNoteTitle"></strong>"?</p>
            <p class="text-danger">This action cannot be undone.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <span class="submit-btn-text">Delete Permanently</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- View Note Modal -->
  <div class="modal fade" id="viewNoteModal" tabindex="-1" role="dialog" aria-labelledby="viewNoteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewNoteModalLabel">Note Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="preview-container">
            <h4 id="viewNoteTitle"></h4>
            <div id="viewNoteContent" class="note-preview"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php include('./lms-footer.php'); ?>
  <!-- JavaScript -->
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
    // Initialize SimpleBar for sidebar
    new SimpleBar(document.getElementById('leftSidebar'));

    // Menu button functionality
    $('.collapseSidebar').on('click', function() {
      $('.wrapper').toggleClass('sidebar-collapsed');
      $('.sidebar-left').toggleClass('sidebar-collapsed');
      $('.main-content').toggleClass('sidebar-collapsed');
    });

    // Initialize DataTables
    $('#documentTable').DataTable({
      order: [[5, 'desc']],
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search documents..."
      }
    });
    
    $('#noteTable').DataTable({
      order: [[3, 'desc']],
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search notes..."
      }
    });

    // Initialize Summernote editor
    $('#noteContent, #editNoteContent').summernote({
      height: 200,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });

    // Show toast notifications
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

    // Document upload drag and drop
    const documentUploadContainer = document.getElementById('documentUploadContainer');
    const documentFileInput = document.getElementById('documentFile');
    const documentUploadContent = document.getElementById('documentUploadContent');
    const documentUploadPreview = document.getElementById('documentUploadPreview');
    const documentFileName = document.getElementById('documentFileName');
    const documentFileSize = document.getElementById('documentFileSize');

    if (documentUploadContainer && documentFileInput) {
      documentUploadContainer.addEventListener('click', () => documentFileInput.click());

      documentFileInput.addEventListener('change', function(e) {
        if (this.files.length) {
          const file = this.files[0];
          updateDocumentPreview(file);
        }
      });

      documentUploadContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        documentUploadContainer.classList.add('dragover');
      });

      documentUploadContainer.addEventListener('dragleave', () => {
        documentUploadContainer.classList.remove('dragover');
      });

      documentUploadContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        documentUploadContainer.classList.remove('dragover');

        if (e.dataTransfer.files.length) {
          documentFileInput.files = e.dataTransfer.files;
          updateDocumentPreview(e.dataTransfer.files[0]);
        }
      });

      function updateDocumentPreview(file) {
        const maxSize = 50 * 1024 * 1024; // 50MB
        const validTypes = [
          'application/pdf', 
          'application/msword',
          'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
          'application/vnd.ms-excel',
          'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          'application/vnd.ms-powerpoint',
          'application/vnd.openxmlformats-officedocument.presentationml.presentation',
          'text/plain',
          'image/jpeg',
          'image/png',
          'image/gif'
        ];
        
        if (!validTypes.includes(file.type)) {
          alert('Invalid file type. Please upload a document file (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, PNG, GIF).');
          return;
        }
        
        if (file.size > maxSize) {
          alert('File is too large. Maximum size is 50MB.');
          return;
        }

        documentFileName.textContent = file.name;
        documentFileSize.textContent = formatFileSize(file.size);

        documentUploadContent.style.display = 'none';
        documentUploadPreview.style.display = 'block';
      }

      function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
      }
    }

    // View document
    $(document).on('click', '.view-document', function() {
      const id = $(this).data('id');
      const title = $(this).data('title');
      const path = $(this).data('path');
      const type = $(this).data('type');
      
      $('#viewDocumentModalLabel').text(title);
      $('#downloadDocument').attr('href', path);
      
      // Hide all preview types first
      $('#documentPreview').hide().attr('src', '');
      $('#imagePreview').hide();
      $('#textPreview').hide();
      
      if (type.includes('pdf')) {
        // PDF preview
        $('#documentPreview').attr('src', path).show();
      } else if (type.includes('image')) {
        // Image preview
        $('#previewImage').attr('src', path);
        $('#imagePreview').show();
      } else if (type.includes('text')) {
        // Text preview - load via AJAX
        $.get(path, function(data) {
          $('#textPreview').text(data).show();
        }).fail(function() {
          $('#textPreview').text('Could not load text content').show();
        });
      } else {
        // Unsupported type - show download button only
        $('#documentPreview').attr('src', '').hide();
        $('#textPreview').text('Preview not available for this file type. Please download to view.').show();
      }
      
      $('#viewDocumentModal').modal('show');
    });

    // Edit document
    $(document).on('click', '.edit-document', function() {
      $('#editDocumentId').val($(this).data('id'));
      $('#editDocumentTitle').val($(this).data('title'));
      $('#editDocumentSubject').val($(this).data('subject'));
      $('#editDocumentClass').val($(this).data('class'));
      $('#editDocumentFolder').val($(this).data('folder-id'));
      
      $('#editDocumentModal').modal('show');
    });

    // Delete document
    $(document).on('click', '.delete-document', function() {
      $('#deleteDocumentId').val($(this).data('id'));
      $('#deleteDocumentTitle').text($(this).data('title'));
      $('#deleteDocumentModal').modal('show');
    });

    // View note
    $(document).on('click', '.view-note', function() {
      $('#viewNoteTitle').text($(this).data('title'));
      $('#viewNoteContent').html($(this).data('content'));
      $('#viewNoteModal').modal('show');
    });

    // Edit note
    $(document).on('click', '.edit-note', function() {
      $('#editNoteId').val($(this).data('id'));
      $('#editNoteTitle').val($(this).data('title'));
      $('#editNoteContent').summernote('code', $(this).data('content'));
      $('#editNoteFolder').val($(this).data('folder'));
      
      $('#editNoteModal').modal('show');
    });

    // Delete note
    $(document).on('click', '.delete-note', function() {
      $('#deleteNoteId').val($(this).data('id'));
      $('#deleteNoteTitle').text($(this).data('title'));
      $('#deleteNoteModal').modal('show');
    });

    // Folder filter
    $(document).on('click', '.folder-badge', function() {
      const folder = $(this).text();
      $('.nav-tabs a[href="#documents"]').tab('show');
      $('#documentTable').DataTable().search(folder).draw();
    });

    // Form submissions with loading states
    $('form').on('submit', function(e) {
      e.preventDefault();
      const form = $(this);
      const formData = new FormData(this);
      const submitBtn = form.find('button[type="submit"]');
      const spinner = submitBtn.find('.spinner-border');
      const btnText = submitBtn.find('.submit-btn-text');
      
      // Show loading state
      btnText.addClass('d-none');
      spinner.removeClass('d-none');
      submitBtn.prop('disabled', true);
      $('#loadingSpinner').addClass('show');

      $.ajax({
        url: form.attr('action') || window.location.href,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
          window.location.reload();
        },
        error: function(xhr, status, error) {
          // Reset button states
          btnText.removeClass('d-none');
          spinner.addClass('d-none');
          submitBtn.prop('disabled', false);
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
        }
      });
    });
  });
  </script>
</body>
</html>