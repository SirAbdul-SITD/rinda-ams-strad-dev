<?php require_once('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Categories - Shop | Rinda AMS</title>
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
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <span class="ml-lg-2">Dashboard</span>
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
                <span class="ml-lg-2">Product Category</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.php">
                <span class="ml-lg-2">Product Management</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="orders.php">
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
      </div>
    </nav>

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-11">
            <!-- Small table -->
            <div class="col-md-12 my-4">
              <div class="row align-items-center my-3">
                <div class="col">
                  <h2 class="h4 mb-1">Products Category</h2>
                  <p class="mb-3">Explore our wide range of product categories, each offering a unique selection of
                    items to meet your needs. Whether you're looking for books, school uniforms, stationery, sports
                    equipment, or school bags, we have you covered. Browse through our categories and find the perfect
                    products for your requirements.</p>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModel"><span class="fe fe-plus fe-16 mr-3"></span>New</button>
                </div>
              </div>
              <div class="card shadow">
                <div class="card-body">
                  <div class="toolbar">
                    <form class="form">
                      <div class="form-row">

                        <div class="form-group col-auto">
                          <label for="search" class="sr-only">Search</label>
                          <input type="text" class="form-control" id="search1" value="" placeholder="Search">
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- table -->
                  <?php
                  // Query to select all departments
                  $query = "SELECT * FROM product_categories ORDER BY category_name ASC";
                  $stmt = $pdo->prepare($query);
                  $stmt->execute();
                  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (count($categories) === 0) {
                    echo '<div class="text-center">None Added Yet!</div>';
                  } else {
                  ?>
                    <table class="table table-borderless table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Category</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($categories as $index => $category) : ?>
                          <tr>
                            <td>
                              <?= $index + 1 ?>
                            </td>
                            <td>
                              <p class="mb-0 text-muted">
                                <strong class="mb-0 text-muted category-name" data-category-id="<?= $category['category_id'] ?>">
                                  <?= $category['category_name'] ?>
                                </strong>
                                <input type="hidden" class="category-id" value="<?= $category['category_id'] ?>">
                              </p>
                            </td>

                            <td>
                              <p class="mb-0 text-muted">
                                <strong class="mb-0 text-muted category-description">
                                  <?= $category['category_description'] ?>
                                </strong>
                              </p>
                            </td>
                            <td>
                              <button class="btn btn-sm btn-primary edit-button" type="button">
                                <i class="fe fe-edit"></i> Edit
                              </button>
                              <button class="btn btn-sm btn-danger remove-button" type="button">
                                <i class="fe fe-trash"></i> Remove
                              </button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php } ?>
                </div>
              </div>
            </div> <!-- customized table -->
          </div> <!-- end section -->
        </div> <!-- .col-12 -->
      </div> <!-- .row -->



      <!-- new Department-->
      <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModelLabel">Add category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="newForm">
                <div class="form-group">
                  <label for="category-name text-center" class="col-form-label">Category Title: *</label>
                  <input type="text" class="form-control required" id="category-name" required>
                </div>

                <div class="form-group">
                  <label for="category-description text-center" class="col-form-label">Category Description:</label>
                  <textarea type="text" class="form-control" id="category-description"></textarea>
                </div>


              </form>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn mb-2 btn-primary w-100" id="categorySaveBtn">Add New
                Category</button>
            </div>
          </div>
        </div>
      </div>


      <!-- Edit Department -->
      <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModelLabel">Edit category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="editForm">
                <div class="form-group">
                  <label for="edit-category-name" class="col-form-label">category Name: *</label>
                  <input type="text" class="form-control" id="edit-category-name" required>
                </div>
                <div class="form-group">
                  <label for="edit-category-description" class="col-form-label">Category Description</label>
                  <textarea type="number" class="form-control" id="edit-category-description"></textarea>
                </div>
                <input type="hidden" id="edit-category-id">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary w-100" id="editcategoryBtn">Save changes</button>
            </div>
          </div>
        </div>
      </div>


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
              Are you sure you want to delete category?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger confirm-remove">Remove</button>
            </div>
          </div>
        </div>
      </div>


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
      }, 5000);
    }



    $(document).ready(function() {

      // Event listener for Edit button click
      // Event listener for Edit button click
      $(document).on('click', '.edit-button', function() {
        var categoryRow = $(this).closest('tr');
        var categoryName = categoryRow.find('.category-name').text().trim();
        var description = categoryRow.find('.category-description').text().trim();
        var categoryId = categoryRow.find('.category-id').val();

        // Populate modal fields with current data
        $('#edit-category-name').val(categoryName);
        $('#edit-category-name').val(categoryName);
        $('#edit-category-description').val(description);
        $('#edit-category-id').val(categoryId);

        // Show the edit modal
        $('#editModel').modal('show');
      });




      // Event listener for saving changes
      $('#categorySaveBtn').on('click', function() {
        console.log('clicked');
        var newTitle = $('#category-name').val();
        var newDescription = $('#category-description').val();

        // Perform AJAX request to update category information in the database
        $.ajax({
          url: 'add_category.php',
          type: 'POST',
          data: {
            description: newDescription,
            name: newTitle,
          },
          success: function(response) {
            // Parse the JSON response
            var responseData = JSON.parse(response);
            displayPopup(responseData.message, responseData.success);
            if (responseData.success == true) {
              $('#newModal').modal('hide');
              setTimeout(function() {
                location.reload();
              }, 2000);
            }
          },
          error: function(xhr, status, error) {
            // Display error message
            displayPopup(xhr.responseText, false);
            console.error(xhr.responseText);
          }
        });
      });


      $('#editcategoryBtn').on('click', function() {
        var categoryId = $('#edit-category-id').val();
        var newTitle = $('#edit-category-name').val();
        var description = $('#edit-category-description').val();

        // Perform AJAX request to update category information in the database
        $.ajax({
          url: 'update-category.php',
          type: 'POST',
          data: {
            id: categoryId, // Corrected key name
            name: newTitle,
            description: description, // Added salary field
          },
          success: function(response) {
            // Parse the JSON response

            displayPopup(response.message, response.success);
            if (response.success == true) {
              $('#editModel').modal('hide'); // Corrected modal ID
              setTimeout(function() {
                location.reload();
              }, 2000);
            }
          },
          error: function(xhr, status, error) {
            // Display error message
            displayPopup(xhr.responseText, false);
            console.error(xhr.responseText);
          }
        });
      });


      function removecategory(element) {
        var categoryRow = $(element).closest('tr');
        var categoryName = categoryRow.find('.category-name');
        var editButton = categoryRow.find('.remove-button');
        var id = categoryRow.find('.category-id').val(); // Accessing the value of the category ID

        // Show confirmation modal
        $('#confirmationModal').modal('show');

        // Add click event listener to the confirmation button
        $('.confirm-remove').off('click').on('click', function() {
          // Send AJAX request to remove the category
          $.ajax({
            type: 'POST',
            url: 'remove-category.php',
            data: {
              id: id
            }, // Pass the category ID
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                // Remove the row from the table
                categoryRow.remove();
                displayPopup(response.message, true);
              } else {
                displayPopup(response.message, false);
              }
            },
            error: function(xhr, status, error) {
              displayPopup('Error occurred during request. Contact Admin', false);
            },
          });

          // Hide the modal after action
          $('#confirmationModal').modal('hide');
        });
      };

      // Event listener for Edit/Save button
      $(document).on('click', '.remove-button', function() {
        removecategory(this);
      });

    });
  </script>



</body>

</html>