<?php
require_once('../settings.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title> | Rinda AMS</title>
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
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

          <li class="nav-item active">
            <a class="nav-link" href="#">
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
              <a class="nav-link text-primary" href="calendar.php">
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
          <p class="nav-heading mt-4 mb-1">
            <span>Hostel</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="hostel.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Hostels</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="room-types.php">
                <i class="fe fe-user-plus fe-16"></i>
                <span class="ml-3 item-text">Room Types</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="hostel-membership.php">
                <i class="fe fe-file-plus fe-16"></i>
                <span class="ml-3 item-text">Membership</span>
                </i>
              </a>
            </li>
          </ul>
        </nav>
      </aside>
      <main role="main" class="main-content">