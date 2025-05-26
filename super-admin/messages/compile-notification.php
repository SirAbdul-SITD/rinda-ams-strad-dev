<?php require_once '../settings.php';

$type = isset($_COOKIE['typem']) ? $_COOKIE['type'] : '';
$subject = isset($_COOKIE['subject']) ? $_COOKIE['subject'] : '';
$content = isset($_COOKIE['content']) ? $_COOKIE['content'] : '';

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Compile Notification - Messages | Rinda AMS</title>
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
          <a class="nav-link text-muted my-2" href="../#" data-toggle="modal" data-target=".modal-shortcut">
            <span class="fe fe-grid fe-16"></span>
          </a>
        </li>
        <li class="nav-item nav-notif">
          <a class="nav-link text-muted my-2" href="../#" data-toggle="modal" data-target=".modal-notif">
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
          <div class="col-12">
            <div class="row align-items-center mb-4">
              <div class="col">
                <h2 class="h5 page-title"><small class="text-muted text-uppercase">Ticket</small><br />#342</h2>
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-secondary">Close</button>
              </div>
            </div> <!-- .row -->
            <form>
              <div class="row my-4">
                <div class="col-md-9">
                  <div class="card shadow mb-4">
                    <div class="card-header">
                      <strong class="card-title">Configure Notification</strong>
                      <span class="float-right"><i class="fe fe-flag mr-2"></i><span class="badge badge-pill badge-success text-white"><?= $type ?></span></span>
                    </div>
                    <div class="card-body">
                      <div class="form-group col-md-12">
                        <label for="subject">Header Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control required" required value="<?= $subject ?>">
                      </div>

                      <div class=" col-md-12">
                        <p class="mb-2">Send to whom?</p>
                        <div class="form-row">
                          <div class="col-md-6">
                            <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input required" id="customControlValidation23" name="whom" checked required value='1'>
                              <label class="custom-control-label" for="customControlValidation23">All</label>
                              <p class="text-muted">All Parents will receive this notification.</p>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                              <input type="radio" class="custom-control-input required" id="customControlValidation34" name="whom" required value='2'>
                              <label class="custom-control-label" for="customControlValidation34">Select</label>
                              <p class="text-muted"> Select Parents that will receive this notification.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-12">
                        <label for="recipients">Select Recipients</label>
                        <select required class="form-control select2-multi required" id="recipients" name="recipients" aria-placeholder="Search Teachers" multiple>
                          <?php
                          $designation_id = 3;
                          $query = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM staffs WHERE designation_id = :designation_id ORDER BY first_name ASC";
                          $stmt = $pdo->prepare($query);
                          $stmt->bindParam(':designation_id', $designation_id, PDO::PARAM_INT);
                          $stmt->execute();
                          $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          if (count($teachers) === 0) {
                            echo '<option value="" selected disabled>None added Yet!</option>';
                          } else {
                            foreach ($teachers as $teacher) :
                              $x = $teacher['id'];
                              $y = $teacher['full_name'];
                              echo "<option value=$x>$y</option>";
                            endforeach;
                          }
                          ?>
                        </select>
                      </div> <!-- form-group -->
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                  <div class="card shadow mb-4">
                    <div class="card-header">
                      <strong class="card-title">Notification Content</strong>
                      <!-- <span id="recipientCount" class="float-right"><i class="fe fe-message-circle mr-2"></i>0
                        recipients</span> -->
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="content" class="sr-only">Your Message</label>
                        <textarea required class="form-control bg-light required" id="content" name="content" rows="5"><?= $content ?></textarea>
                      </div>
                      <button type="submit" class="w-100 btn btn-primary">Send Notification <i class="fe fe-send text-white"></i></button>
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                </div> <!-- .col-md -->
                <div class="col-md-3">
                  <div class="card shadow mb-4">
                    <div class="card-body">
                      <h3 class="h5 mb-1">Channels</h3>
                      <p class="text-muted mb-4">Where would you like this notification to be sent?</p>
                      <div class="form-check mb-2">
                        <input class="form-check-input required" type="radio" name="sendOption" required id="sendToEmail" value="sendToEmail">
                        <label class="form-check-label" for="sendToEmail">Send to Email</label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input required" type="radio" name="sendOption" required id="sendToWhatsApp" value="sendToWhatsApp">
                        <label class="form-check-label" for="sendToWhatsApp">Send to WhatsApp</label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input required" type="radio" name="sendOption" required id="sendBySMS" value="sendBySMS">
                        <label class="form-check-label" for="sendBySMS">Send by SMS</label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input required" type="radio" name="sendOption" required id="sendToEmailWhatsApp" value="sendToEmailWhatsApp">
                        <label class="form-check-label" for="sendToEmailWhatsApp">To Email & WhatsApp</label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input required" type="radio" name="sendOption" required id="sendBySMSWhatsApp" value="sendBySMSWhatsApp">
                        <label class="form-check-label" for="sendBySMSWhatsApp">By SMS and WhatsApp</label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input required" type="radio" name="sendOption" required id="sendBySMSEmail" value="sendBySMSEmail">
                        <label class="form-check-label" for="sendBySMSEmail">By SMS and Email</label>
                      </div>
                    </div>
                  </div>
                </div> <!-- .col-md -->
              </div> <!-- .col-md -->
            </form>
          </div>
        </div> <!-- .col-12 -->
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
                <p class="text-primary">Dashboard</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="../academics" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                </div>
                <p>Academics</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <a href="../lms" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-primary">E-Learning</p>
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
                <p class="text-primary">Shop</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="../hr/" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center text-white">
                  <i class="fe fe-users fe-32 align-self-center"></i>
                </div>
                <p class="text-primary">HR</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <a href="../assessments" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-primary">Assessments</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="../settings" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-primary">Settings</p>
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
  <script src='../js/jquery.mask.min.js'></script>
  <script src='../js/select2.min.js'></script>
  <script src='../js/jquery.steps.min.js'></script>
  <script src='../js/jquery.validate.min.js'></script>
  <script src='../js/jquery.timepicker.js'></script>
  <script src='../js/dropzone.min.js'></script>
  <script src='../js/uppy.min.js'></script>
  <script src='../js/quill.min.js'></script>

  <script>
    // Add event listener to the multi-select dropdown
    document.getElementById('recipients').addEventListener('change', function() {
      // Get the count of selected options
      var selectedCount = this.selectedOptions.length;
      // Update the count in the span element
      document.getElementById('recipientCount').innerText = selectedCount + ' recipient(s)';
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
    var uptarg = document.getElementById('drag-drop-area');
    if (uptarg) {
      var uppy = Uppy.Core().use(Uppy.Dashboard, {
        inline: true,
        target: uptarg,
        proudlyDisplayPoweredByUppy: false,
        theme: 'dark',
        width: 770,
        height: 210,
        plugins: ['Webcam']
      }).use(Uppy.Tus, {
        endpoint: 'https://master.tus.io/files/'
      });
      uppy.on('complete', (result) => {
        console.log('Upload complete! We’ve uploaded these files:', result.successful)
      });
    }
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