<?php require '../settings.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Products Management - Shop | Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
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
            <div class="text-right" style="margin-right: 10%;">
              <p style="padding: 0%; margin: 0%;">sirabdul@strad.africa</p>
              <strong>Super Admin</strong>
            </div>
            <hr width="80%">
            <a class="dropdown-item" href="#">Profile</a>
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activities</a>
          </div>
        </li>
      </ul>
    </nav>

    <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
      <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
      </a>
      <nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow">
        <div class="container-fluid">
          <a class="navbar-brand mx-lg-1 mr-0" href="./index.html">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
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
                <a class="nav-link text-primary" href="#">
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
                  <img src="../assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <div class=" col-12 text-left">
                  <p style="padding: 0%; margin: 0%;"><?= $full_name; ?></p>
                  <strong><?= $account_type; ?></strong>
                </div>
                <hr width="80%">
                <a class="dropdown-item" href="../settings/profile.php">Profile</a>
                <a class="dropdown-item" href="../settings">Settings</a>
                <a class="dropdown-item" href="../logout.php">Log out</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

    </aside>
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
          <div class="col-12">
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
                          <img src="uploads/<?php echo $product['image_url']; ?>" class="card-img-top h-60" alt="Product Image">
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
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Dashboard</p>
                </div>
                <div class="col-6 text-center">
                  <a href="../academics/" target="_blank" style="text-decoration: none;">
                    <div class="squircle bg-secondary justify-content-center">
                      <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                    </div>
                    <p class="text-white">Academics</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                  </div>
                  <p>E-Learning</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Messages</p>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-book fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Library</p>
                </div>
                <div class="col-6 text-center">
                  <a href="#" style="text-decoration: none;" class="text-success">
                    <div class="squircle bg-success justify-content-center">
                      <i class="fe fe-users fe-32 align-self-center text-auto"></i>
                    </div>
                    <p>HR</p>
                  </a>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Assessments</p>
                </div>
                <div class="col-6 text-center">
                  <div class="squircle bg-secondary justify-content-center">
                    <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                  </div>
                  <p>Settings</p>
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
  <script src='../js/jquery.dataTables.min.js'></script>
  <script src='../js/dataTables.bootstrap4.min.js'></script>
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
        $('#edit-product-thumbnail').attr('src', 'uploads/' + productImage);

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