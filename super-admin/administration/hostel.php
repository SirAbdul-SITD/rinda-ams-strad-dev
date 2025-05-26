<?php require_once '../settings.php'; ?>
<<<<<<< HEAD
<?php

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new hostel
    if (isset($_POST['add_hostel'])) {
        $hostel_name = $_POST['hostel_name'];
        $hostel_type = $_POST['hostel_type'];
        $capacity = (int)$_POST['capacity'];
        $current_students = (int)$_POST['current_students'];
        $description = $_POST['description'];
        $occupancy_percentage = ($capacity > 0) ? ($current_students / $capacity) * 100 : 0;

        try {
            $sql = "INSERT INTO hostels 
                        (hostel_name, hostel_type, capacity, current_students, occupancy_percentage, description) 
                    VALUES 
                        (:hostel_name, :hostel_type, :capacity, :current_students, :occupancy_percentage, :description)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':hostel_name' => $hostel_name,
                ':hostel_type' => $hostel_type,
                ':capacity' => $capacity,
                ':current_students' => $current_students,
                ':occupancy_percentage' => $occupancy_percentage,
                ':description' => $description
            ]);
            $success_msg = "Hostel added successfully!";
        } catch (PDOException $e) {
            $error_msg = "Add Error: " . $e->getMessage();
        }
    }

    // Update hostel
    if (isset($_POST['update_hostel'])) {
        $id = (int)$_POST['hostel_id'];
        $hostel_name = $_POST['hostel_name'];
        $hostel_type = $_POST['hostel_type'];
        $capacity = (int)$_POST['capacity'];
        $current_students = (int)$_POST['current_students'];
        $description = $_POST['description'];
        $occupancy_percentage = ($capacity > 0) ? ($current_students / $capacity) * 100 : 0;

        try {
            $sql = "UPDATE hostels SET 
                        hostel_name = :hostel_name,
                        hostel_type = :hostel_type,
                        capacity = :capacity,
                        current_students = :current_students,
                        occupancy_percentage = :occupancy_percentage,
                        description = :description
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':hostel_name' => $hostel_name,
                ':hostel_type' => $hostel_type,
                ':capacity' => $capacity,
                ':current_students' => $current_students,
                ':occupancy_percentage' => $occupancy_percentage,
                ':description' => $description,
                ':id' => $id
            ]);
            $success_msg = "Hostel updated successfully!";
        } catch (PDOException $e) {
            $error_msg = "Update Error: " . $e->getMessage();
        }
    }
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];

    try {
        $sql = "DELETE FROM hostels WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $success_msg = "Hostel deleted successfully!";
    } catch (PDOException $e) {
        $error_msg = "Delete Error: " . $e->getMessage();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get hostel statistics
$total_hostels = 0;
$total_boys = 0;
$total_girls = 0;

try {
    $sql = "SELECT 
                COUNT(*) AS total_hostels,
                SUM(CASE WHEN hostel_type = 'Boys' THEN current_students ELSE 0 END) AS total_boys,
                SUM(CASE WHEN hostel_type = 'Girls' THEN current_students ELSE 0 END) AS total_girls
            FROM hostels";
    $stmt = $pdo->query($sql);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stats) {
        $total_hostels = $stats['total_hostels'];
        $total_boys = $stats['total_boys'];
        $total_girls = $stats['total_girls'];
    }
} catch (PDOException $e) {
    $error_msg = "Stats Error: " . $e->getMessage();
}

// Get all hostels
$hostels = [];

try {
    $sql = "SELECT * FROM hostels ORDER BY hostel_name";
    $stmt = $pdo->query($sql);
    $hostels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_msg = "Fetch Error: " . $e->getMessage();
}

