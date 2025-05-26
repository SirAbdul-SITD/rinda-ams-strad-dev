<?php
require '../settings.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set base upload directory - make sure this path is correct
$base_upload_dir = '/opt/lampp/htdocs/strad/super-admin/lms/uploads/';

// Ensure base upload directory exists and is writable
if (!file_exists($base_upload_dir)) {
    if (!mkdir($base_upload_dir, 0777, true)) {
        die("Failed to create upload directory. Please create it manually at: $base_upload_dir");
    }
}

// Debug logging
function debug_log($message) {
    file_put_contents('file_manager_debug.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create_folder') {
                // Validate input
                if (empty($_POST['folder_name'])) {
                    throw new Exception("Folder name is required");
                }
                
                $folder_name = trim($_POST['folder_name']);
                $parent_folder = isset($_POST['parent_folder']) && $_POST['parent_folder'] !== '' ? (int)$_POST['parent_folder'] : null;
                $permission = $_POST['permission'] ?? 'private';
                
                // Check if folder already exists in database
                $stmt = $pdo->prepare("SELECT id FROM folders WHERE name = ? AND parent_id " . ($parent_folder ? "= ?" : "IS NULL"));
                $stmt->execute($parent_folder ? [$folder_name, $parent_folder] : [$folder_name]);
                
                if ($stmt->rowCount() > 0) {
                    throw new Exception("A folder with this name already exists in this location");
                }
                
                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO folders (name, parent_id, created_by, permission) VALUES (?, ?, ?, ?)");
                $success = $stmt->execute([
                    $folder_name,
                    $parent_folder,
                    $_SESSION['user_id'] ?? null,
                    $permission
                ]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                // Create physical directory
                $folder_path = $base_upload_dir;
                
                // If parent folder, get parent folder name to build path
                if ($parent_folder) {
                    $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                    $stmt->execute([$parent_folder]);
                    $parent = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($parent) {
                        $folder_path .= $parent['name'] . '/';
                        // Ensure parent directory exists
                        if (!file_exists($folder_path)) {
                            if (!mkdir($folder_path, 0777, true)) {
                                throw new Exception("Parent directory doesn't exist and couldn't be created");
                            }
                        }
                    }
                }
                
                $folder_path .= $folder_name;
                
                if (!file_exists($folder_path)) {
                    if (!mkdir($folder_path, 0777, true)) {
                        throw new Exception("Failed to create folder directory at: $folder_path");
                    }
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Folder created successfully!'
                ];
                
            } elseif ($_POST['action'] === 'upload_file') {
                // Validate input
                if (empty($_POST['file_title'])) {
                    throw new Exception("File title is required");
                }
                
                if (empty($_FILES['file_upload']['name'])) {
                    throw new Exception("File is required");
                }

                // Handle file upload
                $file_name = $_FILES['file_upload']['name'];
                $file_tmp = $_FILES['file_upload']['tmp_name'];
                $file_type = $_FILES['file_upload']['type'];
                $file_size = $_FILES['file_upload']['size'];
                $file_error = $_FILES['file_upload']['error'];

                if ($file_error !== UPLOAD_ERR_OK) {
                    throw new Exception("File upload error: " . $file_error);
                }

                // Validate file size (max 100MB)
                $max_size = 100 * 1024 * 1024; // 100MB
                if ($file_size > $max_size) {
                    throw new Exception("File is too large. Maximum size is 100MB.");
                }

                // Determine file type category
                $file_category = 'other';
                if (strpos($file_type, 'image') !== false) {
                    $file_category = 'image';
                } elseif (strpos($file_type, 'video') !== false) {
                    $file_category = 'video';
                } elseif (strpos($file_type, 'audio') !== false) {
                    $file_category = 'audio';
                } elseif (strpos($file_type, 'pdf') !== false || 
                          strpos($file_type, 'document') !== false || 
                          strpos($file_type, 'spreadsheet') !== false || 
                          strpos($file_type, 'presentation') !== false || 
                          strpos($file_type, 'text') !== false) {
                    $file_category = 'document';
                }

                // Generate unique filename
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $unique_name = uniqid('file_') . '.' . $file_ext;
                $target_folder = isset($_POST['target_folder']) && $_POST['target_folder'] !== '' ? (int)$_POST['target_folder'] : null;
                
                // Determine upload path
                $upload_path = $base_upload_dir;
                
                // If target folder specified, get folder name to build path
                if ($target_folder) {
                    $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                    $stmt->execute([$target_folder]);
                    $folder = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($folder) {
                        $upload_path .= $folder['name'] . '/';
                        // Ensure target directory exists
                        if (!file_exists($upload_path)) {
                            if (!mkdir($upload_path, 0777, true)) {
                                throw new Exception("Target directory doesn't exist and couldn't be created");
                            }
                        }
                    }
                }
                
                $file_path = $upload_path . $unique_name;

                // Move uploaded file
                if (!move_uploaded_file($file_tmp, $file_path)) {
                    throw new Exception("Failed to move uploaded file to " . $file_path);
                }

                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO files 
                    (title, file_name, file_path, type, size, folder, uploaded_by, permission) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                $success = $stmt->execute([
                    $_POST['file_title'],
                    $file_name,
                    $file_path,
                    $file_category,
                    $file_size,
                    $target_folder,
                    $_SESSION['user_id'] ?? null,
                    $_POST['file_permission'] ?? 'private'
                ]);
                
                if (!$success) {
                    // Delete the uploaded file if database insert failed
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'File uploaded successfully!'
                ];
                
            } elseif ($_POST['action'] === 'delete_file') {
                // Delete file
                if (empty($_POST['file_id'])) {
                    throw new Exception("File ID missing");
                }
                
                // First get the file path to delete the physical file
                $stmt = $pdo->prepare("SELECT file_path FROM files WHERE id = ?");
                $stmt->execute([$_POST['file_id']]);
                $file = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($file && file_exists($file['file_path'])) {
                    if (!unlink($file['file_path'])) {
                        throw new Exception("Failed to delete file from server");
                    }
                }
                
                // Then delete from database
                $stmt = $pdo->prepare("DELETE FROM files WHERE id = ?");
                $success = $stmt->execute([$_POST['file_id']]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'File deleted successfully!'
                ];
                
            } elseif ($_POST['action'] === 'delete_folder') {
                // Delete folder
                if (empty($_POST['folder_id'])) {
                    throw new Exception("Folder ID missing");
                }
                
                // First check if folder is empty
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM files WHERE folder = ?");
                $stmt->execute([$_POST['folder_id']]);
                $file_count = $stmt->fetchColumn();
                
                if ($file_count > 0 && empty($_POST['force_delete'])) {
                    throw new Exception("Folder is not empty. Please delete all files first or check 'Force Delete'.");
                }
                
                // Get folder info
                $stmt = $pdo->prepare("SELECT name FROM folders WHERE id = ?");
                $stmt->execute([$_POST['folder_id']]);
                $folder = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$folder) {
                    throw new Exception("Folder not found");
                }
                
                // Delete all files in folder if force delete
                if (!empty($_POST['force_delete'])) {
                    $stmt = $pdo->prepare("SELECT file_path FROM files WHERE folder = ?");
                    $stmt->execute([$_POST['folder_id']]);
                    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($files as $file) {
                        if (file_exists($file['file_path'])) {
                            unlink($file['file_path']);
                        }
                    }
                    
                    // Delete files from database
                    $stmt = $pdo->prepare("DELETE FROM files WHERE folder = ?");
                    $stmt->execute([$_POST['folder_id']]);
                }
                
                // Delete folder from database
                $stmt = $pdo->prepare("DELETE FROM folders WHERE id = ?");
                $success = $stmt->execute([$_POST['folder_id']]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                // Delete physical folder if empty
                $folder_path = $base_upload_dir . $folder['name'];
                if (file_exists($folder_path)) {
                    if (count(scandir($folder_path)) == 2) { // Empty folder has 2 entries (. and ..)
                        rmdir($folder_path);
                    }
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Folder deleted successfully!'
                ];
                
            } elseif ($_POST['action'] === 'rename_folder') {
                // Rename folder
                if (empty($_POST['folder_id']) || empty($_POST['new_name'])) {
                    throw new Exception("Folder ID and new name are required");
                }
                
                $new_name = trim($_POST['new_name']);
                
                // Check if new name already exists
                $stmt = $pdo->prepare("SELECT id FROM folders WHERE name = ? AND parent_id = (SELECT parent_id FROM folders WHERE id = ?) AND id != ?");
                $stmt->execute([$new_name, $_POST['folder_id'], $_POST['folder_id']]);
                
                if ($stmt->rowCount() > 0) {
                    throw new Exception("A folder with this name already exists in this location");
                }
                
                // Get current folder info
                $stmt = $pdo->prepare("SELECT name, parent_id FROM folders WHERE id = ?");
                $stmt->execute([$_POST['folder_id']]);
                $folder = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$folder) {
                    throw new Exception("Folder not found");
                }
                
                // Update in database
                $stmt = $pdo->prepare("UPDATE folders SET name = ? WHERE id = ?");
                $success = $stmt->execute([$new_name, $_POST['folder_id']]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                // Rename physical folder if exists
                $old_path = $base_upload_dir . $folder['name'];
                $new_path = $base_upload_dir . $new_name;
                
                if (file_exists($old_path)) {
                    if (!rename($old_path, $new_path)) {
                        // Revert database change if physical rename fails
                        $stmt = $pdo->prepare("UPDATE folders SET name = ? WHERE id = ?");
                        $stmt->execute([$folder['name'], $_POST['folder_id']]);
                        throw new Exception("Failed to rename folder directory");
                    }
                }
                
                // Update file paths in database
                $stmt = $pdo->prepare("UPDATE files SET file_path = REPLACE(file_path, ?, ?) WHERE folder = ?");
                $stmt->execute([$old_path . '/', $new_path . '/', $_POST['folder_id']]);
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Folder renamed successfully!'
                ];
                
            } elseif ($_POST['action'] === 'move_item') {
                // Move file or folder
                if (empty($_POST['item_id']) || empty($_POST['item_type']) || !isset($_POST['target_folder'])) {
                    throw new Exception("Required parameters missing");
                }
                
                $target_folder = $_POST['target_folder'] === 'root' ? null : $_POST['target_folder'];
                
                if ($_POST['item_type'] === 'file') {
                    // Move file
                    $stmt = $pdo->prepare("UPDATE files SET folder = ? WHERE id = ?");
                    $success = $stmt->execute([$target_folder, $_POST['item_id']]);
                    
                    if (!$success) {
                        throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                    }
                    
                } elseif ($_POST['item_type'] === 'folder') {
                    // Move folder
                    // Check if target is a descendant (would create circular reference)
                    if ($target_folder) {
                        $check_stmt = $pdo->prepare("WITH RECURSIVE folder_tree AS (
                            SELECT id, parent_id FROM folders WHERE id = ?
                            UNION ALL
                            SELECT f.id, f.parent_id FROM folders f
                            JOIN folder_tree ft ON f.parent_id = ft.id
                        ) SELECT id FROM folder_tree WHERE id = ?");
                        
                        $check_stmt->execute([$target_folder, $_POST['item_id']]);
                        
                        if ($check_stmt->rowCount() > 0) {
                            throw new Exception("Cannot move folder to one of its own subfolders");
                        }
                    }
                    
                    $stmt = $pdo->prepare("UPDATE folders SET parent_id = ? WHERE id = ?");
                    $success = $stmt->execute([$target_folder, $_POST['item_id']]);
                    
                    if (!$success) {
                        throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                    }
                } else {
                    throw new Exception("Invalid item type");
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Item moved successfully!'
                ];
            } elseif ($_POST['action'] === 'update_permission') {
                // Update permission for file or folder
                if (empty($_POST['item_id']) || empty($_POST['item_type']) || empty($_POST['permission'])) {
                    throw new Exception("Required parameters missing");
                }
                
                $valid_permissions = ['private', 'public'];
                if (!in_array($_POST['permission'], $valid_permissions)) {
                    throw new Exception("Invalid permission value");
                }
                
                if ($_POST['item_type'] === 'file') {
                    $stmt = $pdo->prepare("UPDATE files SET permission = ? WHERE id = ?");
                } elseif ($_POST['item_type'] === 'folder') {
                    $stmt = $pdo->prepare("UPDATE folders SET permission = ? WHERE id = ?");
                } else {
                    throw new Exception("Invalid item type");
                }
                
                $success = $stmt->execute([$_POST['permission'], $_POST['item_id']]);
                
                if (!$success) {
                    throw new Exception("Database error: " . implode(" ", $stmt->errorInfo()));
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Permission updated successfully!'
                ];
            }
            
            header("Location: file-manager.php" . (isset($current_folder) ? "?folder=$current_folder" : ""));
            exit();
        }
    } catch (Exception $e) {
        debug_log("Error: " . $e->getMessage());
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => $e->getMessage()
        ];
        header("Location: file-manager.php" . (isset($current_folder) ? "?folder=$current_folder" : ""));
        exit();
    }
}

