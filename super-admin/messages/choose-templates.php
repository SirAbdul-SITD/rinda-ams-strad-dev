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
  <link rel="icon" href="../assets/images/logo.jpg">
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

    .modal-shortcut .con-item {
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .modal-shortcut .con-item:hover {
      transform: scale(1.05);
    }

    .popup {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      z-index: 9999;
      display: flex;
      align-items: center;
      background-color: rgba(0, 10, 5, 0.8);
      /* Background color with opacity */
      color: #fff;
    }

    .popup.success {
      background-color: #4CAF50;
      color: #fff;
    }

    .popup.error {
      background-color: #F44336;
      color: white;
    }

    .popup i {
      margin-right: 5px;
    }

    @media (max-width: 768px) {
      .desktop {
        display: none;
        min-width: 720px;
      }
    }


    @media (min-width: 768px) {
      .mobile {
        display: none;
        min-width: 720px;
      }
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
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Dashboard</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Dashboard</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://web.whatsapp.com" target="_blank">
              <i class="fe fe-message-circle fe-16"></i>
              <span class="ml-3 item-text">Live Chats</span>
              </i>
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link text-primary" href="notifications.php">
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
                <!-- Row 1 -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Academics & Learning Updates</h6>
                    <div class="accordion w-100" id="accordionAcademics">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="acadHeading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#acadCollapse1"
                            aria-expanded="true" aria-controls="acadCollapse1">
                            <strong>Report Card Available</strong>
                          </a>
                        </div>
                        <div id="acadCollapse1" class="collapse show pb-4" aria-labelledby="acadHeading1"
                          data-parent="#accordionAcademics">
                          <div class="card-body">
                            Dear Parent, [Child]’s semester report card is available online. Please log in to the parent
                            portal by
                            [Date] to view grades or contact us with questions.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Report Card Available', 'Dear Parent, [Child]’s semester report card is available online. Please log in to the parent portal by [Date] to view grades or contact us with questions.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="acadHeading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#acadCollapse2"
                            aria-expanded="false" aria-controls="acadCollapse2">
                            <strong>High Quiz Score</strong>
                          </a>
                        </div>
                        <div id="acadCollapse2" class="collapse pb-4" aria-labelledby="acadHeading2"
                          data-parent="#accordionAcademics">
                          <div class="card-body">
                            Great news: [Child] scored 95% on today’s math quiz. Thank you for your support at home – keep
                            up the
                            great work!
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('High Quiz Score', 'Great news: [Child] scored 95% on today’s math quiz. Thank you for your support at home – keep up the great work!')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="acadHeading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#acadCollapse3"
                            aria-expanded="false" aria-controls="acadCollapse3">
                            <strong>Missing Assignment</strong>
                          </a>
                        </div>
                        <div id="acadCollapse3" class="collapse pb-4" aria-labelledby="acadHeading3"
                          data-parent="#accordionAcademics">
                          <div class="card-body">
                            Alert: [Child] has a missing science assignment from last week. Please have [him/her] submit
                            it by [Date]
                            to receive credit.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Missing Assignment', 'Alert: [Child] has a missing science assignment from last week. Please have [him/her] submit it by [Date] to receive credit.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Attendance & Punctuality</h6>
                    <div class="accordion w-100" id="accordionAttendance">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="attHeading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#attCollapse1"
                            aria-expanded="true" aria-controls="attCollapse1">
                            <strong>Absence Notice</strong>
                          </a>
                        </div>
                        <div id="attCollapse1" class="collapse show pb-4" aria-labelledby="attHeading1"
                          data-parent="#accordionAttendance">
                          <div class="card-body">
                            Dear Parent, [Child] was marked absent on [Date]. Please provide a written note with the
                            reason for
                            absence. Thank you.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Absence Notice', 'Dear Parent, [Child] was marked absent on [Date]. Please provide a written note with the reason for absence. Thank you.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="attHeading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#attCollapse2"
                            aria-expanded="false" aria-controls="attCollapse2">
                            <strong>Late Arrival Reminder</strong>
                          </a>
                        </div>
                        <div id="attCollapse2" class="collapse pb-4" aria-labelledby="attHeading2"
                          data-parent="#accordionAttendance">
                          <div class="card-body">
                            Reminder: [Child] arrived late to class 3 times this month. Please ensure [he/she] arrives on
                            time daily
                            to avoid missing instruction.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Late Arrival Reminder', 'Reminder: [Child] arrived late to class 3 times this month. Please ensure [he/she] arrives on time daily to avoid missing instruction.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="attHeading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#attCollapse3"
                            aria-expanded="false" aria-controls="attCollapse3">
                            <strong>Unexcused Absences</strong>
                          </a>
                        </div>
                        <div id="attCollapse3" class="collapse pb-4" aria-labelledby="attHeading3"
                          data-parent="#accordionAttendance">
                          <div class="card-body">
                            Notice: [Child] has 5 unexcused absences this term. Under our attendance policy we need to
                            meet to discuss
                            support. Please call the office to schedule.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Unexcused Absences', 'Notice: [Child] has 5 unexcused absences this term. Under our attendance policy we need to meet to discuss support. Please call the office to schedule.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 2 -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Health & Safety Alerts</h6>
                    <div class="accordion w-100" id="accordionHealth">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="healthHeading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#healthCollapse1"
                            aria-expanded="true" aria-controls="healthCollapse1">
                            <strong>Feeling Ill at School</strong>
                          </a>
                        </div>
                        <div id="healthCollapse1" class="collapse show pb-4" aria-labelledby="healthHeading1"
                          data-parent="#accordionHealth">
                          <div class="card-body">
                            Health Notice: [Child] reported feeling ill in class and was checked by the nurse. We will
                            call if
                            condition worsens.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Feeling Ill at School', 'Health Notice: [Child] reported feeling ill in class and was checked by the nurse. We will call if condition worsens.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="healthHeading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#healthCollapse2"
                            aria-expanded="false" aria-controls="healthCollapse2">
                            <strong>First Aid Administered</strong>
                          </a>
                        </div>
                        <div id="healthCollapse2" class="collapse pb-4" aria-labelledby="healthHeading2"
                          data-parent="#accordionHealth">
                          <div class="card-body">
                            Dear Parent, [Child] fell in PE class and has a minor sprain. We applied first aid. Please
                            check [him/her]
                            after school.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('First Aid Administered', 'Dear Parent, [Child] fell in PE class and has a minor sprain. We applied first aid. Please check [him/her] after school.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="healthHeading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#healthCollapse3"
                            aria-expanded="false" aria-controls="healthCollapse3">
                            <strong>Immunization Reminder</strong>
                          </a>
                        </div>
                        <div id="healthCollapse3" class="collapse pb-4" aria-labelledby="healthHeading3"
                          data-parent="#accordionHealth">
                          <div class="card-body">
                            Reminder: State law requires updated immunizations by [Date]. Please send records to the
                            school nurse by
                            then.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Immunization Reminder', 'Reminder: State law requires updated immunizations by [Date]. Please send records to the school nurse by then.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Events & Activities</h6>
                    <div class="accordion w-100" id="accordionEvents">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="eventHeading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#eventCollapse1"
                            aria-expanded="true" aria-controls="eventCollapse1">
                            <strong>Field Trip Permission</strong>
                          </a>
                        </div>
                        <div id="eventCollapse1" class="collapse show pb-4" aria-labelledby="eventHeading1"
                          data-parent="#accordionEvents">
                          <div class="card-body">
                            Reminder: Field trip on [Date] to [Location]. Please sign and return the permission slip by
                            [Date].
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Field Trip Permission', 'Reminder: Field trip on [Date] to [Location]. Please sign and return the permission slip by [Date].')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="eventHeading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#eventCollapse2"
                            aria-expanded="false" aria-controls="eventCollapse2">
                            <strong>Spring Concert Invite</strong>
                          </a>
                        </div>
                        <div id="eventCollapse2" class="collapse pb-4" aria-labelledby="eventHeading2"
                          data-parent="#accordionEvents">
                          <div class="card-body">
                            Join us: Spring Concert on [Date] at [Time] in the auditorium. We look forward to seeing you
                            there!
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Spring Concert Invite', 'Join us: Spring Concert on [Date] at [Time] in the auditorium. We look forward to seeing you there!')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="eventHeading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#eventCollapse3"
                            aria-expanded="false" aria-controls="eventCollapse3">
                            <strong>Volunteer Opportunity</strong>
                          </a>
                        </div>
                        <div id="eventCollapse3" class="collapse pb-4" aria-labelledby="eventHeading3"
                          data-parent="#accordionEvents">
                          <div class="card-body">
                            Volunteer: We need chaperones for the science fair on [Date]. If you can help, contact
                            [Coordinator].
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Volunteer Opportunity', 'Volunteer: We need chaperones for the science fair on [Date]. If you can help, contact [Coordinator].')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Row 1 -->
                <div class="row my-4">
                  <!-- Behavior & Conduct Notices -->
                  <div class="col-md-6">
                    <h6>Behavior & Conduct Notices</h6>
                    <div class="accordion w-100" id="accordionBehavior">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="behavHeading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#behavCollapse1"
                            aria-expanded="true" aria-controls="behavCollapse1">
                            <strong>Positive Behavior</strong>
                          </a>
                        </div>
                        <div id="behavCollapse1" class="collapse show pb-4" aria-labelledby="behavHeading1"
                          data-parent="#accordionBehavior">
                          <div class="card-body">
                            Good news: [Child] helped a classmate today. We appreciate [his/her] kindness
                            and wanted to share!
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
            'Positive Behavior',
            'Good news: [Child] helped a classmate today. We appreciate [his/her] kindness and wanted to share!'
          )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="behavHeading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#behavCollapse2"
                            aria-expanded="false" aria-controls="behavCollapse2">
                            <strong>Rule Reminder</strong>
                          </a>
                        </div>
                        <div id="behavCollapse2" class="collapse pb-4" aria-labelledby="behavHeading2"
                          data-parent="#accordionBehavior">
                          <div class="card-body">
                            Notice: [Child] received a warning today for speaking out of turn in class.
                            Please remind [him/her] about our classroom rules so [he/she] can improve.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
            'Rule Reminder',
            'Notice: [Child] received a warning today for speaking out of turn in class. Please remind [him/her] about our classroom rules so [he/she] can improve.'
          )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="behavHeading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#behavCollapse3"
                            aria-expanded="false" aria-controls="behavCollapse3">
                            <strong>Character Award</strong>
                          </a>
                        </div>
                        <div id="behavCollapse3" class="collapse pb-4" aria-labelledby="behavHeading3"
                          data-parent="#accordionBehavior">
                          <div class="card-body">
                            Congratulations: [Child] earned the Character Award this week for excellent
                            teamwork. Thank you for reinforcing positive behaviors at home!
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
            'Character Award',
            'Congratulations: [Child] earned the Character Award this week for excellent teamwork. Thank you for reinforcing positive behaviors at home!'
          )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <h6>General Logistics & Reminders</h6>
                    <div class="accordion w-100" id="accordionLogistics">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="logHeading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#logCollapse1"
                            aria-expanded="true" aria-controls="logCollapse1">
                            <strong>School Closure</strong>
                          </a>
                        </div>
                        <div id="logCollapse1" class="collapse show pb-4" aria-labelledby="logHeading1"
                          data-parent="#accordionLogistics">
                          <div class="card-body">
                            Closure Notice: School will be closed on [Date] for [Holiday]. Classes resume on [Date].
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('School Closure', 'Closure Notice: School will be closed on [Date] for [Holiday]. Classes resume on [Date].')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="logHeading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#logCollapse2"
                            aria-expanded="false" aria-controls="logCollapse2">
                            <strong>Bus Delay Alert</strong>
                          </a>
                        </div>
                        <div id="logCollapse2" class="collapse pb-4" aria-labelledby="logHeading2"
                          data-parent="#accordionLogistics">
                          <div class="card-body">
                            Alert: Today’s bus routes are running 20 minutes late due to traffic. Please adjust pickup
                            times accordingly.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Bus Delay Alert', 'Alert: Today’s bus routes are running 20 minutes late due to traffic. Please adjust pickup times accordingly.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="logHeading4">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#logCollapse4"
                            aria-expanded="false" aria-controls="logCollapse4">
                            <strong>Next Year Registration</strong>
                          </a>
                        </div>
                        <div id="logCollapse4" class="collapse pb-4" aria-labelledby="logHeading4"
                          data-parent="#accordionLogistics">
                          <div class="card-body">
                            Registration for next year is now open. Log in to the portal and complete your child’s
                            enrollment by [Date].
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Next Year Registration', 'Registration for next year is now open. Log in to the portal and complete your child’s enrollment by [Date].')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } elseif ($type == 'teacher') { ?>
              <div>
                <!-- Row 1: Lesson Planning & Materials, Class Performance Reports -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Lesson Planning & Materials</h6>
                    <div class="accordion w-100" id="accordionTeach1">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach1Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach1Collapse1"
                            aria-expanded="true" aria-controls="teach1Collapse1">
                            <strong>New Curriculum Resources</strong>
                          </a>
                        </div>
                        <div id="teach1Collapse1" class="collapse show pb-4" aria-labelledby="teach1Heading1"
                          data-parent="#accordionTeach1">
                          <div class="card-body">
                            Please review the new Science curriculum packets uploaded to the shared drive by Monday.
                            Notify the department if files are missing.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('New Curriculum Resources','Please review the new Science curriculum packets uploaded to the shared drive by Monday. Notify the department if files are missing.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach1Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach1Collapse2"
                            aria-expanded="false" aria-controls="teach1Collapse2">
                            <strong>Lesson Plan Submission</strong>
                          </a>
                        </div>
                        <div id="teach1Collapse2" class="collapse pb-4" aria-labelledby="teach1Heading2"
                          data-parent="#accordionTeach1">
                          <div class="card-body">
                            Reminder: Submit your Week 3 lesson plans by Friday 5 PM. Use the online template to ensure
                            district compliance.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Lesson Plan Submission','Reminder: Submit your Week 3 lesson plans by Friday 5 PM. Use the online template to ensure district compliance.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach1Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach1Collapse3"
                            aria-expanded="false" aria-controls="teach1Collapse3">
                            <strong>Resource Request Approved</strong>
                          </a>
                        </div>
                        <div id="teach1Collapse3" class="collapse pb-4" aria-labelledby="teach1Heading3"
                          data-parent="#accordionTeach1">
                          <div class="card-body">
                            Your request for additional classroom markers and chart paper has been approved. Supplies will
                            arrive by Wednesday.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Resource Request Approved','Your request for additional classroom markers and chart paper has been approved. Supplies will arrive by Wednesday.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Class Performance Reports</h6>
                    <div class="accordion w-100" id="accordionTeach2">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach2Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach2Collapse1"
                            aria-expanded="true" aria-controls="teach2Collapse1">
                            <strong>Weekly Progress Summary</strong>
                          </a>
                        </div>
                        <div id="teach2Collapse1" class="collapse show pb-4" aria-labelledby="teach2Heading1"
                          data-parent="#accordionTeach2">
                          <div class="card-body">
                            The Week 2 performance report for your class is posted. Highlights include average quiz scores
                            and areas for reteaching.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Weekly Progress Summary','The Week 2 performance report for your class is posted. Highlights include average quiz scores and areas for reteaching.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach2Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach2Collapse2"
                            aria-expanded="false" aria-controls="teach2Collapse2">
                            <strong>Exceptional Improvement</strong>
                          </a>
                        </div>
                        <div id="teach2Collapse2" class="collapse pb-4" aria-labelledby="teach2Heading2"
                          data-parent="#accordionTeach2">
                          <div class="card-body">
                            Congratulations: Your students exceeded the district benchmark in Reading. Consider sharing
                            your strategies at the next staff meeting.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Exceptional Improvement','Congratulations: Your students exceeded the district benchmark in Reading. Consider sharing your strategies at the next staff meeting.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach2Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach2Collapse3"
                            aria-expanded="false" aria-controls="teach2Collapse3">
                            <strong>At-Risk Student Alert</strong>
                          </a>
                        </div>
                        <div id="teach2Collapse3" class="collapse pb-4" aria-labelledby="teach2Heading3"
                          data-parent="#accordionTeach2">
                          <div class="card-body">
                            Alert: [Student] is performing below expectations in Math with two consecutive F grades.
                            Please schedule a parent conference.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('At-Risk Student Alert','Alert: [Student] is performing below expectations in Math with two consecutive F grades. Please schedule a parent conference.')">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 2: Behavioral Alerts, Staff Meetings & PD -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Behavioral Alerts</h6>
                    <div class="accordion w-100" id="accordionTeach3">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach3Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach3Collapse1"
                            aria-expanded="true" aria-controls="teach3Collapse1">
                            <strong>Classroom Disruption</strong>
                          </a>
                        </div>
                        <div id="teach3Collapse1" class="collapse show pb-4" aria-labelledby="teach3Heading1"
                          data-parent="#accordionTeach3">
                          <div class="card-body">
                            Alert: [Student] was involved in a classroom disruption today. Please discuss appropriate
                            behavior with them at home.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Classroom Disruption','Alert: [Student] was involved in a classroom disruption today. Please discuss appropriate behavior with them at home.')">Choose
                            <i class="fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach3Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach3Collapse2"
                            aria-expanded="false" aria-controls="teach3Collapse2">
                            <strong>Positive Contribution</strong>
                          </a>
                        </div>
                        <div id="teach3Collapse2" class="collapse pb-4" aria-labelledby="teach3Heading2"
                          data-parent="#accordionTeach3">
                          <div class="card-body">
                            Good job: [Student] assisted a peer with classwork today. Please congratulate them for their
                            leadership.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Positive Contribution','Good job: [Student] assisted a peer with classwork today. Please congratulate them for their leadership.')">Choose
                            <i class="fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach3Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach3Collapse3"
                            aria-expanded="false" aria-controls="teach3Collapse3">
                            <strong>Peer Conflict</strong>
                          </a>
                        </div>
                        <div id="teach3Collapse3" class="collapse pb-4" aria-labelledby="teach3Heading3"
                          data-parent="#accordionTeach3">
                          <div class="card-body">
                            Notice: [Student] was involved in a conflict with another student. We have addressed it;
                            please reinforce conflict-resolution skills at home.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Peer Conflict','Notice: [Student] was involved in a conflict with another student. We have addressed it; please reinforce conflict-resolution skills at home.')">Choose
                            <i class="fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Staff Meetings & PD</h6>
                    <div class="accordion w-100" id="accordionTeach4">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach4Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach4Collapse1"
                            aria-expanded="true" aria-controls="teach4Collapse1">
                            <strong>Upcoming Staff Meeting</strong>
                          </a>
                        </div>
                        <div id="teach4Collapse1" class="collapse show pb-4" aria-labelledby="teach4Heading1"
                          data-parent="#accordionTeach4">
                          <div class="card-body">
                            Reminder: Staff meeting this Friday at 3 PM in the library. Agenda includes curriculum review
                            and safety protocols.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Upcoming Staff Meeting','Reminder: Staff meeting this Friday at 3 PM in the library. Agenda includes curriculum review and safety protocols.')">Choose
                            <i class="fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach4Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach4Collapse2"
                            aria-expanded="false" aria-controls="teach4Collapse2">
                            <strong>PD Workshop Available</strong>
                          </a>
                        </div>
                        <div id="#teach4Collapse2" class="collapse pb-4" aria-labelledby="teach4Heading2"
                          data-parent="#accordionTeach4">
                          <div class="card-body">
                            Sign up: Classroom management workshop on [Date] at 4 PM. Register via the HR portal by
                            [Deadline].
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('PD Workshop Available','Sign up: Classroom management workshop on [Date] at 4 PM. Register via the HR portal by [Deadline].')">Choose
                            <i class="fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach4Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach4Collapse3"
                            aria-expanded="false" aria-controls="teach4Collapse3">
                            <strong>Meeting Minutes Posted</strong>
                          </a>
                        </div>
                        <div id="teach4Collapse3" class="collapse pb-4" aria-labelledby="teach4Heading3"
                          data-parent="#accordionTeach4">
                          <div class="card-body">
                            The minutes from last week’s staff meeting are now available on the shared drive under
                            'Meeting Minutes'.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none"
                            onclick="handleChooseClick('Meeting Minutes Posted','The minutes from last week’s staff meeting are now available on the shared drive under \'Meeting Minutes\'.')">Choose
                            <i class="fe fe-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 3: Policy Updates, Emergency Procedures -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>School Policy Updates</h6>
                    <div class="accordion w-100" id="accordionTeach5">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach5Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach5Collapse1"
                            aria-expanded="true" aria-controls="teach5Collapse1">
                            <strong>Attendance Policy Revision</strong>
                          </a>
                        </div>
                        <div id="teach5Collapse1" class="collapse show pb-4" aria-labelledby="teach5Heading1"
                          data-parent="#accordionTeach5">
                          <div class="card-body">
                            The attendance policy has been updated. Teachers must submit weekly attendance by 10 AM each
                            Monday.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
               'Attendance Policy Revision',
               'The attendance policy has been updated. Teachers must submit weekly attendance by 10 AM each Monday.'
             )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach5Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach5Collapse2"
                            aria-expanded="false" aria-controls="teach5Collapse2">
                            <strong>Grading Scale Update</strong>
                          </a>
                        </div>
                        <div id="teach5Collapse2" class="collapse pb-4" aria-labelledby="teach5Heading2"
                          data-parent="#accordionTeach5">
                          <div class="card-body">
                            Reminder: The new grading scale is in effect this term. Consult the handbook for grade
                            boundaries and weightings.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
               'Grading Scale Update',
               'Reminder: The new grading scale is in effect this term. Consult the handbook for grade boundaries and weightings.'
             )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach5Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach5Collapse3"
                            aria-expanded="false" aria-controls="teach5Collapse3">
                            <strong>Dress Code Reminder</strong>
                          </a>
                        </div>
                        <div id="teach5Collapse3" class="collapse pb-4" aria-labelledby="teach5Heading3"
                          data-parent="#accordionTeach5">
                          <div class="card-body">
                            Please ensure students adhere to the updated dress code policy. Read guidelines in the staff
                            handbook.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
               'Dress Code Reminder',
               'Please ensure students adhere to the updated dress code policy. Read guidelines in the staff handbook.'
             )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Emergency Procedures</h6>
                    <div class="accordion w-100" id="accordionTeach6">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach6Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach6Collapse1"
                            aria-expanded="true" aria-controls="teach6Collapse1">
                            <strong>Fire Drill Scheduled</strong>
                          </a>
                        </div>
                        <div id="teach6Collapse1" class="collapse show pb-4" aria-labelledby="teach6Heading1"
                          data-parent="#accordionTeach6">
                          <div class="card-body">
                            Reminder: School-wide fire drill will occur tomorrow at 10 AM. Please review evacuation routes
                            with your class.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
               'Fire Drill Scheduled',
               'Reminder: School-wide fire drill will occur tomorrow at 10 AM. Please review evacuation routes with your class.'
             )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach6Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach6Collapse2"
                            aria-expanded="false" aria-controls="teach6Collapse2">
                            <strong>Lockdown Drill Notification</strong>
                          </a>
                        </div>
                        <div id="teach6Collapse2" class="collapse pb-4" aria-labelledby="teach6Heading2"
                          data-parent="#accordionTeach6">
                          <div class="card-body">
                            Notification: We will conduct a lockdown drill on [Date] at [Time]. Follow protocols and
                            ensure doors are secured.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
               'Lockdown Drill Notification',
               'Notification: We will conduct a lockdown drill on [Date] at [Time]. Follow protocols and ensure doors are secured.'
             )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="teach6Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#teach6Collapse3"
                            aria-expanded="false" aria-controls="teach6Collapse3">
                            <strong>Weather Emergency Protocol</strong>
                          </a>
                        </div>
                        <div id="teach6Collapse3" class="collapse pb-4" aria-labelledby="teach6Heading3"
                          data-parent="#accordionTeach6">
                          <div class="card-body">
                            Alert: In case of severe weather, follow the severe weather plan. Close blinds, move away from
                            windows, and await further instructions.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
               'Weather Emergency Protocol',
               'Alert: In case of severe weather, follow the severe weather plan. Close blinds, move away from windows, and await further instructions.'
             )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            <?php } elseif ($type == 'staff') { ?>
              <!-- Staff Notifications -->
              <div>
                <!-- Row 1: Payroll & Benefits, HR & Administrative -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Payroll & Benefits</h6>
                    <div class="accordion w-100" id="accordionStaff1">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff1Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff1Collapse1"
                            aria-expanded="true" aria-controls="staff1Collapse1">
                            <strong>Salary Credit Confirmation</strong>
                          </a>
                        </div>
                        <div id="staff1Collapse1" class="collapse show pb-4" aria-labelledby="staff1Heading1"
                          data-parent="#accordionStaff1">
                          <div class="card-body">
                            Your monthly salary for [Month] has been credited to your account on [Date]. Please verify
                            your bank
                            statement or contact HR for any discrepancies.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Salary Credit Confirmation',
                             'Your monthly salary for [Month] has been credited to your account on [Date]. Please verify your bank statement or contact HR for any discrepancies.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff1Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff1Collapse2"
                            aria-expanded="false" aria-controls="staff1Collapse2">
                            <strong>Benefits Enrollment Reminder</strong>
                          </a>
                        </div>
                        <div id="staff1Collapse2" class="collapse pb-4" aria-labelledby="staff1Heading2"
                          data-parent="#accordionStaff1">
                          <div class="card-body">
                            Reminder: Open enrollment for health and dental benefits closes on [Date]. Visit the HR portal
                            to review
                            plan options and submit your selections.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Benefits Enrollment Reminder',
                             'Reminder: Open enrollment for health and dental benefits closes on [Date]. Visit the HR portal to review plan options and submit your selections.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff1Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff1Collapse3"
                            aria-expanded="false" aria-controls="staff1Collapse3">
                            <strong>Pension Plan Update</strong>
                          </a>
                        </div>
                        <div id="staff1Collapse3" class="collapse pb-4" aria-labelledby="staff1Heading3"
                          data-parent="#accordionStaff1">
                          <div class="card-body">
                            New pension contribution rates take effect next pay period. Your contribution will increase to
                            [X%].
                            Contact HR if you have questions.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Pension Plan Update',
                             'New pension contribution rates take effect next pay period. Your contribution will increase to [X%]. Contact HR if you have questions.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>HR & Administrative Updates</h6>
                    <div class="accordion w-100" id="accordionStaff2">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff2Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff2Collapse1"
                            aria-expanded="true" aria-controls="staff2Collapse1">
                            <strong>Policy Revision Notice</strong>
                          </a>
                        </div>
                        <div id="staff2Collapse1" class="collapse show pb-4" aria-labelledby="staff2Heading1"
                          data-parent="#accordionStaff2">
                          <div class="card-body">
                            The remote work policy has been updated. Effective immediately, employees may request up to
                            two remote
                            days per week. See the intranet for details.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Policy Revision Notice',
                             'The remote work policy has been updated. Effective immediately, employees may request up to two remote days per week. See the intranet for details.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff2Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff2Collapse2"
                            aria-expanded="false" aria-controls="staff2Collapse2">
                            <strong>ID Badge Renewal</strong>
                          </a>
                        </div>
                        <div id="staff2Collapse2" class="collapse pb-4" aria-labelledby="staff2Heading2"
                          data-parent="#accordionStaff2">
                          <div class="card-body">
                            Your staff ID badge expires on [Date]. Please visit the security office between 9 AM–3 PM this
                            week for a
                            free renewal.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'ID Badge Renewal',
                             'Your staff ID badge expires on [Date]. Please visit the security office between 9 AM–3 PM this week for a free renewal.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff2Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff2Collapse3"
                            aria-expanded="false" aria-controls="staff2Collapse3">
                            <strong>Staff Survey Invitation</strong>
                          </a>
                        </div>
                        <div id="staff2Collapse3" class="collapse pb-4" aria-labelledby="staff2Heading3"
                          data-parent="#accordionStaff2">
                          <div class="card-body">
                            We value your feedback! Complete the annual staff engagement survey by [Date]—it takes less
                            than 5 minutes
                            and helps shape our culture.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Staff Survey Invitation',
                             'We value your feedback! Complete the annual staff engagement survey by [Date]—it takes less than 5 minutes and helps shape our culture.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 2: Facility & Maintenance, IT & System Alerts -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Facility & Maintenance Notices</h6>
                    <div class="accordion w-100" id="accordionStaff3">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff3Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff3Collapse1"
                            aria-expanded="true" aria-controls="staff3Collapse1">
                            <strong>Air Conditioning Maintenance</strong>
                          </a>
                        </div>
                        <div id="staff3Collapse1" class="collapse show pb-4" aria-labelledby="staff3Heading1"
                          data-parent="#accordionStaff3">
                          <div class="card-body">
                            Maintenance team will service the A/C in Building B on [Date] from 8 AM–10 AM. Please keep
                            windows closed
                            and plan accordingly.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Air Conditioning Maintenance',
                             'Maintenance team will service the A/C in Building B on [Date] from 8 AM–10 AM. Please keep windows closed and plan accordingly.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff3Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff3Collapse2"
                            aria-expanded="false" aria-controls="staff3Collapse2">
                            <strong>Cafeteria Closure</strong>
                          </a>
                        </div>
                        <div id="staff3Collapse2" class="collapse pb-4" aria-labelledby="staff3Heading2"
                          data-parent="#accordionStaff3">
                          <div class="card-body">
                            The cafeteria will be closed for deep cleaning on [Date]. Alternate snack stations will be
                            available in
                            the library lounge.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Cafeteria Closure',
                             'The cafeteria will be closed for deep cleaning on [Date]. Alternate snack stations will be available in the library lounge.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff3Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff3Collapse3"
                            aria-expanded="false" aria-controls="staff3Collapse3">
                            <strong>Parking Lot Resurfacing</strong>
                          </a>
                        </div>
                        <div id="staff3Collapse3" class="collapse pb-4" aria-labelledby="staff3Heading3"
                          data-parent="#accordionStaff3">
                          <div class="card-body">
                            Parking lot resurfacing is scheduled for this weekend. Please park in the east lot on [Date]
                            to allow
                            crews to work safely.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Parking Lot Resurfacing',
                             'Parking lot resurfacing is scheduled for this weekend. Please park in the east lot on [Date] to allow crews to work safely.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>IT & System Alerts</h6>
                    <div class="accordion w-100" id="accordionStaff4">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff4Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff4Collapse1"
                            aria-expanded="true" aria-controls="staff4Collapse1">
                            <strong>System Downtime Scheduled</strong>
                          </a>
                        </div>
                        <div id="staff4Collapse1" class="collapse show pb-4" aria-labelledby="staff4Heading1"
                          data-parent="#accordionStaff4">
                          <div class="card-body">
                            The email server will be down for maintenance on [Date] from 11 PM–1 AM. Save your work and
                            log off before
                            11 PM to avoid data loss.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'System Downtime Scheduled',
                             'The email server will be down for maintenance on [Date] from 11 PM–1 AM. Save your work and log off before 11 PM to avoid data loss.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff4Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff4Collapse2"
                            aria-expanded="false" aria-controls="staff4Collapse2">
                            <strong>Password Reset Required</strong>
                          </a>
                        </div>
                        <div id="staff4Collapse2" class="collapse pb-4" aria-labelledby="staff4Heading2"
                          data-parent="#accordionStaff4">
                          <div class="card-body">
                            Your network password expires tomorrow. Please reset it via the self-service portal to
                            maintain
                            uninterrupted access.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Password Reset Required',
                             'Your network password expires tomorrow. Please reset it via the self-service portal to maintain uninterrupted access.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff4Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff4Collapse3"
                            aria-expanded="false" aria-controls="staff4Collapse3">
                            <strong>New Software Rollout</strong>
                          </a>
                        </div>
                        <div id="staff4Collapse3" class="collapse pb-4" aria-labelledby="staff4Heading3"
                          data-parent="#accordionStaff4">
                          <div class="card-body">
                            We’re deploying the new grading software next week. Join the 30-minute orientation webinar on
                            [Date] at
                            [Time].
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'New Software Rollout',
                             'We’re deploying the new grading software next week. Join the 30-minute orientation webinar on [Date] at [Time].'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 3: Health & Safety, Professional Development -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Health & Safety Protocols</h6>
                    <div class="accordion w-100" id="accordionStaff5">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff5Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff5Collapse1"
                            aria-expanded="true" aria-controls="staff5Collapse1">
                            <strong>First Aid Kit Restocked</strong>
                          </a>
                        </div>
                        <div id="staff5Collapse1" class="collapse show pb-4" aria-labelledby="staff5Heading1"
                          data-parent="#accordionStaff5">
                          <div class="card-body">
                            All first aid kits on campus have been restocked. Please report any missing items to the
                            nurse’s office
                            immediately.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'First Aid Kit Restocked',
                             'All first aid kits on campus have been restocked. Please report any missing items to the nurse’s office immediately.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff5Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff5Collapse2"
                            aria-expanded="false" aria-controls="staff5Collapse2">
                            <strong>Fire Extinguisher Inspection</strong>
                          </a>
                        </div>
                        <div id="staff5Collapse2" class="collapse pb-4" aria-labelledby="staff5Heading2"
                          data-parent="#accordionStaff5">
                          <div class="card-body">
                            Quarterly fire extinguisher inspections will occur on [Date]. Ensure clear access to all units
                            in your
                            area.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Fire Extinguisher Inspection',
                             'Quarterly fire extinguisher inspections will occur on [Date]. Ensure clear access to all units in your area.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff5Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff5Collapse3"
                            aria-expanded="false" aria-controls="staff5Collapse3">
                            <strong>COVID-19 Mask Policy Update</strong>
                          </a>
                        </div>
                        <div id="staff5Collapse3" class="collapse pb-4" aria-labelledby="staff5Heading3"
                          data-parent="#accordionStaff5">
                          <div class="card-body">
                            Masks are now optional in all indoor areas. Please respect colleagues’ preferences and stay
                            home if you
                            feel unwell.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'COVID-19 Mask Policy Update',
                             'Masks are now optional in all indoor areas. Please respect colleagues’ preferences and stay home if you feel unwell.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Professional Development & Training</h6>
                    <div class="accordion w-100" id="accordionStaff6">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff6Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff6Collapse1"
                            aria-expanded="true" aria-controls="staff6Collapse1">
                            <strong>Upcoming Workshop Alert</strong>
                          </a>
                        </div>
                        <div id="staff6Collapse1" class="collapse show pb-4" aria-labelledby="staff6Heading1"
                          data-parent="#accordionStaff6">
                          <div class="card-body">
                            Join the “Classroom Technology Tools” workshop on [Date] at [Time] in Room 101. Register
                            online to secure
                            your spot.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Upcoming Workshop Alert',
                             'Join the “Classroom Technology Tools” workshop on [Date] at [Time] in Room 101. Register online to secure your spot.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff6Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff6Collapse2"
                            aria-expanded="false" aria-controls="staff6Collapse2">
                            <strong>Mandatory Compliance Training</strong>
                          </a>
                        </div>
                        <div id="staff6Collapse2" class="collapse pb-4" aria-labelledby="staff6Heading2"
                          data-parent="#accordionStaff6">
                          <div class="card-body">
                            All staff must complete the annual compliance module by [Date]. Log in to the LMS and finish
                            the course to
                            remain in good standing.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Mandatory Compliance Training',
                             'All staff must complete the annual compliance module by [Date]. Log in to the LMS and finish the course to remain in good standing.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="staff6Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#staff6Collapse3"
                            aria-expanded="false" aria-controls="staff6Collapse3">
                            <strong>Peer Mentoring Program</strong>
                          </a>
                        </div>
                        <div id="staff6Collapse3" class="collapse pb-4" aria-labelledby="staff6Heading3"
                          data-parent="#accordionStaff6">
                          <div class="card-body">
                            Volunteers needed for our new peer mentoring program. Sign up by [Date] to guide and support
                            new teachers.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Peer Mentoring Program',
                             'Volunteers needed for our new peer mentoring program. Sign up by [Date] to guide and support new teachers.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } elseif ($type == 'student') { ?>
              <!-- Student Notifications -->
              <div>
                <!-- Row 1: Class Schedules & Changes, Academic Alerts -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Class Schedules & Changes</h6>
                    <div class="accordion w-100" id="accordionStud1">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud1Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud1Collapse1"
                            aria-expanded="true" aria-controls="stud1Collapse1">
                            <strong>Room Change Alert</strong>
                          </a>
                        </div>
                        <div id="stud1Collapse1" class="collapse show pb-4" aria-labelledby="stud1Heading1"
                          data-parent="#accordionStud1">
                          <div class="card-body">
                            Today’s Biology class at 2 PM has moved from Room 204 to Room 310. Please head there directly.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Room Change Alert',
                             'Today’s Biology class at 2 PM has moved from Room 204 to Room 310. Please head there directly.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud1Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud1Collapse2"
                            aria-expanded="false" aria-controls="stud1Collapse2">
                            <strong>Schedule Reminder</strong>
                          </a>
                        </div>
                        <div id="stud1Collapse2" class="collapse pb-4" aria-labelledby="stud1Heading2"
                          data-parent="#accordionStud1">
                          <div class="card-body">
                            Reminder: You have Math and English back-to-back on Friday morning. Be in Room 101 by 8:00 AM.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Schedule Reminder',
                             'Reminder: You have Math and English back-to-back on Friday morning. Be in Room 101 by 8:00 AM.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud1Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud1Collapse3"
                            aria-expanded="false" aria-controls="stud1Collapse3">
                            <strong>Substitute Teacher Notice</strong>
                          </a>
                        </div>
                        <div id="stud1Collapse3" class="collapse pb-4" aria-labelledby="stud1Heading3"
                          data-parent="#accordionStud1">
                          <div class="card-body">
                            Your History class today will be taught by Mr. Kim instead of Ms. Patel. Please bring your
                            textbook as
                            usual.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Substitute Teacher Notice',
                             'Your History class today will be taught by Mr. Kim instead of Ms. Patel. Please bring your textbook as usual.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Academic Alerts</h6>
                    <div class="accordion w-100" id="accordionStud2">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud2Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud2Collapse1"
                            aria-expanded="true" aria-controls="stud2Collapse1">
                            <strong>Low Assignment Warning</strong>
                          </a>
                        </div>
                        <div id="stud2Collapse1" class="collapse show pb-4" aria-labelledby="stud2Heading1"
                          data-parent="#accordionStud2">
                          <div class="card-body">
                            Your Algebra homework score was below 60%. Please attend the after-school help session on
                            Tuesday.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Low Assignment Warning',
                             'Your Algebra homework score was below 60%. Please attend the after-school help session on Tuesday.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud2Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud2Collapse2"
                            aria-expanded="false" aria-controls="stud2Collapse2">
                            <strong>Quiz Retake Opportunity</strong>
                          </a>
                        </div>
                        <div id="stud2Collapse2" class="collapse pb-4" aria-labelledby="stud2Heading2"
                          data-parent="#accordionStud2">
                          <div class="card-body">
                            Missed the Science quiz? Retake is available this Thursday during advisory in Room 215.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Quiz Retake Opportunity',
                             'Missed the Science quiz? Retake is available this Thursday during advisory in Room 215.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud2Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud2Collapse3"
                            aria-expanded="false" aria-controls="stud2Collapse3">
                            <strong>Honor Roll Congratulations</strong>
                          </a>
                        </div>
                        <div id="stud2Collapse3" class="collapse pb-4" aria-labelledby="stud2Heading3"
                          data-parent="#accordionStud2">
                          <div class="card-body">
                            Congratulations! You made the Principal’s Honor Roll for Q2 with a 4.0 GPA. Keep up the great
                            work!
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Honor Roll Congratulations',
                             'Congratulations! You made the Principal’s Honor Roll for Q2 with a 4.0 GPA. Keep up the great work!'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 2: Extracurricular & Clubs, Attendance & Punctuality -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Extracurricular & Clubs</h6>
                    <div class="accordion w-100" id="accordionStud3">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud3Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud3Collapse1"
                            aria-expanded="true" aria-controls="stud3Collapse1">
                            <strong>Club Meeting Reminder</strong>
                          </a>
                        </div>
                        <div id="stud3Collapse1" class="collapse show pb-4" aria-labelledby="stud3Heading1"
                          data-parent="#accordionStud3">
                          <div class="card-body">
                            Debate Club meets this Wednesday at 3:30 PM in the library. New members welcome!
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Club Meeting Reminder',
                             'Debate Club meets this Wednesday at 3:30 PM in the library. New members welcome!'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud3Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud3Collapse2"
                            aria-expanded="false" aria-controls="stud3Collapse2">
                            <strong>Tryouts Announcement</strong>
                          </a>
                        </div>
                        <div id="stud3Collapse2" class="collapse pb-4" aria-labelledby="stud3Heading2"
                          data-parent="#accordionStud3">
                          <div class="card-body">
                            Soccer team tryouts are next Monday at 4 PM on the field. Wear your cleats and bring water.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Tryouts Announcement',
                             'Soccer team tryouts are next Monday at 4 PM on the field. Wear your cleats and bring water.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud3Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud3Collapse3"
                            aria-expanded="false" aria-controls="stud3Collapse3">
                            <strong>Event Volunteer Call</strong>
                          </a>
                        </div>
                        <div id="stud3Collapse3" class="collapse pb-4" aria-labelledby="stud3Heading3"
                          data-parent="#accordionStud3">
                          <div class="card-body">
                            Yearbook committee needs volunteers to take photos at Spring Fest on Saturday. Sign up in Room
                            112.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Event Volunteer Call',
                             'Yearbook committee needs volunteers to take photos at Spring Fest on Saturday. Sign up in Room 112.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Attendance & Punctuality</h6>
                    <div class="accordion w-100" id="accordionStud4">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud4Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud4Collapse1"
                            aria-expanded="true" aria-controls="stud4Collapse1">
                            <strong>Absence Follow-up</strong>
                          </a>
                        </div>
                        <div id="stud4Collapse1" class="collapse show pb-4" aria-labelledby="stud4Heading1"
                          data-parent="#accordionStud4">
                          <div class="card-body">
                            We noticed you were absent on 05/12. Please submit a parent note or doctor’s slip to the
                            attendance
                            office.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Absence Follow-up',
                             'We noticed you were absent on 05/12. Please submit a parent note or doctor’s slip to the attendance office.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud4Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud4Collapse2"
                            aria-expanded="false" aria-controls="stud4Collapse2">
                            <strong>Tardy Warning</strong>
                          </a>
                        </div>
                        <div id="stud4Collapse2" class="collapse pb-4" aria-labelledby="stud4Heading2"
                          data-parent="#accordionStud4">
                          <div class="card-body">
                            You have been late twice this week. Please arrive in homeroom by 8:00 AM to avoid further
                            warnings.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Tardy Warning',
                             'You have been late twice this week. Please arrive in homeroom by 8:00 AM to avoid further warnings.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud4Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud4Collapse3"
                            aria-expanded="false" aria-controls="stud4Collapse3">
                            <strong>Perfect Attendance</strong>
                          </a>
                        </div>
                        <div id="stud4Collapse3" class="collapse pb-4" aria-labelledby="stud4Heading3"
                          data-parent="#accordionStud4">
                          <div class="card-body">
                            Congratulations on perfect attendance this month! You’ll receive a recognition certificate at
                            assembly.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Perfect Attendance',
                             'Congratulations on perfect attendance this month! You’ll receive a recognition certificate at assembly.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 3: Health & Wellness, Campus Events & Safety -->
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6>Health & Wellness</h6>
                    <div class="accordion w-100" id="accordionStud5">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud5Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud5Collapse1"
                            aria-expanded="true" aria-controls="stud5Collapse1">
                            <strong>Nurse Visit Follow-Up</strong>
                          </a>
                        </div>
                        <div id="stud5Collapse1" class="collapse show pb-4" aria-labelledby="stud5Heading1"
                          data-parent="#accordionStud5">
                          <div class="card-body">
                            You visited the nurse today complaining of a headache. Let us know if you need to go home or
                            see a doctor.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Nurse Visit Follow-Up',
                             'You visited the nurse today complaining of a headache. Let us know if you need to go home or see a doctor.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud5Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud5Collapse2"
                            aria-expanded="false" aria-controls="stud5Collapse2">
                            <strong>Counselor Appointment</strong>
                          </a>
                        </div>
                        <div id="stud5Collapse2" class="collapse pb-4" aria-labelledby="stud5Heading2"
                          data-parent="#accordionStud5">
                          <div class="card-body">
                            Reminder: You have a counseling session tomorrow at 1 PM in the counseling office.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Counselor Appointment',
                             'Reminder: You have a counseling session tomorrow at 1 PM in the counseling office.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud5Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud5Collapse3"
                            aria-expanded="false" aria-controls="stud5Collapse3">
                            <strong>Flu Shot Clinic</strong>
                          </a>
                        </div>
                        <div id="stud5Collapse3" class="collapse pb-4" aria-labelledby="stud5Heading3"
                          data-parent="#accordionStud5">
                          <div class="card-body">
                            Flu shot clinic is on 10/03 in the gym lobby during lunch. Consent forms available in the
                            nurse’s office.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Flu Shot Clinic',
                             'Flu shot clinic is on 10/03 in the gym lobby during lunch. Consent forms available in the nurse’s office.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h6>Campus Events & Safety</h6>
                    <div class="accordion w-100" id="accordionStud6">
                      <!-- Template 1 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud6Heading1">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud6Collapse1"
                            aria-expanded="true" aria-controls="stud6Collapse1">
                            <strong>Fire Drill Today</strong>
                          </a>
                        </div>
                        <div id="stud6Collapse1" class="collapse show pb-4" aria-labelledby="stud6Heading1"
                          data-parent="#accordionStud6">
                          <div class="card-body">
                            Fire drill at 10:15 AM today. Follow your classroom’s evacuation route and report to your
                            assembly point.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Fire Drill Today',
                             'Fire drill at 10:15 AM today. Follow your classroom’s evacuation route and report to your assembly point.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 2 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud6Heading2">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud6Collapse2"
                            aria-expanded="false" aria-controls="stud6Collapse2">
                            <strong>Safety Drill Debrief</strong>
                          </a>
                        </div>
                        <div id="stud6Collapse2" class="collapse pb-4" aria-labelledby="stud6Heading2"
                          data-parent="#accordionStud6">
                          <div class="card-body">
                            Great job on the lockdown drill yesterday. Please complete the feedback survey sent to your
                            email.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Safety Drill Debrief',
                             'Great job on the lockdown drill yesterday. Please complete the feedback survey sent to your email.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Template 3 -->
                      <div class="card shadow">
                        <div class="card-header" id="stud6Heading3">
                          <a class="d-block text-decoration-none" data-toggle="collapse" href="#stud6Collapse3"
                            aria-expanded="false" aria-controls="stud6Collapse3">
                            <strong>Homecoming Parade</strong>
                          </a>
                        </div>
                        <div id="stud6Collapse3" class="collapse pb-4" aria-labelledby="stud6Heading3"
                          data-parent="#accordionStud6">
                          <div class="card-body">
                            Homecoming Parade is this Friday at 3 PM. Wear your grade’s color and meet outside the main
                            office.
                          </div>
                          <a href="#" class="col-12 text-right text-decoration-none" onclick="handleChooseClick(
                             'Homecoming Parade',
                             'Homecoming Parade is this Friday at 3 PM. Wear your grade’s color and meet outside the main office.'
                           )">
                            Choose <i class="fe fe-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } else {
              header("Location: index.html");
              exit();
            }
            ?>

          </div> <!-- /.col -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->
      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
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
      <!-- Menu Modal -->
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
                <div class="col-6 text-center con-item">
                  <a href="../administration/" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-secondary control-panel-text">Dashboard</p>
                  </a>
                </div>
                <div class="col-6 text-center con-item">
                  <a href="../academics" style="text-decoration: none;">
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