<?php
require_once('../settings.php');


if (!isset($_POST['student'])) {
  header("Location: add-remarks.php");
  exit;
} else {
  $id = $_POST['student'];
}

if (isset($_POST['session']) && isset($_POST['term'])) {
  $session = $_POST['session'];
  $term = $_POST['term'];

  if ($term == 1) {
    $term_name = 'First Term';
  } elseif ($term == 2) {
    $term_name = 'Second Term';
  } elseif ($term == 3) {
    $term_name = 'Third Term';
  }
}




?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content=" initial-scale=0.1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Compile Results - Assessment | Rinda AMS</title>
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
  <style>
    .card {
      border-radius: 8px;
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
      <!--<form class="form-inline mr-auto searchform text-muted">-->
      <!--  <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"-->
      <!--    placeholder="Type something..." aria-label="Search">-->
      <!--</form>-->
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

          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.php">
            <span class="avatar avatar-sm mt-2">
              <img src="../assets/images/logo.jpg" size="20" alt="..." class="avatar-img rounded-circle">
            </span>
          </a>
        </div>

        <!-- Assessments -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Assessment</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="subjects.php">
              <i class="fe fe-check-circle fe-16"></i>
              <span class="ml-3 item-text">Mark by subject</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="students.php">
              <i class="fe fe-user-check fe-16"></i>
              <span class="ml-3 item-text">Mark by student</span>
              </i>
            </a>
          </li>
        </ul>
        <!-- Questions -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Questions</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item">
            <a class="nav-link" href="question-bank.php">
              <i class="fe fe-codesandbox fe-16"></i>
              <span class="ml-3 item-text">Bank</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="generate.php">
              <i class="fe fe-sliders fe-16"></i>
              <span class="ml-3 item-text">Generate</span>
              </i>
            </a>
          </li>
        </ul>


        <!-- Results -->
        <p class="text-muted nav-heading mt-4 mb-1">
          <span>Results</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
              <i class="fe fe-edit-3 fe-16"></i>
              <span class="ml-3 item-text">Process result</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="past-results.php">
              <i class="fe fe-tool fe-16"></i>
              <span class="ml-3 item-text">Edit past results</span>
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
            <div class="row align-items-center">
              <div class="col">
                <h2 class="page-title">Update Result Info</h2>
              </div>
            </div>
            <?php


            // // SQL query to fetch student results data 
            $sql = "SELECT * FROM result_info WHERE student_id = :id AND term = :term AND session = :session";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':term', $term);
            $stmt->bindParam(':session', $session);
            $stmt->execute();
            $result_info = $stmt->fetch(PDO::FETCH_ASSOC);







            // SQL query to fetch student data based on admission number
            $sql = "SELECT s.*, c.class
                    FROM students s
                    INNER JOIN classes c ON s.class_id = c.id
                    WHERE s.id = :id ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $student = $stmt->fetch(PDO::FETCH_ASSOC);







            function displayIfEmpty($value)
            {
              return empty($value) ? ": Nill" : ': ' . $value;
            }

            // Check if student data exists
            if ($student) {
              // Output the student data in the form
            ?>
              <div class="row">
                <div class="col-md-12" id="studentInfoWindow">
                  <div class="card profile shadow">
                    <div class="card-body">

                      <div class="row align-items-center">
                        <div class="col-12 col-md-3 text-center mb-5">
                          <span class="avatar avatar-xl mb-2">
                            <?php
                            if ($student['photo'] == null) {
                              if ($student['gender'] == 'female') { ?>
                                <img src="../../uploads/student-profiles/2.jpeg" alt="Profile picture" class="avatar-img rounded-circle">
                              <?php } else { ?>
                                <img src="../../uploads/student-profiles/1.jpeg" alt="Profile picture" class="avatar-img rounded-circle">
                              <?php }
                            } else { ?>
                              <img src="../../uploads/student-profiles/<?= $student['photo'] ?>" alt="Profile picture" class="avatar-img rounded-circle">
                            <?php } ?>
                          </span>
                          <div class="col-12">
                            <h5 class="mt-3 student-name">
                              <?= $student['firstName'] . ' ' . $student['lastName']; ?>
                            </h5>
                            <p class="mt-3"><span class="badge badge-dark student-grade">
                                <?= $student['admission_no']; ?>
                              </span></p>

                          </div>
                        </div>

                        <div class="col">

                          <div class="row mb-4">
                            <div class="col-md-7">
                              <div class="row">
                                <p class="text-muted">Class </p>
                                <p class="student-class">
                                  <?= displayIfEmpty($student['class']); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Term </p>
                                <p class="student-gender">
                                  <?= displayIfEmpty($term_name); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Total School Days </p>
                                <p class="student-dob">
                                  <?= displayIfEmpty($days_opened); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Height At The Begining Of Term </p>
                                <p class="student-religion">
                                  <?= displayIfEmpty($result_info['start_height']); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Weight At The Begining Of Term </p>
                                <p class="student-blood-group">
                                  <?= displayIfEmpty($result_info['start_weight']); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Class Teacher </p>
                                <p class="student-height">
                                  <?php
                                  $pos = 1;
                                  $class_id = $student['class_id'];
                                  $count = "SELECT a.teacher_id, CONCAT(s.first_name, ' ', s.last_name) AS full_name FROM assigned_classes a INNER JOIN staffs s ON a.teacher_id = s.id WHERE a.class_id = :class_id AND a.pos = :pos";
                                  $stmt = $pdo->prepare($count);
                                  $stmt->bindParam(':class_id', $class_id);
                                  $stmt->bindParam(':pos', $pos);
                                  $stmt->execute();
                                  $class_teacher = $stmt->fetch(PDO::FETCH_ASSOC);
                                  echo displayIfEmpty($class_teacher['full_name']);

                                  ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Award </p>
                                <p class="student-weight">
                                  <?= displayIfEmpty($result_info['award']); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Significant Contribution </p>
                                <p class="student-disorder">
                                  <?= displayIfEmpty($result_info['contributions']); ?>
                                </p>
                              </div>
                            </div>
                            <div class="col">
                              <div class="row">
                                <p class="text-muted">Number In Class </p>
                                <p class="student-email">
                                  <?php
                                  $class_id = $student['class_id'];
                                  $count = "SELECT * FROM `students` WHERE `class_id` = :class_id AND status = 1";
                                  $stmt = $pdo->prepare($count);
                                  $stmt->bindParam(':class_id', $class_id);
                                  $stmt->execute();
                                  $row_count = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                  echo displayIfEmpty(count($row_count));

                                  ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Session </p>
                                <p class="student-phone">
                                  <?= displayIfEmpty($session); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Total Days Present </p>
                                <p class="student-admitted-term">
                                  <?= displayIfEmpty($result_info['days_present']); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Height At The End Of Term </p>
                                <p class="student-admitted-session">
                                  <?= displayIfEmpty($result_info['end_height']); ?>
                                </p>
                              </div>

                              <div class="row">
                                <p class="text-muted">Weight At The End Of Term </p>
                                <p class="student-address">
                                  <?= displayIfEmpty($result_info['end_weight']); ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Class Teacher Assisstant </p>
                                <p class="student-city">
                                  <?php
                                  $pos = 2;
                                  $class_id = $student['class_id'];
                                  $count = "SELECT a.teacher_id, CONCAT(s.first_name, ' ', s.last_name) AS full_name FROM assigned_classes a INNER JOIN staffs s ON a.teacher_id = s.id WHERE a.class_id = :class_id AND a.pos = :pos";
                                  $stmt = $pdo->prepare($count);
                                  $stmt->bindParam(':class_id', $class_id);
                                  $stmt->bindParam(':pos', $pos);
                                  $stmt->execute();
                                  $class_teacher = $stmt->fetch(PDO::FETCH_ASSOC);
                                  echo displayIfEmpty($class_teacher['full_name']);

                                  ?>
                                </p>
                              </div>
                              <div class="row">
                                <p class="text-muted">Office Held </p>
                                <p class="student-state">
                                  <?= displayIfEmpty($result_info['office_held']); ?>
                                </p>
                              </div>

                            </div>
                          </div>
                          <div class="row ">
                            <div class="row mb-2">


                              <span class="m-1">
                                <button href="./#" data-toggle="modal" data-target=".gradingModal" class="btn mb-2 btn-outline-secondary">Grading System</button>
                              </span>
                              <span class="m-1">
                                <button href="./#" data-toggle="modal" data-target=".resultInfo" class="btn mb-2 btn-outline-success">Update Result Info</button>
                              </span>
                              <span class="m-1">
                                <button href="./#" data-toggle="modal" data-target=".pastResults" class="btn mb-2 btn-outline-success">Browse Past Results</button>
                              </span>
                              <span class="m-1">
                                <button href="./#" data-toggle="modal" data-target=".resultComment" class="btn mb-2 btn-outline-success">Facilitators Remarks</button>
                              </span>

                            </div>
                          </div>
                        </div>


                      <?php
                    } else {
                      // If student data not found, display a message
                      echo "Student data not found.";
                    }
                      ?>

                      </div>

                    </div> <!-- / .row- -->
                  </div> <!-- / .card-body - -->
                </div> <!-- / .card- -->
              </div>
          </div> <!-- / .col- -->

          <!--<div class="row my-4">-->
          <!-- Small table -->
          <div class="col-md-12 mb-3 mt-3">
            <div class="card shadow">
              <div class="card-body">

                <table class="table table-borderless table-hover">
                  <thead>
                    <tr>
                      <th style='color: black'>SUBJECTS</th>

                      <th style='color: black'>CA 1</th>
                      <th style='color: black'>CA 2</th>
                      <th style='color: black'>CA 3</th>
                      <th style='color: black'>CA 4</th>
                      <?php
                      $exams = 'Exams';
                      $query_check_assessment_type = "SELECT * FROM assessment_types WHERE class_id = :class_id AND assessment_type = :exams";
                      $stmt_check_assessment_type = $pdo->prepare($query_check_assessment_type);
                      $stmt_check_assessment_type->bindParam(':class_id', $class_id);
                      $stmt_check_assessment_type->bindParam(':exams', $exams);
                      $stmt_check_assessment_type->execute();
                      $assessment_type = $stmt_check_assessment_type->fetch(PDO::FETCH_ASSOC);
                      echo ($assessment_type ? "<td style='color: black'>" . $assessment_type['assessment_type']  . "</td>" : '');

                      ?>
                      <th style='color: black'>TOTAL MARKS</th>
                      <th style='color: black'>SUBJECT GRADE</th>
                      <th style='color: black'>HIGHEST SCORE</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $class_id = $student['class_id'];
                    // Query to fetch subjects for the class
                    $query_subjects = "SELECT * FROM subjects WHERE class_id = :class_id AND status = 1 ORDER BY subject ASC";
                    $stmt_subjects = $pdo->prepare($query_subjects);
                    $stmt_subjects->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                    $stmt_subjects->execute();
                    $subjects = $stmt_subjects->fetchAll(PDO::FETCH_ASSOC);

                    // Loop through subjects
                    foreach ($subjects as $subject) {
                      $subject_id = $subject['id'];
                      echo "<tr class='text-center'>";
                      echo "<td class='text-left'>" . $subject['subject'] . "</td>";

                      // Query to fetch the best 4 CA marks for the subject and student
                      $query_ca_marks = "SELECT m.mark FROM assessment_marks m
                                               INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                                               WHERE m.student_id = :student_id 
                                               AND m.subject_id = :subject_id 
                                               AND m.session = :session
                                               AND m.term = :term
                                               AND t.assessment_type != :exams
                                               ORDER BY m.mark DESC LIMIT 4";
                      $stmt_ca_marks = $pdo->prepare($query_ca_marks);
                      $stmt_ca_marks->bindParam(':student_id', $id);
                      $stmt_ca_marks->bindParam(':subject_id', $subject_id);
                      $stmt_ca_marks->bindParam(':session', $session);
                      $stmt_ca_marks->bindParam(':term', $term);
                      $stmt_ca_marks->bindParam(':exams', $exams);
                      $stmt_ca_marks->execute();
                      $ca_marks = $stmt_ca_marks->fetchAll(PDO::FETCH_ASSOC);

                      // Display the best 4 CA marks
                      $total_ca_marks = 0;
                      foreach ($ca_marks as $ca_mark) {
                        echo "<td>" . $ca_mark['mark'] . "</td>";
                        $total_ca_marks += $ca_mark['mark'];
                      }

                      // Fill in empty cells if there are less than 4 CA marks
                      for ($i = count($ca_marks); $i < 4; $i++) {
                        echo "<td></td>";
                      }

                      // Query to fetch the exam mark for the subject and student
                      $query_exam_mark = "SELECT m.mark FROM assessment_marks m
                                                INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                                                WHERE m.student_id = :student_id 
                                                AND m.subject_id = :subject_id 
                                                AND m.session = :session
                                                AND m.term = :term
                                                AND t.assessment_type = :exams";
                      $stmt_exam_mark = $pdo->prepare($query_exam_mark);
                      $stmt_exam_mark->bindParam(':student_id', $id);
                      $stmt_exam_mark->bindParam(':subject_id', $subject_id);
                      $stmt_exam_mark->bindParam(':session', $session);
                      $stmt_exam_mark->bindParam(':term', $term);
                      $stmt_exam_mark->bindParam(':exams', $exams);
                      $stmt_exam_mark->execute();
                      $exam_mark = $stmt_exam_mark->fetch(PDO::FETCH_ASSOC);

                      $exam_mark_value = $exam_mark ? $exam_mark['mark'] : 0;
                      echo "<td>" . $exam_mark_value . "</td>";

                      // Calculate and display the total marks
                      $total_marks = $total_ca_marks + $exam_mark_value;
                      echo "<td>" . $total_marks . "</td>";

                      // 			// Determine and display subject grade based on total marks
                      echo "<td class='text-left'>";
                      if ($total_marks <= 40) {
                        echo "'E'(Retake)";
                      } elseif ($total_marks >= 41 && $total_marks <= 49) {
                        echo "'D' FAIR";
                      } elseif ($total_marks >= 50 && $total_marks <= 59) {
                        echo "'C' (PASS)";
                      } elseif ($total_marks >= 60 && $total_marks <= 69) {
                        echo "'B-' (GOOD)";
                      } elseif ($total_marks >= 70 && $total_marks <= 79) {
                        echo "'B+' (GOOD SHOW)";
                      } elseif ($total_marks >= 80 && $total_marks <= 89) {
                        echo "'A-' (VERY GOOD)";
                      } elseif ($total_marks >= 90 && $total_marks <= 100) {
                        echo "'A+' (EXCELLENT)";
                      } else {
                        echo "Invalid Total Marks"; // or any default message
                      }
                      echo "</td>";





                      $max_total_marks = 0;
                      $top_student_id = null;

                      // Query to fetch all students in the class
                      $query_student = "SELECT id FROM students WHERE class_id = :class_id";
                      $stmt_student = $pdo->prepare($query_student);
                      $stmt_student->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                      $stmt_student->execute();
                      $studentss = $stmt_student->fetchAll(PDO::FETCH_ASSOC);

                      // Loop through each student to calculate their total marks
                      foreach ($studentss as $students) {
                        $student_id = $students['id'];

                        // Query to fetch the best 4 CA marks for the student and subject
                        $query_ca_marks = "SELECT m.mark FROM assessment_marks m
                               INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                               WHERE m.student_id = :student_id 
                               AND m.subject_id = :subject_id 
                               AND m.session = :session
                               AND m.term = :term
                               AND t.assessment_type != :exams
                               ORDER BY m.mark DESC LIMIT 4";
                        $stmt_ca_marks = $pdo->prepare($query_ca_marks);
                        $stmt_ca_marks->bindParam(':student_id', $student_id);
                        $stmt_ca_marks->bindParam(':subject_id', $subject_id);
                        $stmt_ca_marks->bindParam(':session', $session);
                        $stmt_ca_marks->bindParam(':term', $term);
                        $stmt_ca_marks->bindParam(':exams', $exams);
                        $stmt_ca_marks->execute();
                        $ca_marks = $stmt_ca_marks->fetchAll(PDO::FETCH_ASSOC);

                        // Calculate total CA marks for the student
                        $total_ca_marks = 0;
                        foreach ($ca_marks as $ca_mark) {
                          $total_ca_marks += $ca_mark['mark'];
                        }

                        // Query to fetch the exam mark for the student and subject
                        $query_exam_mark = "SELECT m.mark FROM assessment_marks m
                                INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                                WHERE m.student_id = :student_id 
                                AND m.subject_id = :subject_id 
                                AND m.session = :session
                                AND m.term = :term
                                AND t.assessment_type = :exams";
                        $stmt_exam_mark = $pdo->prepare($query_exam_mark);
                        $stmt_exam_mark->bindParam(':student_id', $student_id);
                        $stmt_exam_mark->bindParam(':subject_id', $subject_id);
                        $stmt_exam_mark->bindParam(':session', $session);
                        $stmt_exam_mark->bindParam(':term', $term);
                        $stmt_exam_mark->bindParam(':exams', $exams);
                        $stmt_exam_mark->execute();
                        $exam_mark = $stmt_exam_mark->fetch(PDO::FETCH_ASSOC);

                        // Calculate total marks for the student
                        $exam_mark_value = $exam_mark ? $exam_mark['mark'] : 0;
                        $total_marks = $total_ca_marks + $exam_mark_value;

                        // Update the maximum total marks and the corresponding student ID if the current student's total marks are higher
                        if ($total_marks > $max_total_marks) {
                          $max_total_marks = $total_marks;
                          $top_student_id = $student_id;
                        }
                      }

                      // Display the maximum total marks and the corresponding student ID
                      echo "<td>" . $max_total_marks . "</td>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!--</div>-->

          <?php
          if ($student['multiClass'] == 1) {
            $islamiyyaClass_id = $student['2ndClass_id'];
          ?>

            <!--<div class="row">-->
            <!-- Small table -->

            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body">

                  <table class="table table-borderless table-hover">
                    <thead>
                      <tr>
                        <th style='color: black'>SUBJECTS</th>

                        <th style='color: black'>CA 1</th>
                        <th style='color: black'>CA 2</th>
                        <th style='color: black'>CA 3</th>
                        <th style='color: black'>CA 4</th>
                        <?php
                        $exams = 'Exams';
                        $query_check_assessment_type = "SELECT * FROM assessment_types WHERE class_id = :class_id AND assessment_type = :exams";
                        $stmt_check_assessment_type = $pdo->prepare($query_check_assessment_type);
                        $stmt_check_assessment_type->bindParam(':class_id', $islamiyyaClass_id);
                        $stmt_check_assessment_type->bindParam(':exams', $exams);
                        $stmt_check_assessment_type->execute();
                        $assessment_type = $stmt_check_assessment_type->fetch(PDO::FETCH_ASSOC);
                        echo ($assessment_type ? "<td style='color: black'>" . $assessment_type['assessment_type']  . "</td>" : '');

                        ?>
                        <th style='color: black'>TOTAL MARKS</th>
                        <th style='color: black'>SUBJECT GRADE</th>
                        <th style='color: black'>HIGHEST SCORE</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      // Query to fetch subjects for the class
                      $query_subjects = "SELECT * FROM subjects WHERE class_id = :class_id ORDER BY subject ASC";
                      $stmt_subjects = $pdo->prepare($query_subjects);
                      $stmt_subjects->bindParam(':class_id', $islamiyyaClass_id, PDO::PARAM_INT);
                      $stmt_subjects->execute();
                      $subjects = $stmt_subjects->fetchAll(PDO::FETCH_ASSOC);

                      // Loop through subjects
                      foreach ($subjects as $subject) {
                        $subject_id = $subject['id'];
                        echo "<tr class='text-center'>";
                        echo "<td class='text-left'>" . $subject['subject'] . "</td>";

                        // Query to fetch the best 4 CA marks for the subject and student
                        $query_ca_marks = "SELECT m.mark FROM assessment_marks m
                                               INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                                               WHERE m.student_id = :student_id 
                                               AND m.subject_id = :subject_id 
                                               AND m.session = :session
                                               AND m.term = :term
                                               AND t.assessment_type != :exams
                                               ORDER BY m.mark DESC LIMIT 4";
                        $stmt_ca_marks = $pdo->prepare($query_ca_marks);
                        $stmt_ca_marks->bindParam(':student_id', $id);
                        $stmt_ca_marks->bindParam(':subject_id', $subject_id);
                        $stmt_ca_marks->bindParam(':session', $session);
                        $stmt_ca_marks->bindParam(':term', $term);
                        $stmt_ca_marks->bindParam(':exams', $exams);
                        $stmt_ca_marks->execute();
                        $ca_marks = $stmt_ca_marks->fetchAll(PDO::FETCH_ASSOC);

                        // Display the best 4 CA marks
                        $total_ca_marks = 0;
                        foreach ($ca_marks as $ca_mark) {
                          echo "<td>" . $ca_mark['mark'] . "</td>";
                          $total_ca_marks += $ca_mark['mark'];
                        }

                        // Fill in empty cells if there are less than 4 CA marks
                        for ($i = count($ca_marks); $i < 4; $i++) {
                          echo "<td></td>";
                        }

                        // Query to fetch the exam mark for the subject and student
                        $query_exam_mark = "SELECT m.mark FROM assessment_marks m
                                                INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                                                WHERE m.student_id = :student_id 
                                                AND m.subject_id = :subject_id 
                                                AND m.session = :session
                                                AND m.term = :term
                                                AND t.assessment_type = :exams";
                        $stmt_exam_mark = $pdo->prepare($query_exam_mark);
                        $stmt_exam_mark->bindParam(':student_id', $id);
                        $stmt_exam_mark->bindParam(':subject_id', $subject_id);
                        $stmt_exam_mark->bindParam(':session', $session);
                        $stmt_exam_mark->bindParam(':term', $term);
                        $stmt_exam_mark->bindParam(':exams', $exams);
                        $stmt_exam_mark->execute();
                        $exam_mark = $stmt_exam_mark->fetch(PDO::FETCH_ASSOC);

                        $exam_mark_value = $exam_mark ? $exam_mark['mark'] : 0;
                        echo "<td>" . $exam_mark_value . "</td>";

                        // Calculate and display the total marks
                        $total_marks = $total_ca_marks + $exam_mark_value;
                        echo "<td>" . $total_marks . "</td>";

                        // 			// Determine and display subject grade based on total marks
                        echo "<td class='text-left'>";
                        if ($total_marks <= 40) {
                          echo "'E'(Retake)";
                        } elseif ($total_marks >= 41 && $total_marks <= 49) {
                          echo "'D' FAIR";
                        } elseif ($total_marks >= 50 && $total_marks <= 59) {
                          echo "'C' (PASS)";
                        } elseif ($total_marks >= 60 && $total_marks <= 69) {
                          echo "'B-' (GOOD)";
                        } elseif ($total_marks >= 70 && $total_marks <= 79) {
                          echo "'B+' (GOOD SHOW)";
                        } elseif ($total_marks >= 80 && $total_marks <= 89) {
                          echo "'A-' (VERY GOOD)";
                        } elseif ($total_marks >= 90 && $total_marks <= 100) {
                          echo "'A+' (EXCELLENT)";
                        } else {
                          echo "Invalid Total Marks"; // or any default message
                        }
                        echo "</td>";





                        // Initialize variables for tracking the highest total marks and the student with those marks
                        $max_total_marks = 0;
                        $top_student_id = null;

                        // Query to fetch all students in the class
                        $query_student = "SELECT id FROM students WHERE class_id = :class_id OR 2ndClass_id = :class_id";
                        $stmt_student = $pdo->prepare($query_student);
                        $stmt_student->bindParam(':class_id', $islamiyyaClass_id, PDO::PARAM_INT);
                        $stmt_student->execute();
                        $studentss = $stmt_student->fetchAll(PDO::FETCH_ASSOC);

                        // Loop through each student to calculate their total marks
                        foreach ($studentss as $students) {
                          $student_id = $students['id'];

                          // Query to fetch the best 4 CA marks for the student and subject
                          $query_ca_marks = "SELECT m.mark FROM assessment_marks m
                               INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                               WHERE m.student_id = :student_id 
                               AND m.subject_id = :subject_id 
                               AND m.session = :session
                               AND m.term = :term
                               AND t.assessment_type != :exams
                               ORDER BY m.mark DESC LIMIT 4";
                          $stmt_ca_marks = $pdo->prepare($query_ca_marks);
                          $stmt_ca_marks->bindParam(':student_id', $student_id);
                          $stmt_ca_marks->bindParam(':subject_id', $subject_id);
                          $stmt_ca_marks->bindParam(':session', $session);
                          $stmt_ca_marks->bindParam(':term', $term);
                          $stmt_ca_marks->bindParam(':exams', $exams);
                          $stmt_ca_marks->execute();
                          $ca_marks = $stmt_ca_marks->fetchAll(PDO::FETCH_ASSOC);

                          // Calculate total CA marks for the student
                          $total_ca_marks = 0;
                          foreach ($ca_marks as $ca_mark) {
                            $total_ca_marks += $ca_mark['mark'];
                          }

                          // Query to fetch the exam mark for the student and subject
                          $query_exam_mark = "SELECT m.mark FROM assessment_marks m
                                INNER JOIN assessment_types t ON m.assessment_id = t.assessment_id
                                WHERE m.student_id = :student_id 
                                AND m.subject_id = :subject_id 
                                AND m.session = :session
                                AND m.term = :term
                                AND t.assessment_type = :exams";
                          $stmt_exam_mark = $pdo->prepare($query_exam_mark);
                          $stmt_exam_mark->bindParam(':student_id', $student_id);
                          $stmt_exam_mark->bindParam(':subject_id', $subject_id);
                          $stmt_exam_mark->bindParam(':session', $session);
                          $stmt_exam_mark->bindParam(':term', $term);
                          $stmt_exam_mark->bindParam(':exams', $exams);
                          $stmt_exam_mark->execute();
                          $exam_mark = $stmt_exam_mark->fetch(PDO::FETCH_ASSOC);

                          // Calculate total marks for the student
                          $exam_mark_value = $exam_mark ? $exam_mark['mark'] : 0;
                          $total_marks = $total_ca_marks + $exam_mark_value;

                          // Update the maximum total marks and the corresponding student ID if the current student's total marks are higher
                          if ($total_marks > $max_total_marks) {
                            $max_total_marks = $total_marks;
                            $top_student_id = $student_id;
                          }
                        }

                        // Display the maximum total marks and the corresponding student ID
                        echo "<td>" . $max_total_marks . "</td>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--</div>-->

          <?php  } ?>



        </div> <!-- .col-12 -->
      </div> <!-- .row -->
  </div> <!-- .container-fluid -->


  <!-- GradingModal -->
  <div class="modal fade gradingModal modal-popup" id="gradingModal" tabindex="-1" role="dialog" aria-labelledby="Grading System" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Grading system</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m2">
          <div class="row">

            <span class="col-4 text-center text-left" action="manage_parents.php" method="post">
              <p>100 - 90</p>
              <p>89 - 80</p>
              <p>79 - 70</p>
              <p>69 - 60</p>
              <p>59 - 50</p>
              <p>49 - 41</p>
              <p>40 below</p>
            </span>

            <span class="col-4 text-center" action="manage_parents.php" method="post">
              <p>--------------------</p>
              <p>--------------------</p>
              <p>--------------------</p>
              <p>--------------------</p>
              <p>--------------------</p>
              <p>--------------------</p>
              <p>--------------------</p>
            </span>

            <span class="col-4 text-left" action="manage_parents.php" method="post">
              <p>'A+' (Excellent)</p>
              <p>'A-' (Very Good) </p>
              <p>'B+' (Good Show)</p>
              <p>'B-' (Good)</p>
              <p>'C' (Pass)</p>
              <p>'D' (Fair)</p>
              <p>'E' (Retake)</p>
            </span>


          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Past Results -->
  <div class="modal fade pastResults modal-popup" id="pastResults" tabindex="-1" role="dialog" aria-labelledby="Past Results" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">View Past Results</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="view-past-result" method="POST" action="">
          <div class="modal-body">
            <div class="row col-12">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="sessions">Session</label>
                  <select class="form-control select1" required name="session">
                    <?php
                    $query = "SELECT session FROM sessions ORDER BY session DESC";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $db_sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($db_sessions) != 1) {
                      echo '<option value="" selected disabled>No Previous Session Exist</option>';
                    } else {
                      echo "<option value='' selected>Select Session</option>";
                      foreach ($db_sessions as $db_session) :
                        $past_sessions = $db_session['session'];
                        echo "<option value='$past_sessions'>$past_sessions Session</option>";
                      endforeach;
                    }
                    ?>
                  </select>
                </div>

              </div> <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="award">Term</label>
                  <select class="form-control select1" required name="term">
                    <option value="" selected disabled>Select Term</option>
                    <option value="1">First Term</option>
                    <option value="2">Second Term</option>
                    <option value="3">Third Term</option>
                  </select>
                </div>
                <input type="hidden" name="student" value="<?= $id ?>">

              </div> <!-- /.col -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn mb-2 btn-primary w-100">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Comments -->
  <div class="modal fade resultComment modal-popup" id="resultComment" tabindex="-1" role="dialog" aria-labelledby="Past Results" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">View Past Results</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="update-result-remarks">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="class_teacher">Class Teacher's Comment</label>
                  <textarea id="class_teacher" name="class_teacher" class="form-control"><?= $result_info['class_teacher'] ?></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="islamiyya_teacher">Islamiyya Teacher's Comment</label>
                  <textarea id="islamiyya_teacher" name="islamiyya_teacher" class="form-control"><?= $result_info['islamiyya_teacher'] ?></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="primary_head">Head Of Primary's Comment</label>
                  <textarea id="primary_head" name="primary_head" class="form-control"><?= $result_info['primary_head'] ?></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="islamiyya_head">Head Of Islamiyya's Comment</label>
                  <textarea id="islamiyya_head" name="islamiyya_head" class="form-control"><?= $result_info['islamiyya_head'] ?></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="school_head">Head Of School Comment</label>
                  <textarea id="school_head" name="school_head" class="form-control"><?= $result_info['school_head'] ?></textarea>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="student_id" value="<?= $id ?>">
          <input type="hidden" name="session" value="<?= $session ?>">
          <input type="hidden" name="term" value="<?= $term ?>">
          <div class="modal-footer">
            <button type="submit" class="btn mb-2 btn-primary w-100">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>






  <!-- Notification Modal -->
  <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="defaultModalLabel">Notifications</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
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
        <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear All</button> </div>
      </div>
    </div>
  </div>

  <!-- Menu Modal -->
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
              <a href="../academics" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-award fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary">Academics</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="#" style="text-decoration: none;">
                <div class="squircle bg-success justify-content-center">
                  <i class="fe fe-check-square fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-success">Assessments</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <a href="../curriculum" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-book-open fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary">Curriculum</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="../resources" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-archive fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary">Resources</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <a href="../target" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-trending-up fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary">Target</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="../profile" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center text-white">
                  <i class="fe fe-user fe-32 align-self-center"></i>
                </div>
                <p class="text-secondary">Profile</p>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Update Result Info -->
  <div class="modal fade resultInfo w-80" id="resultInfo" tabindex="-1" role="dialog" aria-labelledby="Result Infol" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h5 class="modal-title text-center" id="warningModelTitle">Update Result Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="update-result-info">
          <div class="modal-body">
            <div class="row col-12">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="daysOpened">Days Present</label>
                  <input type="number" id="daysPresent" name="daysPresent" value="<?= $result_info['days_present'] ?>" class="form-control" placeholder="Days present in school">
                </div>
                <div class="form-group mb-3">
                  <label for="startHeight">Begining Of Term Height:</label>
                  <input type="number" id="startHeight" name="startHeight" value="<?= $result_info['start_height'] ?>" class="form-control" placeholder="cm">
                </div>
                <div class="form-group mb-3">
                  <label for="startWeight">Begining Of Term Weight:</label>
                  <input type="number" id="startWeight" name="startWeight" value="<?= $result_info['start_weight'] ?>" class="form-control" placeholder="lb">
                </div>
                <div class="form-group mb-3">
                  <label for="officeHeld">Office Held</label>
                  <input type="text" id="officeHeld" name="officeHeld" value="<?= $result_info['office_held'] ?>" class="form-control" placeholder="Office Held">
                </div>
              </div> <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="award">Award</label>
                  <input type="text" id="award" name="award" value="<?= $result_info['award'] ?>" class="form-control" placeholder="Merit award collected">
                </div>
                <div class="form-group mb-3">
                  <label for="endHeight">Height At The End Of Term:</label>
                  <input type="number" id="endHeight" name="endHeight" value="<?= $result_info['end_height'] ?>" class="form-control" placeholder="cm">
                </div>
                <div class="form-group mb-3">
                  <label for="endWeight">Weight At The End Of Term:</label>
                  <input type="number" id="endWeight" name="endWeight" value="<?= $result_info['end_weight'] ?>" class="form-control" placeholder="lb">
                </div>
                <div class="form-group mb-3">
                  <label for="contributions">Significant Contribution</label>
                  <input type="text" id="contributions" name="contributions" value="<?= $result_info['contribution'] ?>" class="form-control" placeholder="Contributions">
                </div>
                <input type="hidden" name="student_id" value="<?= $id ?>">
                <input type="hidden" name="session" value="<?= $session ?>">
                <input type="hidden" name="term" value="<?= $term ?>">
              </div> <!-- /.col -->
            </div>

            <div class="modal-footer">
              <!--<button type="button" class="btn mb-2 btn-secondary col-md-6" data-dismiss="modal">Cancel</button>-->
              <button type="submit" class="btn mb-2 btn-primary w-100" id="force_assign">Save Changes</button>
            </div>
        </form>
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
  <script src='../js/jquery.dataTables.min.js'></script>
  <script src='../js/dataTables.bootstrap4.min.js'></script>
  <script src='../js/jquery.validate.min.js'></script>



  <script>
    //Function to display a popup message
    function displayPopup(message, success) {
      var popup = document.createElement('div');
      popup.className = 'popup ' + (success ? 'success' : 'error');

      var iconClass = success ? 'fa fa-check-circle' : 'fa fa-times-circle';
      var icon = document.createElement('i');
      icon.className = iconClass;
      popup.appendChild(icon);

      var text = document.createElement('span');
      text.textContent = message;
      popup.appendChild(text);

      document.body.appendChild(popup);

      setTimeout(function() {
        popup.remove();
      }, 5000);
    }




    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("#update-result-info");
      if (form) {
        form.addEventListener("submit", function(event) {
          event.preventDefault();

          $.ajax({
            type: 'POST',
            url: 'update-result-info.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                displayPopup(response.message, true);
                // Refresh the page after 2 seconds
                setTimeout(function() {
                  location.reload();
                }, 2000);
              } else {
                displayPopup(response.message, false);
              }
            },
            error: function(xhr, status, error) {
              console.log(xhr, status, error);
              displayPopup(error);
            }
          });
        });
      }
    });

    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("#update-result-remarks");
      if (form) {
        form.addEventListener("submit", function(event) {
          event.preventDefault();

          $.ajax({
            type: 'POST',
            url: 'update-result-remarks.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                displayPopup(response.message, true);
                // Refresh the page after 2 seconds
                setTimeout(function() {
                  location.reload();
                }, 2000);
              } else {
                displayPopup(response.message, false);
              }
            },
            error: function(xhr, status, error) {
              console.log(xhr, status, error);
              displayPopup(error);
            }
          });
        });
      }
    });
  </script>
  <script>
    $('.select2').select2({
      theme: 'bootstrap4',
    });
    $('.select2-multi').select2({
      multiple: true,
      theme: 'bootstrap4',
    });
    $('.drgpicker').daterangepicker({
      singleDatePicker: true,
      timePicker: false,
      showDropdowns: true,
      locale: {
        format: 'MM/DD/YYYY'
      }
    });
    $('.time-input').timepicker({
      'scrollDefault': 'now',
      'zindex': '9999' /* fix modal open */
    });
    /** date range picker */
    if ($('.datetimes').length) {
      $('.datetimes').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
          format: 'M/DD hh:mm A'
        }
      });
    }
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);
    cb(start, end);
    $('.input-placeholder').mask("00/00/0000", {
      placeholder: "__/__/____"
    });
    $('.input-zip').mask('00000-000', {
      placeholder: "____-___"
    });
    $('.input-money').mask("#.##0,00", {
      reverse: true
    });
    $('.input-phoneus').mask('(000) 000-0000');
    $('.input-mixed').mask('AAA 000-S0S');
    $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/,
          optional: true
        }
      },
      placeholder: "___.___.___.___"
    });
    // editor
    var editor = document.getElementById('editor');
    if (editor) {
      var toolbarOptions = [
        [{
          'font': []
        }],
        [{
          'header': [1, 2, 3, 4, 5, 6, false]
        }],
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{
            'header': 1
          },
          {
            'header': 2
          }
        ],
        [{
            'list': 'ordered'
          },
          {
            'list': 'bullet'
          }
        ],
        [{
            'script': 'sub'
          },
          {
            'script': 'super'
          }
        ],
        [{
            'indent': '-1'
          },
          {
            'indent': '+1'
          }
        ], // outdent/indent
        [{
          'direction': 'rtl'
        }], // text direction
        [{
            'color': []
          },
          {
            'background': []
          }
        ], // dropdown with defaults from theme
        [{
          'align': []
        }],
        ['clean'] // remove formatting button
      ];
      var quill = new Quill(editor, {
        modules: {
          toolbar: toolbarOptions
        },
        theme: 'snow'
      });
    }
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
  <script>
    $('#dataTable-1').DataTable({
      autoWidth: true,
      "lengthMenu": [
        [16, 32, 64, -1],
        [16, 32, 64, "All"]
      ]
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