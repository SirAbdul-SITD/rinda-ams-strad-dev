<?php require_once('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>All Orders - Shop | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="../overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/select2.css">
  <link rel="stylesheet" href="../css/dropzone.css">
  <link rel="stylesheet" href="../css/uppy.min.css">
  <link rel="stylesheet" href="../css/jquery.steps.css">
  <link rel="stylesheet" href="../css/jquery.timepicker.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap4.css">
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

<body class="horizontal light  ">
  <div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow">
      <div class="container-fluid">
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="index.php">
          <span class="avatar avatar-sm mt-2">
            <img src="../assets/images/logo.jpg" size="20" alt="..." class="avatar-img rounded-circle">
          </span>
        </a>
        <button class="navbar-toggler mt-2 mr-auto toggle-sidebar text-muted">
          <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <div class="navbar-slide bg-white ml-lg-4" id="navbarSupportedContent">
          <a href="#" class="btn toggle-sidebar d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
            <i class="fe fe-x"><span class="sr-only"></span></i>
          </a>
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">
                <span class="ml-lg-2">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="categories.php">
                <span class="ml-lg-2">Product Category</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.php">
                <span class="ml-lg-2">Product Management</span>
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link text-primary" href="orders.php">
                <span class="ml-lg-2">Orders</span>
                <span class="mb-2 badge badge-pill badge-primary pb-0">New</span>
              </a>
            </li>

          </ul>
        </div>
        <form class="form-inline ml-md-auto d-none d-lg-flex searchform text-muted">
          <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
        </form>
        <ul class="navbar-nav d-flex flex-row">
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="./#" id="modeSwitcher" data-mode="light">
              <i class="fe fe-sun fe-16"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
              <i class="fe fe-grid fe-16"></i>
            </a>
          </li>
          <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
              <i class="fe fe-bell fe-16"></i>
              <span class="dot dot-md bg-success"></span>
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
                <p style="padding: 0%; margin: 0%;"><?= $full_name; ?></p>
                <strong><?= $account_type; ?></strong>
              </div>
              <hr width="80%">
              <a class="dropdown-item text-muted" href="#">Profile</a>
              <a class="dropdown-item text-muted" href="#">Settings</a>
              <a class="dropdown-item" href="../logout.php">Log out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-11">
            <div class="row align-items-center my-3">
              <div class="col-auto col-8">
                <h2 class="h3 mb-3 page-title">Orders</h2>

                <div class="col-md">
                  <ul class="nav nav-pills justify-content-start">
                    <?php
                    // Prepare and execute SQL query to count all orders
                    $stmt_all = $pdo->prepare("SELECT COUNT(*) AS all_count FROM orders");
                    $stmt_all->execute();
                    $all_count = $stmt_all->fetch(PDO::FETCH_ASSOC)['all_count'];



                    // Count orders with "Processing" status
                    $stmt_processing = $pdo->prepare("SELECT COUNT(*) AS processing_count FROM orders WHERE status = 'Processing'");
                    $stmt_processing->execute();
                    $processing_count = $stmt_processing->fetch(PDO::FETCH_ASSOC)['processing_count'];

                    // Count orders with "Completed" status
                    $stmt_completed = $pdo->prepare("SELECT COUNT(*) AS completed_count FROM orders WHERE status = 'Completed'");
                    $stmt_completed->execute();
                    $completed_count = $stmt_completed->fetch(PDO::FETCH_ASSOC)['completed_count'];
                    ?>
                    <!-- Display counts in the navigation -->
                    <li class="nav-item">
                      <a class="nav-link active bg-transparent pr-2 pl-0 text-primary" href="#">All <span class="badge badge-pill bg-primary text-white ml-2"><?php echo $all_count; ?></span></a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link text-muted px-2" href="#">Processing <span class="badge badge-pill bg-white border text-muted ml-2">
                          <?php echo $processing_count; ?>
                        </span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-muted px-2" href="#">Completed <span class="badge badge-pill bg-white border text-muted ml-2">
                          <?php echo $completed_count; ?>
                        </span></a>
                    </li>
                  </ul>
                </div>

              </div>

              <div class="col-auto col-4">
                <input class="form-control" type="search" name="search" id="searchInput" placeholder="Search Orders">
              </div>


            </div>
            <table class="table border table-hover bg-white datatables" id="dataTable-1">
              <thead>
                <tr role="row">
                  <th>Order Ref</th>
                  <th>Purchase Date</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Total</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                // Prepare the SQL query
                $sql = "SELECT * FROM orders ORDER BY id DESC";

                // Execute the query
                $stmt = $pdo->query($sql);

                // Fetch all rows as an associative array
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Loop through each order and populate the table rows
                foreach ($orders as $order) {
                  echo "<tr>";
                  echo "<td>{$order['order_ref']}</td>";
                  echo "<td>{$order['purchase_date']}</td>";
                  echo "<td>{$order['name']}</td>";
                  echo "<td>{$order['phone']}</td>";
                  echo "<td>{$order['total']}</td>";
                  echo "<td>{$order['payment']}</td>";
                  // Check the status and set the corresponding indicator
                  if ($order['status'] === 'Completed') {
                    echo "<td><span class=\"dot dot-lg bg-success mr-2\"></span> {$order['status']}</td>";
                  } else {
                    echo "<td><span class=\"dot dot-lg bg-warning mr-2\"></span> {$order['status']}</td>";
                  }

                  echo "<td>
                  <div class=\"dropdown\">
                    <button class=\"btn btn-sm dropdown-toggle more-vertical\" type=\"button\" data-toggle=\"dropdown\"
                      aria-haspopup=\"true\" aria-expanded=\"false\">
                      <span class=\"text-muted sr-only\">Action</span>
                    </button>
                    <div class=\"dropdown-menu dropdown-menu-right\">
                      <a class=\"dropdown-item view-items-link\" data-order-id=\"{$order['id']}\" href=\"#\">View Items</a>
                      <a class=\"dropdown-item change-status-link\" data-order-id=\"{$order['id']}\" href=\"#\">Change label</a>
                      <a class=\"dropdown-item\" href=\"#\">Send Receipt</a>
                    </div>
                  </div>
                </td>";

                  echo "</tr>";
                }
                ?>

              </tbody>
            </table>


            <nav aria-label="Table Paging" class="my-3">
              <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item "><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->



      <!-- Change Status Modal -->
      <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="changeStatusModalLabel">Change Order Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="changeStatusForm">
                <div class="form-group">
                  <label for="statusSelect">Select Status:</label>
                  <select class="form-control" id="statusSelect" name="status">
                    <option value="Processing">Processing</option>
                    <option value="Completed">Completed</option>
                  </select>
                </div>
                <input type="hidden" id="orderIdInput" name="order_id">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
            </div>
          </div>
        </div>
      </div>



      <!-- Modal for displaying order items -->
      <div class="modal fade" id="orderItemsModal" tabindex="-1" role="dialog" aria-labelledby="orderItemsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="orderItemsModalLabel">Order Items</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="orderItemsList">
              <!-- Order items will be displayed here -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                  <a href="../administration/" style="text-decoration: none;">
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
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-success">Shop</p>
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
  <script src='../js/jquery.steps.min.js'></script>
  <script src='../js/jquery.validate.min.js'></script>
  <script src='../js/jquery.timepicker.js'></script>
  <script src='../js/dropzone.min.js'></script>
  <script src='../js/uppy.min.js'></script>
  <script src='../js/quill.min.js'></script>
  <script src='../js/jquery.dataTables.min.js'></script>
  <script src='../js/dataTables.bootstrap4.min.js'></script>
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var searchInput = document.getElementById('searchInput');

      searchInput.addEventListener('keyup', function() {
        var searchValue = searchInput.value.trim();

        // Send an AJAX request to fetch search results
        fetchSearchResults(searchValue);
      });
    });

    function fetchSearchResults(searchValue) {
      // Make an AJAX request to fetch search results
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Update the table with the search results
          updateTable(JSON.parse(this.responseText));
        }
      };
      xhr.open("GET", "search-orders.php?search=" + encodeURIComponent(searchValue), true);
      xhr.send();
    }

    function updateTable(data) {
      var tableBody = document.querySelector("#dataTable-1 tbody");
      tableBody.innerHTML = '';

      data.forEach(function(order) {
        var newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${order.order_ref}</td>
            <td>${order.purchase_date}</td>
            <td>${order.name}</td>
            <td>${order.phone}</td>
            <td>${order.total}</td>
            <td>${order.payment}</td>
            <td><span class="dot dot-lg bg-${order.status === 'Completed' ? 'success' : 'warning'} mr-2"></span> ${order.status}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle more-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item view-items-link" data-order-id="${order.id}" href="#">View Items</a>
                        <a class="dropdown-item change-status-link" data-order-id="${order.id}" href="#">Change label</a>
                        <a class="dropdown-item" href="#">Send Receipt</a>
                    </div>
                </div>
            </td>
        `;
        tableBody.appendChild(newRow);
      });
    }
  </script>

  <script>
    // Function to display a popup message
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
      }, 1000);
    }


    // JavaScript code to handle click event of "View Items" link
    $(document).on('click', '.view-items-link', function() {
      var orderId = $(this).data('order-id');

      // AJAX request to fetch order items
      $.ajax({
        url: 'get_order_items.php',
        type: 'POST',
        data: {
          order_id: orderId
        },
        success: function(response) {
          $('#orderItemsList').html(response);
          $('#orderItemsModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error('Error fetching order items:', error);
        }
      });
    });


    // Handle click on "Change status" dropdown item
    $('.change-status-link').click(function() {
      // Get the order ID from the data attribute
      var orderId = $(this).data('order-id');

      // Set the order ID in the modal form
      $('#orderIdInput').val(orderId);

      // Show the modal
      $('#changeStatusModal').modal('show');
    });


    // Handle click on "Save changes" button in the modal
    $('#saveStatusBtn').click(function() {
      // Get the form data
      var formData = $('#changeStatusForm').serialize();

      // Send AJAX request to update the status
      $.ajax({
        url: 'update_status.php', // Replace with your PHP file handling the update
        method: 'POST',
        data: formData,
        success: function(response) {
          // Handle success response
          displayPopup(response, true);
          // console.log(response);
          // Close the modal
          $('#changeStatusModal').modal('hide');
          // Optionally, reload or update the page content
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr, status, error) {
          // Handle error response
          console.error(xhr.responseText);
        }
      });
    });
  </script>
</body>

</html>