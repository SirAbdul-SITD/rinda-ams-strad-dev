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
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="../js/apexcharts.min.js"></script>
  <script src="../js/apexcharts.custom.js"></script>
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
              <a class="dropdown-item" href="../profile">Profile</a>
              <a class="dropdown-item" href="../profile/settings.php">Settings</a>
              <a class="dropdown-item" href="../logout.php">Log out</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row align-items-center mb-2">
              <div class="col">
                <h2 class="h5 page-title">Welcome!</h2>
              </div>
              <div class="col-auto">
                <form class="form-inline">
                  <div class="form-group d-none d-lg-inline">
                    <label for="reportrange" class="sr-only">Date Ranges</label>
                    <div id="reportrange" class="px-2 py-2 text-muted">
                      <span class="small"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="card shadow my-4">
              <div class="card-body">
                <div class="row align-items-center my-4">
                  <?php


                  // Get all time sales (total sum of total in orders table)
                  $sqlAllTimeSales = "SELECT SUM(total) AS all_time_sales FROM orders";
                  $stmtAllTimeSales = $pdo->query($sqlAllTimeSales);
                  $allTimeSales = $stmtAllTimeSales->fetch(PDO::FETCH_ASSOC);

                  // Get sales for the current month
                  $currentMonth = date('Y-m');
                  $sqlCurrentMonthSales = "SELECT SUM(total) AS current_month_sales FROM orders WHERE DATE_FORMAT(order_date, '%Y-%m') = :current_month";
                  $stmtCurrentMonthSales = $pdo->prepare($sqlCurrentMonthSales);
                  $stmtCurrentMonthSales->bindParam(':current_month', $currentMonth);
                  $stmtCurrentMonthSales->execute();
                  $currentMonthSales = $stmtCurrentMonthSales->fetch(PDO::FETCH_ASSOC);

                  // Get the number of completed orders
                  $sqlCompletedOrders = "SELECT COUNT(*) AS completed_orders FROM orders WHERE status = 'Completed'";
                  $stmtCompletedOrders = $pdo->query($sqlCompletedOrders);
                  $completedOrders = $stmtCompletedOrders->fetch(PDO::FETCH_ASSOC);
                  ?>

                  <div class="col-md-4">
                    <div class="mx-4">
                      <strong class="mb-0 text-uppercase text-muted">All time Sales</strong><br />
                      <h3>
                        <?php echo '₦' . number_format($allTimeSales['all_time_sales'], 2); ?>
                      </h3>
                      <p class="text-muted">This is the sales amount since the beginning of sales on this platform</p>
                    </div>
                    <div class="row align-items-center">
                      <div class="col-6">
                        <div class="p-4">
                          <p class="small text-uppercase text-muted mb-0">Sales</p>
                          <span class="h4 mb-0">
                            <?php echo '₦' . number_format($currentMonthSales['current_month_sales'], 2); ?>
                          </span>
                          <p class="small mb-0"><span class="text-muted ml-1">
                              <?= $currentMonth ?>
                            </span></p>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="p-4">
                          <p class="small text-uppercase text-muted mb-0">Orders</p>
                          <span class="h4 mb-0">
                            <?php echo $completedOrders['completed_orders']; ?> Completed
                          </span>
                          <p class="small mb-0"><span class="text-muted ml-1">
                              <?= $currentMonth ?>
                            </span></p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="mr-4">

                      <div id="columnCharts"></div>

                    </div>
                    <?php
                    // Your database connection and other configurations here

                    // Fetch total sales amount and number of orders for each month
                    $sql = "SELECT 
            DATE_FORMAT(, '%Y-%m') AS order_month, 
            SUM(total) AS total_sales,
            COUNT(*) AS order_count 
        FROM orders 
        GROUP BY DATE_FORMAT(order_date, '%Y-%m')";
                    $stmt = $pdo->query($sql);
                    $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Initialize arrays to store chart data
                    $chartLabels = [];
                    $totalSales = [];
                    $orderCount = [];

                    // Loop through fetched data and populate arrays
                    foreach ($chartData as $data) {
                      $chartLabels[] = $data['order_month'];
                      $totalSales[] = $data['total_sales'];
                      $orderCount[] = $data['order_count'];
                    }

                    // Convert PHP arrays to JSON for use in JavaScript
                    $chartLabelsJSON = json_encode($chartLabels);
                    $totalSalesJSON = json_encode($totalSales);
                    $orderCountJSON = json_encode($orderCount);
                    ?>

                    <script>
                      // Initialize ApexCharts with dynamic data
                      var columnChart;
                      var columnChartoptions = {
                        series: [{
                            name: "Sales",
                            data: <?php echo $totalSalesJSON; ?>
                          },
                          {
                            name: "Orders",
                            data: <?php echo $orderCountJSON; ?>
                          }
                        ],
                        chart: {
                          type: "bar",
                          height: 350,
                          stacked: false,
                          columnWidth: "70%",
                          zoom: {
                            enabled: true
                          },
                          toolbar: {
                            show: false
                          },
                          background: "transparent"
                        },
                        xaxis: {
                          categories: <?php echo $chartLabelsJSON; ?> // Dynamic categories (chart labels)
                        },
                        yaxis: {
                          labels: {
                            formatter: function(val) {
                              return val.toFixed(2); // Format y-axis labels
                            }
                          }
                        },
                        plotOptions: {
                          bar: {
                            horizontal: false,
                            columnWidth: "40%",
                            radius: 50,
                            enableShades: false,
                            endingShape: "rounded"
                          }
                        },
                        colors: [
                          "#3B93A5",
                          "#F7B844"
                        ] // Custom colors for the series
                      };

                      // Render the chart
                      var columnChartCtn = document.querySelector("#columnCharts");
                      if (columnChartCtn) {
                        columnChart = new ApexCharts(columnChartCtn, columnChartoptions);
                        columnChart.render();
                      }
                    </script>


                  </div> <!-- .col-md-8 -->
                </div> <!-- end section -->
              </div> <!-- .card-body -->
            </div> <!-- .card -->
            <div class="row">
              <div class="col-md-6">
                <div class="card shadow eq-card mb-4">
                  <?php

                  // Function to execute SQL query and fetch single value
                  function fetchSingleValue($pdo, $sql)
                  {
                    $stmt = $pdo->query($sql);
                    return $stmt->fetchColumn();
                  }

                  // Function to calculate percentage change
                  function calculatePercentageChange($current, $previous)
                  {
                    if ($previous != 0) {
                      $change = $current - $previous;
                      $percentageChange = ($change / abs($previous)) * 100;
                      return number_format($percentageChange, 2);
                    } else {
                      return "100";
                    }
                  }

                  // Function to determine arrow icon class based on change
                  function getArrowIconClass($change)
                  {
                    return $change >= 0 ? "fe fe-arrow-up  text-success" : "fe fe-arrow-down  text-warning";
                  }

                  // Get today's total orders count
                  $todayOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE DATE(order_date) = CURDATE()");

                  // Get yesterday's total orders count
                  $yesterdayOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE DATE(order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");

                  // Get this week's total orders count
                  $thisWeekOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE YEARWEEK(order_date) = YEARWEEK(CURDATE())");

                  // Get last week's total orders count
                  $lastWeekOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE YEARWEEK(order_date) = YEARWEEK(CURDATE()) - 1");

                  // Get this month's total orders count
                  $thisMonthOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())");

                  // Get last month's total orders count
                  $lastMonthOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) - 1 AND YEAR(order_date) = YEAR(CURDATE())");

                  // Get total orders count from two months ago
                  $twoMonthsAgoOrdersCount = fetchSingleValue($pdo, "SELECT COUNT(*) FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) - 2 AND YEAR(order_date) = YEAR(CURDATE())");


                  // Calculate percentage changes
                  $todayYesterdayChange = calculatePercentageChange($todayOrdersCount, $yesterdayOrdersCount);
                  $thisWeekLastWeekChange = calculatePercentageChange($thisWeekOrdersCount, $lastWeekOrdersCount);
                  $thisMonthLastMonthChange = calculatePercentageChange($thisMonthOrdersCount, $lastMonthOrdersCount);
                  // Calculate percentage changes
                  $thisMonthLastTwoMonthChange = calculatePercentageChange($lastMonthOrdersCount, $twoMonthsAgoOrdersCount);
                  $lastMonthTwoMonthsAgoChange = calculatePercentageChange($lastMonthOrdersCount, $twoMonthsAgoOrdersCount);

                  // Output the summarized statistics
                  echo '<div class="card-body">
                    <div class="card-title">
                        <strong>Summarize</strong>
                        <a class="float-right small text-muted" href="oders.php">View all</a>
                    </div>
                    <div class="row mt-b">
                        <div class="col-6 text-center mb-3 border-right">
                            <p class="text-muted mb-1">Today</p>
                            <h6 class="mb-1">' . $todayOrdersCount . '</h6>
                            <p class="text-muted mb-2">' . $todayYesterdayChange . '% <span class="' . getArrowIconClass($todayYesterdayChange) . ' fe-12"> From Yesterday</span></p>
                        </div>
                        <div class="col-6 text-center mb-3">
                            <p class="text-muted mb-1">This Week</p>
                            <h6 class="mb-1">' . $thisWeekOrdersCount . '</h6>
                            <p class="text-muted">' . $thisWeekLastWeekChange . '% <span class="' . getArrowIconClass($thisWeekLastWeekChange) . ' fe-12"> From Last Week</span></p>
                        </div>
                        <div class="col-6 text-center border-right">
                            <p class="text-muted mb-1">This Month</p>
                            <h6 class="mb-1">' . $thisMonthOrdersCount . '</h6>
                            <p class="text-muted mb-2">' . $thisMonthLastMonthChange . '% <span class="' . getArrowIconClass($thisMonthLastMonthChange) . ' fe-12"> From Last Month</span></p>
                        </div>
                        <div class="col-6 text-center">
                            <p class="text-muted mb-1">Last Month</p>
                            <h6 class="mb-1">' . $lastMonthOrdersCount . '</h6>
                            <p class="text-muted mb-2">' . $thisMonthLastTwoMonthChange . '% <span class="' . getArrowIconClass($lastMonthTwoMonthsAgoChange) . ' fe-12"> From Last Upper Month</span></p>
                        
                        </div>
                    </div>
                    ';
                  // Example SQL query to retrieve data for the chart
                  $sql = "SELECT 
