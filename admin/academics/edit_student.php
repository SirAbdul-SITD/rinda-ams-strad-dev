<?php require('../settings.php');

if (!isset($_POST['admission_no'])) {
  header("Location: students.php");
  exit;
} else {
  $admission_no = $_POST['admission_no'];
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Rinda AMS - Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
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

<body class=" light  ">
  <div class="wrapper">

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 ">
            <h3 class="page-title">Edit Student Info</h3>
            <p>Use the form below to update student information. All fields marked by an asterisk (*) must be filled.
            </p>
            <div class="card my-4">
              <div class="card-header">
                <strong>Update Form</strong>
              </div>
              <?php
              // Fetch student data based on the admission number
              $sql = "SELECT * FROM students WHERE admission_no = :admission_no";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':admission_no', $_POST['admission_no']);
              $stmt->execute();
              $student = $stmt->fetch(PDO::FETCH_ASSOC);

              // Check if student data exists
              if ($student) {
                // Assign student data to variables for easier access
                $id = $student['id'];
                $firstName = $student['firstName'];
                $lastName = $student['lastName'];
                $email = $student['email'];
                $class_id = $student['class_id'];
                $phoneNumber = $student['phoneNumber'];
                $address = $student['address'];
                $studentState = $student['state'];
                $likes = $student['likes'];
                $dislikes = $student['dislikes'];
                $allergies = $student['allergies'];
                $disorder = $student['disorder'];
                $health_info = $student['health_info'];
                $pickup_name1 = $student['pickup_name1'];
                $pickup_relationship1 = $student['pickup_relationship1'];
                $pickup_number1 = $student['pickup_number1'];
                $pickup_name2 = $student['pickup_name2'];
                $pickup_relationship2 = $student['pickup_relationship2'];
                $pickup_number2 = $student['pickup_number2'];
                $pickup_name3 = $student['pickup_name3'];
                $pickup_relationship3 = $student['pickup_relationship3'];
                $pickup_number3 = $student['pickup_number3'];
              }
              ?>

              <div class="card-body">
                <form id="example-form" action="update-student-info.php" method="POST">
                  <div id="wizard">

                    <h3>Student's Info</h3>
                    <section>
                      <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input id="firstName" name="firstName" value="<?= $firstName ?>" type="text" class="form-control ">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input id="lastName" name="lastName" value="<?= $lastName ?>" type="text" class="form-control ">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="phoneNumber">Phone Number *</label>
                            <input id="phoneNumber" name="phoneNumber" value="<?= $phoneNumber ?>" type="tel" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email">Email *</label>
                            <input id="email" name="email" value="<?= $email ?>" type="email" class="form-control">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Gender and Date of Birth -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="class_id">Current Class *</label>
                            <select id="class_id" class="form-control select1" name="class_id">
                              <?php
                              $query = "SELECT c.*, s.section FROM classes c INNER JOIN sections s ON c.section_id = s.id  WHERE s.status = 1 AND c.status = 1 ORDER BY c.section_id ASC";
                              $stmt = $pdo->prepare($query);
                              $stmt->execute();
                              $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                              if (count($classes) === 0) {
                                echo '<option value="" selected disabled>No class added Yet!</option>';
                              } else {
                                echo "<option value=''>Select Class</option>";
                                foreach ($classes as $class) :
                                  $x = $class['id'];
                                  $y = $class['class'];
                                  $z = $class['section'];
                                  echo '<option value="' . $x . '" ' . ($x == $class_id ? 'selected' : '') . '>' . $y . '</option>';

                                endforeach;
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="state">State *</label>
                            <select id="state" name="state" class="form-control ">
                              <option value="">Select State</option>
                              <?php
                              $states = array(
                                "Abia",
                                "Adamawa",
                                "Akwa Ibom",
                                "Anambra",
                                "Bauchi",
                                "Bayelsa",
                                "Benue",
                                "Borno",
                                "Cross River",
                                "Delta",
                                "Ebonyi",
                                "Edo",
                                "Ekiti",
                                "Enugu",
                                "FCT",
                                "Gombe",
                                "Imo",
                                "Jigawa",
                                "Kaduna",
                                "Kano",
                                "Katsina",
                                "Kebbi",
                                "Kogi",
                                "Kwara",
                                "Lagos",
                                "Nasarawa",
                                "Niger",
                                "Ogun",
                                "Ondo",
                                "Osun",
                                "Oyo",
                                "Plateau",
                                "Rivers",
                                "Sokoto",
                                "Taraba",
                                "Yobe",
                                "Zamfara"
                              );
                              foreach ($states as $state) {
                                echo '<option value="' . $state . '" ' . ($state == $studentState ? 'selected' : '') . '>' . $state . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <!-- State and Country -->

                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="address">Residential Address *</label>
                            <textarea id="address" name="address" class="form-control "><?= $address ?></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Likes and Dislikes -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="likes">Likes *</label>
                            <textarea id="likes" name="likes" class="form-control "><?= $likes ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="dislikes">Dislikes *</label>
                            <textarea id="dislikes" name="dislikes" class="form-control "><?= $dislikes ?></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Allergies and learning_disorder -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="allergies">Allergies *</label>
                            <textarea id="allergies" name="allergies" class="form-control "><?= $allergies ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="disorder">Any Leaning difficulty? *</label>
                            <textarea id="disorder" name="disorder" class="form-control "><?= $disorder ?></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- All vital health information -->
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="health_info">All vital health information *</label>
                            <textarea id="health_info" name="health_info" class="form-control "><?= $health_info ?></textarea>
                          </div>
                        </div>
                      </div>

                    </section>


                    <h3>Pickup Person(s)</h3>
                    <section>

                      <span id="pickup" class="mt-5">
                        <p class="mb-3">Person 1</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_name1">Full Name *</label>
                              <input id="pickup_name1" name="pickup_name1" value="<?= $pickup_name1 ?>" type="text" class="form-control ">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_relationship1">Relationship *</label>
                              <input id="pickup_relationship1" name="pickup_relationship1" value="<?= $pickup_relationship1 ?>" type="text" class="form-control ">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_number1">Contact Number *</label>
                              <input id="pickup_number1" name="pickup_number1" type="tel" value="<?= $pickup_number1 ?>" class="form-control ">
                            </div>
                          </div>
                        </div>



                        <p class="mb-3">Person 2</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_name2">Full Name </label>
                              <input id="pickup_name2" name="pickup_name2" value="<?= $pickup_name2 ?>" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_relationship2">Relationship </label>
                              <input id="pickup_relationship2" name="pickup_relationship2" value="<?= $pickup_relationship2 ?>" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_number2">Contact Number </label>
                              <input id="pickup_number2" name="pickup_number2" value="<?= $pickup_number2 ?>" type="tel" class="form-control">
                            </div>
                          </div>
                        </div>


                        <p class="mb-3">Person 3</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_name3">Full Name </label>
                              <input id="pickup_name3" name="pickup_name3" value="<?= $pickup_name3 ?>" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_relationship3">Relationship </label>
                              <input id="pickup_relationship3" name="pickup_relationship3" value="<?= $pickup_relationship3 ?>" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_number3">Contact Number </label>
                              <input id="pickup_number3" name="pickup_number3" value="<?= $pickup_number3 ?>" type="tel" class="form-control">
                            </div>
                          </div>
                        </div>


                      </span>

                      <!-- Help Text -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="help-text text-muted">(*) Mandatory</div>
                        </div>
                      </div>
                    </section>


                    <h3>Profile Picture</h3>
                    <section>

                     <?php $_SESSION['photo_id'] = $id; ?>
                      <!-- Photo Upload -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="student_photo">Update profile picture, The last upload will override the previous once
                            </label>
                            <div id="my-dropzone" class="dropzone">

                              <div class="dz-message needsclick">
                                <div class="circle circle-lg bg-primary">
                                  <i class="fe fe-upload fe-24 text-white"></i>
                                </div>
                                <h5 class="text-muted mt-4">Drop file here or click to upload</h5>
                              </div>

                              <div class="d-none" id="uploadPreviewTemplate">
                                <div class="card mt-1 mb-0 shadow-none border">
                                  <div class="p-2">
                                    <div class="row align-items-center">
                                      <div class="col-auto" style="border-radius: 10%;">
                                        <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                      </div>
                                      <div class="col pl-0">
                                        <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                                        <p class="mb-0" data-dz-size></p>
                                      </div>
                                      <div class="col-auto">

                                        Button
                                        <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                          <i class="dripicons-cross"></i>
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>


                      <input type="hidden" name="admission_no" id="admission_no" value="<?= $admission_no; ?>">
                    </section>



                  </div>
                </form>
              </div> <!-- .card-body -->
            </div> <!-- .card -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->

      <!-- Notifications modal -->
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

      <!-- Application Form Submimitted -->
      <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header justify-content-center">
              <h5 class="modal-title text-center" id="successModalTitle">Application Form Submimitted</h5>
            </div>
            <div class="modal-body">Your Application Was Submitted Successfully, Please Make the <span id='amount'></span> non-refundable application fee payment to the following account.</div>
            <div class="modal-footer">
              <a href="application-status.php" class=" w-100">
                <button type="button" class="btn mb-2 btn-primary w-100">View Application Status</button>
              </a>
            </div>
          </div>
        </div>
      </div>


      <!-- Application Form A;ready Submimitted -->
      <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header justify-content-center">
              <h5 class="modal-title text-center" id="errorModalTitle">Application Already Submimitted</h5>
            </div>
            <div class="modal-body">You have already submitted this application before. Please make sure to pay the application fee. Use the button below to check your application status</div>
            <div class="modal-footer">
              <a href="application-status.php" class=" w-100">
                <button type="button" class="btn mb-2 btn-primary w-100">View Application Status</button>
              </a>
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
  <script src="../js/d3.min.js"></script>
  <script src="../js/topojson.min.js"></script>
  <script src="../js/datamaps.all.min.js"></script>
  <script src="../js/datamaps-zoomto.js"></script>
  <script src="../js/datamaps.custom.js"></script>
  <script src="../js/Chart.min.js"></script>
  <script>
    /* defind global options */
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
  </script>
  <script src="../js/gauge.min.js"></script>
  <script src="../js/jquery.sparkline.min.js"></script>
  <script src="../js/apexcharts.min.js"></script>
  <script src="../js/apexcharts.custom.js"></script>
  <script src='../js/jquery.mask.min.js'></script>
  <script src='../js/select2.min.js'></script>
  <!-- <script src='../js/jquery.step.min.js'></script> -->
  <script src='../js/jquery.validate.min.js'></script>
  <script src='../js/jquery.timepicker.js'></script>
  <script src='../js/dropzone.min.js'></script>
  <script src='../js/uppy.min.js'></script>
  <script src='../js/quill.min.js'></script>

  <script>
    function toggleClassInfo(type) {
      var classInfo = document.getElementById(type + 'Info');
      var checkbox = document.getElementById('customSwitch4');
      var label = document.getElementById(type + 'Label');

      if (checkbox.checked) {
        // Add animation to slide down the parent info section
        $(classInfo).slideDown();
        label.innerText = 'No';
      } else {
        // Add animation to slide up the parent info section
        $(classInfo).slideUp();
        label.innerText = 'Yes';
      }
    }
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

  <script src="../js/apps.js"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
  </script>

  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
  <script>
    $(document).ready(function() {
      // Define citiesByState object
      const citiesByState = {
        "FCT": [
          "Abuja",
          "Gwagwalada",
          "Kuje",
          "Abaji",
          "Bwari",
          "Kwali"
        ],
        "Abia": [
          "Aba",
          "Umuahia",
          "Arochukwu",
          "Ohafia",
          "Bende",
          "Isuikwuato",
          "Umunneochi",
          "Ikwuano",
          "Ukwa West",
          "Ukwa East",
          "Obingwa",
          "Osisioma",
          "Isiala Ngwa North",
          "Isiala Ngwa South",
          "Ugwunagbo",
          "Ukwa East"
        ],
        "Adamawa": [
          "Yola",
          "Jimeta",
          "Mubi",
          "Ganye",
          "Hong",
          "Gombi",
          "Numan",
          "Michika",
          "Madagali",
          "Song",
          "Toungo",
          "Mayo-Belwa",
          "Fufure",
          "Demsa",
          "Jada",
          "Guyuk",
          "Fufore"
        ],
        "Akwa Ibom": [
          "Uyo",
          "Eket",
          "Ikot Ekpene",
          "Oron",
          "Ikot Abasi",
          "Etinan",
          "Abak",
          "Ibiono Ibom",
          "Itu",
          "Ika",
          "Uruan",
          "Ibesikpo Asutan",
          "Obot Akara",
          "Ikono",
          "Essien Udim",
          "Nsit Atai",
          "Nsit Ubium",
          "Ini",
          "Ukanafun",
          "Ikot Okpora"
        ],
        "Anambra": [
          "Awka",
          "Onitsha",
          "Nnewi",
          "Aguata",
          "Njikoka",
          "Idemili North",
          "Anaocha",
          "Dunukofia",
          "Idemili South",
          "Oyi",
          "Orumba North",
          "Orumba South",
          "Ekwusigo",
          "Ogbaru",
          "Anambra East",
          "Anambra West",
          "Ayamelum"
        ],
        "Bauchi": [
          "Bauchi",
          "Azare",
          "Misau",
          "Jama'are",
          "Katagum",
          "Tafawa Balewa",
          "Dass",
          "Ganjuwa",
          "Ningi",
          "Zaki",
          "Itas/Gadau",
          "Toro",
          "Alkaleri",
          "Darazo",
          "Giade",
          "Warji",
          "Damban",
          "Kirfi",
          "Bogoro",
          "Shira"
        ],
        "Bayelsa": [
          "Yenagoa",
          "Brass",
          "Sagbama",
          "Ogbia",
          "Nembe",
          "Ekeremor",
          "Kolokuma/Opokuma",
          "Southern Ijaw",
          "Brass",
          "Yenagoa",
          "Ekeremor",
          "Sagbama"
        ],
        "Benue": [
          "Makurdi",
          "Gboko",
          "Otukpo",
          "Katsina-Ala",
          "Ukum",
          "Vandeikya",
          "Gwer East",
          "Buruku",
          "Logo",
          "Kwande",
          "Agatu",
          "Guma",
          "Gwer West",
          "Tarka",
          "Oju",
          "Oturkpo",
          "Obi",
          "Konshisha",
          "Ado"
        ],
        "Borno": [
          "Maiduguri",
          "Jere",
          "Marte",
          "Gwoza",
          "Monguno",
          "Damboa",
          "Konduga",
          "Askira/Uba",
          "Bama",
          "Ngala",
          "Kaga",
          "Abadam",
          "Nganzai",
          "Magumeri",
          "Kukawa",
          "Guzamala",
          "Mobbar"
        ],
        "Cross River": [
          "Calabar",
          "Akamkpa",
          "Ikom",
          "Obudu",
          "Ogoja",
          "Obanliku",
          "Bekwarra",
          "Yala",
          "Boki",
          "Biase",
          "Abi",
          "Etung",
          "Bakassi",
          "Yakurr",
          "Ugep",
          "Okpoma"
        ],
        "Delta": [
          "Asaba",
          "Warri",
          "Ughelli",
          "Sapele",
          "Ozoro",
          "Agbor",
          "Effurun",
          "Koko",
          "Issele-Uku",
          "Abraka",
          "Ogwashi-Uku",
          "Uvwie",
          "Orerokpe",
          "Oleh",
          "Owa-Oyibu",
          "Otor-Owhe",
          "Patani",
          "Ughoton"
        ],
        "Ebonyi": [
          "Abakaliki",
          "Afikpo",
          "Onueke",
          "Izzi",
          "Ezza",
          "Ishielu",
          "Ohaukwu",
          "Onicha",
          "Ikwo",
          "Afikpo",
          "Ezzamgbo",
          "Ezza",
          "Onicha"
        ],
        "Edo": [
          "Benin City",
          "Auchi",
          "Uromi",
          "Ikpoba-Okha",
          "Igarra",
          "Ekpoma",
          "Sabongida-Ora",
          "Igueben",
          "Ubiaja",
          "Auchi",
          "Igueben",
          "Ekpoma",
          "Uromi",
          "Auchi"
        ],
        "Ekiti": [
          "Ado Ekiti",
          "Ikere Ekiti",
          "Ikole Ekiti",
          "Araromi Oke",
          "Omuo Ekiti",
          "Ijero Ekiti",
          "Ode Ekiti",
          "Ipoti Ekiti",
          "Igede Ekiti",
          "Emure Ekiti",
          "Oye Ekiti",
          "Ido Ekiti",
          "Ilawe Ekiti",
          "Ise Ekiti",
          "Ikun Ekiti",
          "Iloro Ekiti"
        ],
        "Enugu": [
          "Enugu",
          "Nsukka",
          "Agbani",
          "Awgu",
          "Udi",
          "Oji River",
          "Nsukka",
          "Enugu Ezike",
          "Nsukka",
          "Enugu Ngwo",
          "Ozalla"
        ],
        "Gombe": [
          "Gombe",
          "Kaltungo",
          "Billiri",
          "Dukku",
          "Balanga",
          "Nafada",
          "Deba",
          "Bajoga",
          "Dadin Kowa",
          "Duku",
          "Tumu",
          "Bogoro"
        ],
        "Imo": [
          "Owerri",
          "Okigwe",
          "Orlu",
          "Mbaise",
          "Oguta",
          "Orlu",
          "Nkwerre",
          "Aboh Mbaise",
          "Owerri West",
          "Isu",
          "Ngor Okpala",
          "Obowo",
          "Owerri North",
          "Ikeduru",
          "Ohaji/Egbema"
        ],
        "Jigawa": [
          "Dutse",
          "Birnin Kudu",
          "Hadejia",
          "Kazaure",
          "Gumel",
          "Kiyawa",
          "Gwaram",
          "Ringim",
          "Babura",
          "Kaugama",
          "Maigatari",
          "Gagarawa"
        ],
        "Kaduna": [
          "Kaduna",
          "Zaria",
          "Kafanchan",
          "Soba",
          "Jere",
          "Kaura",
          "Zangon Kataf",
          "Kagarko",
          "Sabon Gari",
          "Ikara",
          "Makarfi",
          "Kudan",
          "Giwa"
        ],
        "Kano": [
          "Kano",
          "Gwale",
          "Fagge",
          "Dala",
          "Nassarawa",
          "Tarauni",
          "Kumbotso",
          "Ungogo",
          "Dawakin Kudu",
          "Kura",
          "Madobi",
          "Garko",
          "Rano"
        ],
        "Katsina": [
          "Katsina",
          "Daura",
          "Funtua",
          "Malumfashi",
          "Kankia",
          "Mani",
          "Dutsin Ma",
          "Batsari",
          "Safana",
          "Danja",
          "Kafur",
          "Charanchi"
        ],
        "Kebbi": [
          "Birnin Kebbi",
          "Yauri",
          "Argungu",
          "Zuru",
          "Jega",
          "Dandi",
          "Aleiro",
          "Bunza",
          "Wasagu",
          "Augie",
          "Maiyama",
          "Bagudo"
        ],
        "Kogi": [
          "Lokoja",
          "Okene",
          "Anyigba",
          "Idah",
          "Ankpa",
          "Ogaminana",
          "Kabba",
          "Ejule",
          "Ochadamu",
          "Isanlu",
          "Idah",
          "Ajaokuta",
          "Ibaji",
          "Igalamela-Odolu",
          "Dekina",
          "Ankpa",
          "Olamaboro"
        ],
        "Kwara": [
          "Ilorin",
          "Offa",
          "Omu Aran",
          "Lafiagi",
          "Kaiama",
          "Jebba",
          "Pategi",
          "Ilorin",
          "Eruwa",
          "Bode Saadu",
          "Oke-Onigbin",
          "Owode"
        ],
        "Lagos": [
          "Lagos",
          "Ikeja",
          "Lekki",
          "Victoria Island",
          "Epe",
          "Badagry",
          "Ikorodu",
          "Ajah",
          "Surulere",
          "Apapa",
          "Mushin",
          "Yaba",
          "Ketu",
          "Agege",
          "Iyana Ipaja",
          "Maryland"
        ],
        "Nasarawa": [
          "Lafia",
          "Keffi",
          "Akwanga",
          "Nasarawa",
          "Karu",
          "Toto",
          "Wamba",
          "Nasarawa Eggon",
          "Obi",
          "Kokona",
          "Awe"
        ],
        "Niger": [
          "Minna",
          "Bida",
          "Suleja",
          "Kontagora",
          "Lapai",
          "New Bussa",
          "Wushishi",
          "Agwara",
          "Kagara",
          "Rijau",
          "Mokwa"
        ],
        "Ogun": [
          "Abeokuta",
          "Sagamu",
          "Ijebu Ode",
          "Ilaro",
          "Ota",
          "Ijebu Igbo",
          "Ifo",
          "Shagamu",
          "Ipokia",
          "Owode",
          "Odeda",
          "Idiroko"
        ],
        "Ondo": [
          "Akure",
          "Ondo",
          "Owo",
          "Ile-Oluji",
          "Igbara-Oke",
          "Irele",
          "Okitipupa",
          "Igbokoda",
          "Idanre",
          "Ikare",
          "Igbara-Oke",
          "Odigbo"
        ],
        "Osun": [
          "Osogbo",
          "Ilesa",
          "Ife",
          "Iwo",
          "Ejigbo",
          "Ikirun",
          "Ila Orangun",
          "Ijebu Jesa",
          "Ede",
          "Ilobu",
          "Oke Ila",
          "Igbona"
        ],
        "Oyo": [
          "Ibadan",
          "Ogbomoso",
          "Iseyin",
          "Saki",
          "Oyo",
          "Okeho",
          "Igboho",
          "Igbo-Ora",
          "Igboora",
          "Eruwa",
          "Ago-Are",
          "Oyo",
          "Ibarapa"
        ],
        "Plateau": [
          "Jos",
          "Bukuru",
          "Pankshin",
          "Shendam",
          "Langtang",
          "Mangu",
          "Barkin Ladi",
          "Riyom",
          "Wase",
          "Bassa",
          "Qua'an Pan"
        ],
        "Rivers": [
          "Port Harcourt",
          "Obio-Akpor",
          "Bonny",
          "Degema",
          "Eleme",
          "Opobo",
          "Okrika",
          "Oyigbo",
          "Ahoada",
          "Ogu-Bolo",
          "Andoni",
          "Ikwerre",
          "Emuoha"
        ],
        "Sokoto": [
          "Sokoto",
          "Tambuwal",
          "Goronyo",
          "Kware",
          "Wurno",
          "Isa",
          "Gada",
          "Bodinga",
          "Gwadabawa",
          "Dange-Shuni",
          "Rabah"
        ],
        "Taraba": [
          "Jalingo",
          "Wukari",
          "Bali",
          "Takum",
          "Zing",
          "Gashaka",
          "Kurmi",
          "Gassol",
          "Ibi",
          "Donga"
        ],
        "Yobe": [
          "Damaturu",
          "Nguru",
          "Potiskum",
          "Gashua",
          "Buni Yadi",
          "Geidam",
          "Yusufari",
          "Fika",
          "Nangere",
          "Bade",
          "Bursari"
        ],
        "Zamfara": [
          "Gusau",
          "Tsafe",
          "Talata Mafara",
          "Anka",
          "Kaura Namoda",
          "Maru",
          "Bakura",
          "Gummi",
          "Shinkafi",
          "Bungudu",
          "Maradun",
          "Zurmi"
        ],
        // Add cities for other states here
      };

      //Function to display a popup message
      function displayPopup(message, success) {
        var popup = document.createElement('div');
        popup.className = 'popup ' + (success ? 'success' : 'error');

        var iconClass = success ? 'fe fe-check-circle' : 'fe fe-x-octagon';
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



      // Function to populate city dropdown based on selected state
      function populateCities(stateSelect, citySelect) {
        const selectedState = stateSelect.value;
        // Clear previous options
        citySelect.innerHTML = "<option value=''>Select City</option>";
        // Populate with cities based on selected state
        if (selectedState && citiesByState[selectedState]) {
          citiesByState[selectedState].forEach(city => {
            const option = document.createElement("option");
            option.text = city;
            option.value = city;
            citySelect.appendChild(option);
          });
        }
      }
      // Initialize wizard after event listener
      $("#wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function(event, currentIndex, newIndex) {
          form.validate().settings.ignore = ":disabled,:hidden";
          return form.valid();
        },
        onFinishing: function(event, currentIndex) {
          form.validate().ignore;
          return form.valid();
        },
        onFinished: function(event, currentIndex) {
          // Submit the form via AJAX
          $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            // beforeSend: function () {
            // $('#warningModel').modal('hide');
            // },
            success: function(response) {
              if (response.success) {
                displayPopup(response.message, true);


              } else {
                displayPopup(response.message, false);

              }
            },
            error: function(xhr, status, error) {
              // Handle error
              console.error(xhr.responseText);
            }

          });
        }
      });

      // Event listener for student state dropdown change
      $('#student_state').on('change', function() {
        populateCities(this, document.getElementById("student_city"));
      });

      // Event listener for father state dropdown change
      $('#father_state').on('change', function() {
        populateCities(this, document.getElementById("father_city"));
      });

      // Event listener for mother state dropdown change
      $('#mother_state').on('change', function() {
        populateCities(this, document.getElementById("mother_city"));
      });

      // Event listener for guardian state dropdown change
      $('#guardian_state').on('change', function() {
        populateCities(this, document.getElementById("guardian_city"));
      });

      // Initially populate cities based on default state selection
      populateCities(document.getElementById("student_state"), document.getElementById("student_city"));
    });
  </script>
  <script>
    Dropzone.autoDiscover = false; // Disable auto initialization

    $(document).ready(function() {
      // Initialize Dropzone on the specific element
      $("#my-dropzone").dropzone({
        url: "upload.php",
        paramName: "file", // Name of the file parameter to be sent to the server
        maxFilesize: 50, // Maximum file size in MB
        // Add more Dropzone options as needed
      });
    });
  </script>
  <!-- <script>
    $(document).ready(function() {
      $('#application-form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Retrieve the reference number from localStorage
        var storedRefNumber = localStorage.getItem('refNumber');

        // Serialize form data
        var formData = $(this).serialize();

        // Append the reference number to the serialized form data
        formData += '&ref=' + storedRefNumber;

        // Submit form data via AJAX
        $.ajax({
          url: 'save-application.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            // Handle the response
            if (response.success) {
              displayPopup(response.message, true);
              if (response.section == 3) {
                document.getElementById("amount").innerText = '5,000';
              } else {
                document.getElementById("amount").innerText = '15,000';
              }

              $('#successModal').modal({
                backdrop: 'static',
                keyboard: false
              });

            } else {
              // displayPopup(response.message, false);
              $('#successModal').modal({
                backdrop: 'static',
                keyboard: false
              });
            }
          },
          error: function(xhr, status, error) {
            // console.log(xhr.responseText);
            // Handle errors if any
          }
        });
      });
    });
  </script> -->
</body>

</html>