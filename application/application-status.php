<?php require('db.php');

if (isset($_POST['ref'])) {
  $ref = $_POST['ref'];
  $_SESSION['ref'] = $ref;
} elseif (isset($_SESSION['ref'])) {
  $ref = $_SESSION['ref'];
} else {
  header('Location: index.php');
}


$query = "SELECT * FROM applications WHERE ref = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$ref]);
$application_info = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$application_info) {
  // throw new Exception("Invalid Application Reference Number");
  header('Location: index.php');
}

$c_id = $application_info['class_id'];

$query = "SELECT class From classes WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$application_info['class_id']]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);

$ap_class = $class['class'];


$secQuery = "SELECT section_id FROM classes WHERE id = ?";
$sec = $pdo->prepare($secQuery);
$sec->execute([$application_info['class_id']]);
$section = $sec->fetch(PDO::FETCH_ASSOC);
$section_id = $section['section_id'];


if ($section_id == 3) {
  $amount = '5,000';
} else {
  $amount = '15,000';
}


$comment = '';
if ($application_info['status'] == 'Initiated') {
  $progress = 20;
  $color = 'red';
  $comment = "Thank you for initiating your application with us. We appreciate your interest. Please proceed by filling in the form to continue the application process.";
} elseif ($application_info['status'] == 'Submitted') {
  $progress = 40;
  $color = 'black';
  $comment = "Congratulations! Your application has been successfully submitted. To proceed further, kindly make a payment of $amount to Grithall Academy Ltd, Account Number: 0003166996 at Jaiz Bank. Thank you for choosing us.";
} elseif ($application_info['status'] == 'Paid') {
  $progress = 60;
  $color = 'blue';
  $comment = "We are pleased to inform you that your application fee payment has been received and confirmed. Your application is now under review. Kindly await further communication from our admission team regarding the interview date.";
} elseif ($application_info['status'] == 'Interviewed') {
  $progress = 80;
  $color = 'gold';
  $comment = "Great news! Your interview has been conducted successfully. Now, please await your admission status and further instructions on the class payment process. We appreciate your participation in the interview.";
} elseif ($application_info['status'] == 'Admitted') {
  $progress = 100;
  $color = 'green';
  $comment = "Congratulations! We are thrilled to inform you that your application has been successful, and you have been admitted to our institution. Welcome to the Grithall Academy family! Please await further details on your admission status and instructions for class payment. We look forward to having you with us.";
} elseif ($application_info['status'] == 'Rejected') {
  $progress = 100;
  $color = 'red';
  $comment = "We regret to inform you that your application for admission has been unsuccessful. We appreciate your interest in our institution and wish you the best in your future endeavors.";
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
  <title>Rinda AMS - Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="css/feather.css">
  <link rel="stylesheet" href="css/select2.css">
  <link rel="stylesheet" href="css/dropzone.css">
  <link rel="stylesheet" href="css/uppy.min.css">
  <link rel="stylesheet" href="css/jquery.steps.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">
  <link rel="stylesheet" href="css/quill.snow.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="css/app-dark.css" id="darkTheme" disabled>
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

<body class="light  ">
  <div class="wrapper">

    <main role="main" class="main-content mt-5">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-10">
            <h3 class="page-title">Application Status</h3>
            <p>View the status of your application and latest updates on this page</p>

            <div class="card my-4">
              <div class="card profile shadow">
                <div class="card-body my-4">
                  <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-5">
                      <strong>
                        <h1><?= $application_info['status'] ?></h1>
                      </strong>
                      <div class="col">
                        <div class="small mb-2 d-flex">
                          <span class="text-muted flex-fill text-left">Progress</span>
                          <span class="text-muted"><?= $progress ?>%</span>
                        </div>
                        <div class="progress" style="height: 2px;">
                          <div class="progress-bar" role="progressbar" style="width: <?= $progress ?>%; background-color: <?= $color ?>" aria-valuenow="<?= $progress ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row align-items-center">
                        <div class="col-md-7">
                          <h4 class="mb-1"><?= $application_info['student_firstName'] . ' ' . $application_info['student_lastName']; ?></h4>
                          <p class=" mb-3"><span class="badge badge-dark"><?= $class['class'] ?></span></p>
                        </div>
                        <div class="col">
                        </div>
                      </div>
                      <div class="row mb-4">
                        <div class="col-md-7">
                          <p class="text-muted h5 mb-2"> <?= $comment; ?> </p>
                          <div class="col">
                            <?php if ($application_info['status'] == 'Initiated') { ?>
                              <a href="application.php" class=" w-100">
                                <button type="button" class="btn mb-2 btn-primary w-100">Fill Application Form</button>
                              </a> <?php } else { ?>
                              <button type="button" class="btn btn-primary w-100" id="reveal">Reveal Fees Invoice</button>
                            <?php  } ?>
                          </div>
                        </div>
                        <div class="col">
                          <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>No. 1 JD Abubakar Close, Harmony Estate, Off Panaf Drive, Dawaki Abuja</p>
                          <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+234 809 907 2019</p>
                          <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+234 905 140 9256</p>
                          <p class="mb-2"><i class="fa fa-envelope me-3"></i>grithallacademy@gmail.com</p>
                        </div>
                      </div>

                    </div>
                  </div> <!-- / .row- -->
                </div> <!-- / .card-body - -->
              </div> <!-- / .card- -->
            </div> <!-- / .col- -->

            <div class="card my-4" id="revealDetails" style="display: none;">
              <div class="card-header">
                <strong><?= $ap_class ?> Invoices</strong>
              </div>
              <div class="card-body">


                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Type</th>
                      <th>First Term Amount</th>
                      <th>Second Term Amount</th>
                      <th>Third Term Amount</th>
                      <th>Annual Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    try {
                      if ($section_id == 3) {
                      $query = "SELECT
                        id AS fee_id, 
                        type,
                        first_term, 
                        second_term, 
                        third_term, 
                        annual 
                      FROM islamiyyah_fees 
                      WHERE class_id = ?";
                      } else {
                        $query = "SELECT
                        id AS fee_id, 
                        type,
                        first_term, 
                        second_term, 
                        third_term, 
                        annual 
                      FROM compulsory_fees 
                      WHERE class_id = ?";
                      }

                      $stmt = $pdo->prepare($query);
                      if (!$stmt) {
                        throw new Exception("Failed to prepare statement: " . implode(" ", $pdo->errorInfo()));
                      }

                      if (!$stmt->execute([$c_id])) {
                        throw new Exception("Failed to execute statement: " . implode(" ", $stmt->errorInfo()));
                      }

                      $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      if (!$invoices) {
                        throw new Exception("Failed to fetch data: " . implode(" ", $stmt->errorInfo()));
                      }

                      foreach ($invoices as $index => $invoice) : ?>
                        <tr>
                          <td><?= htmlspecialchars($index + 1, ENT_QUOTES, 'UTF-8') ?></td>
                          <td><?= htmlspecialchars($invoice['type'], ENT_QUOTES, 'UTF-8') ?></td>
                          <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['first_term'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['second_term'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['third_term'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td>
                        <?php
                        $annual_amount = $invoice['first_term'] + $invoice['second_term'] + $invoice['third_term'];
                        $formatted_amount = '₦' . number_format($annual_amount, 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>

                        </tr>
                    <?php endforeach;
                    } catch (Exception $e) {
                      echo '<tr><td colspan="7" style="color: red;">Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</td></tr>';
                    }
                    ?>
                  </tbody>
                </table>



              </div> <!-- .card-body -->
            </div> <!-- .card -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->




    </main> <!-- main -->
  </div> <!-- .wrapper -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/simplebar.min.js"></script>
  <script src='js/daterangepicker.js'></script>
  <script src='js/jquery.stickOnScroll.js'></script>
  <script src="js/tinycolor-min.js"></script>
  <script src="js/config.js"></script>
  <script src="js/d3.min.js"></script>
  <script src="js/topojson.min.js"></script>
  <script src="js/datamaps.all.min.js"></script>
  <script src="js/datamaps-zoomto.js"></script>
  <script src="js/datamaps.custom.js"></script>
  <script src="js/Chart.min.js"></script>
  <script>
    /* defind global options */
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
  </script>
  <script src="js/gauge.min.js"></script>
  <script src="js/jquery.sparkline.min.js"></script>
  <script src="js/apexcharts.min.js"></script>
  <script src="js/apexcharts.custom.js"></script>
  <script src='js/jquery.mask.min.js'></script>
  <script src='js/select2.min.js'></script>
  <!-- <script src='js/jquery.step.min.js'></script> -->
  <script src='js/jquery.validate.min.js'></script>
  <script src='js/jquery.timepicker.js'></script>
  <script src='js/dropzone.min.js'></script>
  <script src='js/uppy.min.js'></script>
  <script src='js/quill.min.js'></script>

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

  <script src="js/apps.js"></script>
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
  <!-- <script>
    Dropzone.autoDiscover = false; // Disable auto initialization

    $(document).ready(function() {
      // Initialize Dropzone on the specific element
      $("#my-dropzone").dropzone({
        url: "upload.php",
        paramName: "file", // Name of the file parameter to be sent to the server
        maxFilesize: 10, // Maximum file size in MB
        // Add more Dropzone options as needed
      });
    });
  </script> -->
  <script>
    const reveal = $('#reveal');
    const revealDetails = $('#revealDetails');

    reveal.click(function() {
      if (revealDetails.is(':hidden')) {
        // Show the add class form
        revealDetails.slideDown();
        reveal.text('Hide Fees Invoice'); // Change button text to 'Hide Form'
      } else {
        // Hide the add class form
        revealDetails.slideUp();
        reveal.text('Reveal Fees Invoice'); // Change button text back to 'Add class'
      }
    });
  </script>
</body>

</html>