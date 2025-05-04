<?php

if (isset($_COOKIE['type']) && !empty($_COOKIE['type'])) {

  $type = $_COOKIE['type'];
} else {
  header('Location: index.php');
  exit;
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
  <title>Choose template - Messages | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="../css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="../css/app-dark.css" id="darkTheme" disabled>
  <style>
    .card {
      border-radius: 8px;
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
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chats.php.php">
              <i class="fe fe-message-circle fe-16"></i>
              <span class="ml-3 item-text">Live Chats</span>
              </i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="notifications.php">
              <i class="fe fe-navigation fe-16"></i>
              <span class="ml-3 item-text">Notifications</span>
              </i>
            </a>
          </li>



          <!-- Contacts -->
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Contacts</span>
          </p>
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a class="nav-link" href="parent-contacts.php">
                <i class="fe fe-users fe-16"></i>
                <span class="ml-3 item-text">Parent Contacts</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="teacher-contacts.php">
                <i class="fe fe-user-check fe-16"></i>
                <span class="ml-3 item-text">Teachers Contacts</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="staff-contacts.php">
                <i class="fe fe-book fe-16"></i>
                <span class="ml-3 item-text">Staff Contact</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="student-contacts.php">
                <i class="fe fe-smile fe-16"></i>
                <span class="ml-3 item-text">Students Contact</span>
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
              <a class="nav-link" href="notice-log.php">
                <i class="fe fe-file-text fe-16"></i>
                <span class="ml-3 item-text">Rinda Notice Log</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="chat-log.php">
                <i class="fe fe-file-text fe-16"></i>
                <span class="ml-3 item-text">Rinda Chats Log</span>
                </i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="rinda-message-settings.php">
                <i class="fe fe-tool fe-16"></i>
                <span class="ml-3 item-text">Rinda Message Settings</span>
                </i>
              </a>
            </li>
          </ul>
      </nav>
    </aside>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xl-12">
            <div class="row align-items-center my-3">
              <div class="col">
                <h4 class="page-title">Choose Template</h4>
              </div>
              <!-- <div class="col-auto">
                <button type="button" class="continue btn btn-success" id="addSubjectBtn">Skip <i
                    class=" fe fe-arrow-right"></i></button>
              </div> -->
            </div>
            <?php
            if ($type == 'parent') { ?>
              <div>
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>New Payment</h6>
                    <div class="accordion w-100" id="accordion1">
                      <div class="card shadow">
                        <div class="card-header" id="heading1">
                          <a style="text-decoration: none;" role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse1" class="collapse show  pb-4" aria-labelledby="heading1" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right" onclick="handleChooseClick('Lorem ipsum dolor sit amet, consectetur adipiscing elit?', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading2">
                          <a style="text-decoration: none;" role="button" href="#collapse2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse2" class="collapse  pb-4" aria-labelledby="heading2" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading3">
                          <a style="text-decoration: none;" role="button" href="#collapse3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse3" class="collapse  pb-4" aria-labelledby="heading3" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6 class="m-2">Default Payments</h6>
                    <div class="accordion w-100" id="accordion2">
                      <div class="card shadow">
                        <div class="card-header" id="heading4">
                          <a style="text-decoration: none;" role="button" href="#collapse4" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse4" class="collapse show  pb-4" aria-labelledby="heading4" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading5">
                          <a style="text-decoration: none;" role="button" href="#collapse5" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse5" class="collapse  pb-4" aria-labelledby="heading5" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading6">
                          <a style="text-decoration: none;" role="button" href="#collapse6" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse6" class="collapse  pb-4" aria-labelledby="heading6" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Payment Refund</h6>
                    <div class="accordion w-100" id="accordion3">
                      <div class="card shadow">
                        <div class="card-header" id="heading7">
                          <a style="text-decoration: none;" role="button" href="#collapse7" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse7" class="collapse show  pb-4" aria-labelledby="heading7" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>

                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading8">
                          <a style="text-decoration: none;" role="button" href="#collapse8" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse8" class="collapse  pb-4" aria-labelledby="heading8" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading9">
                          <a style="text-decoration: none;" role="button" href="#collapse9" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse9" class="collapse  pb-4" aria-labelledby="heading9" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6 class="m-2">Fees Increment</h6>
                    <div class="accordion w-100" id="accordion4">
                      <div class="card shadow">
                        <div class="card-header" id="heading10">
                          <a style="text-decoration: none;" role="button" href="#collapse10" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse10" class="collapse show  pb-4" aria-labelledby="heading10" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading11">
                          <a style="text-decoration: none;" role="button" href="#collapse11" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse11" class="collapse  pb-4" aria-labelledby="heading11" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading12">
                          <a style="text-decoration: none;" role="button" href="#collapse12" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse12" class="collapse  pb-4" aria-labelledby="heading12" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
              </div>
            <?php } elseif ($type == 'teacher') { ?>
              <div>
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>New Event</h6>
                    <div class="accordion w-100" id="accordion1">
                      <div class="card shadow">
                        <div class="card-header" id="heading1">
                          <a style="text-decoration: none;" role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse1" class="collapse show  pb-4" aria-labelledby="heading1" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading2">
                          <a style="text-decoration: none;" role="button" href="#collapse2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse2" class="collapse  pb-4" aria-labelledby="heading2" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading3">
                          <a style="text-decoration: none;" role="button" href="#collapse3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse3" class="collapse  pb-4" aria-labelledby="heading3" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6>Default Payments</h6>
                    <div class="accordion w-100" id="accordion2">
                      <div class="card shadow">
                        <div class="card-header" id="heading4">
                          <a style="text-decoration: none;" role="button" href="#collapse4" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse4" class="collapse show  pb-4" aria-labelledby="heading4" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading5">
                          <a style="text-decoration: none;" role="button" href="#collapse5" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse5" class="collapse  pb-4" aria-labelledby="heading5" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading6">
                          <a style="text-decoration: none;" role="button" href="#collapse6" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse6" class="collapse  pb-4" aria-labelledby="heading6" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Payment Refund</h6>
                    <div class="accordion w-100" id="accordion3">
                      <div class="card shadow">
                        <div class="card-header" id="heading7">
                          <a style="text-decoration: none;" role="button" href="#collapse7" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse7" class="collapse show  pb-4" aria-labelledby="heading7" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading8">
                          <a style="text-decoration: none;" role="button" href="#collapse8" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse8" class="collapse  pb-4" aria-labelledby="heading8" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading9">
                          <a style="text-decoration: none;" role="button" href="#collapse9" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse9" class="collapse  pb-4" aria-labelledby="heading9" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6>Fees Increment</h6>
                    <div class="accordion w-100" id="accordion4">
                      <div class="card shadow">
                        <div class="card-header" id="heading10">
                          <a style="text-decoration: none;" role="button" href="#collapse10" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse10" class="collapse show  pb-4" aria-labelledby="heading10" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading11">
                          <a style="text-decoration: none;" role="button" href="#collapse11" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse11" class="collapse  pb-4" aria-labelledby="heading11" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading12">
                          <a style="text-decoration: none;" role="button" href="#collapse12" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse12" class="collapse  pb-4" aria-labelledby="heading12" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
              </div>
            <?php } elseif ($type == 'staff') { ?>
              <div>
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Upcoming Holiday</h6>
                    <div class="accordion w-100" id="accordion1">
                      <div class="card shadow">
                        <div class="card-header" id="heading1">
                          <a style="text-decoration: none;" role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse1" class="collapse show  pb-4" aria-labelledby="heading1" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading2">
                          <a style="text-decoration: none;" role="button" href="#collapse2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse2" class="collapse  pb-4" aria-labelledby="heading2" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading3">
                          <a style="text-decoration: none;" role="button" href="#collapse3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse3" class="collapse  pb-4" aria-labelledby="heading3" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6>Default Payments</h6>
                    <div class="accordion w-100" id="accordion2">
                      <div class="card shadow">
                        <div class="card-header" id="heading4">
                          <a style="text-decoration: none;" role="button" href="#collapse4" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse4" class="collapse show  pb-4" aria-labelledby="heading4" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading5">
                          <a style="text-decoration: none;" role="button" href="#collapse5" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse5" class="collapse  pb-4" aria-labelledby="heading5" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading6">
                          <a style="text-decoration: none;" role="button" href="#collapse6" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse6" class="collapse  pb-4" aria-labelledby="heading6" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Payment Refund</h6>
                    <div class="accordion w-100" id="accordion3">
                      <div class="card shadow">
                        <div class="card-header" id="heading7">
                          <a style="text-decoration: none;" role="button" href="#collapse7" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse7" class="collapse show  pb-4" aria-labelledby="heading7" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading8">
                          <a style="text-decoration: none;" role="button" href="#collapse8" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse8" class="collapse  pb-4" aria-labelledby="heading8" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading9">
                          <a style="text-decoration: none;" role="button" href="#collapse9" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse9" class="collapse  pb-4" aria-labelledby="heading9" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6>Fees Increment</h6>
                    <div class="accordion w-100" id="accordion4">
                      <div class="card shadow">
                        <div class="card-header" id="heading10">
                          <a style="text-decoration: none;" role="button" href="#collapse10" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse10" class="collapse show  pb-4" aria-labelledby="heading10" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading11">
                          <a style="text-decoration: none;" role="button" href="#collapse11" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse11" class="collapse  pb-4" aria-labelledby="heading11" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading12">
                          <a style="text-decoration: none;" role="button" href="#collapse12" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse12" class="collapse  pb-4" aria-labelledby="heading12" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                          <a href="#" style="text-decoration: none;" class="col-12 ml-2 mb-5 text-right">Choose <i class=" fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
              </div>
            <?php } elseif ($type == 'student') { ?>
              <div>
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Exam Commencement</h6>
                    <div class="accordion w-100" id="accordion1">
                      <div class="card shadow">
                        <div class="card-header" id="heading1">
                          <a style="text-decoration: none;" role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse1" class="collapse show  pb-4" aria-labelledby="heading1" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading2">
                          <a style="text-decoration: none;" role="button" href="#collapse2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse2" class="collapse  pb-4" aria-labelledby="heading2" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading3">
                          <a style="text-decoration: none;" role="button" href="#collapse3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse3" class="collapse  pb-4" aria-labelledby="heading3" data-parent="#accordion1">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6>Default Payments</h6>
                    <div class="accordion w-100" id="accordion2">
                      <div class="card shadow">
                        <div class="card-header" id="heading4">
                          <a style="text-decoration: none;" role="button" href="#collapse4" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse4" class="collapse show  pb-4" aria-labelledby="heading4" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading5">
                          <a style="text-decoration: none;" role="button" href="#collapse5" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse5" class="collapse  pb-4" aria-labelledby="heading5" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading6">
                          <a style="text-decoration: none;" role="button" href="#collapse6" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse6" class="collapse  pb-4" aria-labelledby="heading6" data-parent="#accordion2">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Payment Refund</h6>
                    <div class="accordion w-100" id="accordion3">
                      <div class="card shadow">
                        <div class="card-header" id="heading7">
                          <a style="text-decoration: none;" role="button" href="#collapse7" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</strong>
                          </a>
                        </div>
                        <div id="collapse7" class="collapse show  pb-4" aria-labelledby="heading7" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading8">
                          <a style="text-decoration: none;" role="button" href="#collapse8" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            <strong>Dignissim suspendisse in est ante?</strong>
                          </a>
                        </div>
                        <div id="collapse8" class="collapse  pb-4" aria-labelledby="heading8" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading9">
                          <a style="text-decoration: none;" role="button" href="#collapse9" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            <strong>Sapien et ligula ullamcorper malesuada proin?</strong>
                          </a>
                        </div>
                        <div id="collapse9" class="collapse  pb-4" aria-labelledby="heading9" data-parent="#accordion3">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                  <div class="col-md-6">
                    <h6>Fees Increment</h6>
                    <div class="accordion w-100" id="accordion4">
                      <div class="card shadow">
                        <div class="card-header" id="heading10">
                          <a style="text-decoration: none;" role="button" href="#collapse10" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            <strong>Massa eget egestas purus viverra accumsan in nisl?</strong>
                          </a>
                        </div>
                        <div id="collapse10" class="collapse show  pb-4" aria-labelledby="heading10" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading11">
                          <a style="text-decoration: none;" role="button" href="#collapse11" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            <strong>Augue lacus viverra vitae congue eu?</strong>
                          </a>
                        </div>
                        <div id="collapse11" class="collapse  pb-4" aria-labelledby="heading11" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                      <div class="card shadow">
                        <div class="card-header" id="heading12">
                          <a style="text-decoration: none;" role="button" href="#collapse12" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                            <strong>Pharetra massa massa ultricies mi quis?</strong>
                          </a>
                        </div>
                        <div id="collapse12" class="collapse  pb-4" aria-labelledby="heading12" data-parent="#accordion4">
                          <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                            terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                            Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
                            on it squid single-origin coffee nulla assumenda shoreditch et. </div>
                        </div>
                      </div>
                    </div>
                  </div> <!-- /.col -->
                </div> <!-- end section -->
              </div>
            <?php } else {
              header("Location: index.html");
              exit();
            }
            ?>

          </div> <!-- /.col -->
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

                    <div class="col text-center">
                      <small><strong>You're well up to date</strong></small>
                      <div class="my-0 text-muted small">No notifications available</div>
                    </div>
                  </div>
                </div>
              </div> <!-- / .list-group -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear All</button>
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
                  <a href="../lms" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">E-Learning</p>
                  </a>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Messages</p>
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
    </main> <!-- main -->
  </div> <!-- .wrapper -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/moment.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src='../js/daterangepicker.js'></script>
  <script src='../js/jquery.stickOnScroll.js'></script>
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src="../js/apps.js"></script>
  <script>
    // Function to set cookies
    function setCookie(name, value) {
      document.cookie = name + "=" + value + "; path=/";
    }

    // Function to handle "Choose" link click
    function handleChooseClick(templateName, content) {
      // Set cookies for template name and content
      setCookie('subject', templateName);
      setCookie('content', content);
      console.log(templateName);
      console.log(content);

      // Redirect to compile-message.php
      window.location.href = 'compile-notification.php';
    }
  </script>
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