// Get current folder from query string
$current_folder = isset($_GET['folder']) ? (int)$_GET['folder'] : null;

// Get folder data
try {
    // Get breadcrumbs
    $breadcrumbs = [];
    if ($current_folder) {
        $folder_id = $current_folder;
        while ($folder_id) {
            $stmt = $pdo->prepare("SELECT id, name, parent_id FROM folders WHERE id = ?");
            $stmt->execute([$folder_id]);
            $folder = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($folder) {
                array_unshift($breadcrumbs, $folder);
                $folder_id = $folder['parent_id'];
            } else {
                $folder_id = null;
            }
        }
    }
    
    // Get current folder contents
    $files = [];
    $subfolders = [];
    
    // Get files in current folder
    $query = "
    SELECT 
        id, 
        title, 
        file_name, 
        file_path, 
        type, 
        IFNULL(size, 0) AS size,
        folder, 
        uploaded_by, 
        permission, 
        uploaded_at,
        'files' AS source_table
    FROM files 
    WHERE folder " . ($current_folder ? "= ?" : "IS NULL") . "
    
    UNION ALL
    
    SELECT 
        id, 
        title, 
        NULL AS file_name, 
        file_path, 
        'audio' AS type, 
        0 AS size,
        folder_id AS folder, 
        NULL AS uploaded_by, 
        'private' AS permission, 
        created_at AS uploaded_at,
        'lms_audio' AS source_table
    FROM lms_audio 
    WHERE folder_id " . ($current_folder ? "= ?" : "IS NULL") . "
    
    UNION ALL
    
    SELECT 
        id, 
        title, 
        NULL AS file_name, 
        youtube_url AS file_path, 
        'video' AS type, 
        0 AS size,
        folder_id AS folder, 
        added_by AS uploaded_by, 
        'public' AS permission, 
        created_at AS uploaded_at,
        'videos' AS source_table
    FROM videos 
    WHERE folder_id " . ($current_folder ? "= ?" : "IS NULL") . "
        
    UNION ALL
        
    SELECT 
        id, 
        title, 
        NULL AS file_name, 
        file_path, 
        'document' AS type, 
        0 AS size,
        folder_id AS folder, 
        added_by AS uploaded_by, 
        'private' AS permission, 
        date AS uploaded_at,
        'lms_documents' AS source_table
    FROM lms_documents 
    WHERE folder_id " . ($current_folder ? "= ?" : "IS NULL") . "
        
   
    ";
    
    // Count the number of parameters needed
    $param_count = substr_count($query, '?');
    $params = $current_folder ? array_fill(0, $param_count, $current_folder) : [];

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get subfolders
    $query = "SELECT * FROM folders WHERE parent_id " . ($current_folder ? "= ?" : "IS NULL") . " ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($current_folder ? [$current_folder] : []);
    $subfolders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all folders for move dropdown
    $all_folders = $pdo->query("SELECT id, name, parent_id FROM folders ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    
    // Build folder tree for dropdown
    function buildFolderTree($folders, $parent_id = null, $exclude_id = null, $level = 0) {
        $tree = [];
        foreach ($folders as $folder) {
            if ($folder['parent_id'] == $parent_id && $folder['id'] != $exclude_id) {
                $folder['level'] = $level;
                $folder['children'] = buildFolderTree($folders, $folder['id'], $exclude_id, $level + 1);
                $tree[] = $folder;
            }
        }
        return $tree;
    }
    
    $folder_tree = buildFolderTree($all_folders);
    
    // Get storage statistics
    $total_files = $pdo->query("SELECT COUNT(*) FROM files")->fetchColumn();
    $total_folders = $pdo->query("SELECT COUNT(*) FROM folders")->fetchColumn();
    $total_storage = $pdo->query("SELECT SUM(size) FROM files")->fetchColumn() ?? 0;
    
} catch (PDOException $e) {
    $files = [];
    $subfolders = [];
    $all_folders = [];
    $folder_tree = [];
    $breadcrumbs = [];
    $total_files = 0;
    $total_folders = 0;
    $total_storage = 0;
    
    debug_log("Database error: " . $e->getMessage());
}

// Function to get file icon based on type
function getFileIcon($type) {
    switch ($type) {
        case 'image':
            return 'fe fe-image text-primary';
        case 'video':
            return 'fe fe-film text-danger';
        case 'audio':
            return 'fe fe-music text-success';
        case 'document':
            return 'fe fe-file-text text-info';
        default:
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

// Function to get actual file size (for physical files)
function getActualFileSize($file) {
    if (!empty($file['file_path']) && file_exists($file['file_path'])) {
        return filesize($file['file_path']);
    }
    return $file['size'] ?? 0;
}

// Function to render folder options for dropdown
function renderFolderOptions($folders, $current_folder = null, $prefix = '') {
    $html = '';
    foreach ($folders as $folder) {
        $html .= '<option value="' . $folder['id'] . '" ' . ($folder['id'] == $current_folder ? 'selected' : '') . '>';
        $html .= str_repeat('&nbsp;&nbsp;', $folder['level']) . $prefix . htmlspecialchars($folder['name']);
        $html .= '</option>';
        
        if (!empty($folder['children'])) {
            $html .= renderFolderOptions($folder['children'], $current_folder, $prefix);
        }
    }
    return $html;
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
  <title>File Manager | <?= $school_name ?></title>
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
  <!-- Noty CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@300;400;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Overpass', sans-serif; }
    .file-card, .folder-card { transition: all 0.3s; }
    .file-card:hover, .folder-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .file-icon { font-size: 2.5rem; }
    .folder-icon { font-size: 2rem; }
    .file-upload-container { border: 2px dashed #dee2e6; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s; }
    .file-upload-container:hover { border-color: #6c757d; background: #f8f9fa; }
    .file-upload-container.dragover { border-color: #007bff; background: rgba(0, 123, 255, 0.05); }
    .file-upload-preview { margin-top: 15px; display: none; }
    .spinner-container { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; }
    .spinner-container.show { display: flex; }
    .permission-badge { cursor: pointer; }
    .breadcrumb-item + .breadcrumb-item::before { content: "\u203a"; }
    .file-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
    .file-item, .folder-item { cursor: pointer; }
    .file-thumbnail { height: 120px; background-size: contain; background-position: center; background-repeat: no-repeat; }
    .folder-thumbnail { height: 120px; display: flex; align-items: center; justify-content: center; }
    .list-view .file-item, .list-view .folder-item { display: flex; align-items: center; padding: 10px; border-bottom: 1px solid #eee; }
    .list-view .file-thumbnail, .list-view .folder-thumbnail { width: 40px; height: 40px; margin-right: 15px; }
    .list-view .file-details, .list-view .folder-details { flex: 1; }
    .context-menu { position: absolute; z-index: 1000; display: none; }
    .view-toggle { cursor: pointer; }
    .view-toggle.active { color: #007bff; }
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
    <?php include('./lms-header.php'); ?>
    
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row align-items-center mb-4">
              <div class="col">
                <h2 class="h5 page-title">File Manager</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="file-manager.php"><i class="fe fe-home"></i> Home</a></li>
                    <?php foreach ($breadcrumbs as $index => $crumb): ?>
                      <li class="breadcrumb-item<?= $index === count($breadcrumbs) - 1 ? ' active' : '' ?>">
                        <?php if ($index < count($breadcrumbs) - 1): ?>
                          <a href="file-manager.php?folder=<?= $crumb['id'] ?>"><?= htmlspecialchars($crumb['name']) ?></a>
                        <?php else: ?>
                          <?= htmlspecialchars($crumb['name']) ?>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  </ol>
                </nav>
              </div>
              <div class="col-auto">
                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fe fe-plus mr-2"></i>Add New
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createFolderModal">
                      <i class="fe fe-folder mr-2"></i>New Folder
                    </a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#uploadFileModal">
                      <i class="fe fe-upload mr-2"></i>Upload File
                    </a>
                  </div>
                </div>
                <div class="btn-group ml-2">
                  <button class="btn btn-outline-secondary view-toggle grid-view active" data-view="grid">
                    <i class="fe fe-grid"></i>
                  </button>
                  <button class="btn btn-outline-secondary view-toggle list-view" data-view="list">
                    <i class="fe fe-list"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Files</p>
                        <h3 class="mb-0"><?= number_format($total_files) ?></h3>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-file fe-32 text-primary"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <p class="mb-0 text-muted">Total Folders</p>
                        <h3 class="mb-0"><?= number_format($total_folders) ?></h3>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-folder fe-32 text-warning"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-4">
                <div class="card shadow">
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
            
            <!-- File Manager Content -->
            <div class="row">
              <div class="col-12">
                <div class="card shadow">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col">
                        <h6 class="card-title"><?= $current_folder ? 'Folder Contents' : 'All Files' ?></h6>
                      </div>
                      <div class="col-auto">
                        <div class="form-inline">
                          <div class="form-group mb-0">
                            <label for="sortBy" class="sr-only">Sort By</label>
                            <select class="form-control form-control-sm" id="sortBy">
                              <option>Name (A-Z)</option>
                              <option>Name (Z-A)</option>
                              <option>Date (Newest)</option>
                              <option>Date (Oldest)</option>
                              <option>Size (Largest)</option>
                              <option>Size (Smallest)</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Grid View -->
                    <div class="file-grid" id="gridView">
                      <!-- Folders -->
                      <?php foreach ($subfolders as $folder): ?>
                        <div class="folder-item folder-card" data-id="<?= $folder['id'] ?>" data-name="<?= htmlspecialchars($folder['name']) ?>">
                          <div class="card shadow-sm">
                            <div class="card-body text-center">
                              <div class="folder-thumbnail">
                                <i class="fe fe-folder fe-48 text-warning"></i>
                              </div>
                              <div class="folder-details mt-2">
                                <h6 class="mb-0"><?= htmlspecialchars($folder['name']) ?></h6>
                              </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-0">
                              <div class="dropdown d-inline-block float-right">
                                <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="text-muted sr-only">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item folder-open" href="file-manager.php?folder=<?= $folder['id'] ?>">
                                    <i class="fe fe-folder fe-12 mr-2"></i>Open
                                  </a>
                                  <a class="dropdown-item folder-rename" href="#" data-id="<?= $folder['id'] ?>">
                                    <i class="fe fe-edit-2 fe-12 mr-2"></i>Rename
                                  </a>
                                  <a class="dropdown-item folder-move" href="#" data-id="<?= $folder['id'] ?>" data-type="folder">
                                    <i class="fe fe-chevrons-right fe-12 mr-2"></i>Move
                                  </a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item folder-delete" href="#" data-id="<?= $folder['id'] ?>">
                                    <i class="fe fe-trash-2 fe-12 mr-2 text-danger"></i>Delete
                                  </a>
                                </div>
                              </div>
                              <span class="badge badge-light permission-badge" data-permission="<?= $folder['permission'] ?>">
                                <?php if ($folder['permission'] == 'public'): ?>
                                  <i class="fe fe-users fe-12"></i> Public
                                <?php else: ?>
                                  <i class="fe fe-lock fe-12"></i> Private
                                <?php endif; ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                      
                      <!-- Files -->
                      <?php foreach ($files as $file): ?>
                        <div class="file-item file-card" data-id="<?= $file['id'] ?>" data-type="<?= $file['type'] ?>">
                          <div class="card shadow-sm">
                            <div class="card-body text-center">
                              <?php if ($file['type'] == 'image'): ?>
                                <div class="file-thumbnail" style="background-image: url('<?= htmlspecialchars($file['file_path']) ?>')"></div>
                              <?php else: ?>
                                <div class="file-thumbnail d-flex align-items-center justify-content-center">
                                  <i class="<?= getFileIcon($file['type']) ?> file-icon"></i>
                                </div>
                              <?php endif; ?>
                              <div class="file-details mt-2">
                                <h6 class="mb-0 text-truncate"><?= htmlspecialchars($file['title']) ?></h6>
                                <small class="text-muted"><?= formatSize($file['size']) ?></small>
                              </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-0">
                              <div class="dropdown d-inline-block float-right">
                                <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="text-muted sr-only">Action</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item file-view" href="<?= htmlspecialchars($file['file_path']) ?>" target="_blank">
                                    <i class="fe fe-eye fe-12 mr-2"></i>View
                                  </a>
                                  <a class="dropdown-item file-download" href="<?= htmlspecialchars($file['file_path']) ?>" download>
                                    <i class="fe fe-download fe-12 mr-2"></i>Download
                                  </a>
                                  <a class="dropdown-item file-move" href="#" data-id="<?= $file['id'] ?>" data-type="file">
                                    <i class="fe fe-chevrons-right fe-12 mr-2"></i>Move
                                  </a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item file-delete" href="#" data-id="<?= $file['id'] ?>">
                                    <i class="fe fe-trash-2 fe-12 mr-2 text-danger"></i>Delete
                                  </a>
                                </div>
                              </div>
                              <span class="badge badge-light permission-badge" data-permission="<?= $file['permission'] ?>">
                                <?php if ($file['permission'] == 'public'): ?>
                                  <i class="fe fe-users fe-12"></i> Public
                                <?php else: ?>
                                  <i class="fe fe-lock fe-12"></i> Private
                                <?php endif; ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                      
                      <?php if (empty($subfolders) && empty($files)): ?>
                        <div class="col-12 text-center py-5">
                          <i class="fe fe-folder fe-48 text-muted"></i>
                          <h5 class="mt-3">This folder is empty</h5>
                          <p class="text-muted">Upload files or create subfolders to get started</p>
                        </div>
                      <?php endif; ?>
                    </div>
                    
                    <!-- List View (hidden by default) -->
                    <div class="list-view" id="listView" style="display: none;">
                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Type</th>
                              <th>Size</th>
                              <th>Modified</th>
                              <th>Permission</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- Folders -->
                            <?php foreach ($subfolders as $folder): ?>
                              <tr class="folder-item" data-id="<?= $folder['id'] ?>" data-name="<?= htmlspecialchars($folder['name']) ?>">
                                <td>
                                  <div class="d-flex align-items-center">
                                    <div class="folder-thumbnail mr-3">
                                      <i class="fe fe-folder fe-24 text-warning"></i>
                                    </div>
                                    <div class="folder-details">
                                      <strong><?= htmlspecialchars($folder['name']) ?></strong>
                                    </div>
                                  </div>
                                </td>
                                <td>Folder</td>
                                <td>
                                  <?php 
                                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM files WHERE folder = ?");
                                    $stmt->execute([$folder['id']]);
                                    echo $stmt->fetchColumn() . ' items';
                                  ?>
                                </td>
                                <td><?= date('M j, Y', strtotime($folder['created_at'])) ?></td>
                                <td>
                                  <span class="badge badge-light permission-badge" data-permission="<?= $folder['permission'] ?>">
                                    <?php if ($folder['permission'] == 'public'): ?>
                                      <i class="fe fe-users fe-12"></i> Public
                                    <?php else: ?>
                                      <i class="fe fe-lock fe-12"></i> Private
                                    <?php endif; ?>
                                  </span>
                                </td>
                                <td>
                                  <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item folder-open" href="file-manager.php?folder=<?= $folder['id'] ?>">
                                        <i class="fe fe-folder fe-12 mr-2"></i>Open
                                      </a>
                                      <a class="dropdown-item folder-rename" href="#" data-id="<?= $folder['id'] ?>">
                                        <i class="fe fe-edit-2 fe-12 mr-2"></i>Rename
                                      </a>
                                      <a class="dropdown-item folder-move" href="#" data-id="<?= $folder['id'] ?>" data-type="folder">
                                        <i class="fe fe-chevrons-right fe-12 mr-2"></i>Move
                                      </a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item folder-delete" href="#" data-id="<?= $folder['id'] ?>">
                                        <i class="fe fe-trash-2 fe-12 mr-2 text-danger"></i>Delete
                                      </a>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                            
                            <!-- Files -->
                            <?php foreach ($files as $file): ?>
                              <tr class="file-item" data-id="<?= $file['id'] ?>" data-type="<?= $file['type'] ?>">
                                <td>
                                  <div class="d-flex align-items-center">
                                    <div class="file-thumbnail mr-3">
                                      <i class="<?= getFileIcon($file['type']) ?>"></i>
                                    </div>
                                    <div class="file-details">
                                      <strong><?= htmlspecialchars($file['title']) ?></strong>
                                      <small class="d-block text-muted"><?= htmlspecialchars($file['file_name']) ?></small>
                                    </div>
                                  </div>
                                </td>
                                <td><?= ucfirst($file['type']) ?></td>
                                <td><?= formatSize($file['size']) ?></td>
                                <td><?= date('M j, Y', strtotime($file['uploaded_at'])) ?></td>
                                <td>
                                  <span class="badge badge-light permission-badge" data-permission="<?= $file['permission'] ?>">
                                    <?php if ($file['permission'] == 'public'): ?>
                                      <i class="fe fe-users fe-12"></i> Public
                                    <?php else: ?>
                                      <i class="fe fe-lock fe-12"></i> Private
                                    <?php endif; ?>
                                  </span>
                                </td>
                                <td>
                                  <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item file-view" href="<?= htmlspecialchars($file['file_path']) ?>" target="_blank">
                                        <i class="fe fe-eye fe-12 mr-2"></i>View
                                      </a>
                                      <a class="dropdown-item file-download" href="<?= htmlspecialchars($file['file_path']) ?>" download>
                                        <i class="fe fe-download fe-12 mr-2"></i>Download
                                      </a>
                                      <a class="dropdown-item file-move" href="#" data-id="<?= $file['id'] ?>" data-type="file">
                                        <i class="fe fe-chevrons-right fe-12 mr-2"></i>Move
                                      </a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item file-delete" href="#" data-id="<?= $file['id'] ?>">
                                        <i class="fe fe-trash-2 fe-12 mr-2 text-danger"></i>Delete
                                      </a>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($subfolders) && empty($files)): ?>
                              <tr>
                                <td colspan="6" class="text-center py-5">
                                  <i class="fe fe-folder fe-48 text-muted"></i>
                                  <h5 class="mt-3">This folder is empty</h5>
                                  <p class="text-muted">Upload files or create subfolders to get started</p>
                                </td>
                              </tr>
                            <?php endif; ?>
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
      </div>
    </main>
  </div>

  <!-- Create Folder Modal -->
  <div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog" aria-labelledby="createFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="createFolderForm" method="post" action="file-manager.php">
          <input type="hidden" name="action" value="create_folder">
          <input type="hidden" name="parent_folder" value="<?= $current_folder ?>">
          <div class="modal-body">
            <div class="form-group">
              <label for="folderName">Folder Name *</label>
              <input type="text" class="form-control" id="folderName" name="folder_name" required>
            </div>
            <div class="form-group">
              <label for="folderPermission">Permission</label>
              <select class="form-control" id="folderPermission" name="permission">
                <option value="private">Private (Only you can access)</option>
                <option value="public">Public (Anyone can access)</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Create Folder</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Updated Upload File Modal -->
  <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadFileModalLabel">Upload File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="uploadFileForm" method="post" action="file-manager.php" enctype="multipart/form-data">
          <input type="hidden" name="action" value="upload_file">
          <input type="hidden" name="target_folder" value="<?= $current_folder ?>">
          <div class="modal-body">
            <div class="form-group">
              <label for="fileTitle">File Title *</label>
              <input type="text" class="form-control" id="fileTitle" name="file_title" required>
            </div>
            <div class="form-group">
              <label for="filePermission">Permission</label>
              <select class="form-control" id="filePermission" name="file_permission">
                <option value="private">Private (Only you can access)</option>
                <option value="public">Public (Anyone can access)</option>
              </select>
            </div>
            <div class="form-group">
              <label>File *</label>
              <div class="file-upload-container" id="fileUploadContainer">
                <input type="file" id="fileUpload" name="file_upload" style="display: none;" required>
                <div id="fileUploadContent">
                  <i class="fe fe-upload fe-24 mb-3"></i>
                  <h5>Drag and drop file here</h5>
                  <p class="text-muted">or click to browse files</p>
                  <p class="small text-muted">Max file size: 100MB</p>
                </div>
                <div id="fileUploadPreview" class="file-upload-preview">
                  <p class="mt-2 mb-0"><strong id="fileName"></strong> (<span id="fileSize"></span>)</p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Upload File</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Rename Folder Modal -->
  <div class="modal fade" id="renameFolderModal" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="renameFolderModalLabel">Rename Folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="renameFolderForm" method="post" action="file-manager.php">
          <input type="hidden" name="action" value="rename_folder">
          <input type="hidden" name="folder_id" id="renameFolderId">
          <div class="modal-body">
            <div class="form-group">
              <label for="newFolderName">New Folder Name *</label>
              <input type="text" class="form-control" id="newFolderName" name="new_name" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Rename Folder</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Delete Folder Modal -->
  <div class="modal fade" id="deleteFolderModal" tabindex="-1" role="dialog" aria-labelledby="deleteFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteFolderModalLabel">Confirm Folder Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteFolderForm" method="post" action="file-manager.php">
          <input type="hidden" name="action" value="delete_folder">
          <input type="hidden" name="folder_id" id="deleteFolderId">
          <div class="modal-body">
            <p>Are you sure you want to delete the folder "<strong id="deleteFolderName"></strong>"?</p>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="forceDelete" name="force_delete">
              <label class="form-check-label" for="forceDelete">
                Force delete (including all contents)
              </label>
            </div>
            <p class="text-danger mt-2">This action cannot be undone.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <span class="submit-btn-text">Delete Folder</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Delete File Modal -->
  <div class="modal fade" id="deleteFileModal" tabindex="-1" role="dialog" aria-labelledby="deleteFileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteFileModalLabel">Confirm File Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteFileForm" method="post" action="file-manager.php">
          <input type="hidden" name="action" value="delete_file">
          <input type="hidden" name="file_id" id="deleteFileId">
          <div class="modal-body">
            <p>Are you sure you want to delete the file "<strong id="deleteFileName"></strong>"?</p>
            <p class="text-danger">This action cannot be undone.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <span class="submit-btn-text">Delete File</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Move Item Modal -->
  <div class="modal fade" id="moveItemModal" tabindex="-1" role="dialog" aria-labelledby="moveItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="moveItemModalLabel">Move Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="moveItemForm" method="post" action="file-manager.php">
          <input type="hidden" name="action" value="move_item">
          <input type="hidden" name="item_id" id="moveItemId">
          <input type="hidden" name="item_type" id="moveItemType">
          <div class="modal-body">
            <div class="form-group">
              <label for="targetFolder">Destination Folder</label>
              <select class="form-control" id="targetFolder" name="target_folder">
                <option value="root">Root (Home)</option>
                <?= renderFolderOptions($folder_tree, $current_folder) ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <span class="submit-btn-text">Move Item</span>
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
  
  <script>
  $(document).ready(function() {
    // Initialize DataTable for list view
    $('#listView table').DataTable({
      responsive: true,
      searching: false,
      paging: false,
      info: false,
      order: [[0, 'asc']]
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

    // File upload drag and drop
    const fileUploadContainer = document.getElementById('fileUploadContainer');
    const fileUploadInput = document.getElementById('fileUpload');
    const fileUploadContent = document.getElementById('fileUploadContent');
    const fileUploadPreview = document.getElementById('fileUploadPreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    if (fileUploadContainer && fileUploadInput) {
      fileUploadContainer.addEventListener('click', function(e) {
        // Only trigger file input if not clicking on a button or other interactive element
        if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
          fileUploadInput.click();
        }
      });

      fileUploadInput.addEventListener('change', function(e) {
        if (this.files.length) {
          const file = this.files[0];
          updateFilePreview(file);
        }
      });

      fileUploadContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileUploadContainer.classList.add('dragover');
      });

      fileUploadContainer.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileUploadContainer.classList.remove('dragover');
      });

      fileUploadContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileUploadContainer.classList.remove('dragover');

        if (e.dataTransfer.files.length) {
          fileUploadInput.files = e.dataTransfer.files;
          updateFilePreview(e.dataTransfer.files[0]);
        }
      });

      function updateFilePreview(file) {
        const maxSize = 100 * 1024 * 1024; // 100MB
        
        if (file.size > maxSize) {
          alert('File is too large. Maximum size is 100MB.');
          return;
        }

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

    // View toggle
    $('.view-toggle').on('click', function() {
      const view = $(this).data('view');
      $('.view-toggle').removeClass('active');
      $(this).addClass('active');
      
      if (view === 'grid') {
        $('#gridView').show();
        $('#listView').hide();
      } else {
        $('#gridView').hide();
        $('#listView').show();
      }
    });

    // Folder click
    $('.folder-item').on('click', function(e) {
      // Only navigate if clicked on the card itself, not on action buttons
      if (!$(e.target).closest('.dropdown, .permission-badge, .dropdown-toggle').length) {
        window.location.href = 'file-manager.php?folder=' + $(this).data('id');
      }
    });

    // Rename folder
    $(document).on('click', '.folder-rename', function(e) {
      e.preventDefault();
      const folderId = $(this).data('id');
      const folderName = $(this).closest('.folder-item').data('name');
      
      $('#renameFolderId').val(folderId);
      $('#newFolderName').val(folderName);
      $('#renameFolderModal').modal('show');
    });

    // Delete folder
    $(document).on('click', '.folder-delete', function(e) {
      e.preventDefault();
      const folderId = $(this).data('id');
      const folderName = $(this).closest('.folder-item').data('name');
      
      $('#deleteFolderId').val(folderId);
      $('#deleteFolderName').text(folderName);
      $('#deleteFolderModal').modal('show');
    });

    // Delete file
    $(document).on('click', '.file-delete', function(e) {
      e.preventDefault();
      const fileId = $(this).data('id');
      const fileName = $(this).closest('.file-item').find('.file-details h6').text();
      
      $('#deleteFileId').val(fileId);
      $('#deleteFileName').text(fileName);
      $('#deleteFileModal').modal('show');
    });

    // Move item
    $(document).on('click', '.folder-move, .file-move', function(e) {
      e.preventDefault();
      const itemId = $(this).data('id');
      const itemType = $(this).data('type');
      
      $('#moveItemId').val(itemId);
      $('#moveItemType').val(itemType);
      $('#moveItemModal').modal('show');
    });

    // Toggle permission
    $('.permission-badge').on('click', function() {
      const currentPermission = $(this).data('permission');
      const newPermission = currentPermission === 'public' ? 'private' : 'public';
      const itemId = $(this).closest('.file-item, .folder-item').data('id');
      const itemType = $(this).closest('.file-item').length ? 'file' : 'folder';
      
      // Show loading
      const badge = $(this);
      badge.html('<i class="fe fe-loader fe-12 fa-spin"></i> Updating...');
      
      // AJAX call to update permission
      $.ajax({
        url: 'file-manager.php',
        type: 'POST',
        data: {
          action: 'update_permission',
          item_id: itemId,
          item_type: itemType,
          permission: newPermission
        },
        success: function(response) {
          // Update badge display
          if (newPermission === 'public') {
            badge.html('<i class="fe fe-users fe-12"></i> Public');
          } else {
            badge.html('<i class="fe fe-lock fe-12"></i> Private');
          }
          badge.data('permission', newPermission);
          
          // Show success message
          new Noty({
            type: 'success',
            text: 'Permission updated successfully',
            timeout: 2000,
            progressBar: true,
            layout: 'topRight'
          }).show();
        },
        error: function(xhr) {
          // Revert to original state
          if (currentPermission === 'public') {
            badge.html('<i class="fe fe-users fe-12"></i> Public');
          } else {
            badge.html('<i class="fe fe-lock fe-12"></i> Private');
          }
          
          // Show error message
          new Noty({
            type: 'error',
            text: 'Failed to update permission',
            timeout: 2000,
            progressBar: true,
            layout: 'topRight'
          }).show();
        }
      });
    });

    // Form submissions with loading states
    $('form').on('submit', function(e) {
      const form = $(this);
      const submitBtn = form.find('button[type="submit"]');
      const spinner = submitBtn.find('.spinner-border');
      const btnText = submitBtn.find('.submit-btn-text');
      
      // Show loading state
      btnText.addClass('d-none');
      spinner.removeClass('d-none');
      submitBtn.prop('disabled', true);
      $('#loadingSpinner').addClass('show');
      
      // For file upload forms, use FormData
      if (form.attr('id') === 'uploadFileForm') {
        e.preventDefault();
        
        const formData = new FormData(form[0]);
        
        $.ajax({
          url: form.attr('action'),
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function() {
            window.location.reload();
          },
          error: function(xhr) {
            // Reset button states
            btnText.removeClass('d-none');
            spinner.addClass('d-none');
            submitBtn.prop('disabled', false);
            $('#loadingSpinner').removeClass('show');
            
            let errorMsg = 'Upload failed. Please try again.';
            try {
              const response = JSON.parse(xhr.responseText);
              if (response.message) {
                errorMsg = response.message;
              }
            } catch (e) {
              console.error('Error parsing response:', e);
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
      } else {
        // For regular forms, let them submit normally
        return true;
      }
    });
  });
  </script>

 <?php include('./lms-footer.php'); ?>
