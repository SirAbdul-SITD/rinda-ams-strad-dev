<?php require_once('../settings.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Rinda AMS | Rinda AMS</title>
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
            <li class="nav-item">
              <a class="nav-link" href="categories.php">
                <span class="ml-lg-2">Product Category</span>
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link text-primary" href="#">
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
      <?php
      // Fetch products from the database
      $stmt = $pdo->query("SELECT p.*, c.category_name FROM products p INNER JOIN product_categories c ON p.category_id = c.category_id ORDER BY 
    CASE 
        WHEN p.quantity_available <= 0 THEN 2  -- Show products with no available quantity last
        ELSE 1  -- Show other products first
    END,
    p.id DESC");
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

      ?>

      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-11">
            <!-- Small table -->
            <div class="col-md-12 my-4">
              <div class="row align-items-center my-3">
                <div class="col">
                  <h2 class="h4 mb-1">Products</h2>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModel">
                    <span class="fe fe-plus fe-16 mr-3"></span>New
                  </button>
                </div>
              </div>
              <div class="card shadow">
                <div class="card-body">
                  <div class="row">
                    <!-- Product Cards -->
                    <?php foreach ($products as $product) : ?>
                      <div class="col-md-4 mb-4">
                        <div class="card h-100">
                          <!-- Category Overlay -->
                          <span class="badge badge-primary position-absolute p-1" style="top: 10px; left: 0;   border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                            <?php echo $product['category_name']; ?>
                          </span>
                          <img src="https://grithallacademy.com.ng/uploads/shop/<?php echo $product['image_url']; ?>" class="card-img-top h-60" alt="Product Image">
                          <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                              <?php echo $product['name']; ?>
                            </h5>
                            <p class="card-text">
                              <?php echo $product['description']; ?>
                            </p>
                            <div class="row">
                              <p class="col-6 h5 mb-2 card-text">
                                <?php echo '$' . $product['price']; ?>
                              </p>
                              <p class="col-6  mb-2 card-text">
                                <?php echo $product['quantity_available'] . ' In Stock'; ?>
                              </p>
                            </div>
                            <button class="btn btn-primary mt-auto w-100 edit-product-btn" data-product-id="<?php echo $product['id']; ?>" data-product-name="<?php echo htmlspecialchars($product['name']); ?>" data-product-description="<?php echo htmlspecialchars($product['description']); ?>" data-product-category-id="<?php echo $product['category_id']; ?>" data-category-name="<?php echo $product['category_name']; ?>" data-available-quantity="<?php echo $product['quantity_available']; ?>" data-product-price="<?php echo $product['price']; ?>" data-product-image="<?php echo $product['image_url']; ?>">
                              Edit Product
                            </button>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>

                    <!-- Repeat Product Cards for each product -->
                  </div>
                </div>
              </div>
            </div> <!-- customized table -->
          </div> <!-- end section -->
        </div> <!-- .col-12 -->
      </div>



      <!-- Add Product -->
      <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModelLabel">Add New Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="addProductForm">
                <div class="form-group">
                  <label for="add-product-name" class="col-form-label">Product Name: *</label>
                  <input type="text" class="form-control" id="add-product-name" name="add-product-name" required>
                </div>
                <div class="form-group">
                  <label for="add-product-description" class="col-form-label">Product Description:</label>
                  <textarea class="form-control" id="add-product-description" name="add-product-description"></textarea>
                </div>
                <div class="form-group">
                  <label for="add-product-price" class="col-form-label">Price: *</label>
                  <input type="number" class="form-control" id="add-product-price" name="add-product-price" required>
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="add-product-category" class="col-form-label">Select category: *</label>
                    <select id="add-product-category" class="form-control select2 required" required name="add-product-category" required>
                      <?php
                      $query = "SELECT * FROM product_categories ORDER BY `product_categories`.`category_name` ASC";
                      $stmt = $pdo->prepare($query);
                      $stmt->execute();
                      $product_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      if (count($product_categories) === 0) {
                        echo '<option value="" selected disabled>None added Yet!</option>';
                      } else {
                        echo "<option value='' id='add-product-category' selected>Change Category</option>";
                        foreach ($product_categories as $category) :
                          $x = $category['category_id'];
                          $y = $category['category_name'];
                          echo "<option value=$x>$y</option>";
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-6">
                    <label for="add-product-quantity" class="col-form-label">Stock:</label>
                    <input type="number" class="form-control" id="add-product-quantity" name="add-product-quantity" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="add-product-image" class="col-form-label">Product Image:</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="add-product-image" name="image">
                    <label class="custom-file-label" for="add-product-image">Choose file</label>
                  </div>
                  <img src="" class="img-thumbnail mt-2" id="add-product-thumbnail" style="display: none;" alt="Product Image">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary w-100" id="addProductBtn">Add Product</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        // JavaScript code to update product image
        document.getElementById('add-product-image').addEventListener('change', function() {
          var fileInput = this;
          var imgThumbnail = document.getElementById('add-product-thumbnail');
          if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              imgThumbnail.src = e.target.result;
              imgThumbnail.style.display = 'block'; // Display the thumbnail
            };
            reader.readAsDataURL(fileInput.files[0]);
          }
        });
      </script>



      <!-- Edit Product -->
      <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModelLabel">Edit Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="editProductForm">
                <div class="form-group">
                  <label for="edit-product-name" class="col-form-label">Product Name: *</label>
                  <input type="text" class="form-control" id="edit-product-name" name="edit-product-name" required>
                </div>
                <div class="form-group">
                  <label for="edit-product-description" class="col-form-label">Product Description:</label>
                  <textarea class="form-control" id="edit-product-description" name="edit-product-description"></textarea>
                </div>
                <div class="form-group">
                  <label for="edit-product-price" class="col-form-label">Price: *</label>
                  <input type="number" class="form-control" id="edit-product-price" name="edit-product-price" required>
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="edit-categories" class="col-form-label">Select category: *</label>
                    <select id="edit-categories" class="form-control select2 required" required name="edit-category" required>
                      <?php
                      $query = "SELECT * FROM product_categories ORDER BY `product_categories`.`category_name` ASC";
                      $stmt = $pdo->prepare($query);
                      $stmt->execute();
                      $product_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      if (count($product_categories) === 0) {
                        echo '<option value="" selected disabled>None added Yet!</option>';
                      } else {
                        echo "<option value='' id='edit-product-category' selected>Change Category</option>";
                        foreach ($product_categories as $category) :
                          $x = $category['category_id'];
                          $y = $category['category_name'];
                          echo "<option value=$x>$y</option>";
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-6">
                    <label for="edit-product-quantity" class="col-form-label">Stock:</label>
                    <input type="number" class="form-control" id="edit-product-quantity" name="edit-product-quantity" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit-product-image" class="col-form-label">Product Image:</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="edit-product-image" name="image">
                    <label class="custom-file-label" for="edit-product-image">Choose file</label>
                  </div>
                  <img src="" class="img-thumbnail mt-2" id="edit-product-thumbnail" alt="Product Image">
                </div>
                <input type="hidden" id="edit-product-id" name="product_id">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary w-100" id="editProductBtn">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        // JavaScript code to update product image
        document.getElementById('edit-product-image').addEventListener('change', function() {
          var fileInput = this;
          var imgThumbnail = document.getElementById('edit-product-thumbnail');
          if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              imgThumbnail.src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
          }
        });
      </script>





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
              Are you sure you want to delete designation?
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




    document.getElementById('addProductBtn').addEventListener('click', function() {
      var form = document.getElementById('addProductForm');
      var formData = new FormData(form);

      // AJAX request to send form data
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'add_product.php', true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Success
          console.log(xhr.responseText);
          // Optionally, close the modal or display a success message
          $('#addModel').modal('hide');
          // Refresh the product list or perform any other necessary action
        } else {
          // Error
          console.error('Error occurred while adding product');
        }
      };
      xhr.onerror = function() {
        console.error('AJAX request failed');
      };
      xhr.send(formData);
    });






    $(document).ready(function() {
      $('.edit-product-btn').click(function() {
        // Get product details from data attributes
        var productId = $(this).data('product-id');
        var productName = $(this).data('product-name');
        var productDescription = $(this).data('product-description');
        var productPrice = $(this).data('product-price');
        var productCategory = $(this).data('product-category-id');
        var productQuantity = $(this).data('available-quantity');
        var productImage = $(this).data('product-image');

        // Set the modal input values with the product details
        $('#edit-product-id').val(productId);
        $('#edit-product-name').val(productName);
        $('#edit-product-description').val(productDescription);
        $('#edit-product-price').val(productPrice);
        $('#edit-product-category').val(productCategory);
        $('#edit-product-quantity').val(productQuantity);
        $('#edit-product-thumbnail').attr('src', 'https://grithallacademy.com.ng/uploads/shop/' + productImage);

        // Show the edit modal
        $('#editModel').modal('show');
      });
    });


    document.getElementById('editProductBtn').addEventListener('click', function() {
      var form = document.getElementById('editProductForm');
      var formData = new FormData(form);

      // AJAX request to send form data
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'update_product.php', true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Success
          displayPopup(xhr.responseText, true);
          // Optionally, close the modal or display a success message
          $('#editModel').modal('hide');
          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          // Error
          displayPopup('Error occurred while updating product', true);
        }
      };
      xhr.onerror = function() {
        console.error('AJAX request failed');
      };
      xhr.send(formData);
    });
  </script>




</body>

</html>