MONTH(order_date) AS order_month, 
SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_count, 
SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) AS processing_count 
FROM orders 
WHERE YEAR(order_date) = YEAR(CURRENT_DATE)
GROUP BY MONTH(order_date)";
                  $stmt = $pdo->query($sql);
                  $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // Initialize arrays to store labels and data
                  $chartLabels = [];
                  $completedValues = [];
                  $processingValues = [];

                  // Loop through the fetched data and populate the arrays
                  foreach ($chartData as $data) {
                    // Get the month name from the month number
                    $monthName = date('F', mktime(0, 0, 0, $data['order_month'], 1));
                    $chartLabels[] = $monthName;
                    $completedValues[] = $data['completed_count'];
                    $processingValues[] = $data['processing_count'];
                  }


                  ?>
                  <div class="chart-widget" style="border-radius: 10px;">
                    <div id="orderChart" style="width: 100%;"></div>
                  </div>




                  <script>
                    // Parse PHP arrays into JavaScript arrays
                    var chartLabels = <?php echo json_encode($chartLabels); ?>;
                    var completedValues = <?php echo json_encode($completedValues); ?>;
                    var processingValues = <?php echo json_encode($processingValues); ?>;

                    // Create a new ApexCharts instance
                    var options = {
                      series: [{
                        name: 'Completed',
                        data: completedValues
                      }, {
                        name: 'Pending',
                        data: processingValues
                      }],
                      chart: {
                        type: 'bar',
                        height: 200
                      },
                      plotOptions: {
                        bar: {
                          horizontal: false,
                          columnWidth: '35%',
                          endingShape: 'rounded'
                        },
                      },
                      dataLabels: {
                        enabled: false
                      },
                      toolbar: {
                        show: false
                      },
                      stroke: {

                        show: true,
                        width: 2,
                        colors: ['transparent']
                      },
                      xaxis: {
                        categories: chartLabels,
                      },
                      yaxis: {
                        title: {
                          text: '(orders)'
                        }
                      },
                      fill: {
                        opacity: 1
                      },
                      tooltip: {
                        y: {
                          formatter: function(val) {
                            if (val > 1) {
                              return val + " orders"
                            } else {
                              return val + " order"
                            }
                          }
                        }
                      }
                    };

                    var chart = new ApexCharts(document.querySelector("#orderChart"), options);

                    // Render the chart
                    chart.render();
                  </script>
                </div>


              </div> <!-- .card -->
            </div> <!-- .col -->
            <div class="col-md-6">
              <div class="card shadow eq-card mb-4">
                <div class="card-body">
                  <div class="card-title">
                    <strong>Most Ordered Products</strong>
                    <a class="float-right small text-muted" href="orders.php">View all</a>
                  </div>

                  <?php
                  // Example SQL query to retrieve data for the chart
                  $sql = "SELECT 
            p.name AS product_name,
            COUNT(oi.product_id) AS order_count
        FROM 
            order_items oi
        INNER JOIN 
            products p ON oi.product_id = p.id
        INNER JOIN 
            orders o ON oi.order_id = o.id
        WHERE 
            o.status IN ('completed', 'processing')
            AND YEAR(o.order_date) = YEAR(CURRENT_DATE)
        GROUP BY 
            p.id";

                  $stmt = $pdo->query($sql);
                  $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // Initialize array to store chart data
                  $chartSeries = [];

                  // Loop through the fetched data and populate the series array
                  foreach ($chartData as $data) {
                    $chartSeries[] = [
                      'x' => $data['product_name'],
                      'y' => $data['order_count']
                    ];
                  }

                  // Function to generate random colors
                  function generateRandomColor()
                  {
                    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                  }

                  // Initialize array to store colors
                  $chartColors = [];

                  // Generate random colors for each data point
                  foreach ($chartData as $data) {
                    $chartColors[] = generateRandomColor();
                  }

                  ?>


                  <div class="chart-widget" style="border-radius: 10px;">
                    <div id="orderProductsChart" style="width: 100%;"></div>
                  </div>
                  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                  <script>
                    // Parse PHP arrays into JavaScript arrays
                    var chartSeries = <?php echo json_encode($chartSeries); ?>;
                    var chartColors = <?php echo json_encode($chartColors); ?>;

                    // Create data object with x and y values for each product
                    var chartData = chartSeries.map(function(item) {
                      return {
                        x: item.x,
                        y: item.y
                      };
                    });

                    var options = {
                      series: [{
                        data: chartData
                      }],
                      legend: {
                        show: false
                      },
                      chart: {
                        height: 350,
                        type: 'treemap'
                      },

                      colors: chartColors,
                      plotOptions: {
                        treemap: {
                          distributed: true,
                          enableShades: false
                        }
                      }
                    };

                    var chart = new ApexCharts(document.querySelector("#orderProductsChart"), options);
                    chart.render();
                  </script>

                </div> <!-- .card-body -->
              </div> <!-- .card -->
            </div> <!-- .col-md-4 -->
            <!-- Map -->

          </div> <!-- / .row -->
          <div class="row">
            <!-- Recent orders -->
            <div class="col-md-12">
              <div class="card shadow eq-card">
                <div class="card-header">
                  <strong class="card-title">Recent Orders</strong>
                  <a class="float-right small text-muted" href="orders.php">View all</a>
                </div>
                <div class="card-body">
                  <table class="table table-hover table-borderless table-striped mt-n3 mb-n1">
                    <thead>
                      <tr>
                        <th>Order Ref</th>
                        <th>Purchase Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Total</th>

                        <th>Status</th>

                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      // Prepare the SQL query
                      $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 7";

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

                        // Check the status and set the corresponding indicator
                        if ($order['status'] === 'Completed') {
                          echo "<td><span class=\"dot dot-lg bg-success mr-2\"></span> {$order['status']}</td>";
                        } else {
                          echo "<td><span class=\"dot dot-lg bg-warning mr-2\"></span> {$order['status']}</td>";
                        }



                        echo "</tr>";
                      }
                      ?>

                    </tbody>
                  </table>

                </div> <!-- .card-body -->
              </div> <!-- .card -->
            </div> <!-- / .col-md-8 -->

          </div> <!-- end section -->
        </div>
      </div> <!-- .row -->
  </div> <!-- .container-fluid -->
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
                <p class="text-primary">Dashboard</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="../academics/" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-primary">Academics</p>
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
              <a href="../messages" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-primary">Messages</p>
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
</body>

</html>