// Get hostel data for editing
$edit_hostel = null;
if (isset($_GET['edit_id'])) {
    $id = (int)$_GET['edit_id'];

    try {
        $sql = "SELECT * FROM hostels WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $edit_hostel = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_msg = "Edit Fetch Error: " . $e->getMessage();
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
  <title>Rinda AMS | Rinda AMS</title>
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
  <style>
    .card {
      border-radius: 8px;
    }

    .modal-shortcut .con-item {
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .modal-shortcut .con-item:hover {
      transform: scale(1.05);
    }
    
    .progress {
      height: 10px;
    }
    
    .capacity-info {
      font-size: 0.8rem;
      color: #6c757d;
    }
    
    .badge-boys {
      background-color: #467fd0;
      color: white;
    }
    
    .badge-girls {
      background-color: #d63384;
      color: white;
    }
  </style>
</head>

<body class="vertical  light  ">
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
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
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
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">General Fees</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="invoices.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">Student Invoices</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="expenses.php">
              <i class="fe fe-users fe-16"></i>
              <span class="ml-3 item-text">School Expenses</span>
              </i>
            </a>
          </li>

          <!-- Subscriptions Types -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Subscriptions</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item">
              <a class="nav-link" href="breakfast.php">
                <i class="fe fe-coffee fe-16"></i>
                <span class="ml-3 item-text">Breakfast</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="lunch.php">
                <i class="fe fe-slack fe-16"></i>
                <span class="ml-3 item-text">Lunch</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shuttle.php">
                <i class="fe fe-truck fe-16"></i>
                <span class="ml-3 item-text">Shuttle</span>
                </i>
              </a>
            </li>
          </ul>

          <!-- Extras -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Extras</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="calendar.php">
                <i class="fe fe-calendar fe-16"></i>
                <span class="ml-3 item-text">Academic Calendar</span>
                </i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="notice-board.php">
                <i class="fe fe-bell fe-16"></i>
                <span class="ml-3 item-text">Notice Board</span>
                </i>
              </a>
            </li>
          </ul>
          <!-- Hostel -->
          <p class=" nav-heading mt-4 mb-1">
            <span>Hostel</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Hostels</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="room-types.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Room Types</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="hostel-membership.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Membership</span>
                </i>
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
              <!-- Summary Cards -->
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <h4 class="mb-0"><?= $total_hostels ?></h4>
                        <p class="mb-0 text-muted">Total Hostels</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-home fe-24 text-primary"></span>
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
                        <h4 class="mb-0"><?= $total_boys ?></h4>
                        <p class="mb-0 text-muted">Boys in Hostels</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-users fe-24 text-info"></span>
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
                        <h4 class="mb-0"><?= $total_girls ?></h4>
                        <p class="mb-0 text-muted">Girls in Hostels</p>
                      </div>
                      <div class="col-4 text-right">
                        <span class="fe fe-users fe-24 text-danger"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Hostel Table -->
              <div class="col-md-12 my-4">
                <div class="row align-items-center my-3">
                  <div class="col">
                    <h3 class="page-title">Hostel</h3>
                  </div>
                  <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hostelModal">
                      <span class="fe fe-plus fe-16 mr-3"></span>New Hostel
                    </button>
                  </div>
                </div>
                
                <?php if (isset($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $success_msg ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php endif; ?>
                
                <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $error_msg ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php endif; ?>
                
                <div class="card shadow">
                  <div class="card-body">
                    <table class="table table-borderless table-hover" id="hostelTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Hostel Name</th>
                          <th>Type</th>
                          <th>Capacity</th>
                          <th>Occupancy</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($hostels as $index => $hostel): ?>
                        <tr>
                          <td><?= $index + 1 ?></td>
                          <td>
                            <p class="mb-0 text-muted"><strong><?= htmlspecialchars($hostel['hostel_name']) ?></strong></p>
                            <small class="text-muted"><?= htmlspecialchars($hostel['description']) ?></small>
                          </td>
                          <td>
                            <?php if ($hostel['hostel_type'] == 'Boys'): ?>
                              <span class="badge badge-boys">Boys</span>
                            <?php else: ?>
                              <span class="badge badge-girls">Girls</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?= $hostel['current_students'] ?> / <?= $hostel['capacity'] ?>
                            <div class="progress mt-1">
                              <div class="progress-bar 
                                <?= ($hostel['occupancy_percentage'] > 90) ? 'bg-danger' : 
                                   (($hostel['occupancy_percentage'] > 70) ? 'bg-warning' : 'bg-success') ?>" 
                                role="progressbar" style="width: <?= $hostel['occupancy_percentage'] ?>%" 
                                aria-valuenow="<?= $hostel['occupancy_percentage'] ?>" 
                                aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                            <small class="capacity-info"><?= round($hostel['occupancy_percentage'], 2) ?>% occupied</small>
                          </td>
                          <td>
                            <?= $hostel['current_students'] ?>
                          </td>
                          <td>
                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="text-muted sr-only">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="?edit_id=<?= $hostel['id'] ?>">Edit</a>
                              <a class="dropdown-item delete-hostel" href="?delete_id=<?= $hostel['id'] ?>" onclick="return confirm('Are you sure you want to delete this hostel?')">Remove</a>
                            </div>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Add/Edit Hostel Modal -->
      <div class="modal fade" id="hostelModal" tabindex="-1" role="dialog" aria-labelledby="hostelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="hostelModalLabel"><?= isset($edit_hostel) ? 'Edit' : 'Add New' ?> Hostel</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="">
              <div class="modal-body">
                <?php if (isset($edit_hostel)): ?>
                <input type="hidden" name="hostel_id" value="<?= $edit_hostel['id'] ?>">
                <?php endif; ?>
                
                <div class="form-group">
                  <label for="hostel_name">Hostel Name</label>
                  <input type="text" class="form-control" id="hostel_name" name="hostel_name" 
                    value="<?= isset($edit_hostel) ? htmlspecialchars($edit_hostel['hostel_name']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                  <label for="hostel_type">Hostel Type</label>
                  <select class="form-control" id="hostel_type" name="hostel_type" required>
                    <option value="">Select Type</option>
                    <option value="Boys" <?= (isset($edit_hostel) && $edit_hostel['hostel_type'] == 'Boys') ? 'selected' : '' ?>>Boys</option>
                    <option value="Girls" <?= (isset($edit_hostel) && $edit_hostel['hostel_type'] == 'Girls') ? 'selected' : '' ?>>Girls</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="capacity">Total Capacity</label>
                  <input type="number" class="form-control" id="capacity" name="capacity" 
                    value="<?= isset($edit_hostel) ? $edit_hostel['capacity'] : '' ?>" min="1" required>
                </div>
                
                <div class="form-group">
                  <label for="current_students">Current Students</label>
                  <input type="number" class="form-control" id="current_students" name="current_students" 
                    value="<?= isset($edit_hostel) ? $edit_hostel['current_students'] : '' ?>" min="0" required>
                  <small class="form-text text-muted">Number of students currently in this hostel</small>
                </div>
                
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="2"><?= isset($edit_hostel) ? htmlspecialchars($edit_hostel['description']) : '' ?></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="<?= isset($edit_hostel) ? 'update_hostel' : 'add_hostel' ?>" class="btn btn-primary">
                  <?= isset($edit_hostel) ? 'Update' : 'Save' ?> Hostel
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <!-- Existing Notification Modal -->
      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="defaultModalLabel">Notifications</h5> <button type="button" class="close"
                data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
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
            <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"
                disabled>Clear All</button> </div>
          </div>
        </div>
      </div>
      
      <!-- Existing Shortcut Modal -->
      <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
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
                  <a href="../academics/" style="text-decoration: none;">
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
    </main>
  </div>
  
  <!-- Existing JavaScript Includes -->
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
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#hostelTable').DataTable({
        autoWidth: true,
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ]
      });
      
      // Validate current students doesn't exceed capacity
      $('#current_students').on('change', function() {
        var capacity = parseInt($('#capacity').val());
        var current = parseInt($(this).val());
        
        if (current > capacity) {
          alert('Current students cannot exceed capacity!');
          $(this).val(capacity);
        }
      });
      
      // Capacity must be at least 1
      $('#capacity').on('change', function() {
        if (parseInt($(this).val()) < 1) {
          alert('Capacity must be at least 1');
          $(this).val(1);
        }
      });
      
      // Auto-calculate percentage when values change
      $('#capacity, #current_students').on('input', function() {
        var capacity = parseInt($('#capacity').val()) || 0;
        var current = parseInt($('#current_students').val()) || 0;
        
        if (capacity > 0 && current >= 0) {
          var percentage = (current / capacity) * 100;
          if (percentage > 100) {
            $('#current_students').val(capacity);
            percentage = 100;
          }
        }
      });
      
      // Auto-open modal if in edit mode
      <?php if (isset($edit_hostel)): ?>
        $('#hostelModal').modal('show');
      <?php endif; ?>
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