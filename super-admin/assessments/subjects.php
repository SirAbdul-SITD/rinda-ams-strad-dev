<?php require('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Subjects - Assessment | Rinda AMS</title>
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
          <li class="nav-item active">
            <a class="nav-link text-primary" href="#">
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
          <li class="nav-item">
            <a class="nav-link" href="add-remarks.php">
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
            <div class="row align-items-center my-3">
              <div class="col">
                <h2 class="page-title">Assigned Subjects</h2>
                <p class="mb-3">Please select a subject to add or update their assessment marks</p>
              </div>
            </div>




            <div class="row my-4">



              <!-- Small table -->
              <div class="col-md-12">
                <div class="card shadow">
                  <div class="card-body">
                    <?php
                    $query = "SELECT s.*, c.class, CONCAT(u.first_name, ' ', u.last_name) AS teacher_name 
                    FROM subjects s 
                    INNER JOIN classes c ON s.class_id = c.id 
                    LEFT JOIN staffs u ON s.assigned = u.id 
                    WHERE s.status = 1 AND c.status = 1
                    ORDER BY s.class_id ASC";

                    $stmt = $pdo->prepare($query);
                    // $stmt->bindParam(':user', $user_id);
                    $stmt->execute();
                    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    if (count($subjects) === 0) {
                      echo '<p class="text-center">None added Yet!</p>';
                    } else {
                    ?>
                      <!-- table -->
                      <table class="table datatables" id="dataTable-1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Assigned Teacher</th>
                            <th>Class</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($subjects as $index => $subject) : ?>
                            <tr data-id="<?= $subject['id']; ?>">
                              <td>
                                <?= $index + 1; ?>
                              </td>
                              <td class="editable-field" data-field="subject" data-id="<?= $subject['id']; ?>">
                                <span>
                                  <?= $subject['subject']; ?>
                                </span>
                                <div class="input-group" style="display: none;">
                                  <input type="text" class="form-control" value="<?= $subject['subject']; ?>">
                                  <div class="input-group-append">
                                    <button class="btn btn-danger cancel-button" type="button"><span class="fe fe-x-circle "></span></button>
                                    <button class="btn btn-success save-button" type="button"><span class="fe fe-check-circle "></span></button>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <?= $subject['teacher_name']; ?>
                              </td>
                              <td>
                                <?= $subject['class']; ?>
                              </td>
                              <td>
                                <form action="subject-assessment.php" method="POST">
                                  <input type="hidden" name="subject" value="<?= $subject['id']; ?>">
                                  <button type="submit" class="btn  w-100 btn-primary"><i class="fe fe-check-circle fe-16"></i> Process subject assessment</button>
                                </form>

                              </td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    <?php } ?>
                  </div>


                </div>
              </div> <!-- simple table -->



            </div> <!-- end section -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->


      <!-- Assign Modal -->
      <div class="modal fade" id="assignTeacher" tabindex="-1" role="dialog" aria-labelledby="assignTeacherLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="varyModalLabel">Assign Subject Teacher</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="needs-validation assign_subject_form">
              <div class="modal-body p-4">

                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="class">Subjects</label>
                    <select id="class" class="form-control select1" required name="subject">
                      <?php
                      $query = "SELECT s.*, c.id AS class_id, c.class FROM subjects s INNER JOIN classes c ON s.class_id = class_id  WHERE s.status = 1 AND c.status = 1 ORDER BY s.subject ASC";
                      $stmt = $pdo->prepare($query);
                      $stmt->execute();
                      $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      if (count($subjects) === 0) {
                        echo '<option value="" selected disabled>No subject added Yet!</option>';
                      } else {
                        echo "<option value=''>Select Subject</option>";
                        foreach ($subjects as $subject) :
                          $x = $subject['id'];
                          $y = $subject['subject'];
                          $z = $subject['class'];
                          echo "<option value='$x'>$y - $z</option>";
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="teacher">Teacher</label>
                    <select id="teacher" class="form-control select2" required name="teacher">
                      <?php
                      $query = "SELECT * FROM staffs ORDER BY `staffs`.`first_name` ASC";
                      $stmt = $pdo->prepare($query);
                      $stmt->execute();
                      $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      if (count($teachers) === 0) {
                        echo '<option value="" selected disabled>No Teacher added Yet!</option>';
                      } else {
                        echo "<option value=''>Select Teacher</option>";
                        foreach ($teachers as $teacher) :
                          $x = $teacher['id'];
                          $y = $teacher['first_name'] . ' ' . $teacher['last_name'];
                          $z = $teacher['email'];
                          echo "<option value=$x>$y - $z</option>";
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>


              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="submit" class="btn mb-2 btn-primary w-100">Assign Subject To Teacher</button>
              </div>
            </form>


          </div>
        </div>
      </div> <!-- new event modal -->


      <!-- RemoveConfirmModal -->
      <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to remove this subject?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger confirm-remove">Remove</button>
            </div>
          </div>
        </div>
      </div>

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
                  <a href="../academics/" style="text-decoration: none;">
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
                  <a href="../messages" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Messages</p>
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
                  <a href="#" style="text-decoration: none;">
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
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Assessments</p>
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

      <!-- Assign Warning Modal -->
      <div class="modal fade" id="warningModel" tabindex="-1" role="dialog" aria-labelledby="warningModelTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header justify-content-center">
              <h5 class="modal-title text-center" id="warningModelTitle">Subject Already Assigned</h5>
            </div>
            <div class="modal-body">This Subject Is Already Assigned to another teacher, do you want to change teacher
              assign to this subject?</div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn mb-2 btn-primary" id="force_assign">Change Role</button>
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




    // Add class form js
    document.querySelectorAll(".add_subject_form").forEach(function(form) {
      form.addEventListener("submit", function(event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'add_subject.php',
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
          error: function(error, xhr) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      });
    });


    // Assign Class Teacher js
    document.querySelectorAll(".assign_subject_form").forEach(function(form) {
      form.addEventListener("submit", function(event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'assign_subject_form.php',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $('#assignTeacher').modal('hide');
            if (response.success) {
              displayPopup(response.message, true);
              // Refresh the page after 2 seconds
              setTimeout(function() {
                location.reload();
              }, 2000);
            } else {
              $('#warningModel').modal('show');
            }
          },
          error: function(error, xhr) {
            displayPopup('Error occurred during request. Contact Admin', false);
          },
        });
      });
    });


    document.getElementById("force_assign").addEventListener("click", function() {
      $.ajax({
        type: 'POST',
        url: 'force_assign_subject_teacher.php',
        data: $('.assign_subject_form').serialize(),
        dataType: 'json',
        beforeSend: function() {
          $('#warningModel').modal('hide');
        },
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
          displayPopup('Error occurred during request. Contact Admin', false);
          // console.error('Error:', error); // Log the error to the console for debugging
        },
      });
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {

      const addSubjectBtn = $('#addSubjectBtn');
      const addSubjectForm = $('#addSubjectForm');

      addSubjectBtn.click(function() {
        if (addSubjectForm.is(':hidden')) {
          // Show the add subject form
          addSubjectForm.slideDown();
          addSubjectBtn.text('Hide Form'); // Change button text to 'Hide Form'
        } else {
          // Hide the add subject form
          addSubjectForm.slideUp();
          addSubjectBtn.text('Add Subject'); // Change button text back to 'Add Subject'
        }
      });

      // Event delegation for edit action
      document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('edit-action')) {
          event.preventDefault();
          const parentTr = event.target.closest('tr');
          const editableField = parentTr.querySelector('.editable-field');
          const spanElement = editableField.querySelector('span');
          const inputGroup = editableField.querySelector('.input-group');
          const subjectId = editableField.dataset.id; // Get the subject ID

          // Show input field and hide span
          spanElement.style.display = 'none';
          inputGroup.style.display = 'flex';
          const inputElement = inputGroup.querySelector('input');
          inputElement.focus();

          // Save button
          const saveButton = inputGroup.querySelector('.save-button');
          saveButton.addEventListener('click', function() {
            const newName = inputElement.value;

            $.ajax({
              type: 'POST',
              url: 'edit_subject.php',
              data: {
                id: subjectId,
                newName: newName
              }, // Pass subject ID and new name
              dataType: 'json',
              success: function(response) {
                if (response.success) {
                  displayPopup(response.message, true);
                  // Update text with input value
                  spanElement.textContent = inputElement.value;

                  // Hide input field and show span
                  inputGroup.style.display = 'none';
                  spanElement.style.display = 'inline-block';
                } else {
                  displayPopup(response.message, false);
                }
              },
              error: function(error, xhr) {
                displayPopup('Error occurred during request. Contact Admin', false);
              },
            });
          });

          // Cancel button
          const cancelButton = inputGroup.querySelector('.cancel-button');
          cancelButton.addEventListener('click', function() {
            // Hide input field and show span without changing the text
            inputGroup.style.display = 'none';
            spanElement.style.display = 'inline-block';
          });
        }
      });

      // Event delegation for remove action
      document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-action')) {
          event.preventDefault();
          const parentTr = event.target.closest('tr');
          const subjectId = parentTr.dataset.id;

          // Show confirmation modal
          $('#confirmationModal').modal('show');

          // Add click event listener to the confirmation button
          $('.confirm-remove').off('click').on('click', function() {
            // Send AJAX request to remove the subject
            $.ajax({
              type: 'POST',
              url: 'remove_subject.php',
              data: {
                id: subjectId
              },
              dataType: 'json',
              success: function(response) {
                if (response.success) {
                  // Remove the row from the table
                  parentTr.remove();
                  displayPopup(response.message, true);
                } else {
                  displayPopup(response.message, false);
                }
              },
              error: function(error, xhr) {
                displayPopup('Error occurred during request. Contact Admin', false);
              },
            });

            // Hide the modal after action
            $('#confirmationModal').modal('hide');
          });
        }
      });
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