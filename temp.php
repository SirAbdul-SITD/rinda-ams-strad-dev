<?php require_once('settings.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subject_id'])) {
    $_SESSION['class_id'] = intval($_POST['class_id']); //store session
    $_SESSION['subject_id'] = intval($_POST['subject_id']); //store session
    $_SESSION['subject_title'] = $_POST['subject_title']; //store session
    $_SESSION['class_title'] = $_POST['class_title']; //store session
    $_SESSION['lesson_id'] = intval($_POST['lesson_id']); //store session
    $_SESSION['lesson_title'] = $_POST['lesson_title']; //store session
    $_SESSION['content'] = $_POST['content']; //store session
    $_SESSION['video'] = $_POST['video']; //store session
    $_SESSION['thumbnail'] = $_POST['thumbnail']; //store session
    $_SESSION['button_color'] = $_POST['button_color'];
    header("Location: lesson.php"); //redirect to avoid form resubmission
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
$btnColor = $_SESSION['button_color'] ?? '#6c757d';
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Lesson - Nuture 360&deg; | Learning made simple</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css" />
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css" />
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css" />
    <!-- Layout style -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

    <!-- ...existing code... -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <style>
        .menu-options {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }


        table th,
        table td {
            text-align: left !important;
        }

        #pdfViewer {
            width: 100%;
            overflow: auto;
            border: none;
        }

        .pdf-page {
            margin-bottom: 10px;
            width: 100%;
        }

        .menu-options .menu-item {
            cursor: pointer;
            padding: 10px 15px;
            font-size: 16px;
            color: #333;
            transition: border-left 0.3s, color 0.3s;
            border-left: 4px solid transparent;
            /* Default transparent border */
        }

        .menu-options .menu-item:hover {
            background-color: #f8f9fa;
            /* Light gray on hover */
            color: #000;
            /* Black text on hover */
        }

        .menu-options .menu-item.active {
            border-left: 4px solid var(--active-color);
            color: var(--active-color);
            font-weight: bold;
        }

        .menu-options hr {
            margin: 5px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        @media (max-width: 768px) {
            .desktop {
                display: none;

            }
        }

        @media (min-width: 768px) {
            .mobile {
                display: none;
            }
        }
    </style>
</head>

<body class="header-fixed">
    <!-- partial:../../partials/_header.html -->
    <nav class="t-header">
        <!-- <div class="t-header-brand-wrapper">

    </div> -->
        <div class="t-header-content-wrapper">
            <div class="t-header-content">

                <form action="#" class="t-header-search-box">
                    <div class="input-group h-2">
                        <input type="text" class="form-control h-4" id="inlineFormInputGroup" placeholder="Search"
                            autocomplete="off" />
                        <button class="btn btn-success" type="submit" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                            <i class="mdi mdi-arrow-right-thick"></i>
                        </button>
                    </div>
                </form>
                <ul class="nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="btn action-btn btn-success btn-rounded component-flan" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                                <i class="mdi mdi-bell-outline mdi-1x text-white"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown dropdown-menu-right"
                            aria-labelledby="notificationDropdown">
                            <div class="dropdown-header">
                                <h6 class="dropdown-title">Notifications</h6>
                                <p class="dropdown-title-text">
                                    You have 4 unread notification
                                </p>
                            </div>
                            <div class="dropdown-body">
                                <div class="dropdown-list">
                                    <div class="icon-wrapper rounded-circle bg-inverse-success text-success">
                                        <i class="mdi mdi-cloud-upload"></i>
                                    </div>
                                    <div class="content-wrapper">
                                        <small class="name">Upload Completed</small>
                                        <small class="content-text">3 Files uploaded successfully</small>
                                    </div>
                                </div>
                                <div class="dropdown-list">
                                    <div class="icon-wrapper rounded-circle bg-inverse-success text-success">
                                        <i class="mdi mdi-cloud-upload"></i>
                                    </div>
                                    <div class="content-wrapper">
                                        <small class="name">Upload Completed</small>
                                        <small class="content-text">3 Files uploded successfully</small>
                                    </div>
                                </div>
                                <div class="dropdown-list">
                                    <div class="icon-wrapper rounded-circle bg-inverse-warning text-warning">
                                        <i class="mdi mdi-security"></i>
                                    </div>
                                    <div class="content-wrapper">
                                        <small class="name">Authentication Required</small>
                                        <small class="content-text">Please verify your password to continue using cloud
                                            services</small>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <a href="#">View All</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- partial -->
    <?php
    $subject_id = isset($_SESSION['subject_id']) ? $_SESSION['subject_id'] : 0;
    $class_id = isset($_SESSION['class_id']) ? $_SESSION['class_id'] : 0;
    $subject_title = isset($_SESSION['subject_title']) ? $_SESSION['subject_title'] : '';
    $class_title = isset($_SESSION['class_title']) ? $_SESSION['class_title'] : '';
    $lesson_id = isset($_SESSION['lesson_id']) ? $_SESSION['lesson_id'] : 0;
    $lesson_title = isset($_SESSION['lesson_title']) ? $_SESSION['lesson_title'] : '';

    $sql = "SELECT * FROM lessons WHERE lesson_id = $lesson_id ORDER BY lesson_id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        die('No data found for the given lesson ID.');
    }
    ?>

    <div class="mobile col-12 pt-5">

        <div class="d-flex w-100 justify-content-between mt-5">
            <div class="col-md-6 d-flex justify-content-center">
                <a href="index.php" class="btn btn-success btn-md w-100 mb-3" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                    <i class="mdi mdi-undo-variant"></i> Go to subjects
                </a>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <a href="lessons.php" class="btn btn-success btn-md w-100 mb-3" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                    <i class="mdi mdi-undo-variant"></i> Go to lessons
                </a>
            </div>
        </div>
        <div class=" text-center">
            <h5><?= $lesson_title ?></h5>
            <p class="text-gray"><?= $subject_title ?>, <?= $class_title ?></p>
        </div>
        <hr>
        <span class="text-center justify-content-center">
            <p>Click Below To Select ðŸ‘‡</p>
            <select id="mobileMenu" class="text-center custom-select">
                <option value="mobile-overview">Overview</option>
                <option value="mobile-video">Video</option>
                <option value="mobile-content">Content</option>
                <option value="mobile-vocabulary">Vocabulary</option>
                <option value="mobile-assessments">Assessments</option>
            </select>
        </span>


        <!-- Mobile option screens -->
        <div class="mobile-option-screen col-12 mt-4 pt-3 d-block d-md-none">
            <!-- Overview -->
            <div id="mobile-overview" class="mobile-content-section">
                <h3 class="mb-2">Overview</h3>
                <h2>
                    <strong>
                        <?= htmlspecialchars($lesson_title) ?>
                        <?= htmlspecialchars($row['lesson_number']) ?>
                        in <?= htmlspecialchars($subject_title) ?> <?= htmlspecialchars($class_title) ?>.
                    </strong>
                </h2>
                <hr>
                <h4>About this lesson</h4>
                <p style="font-size: large;"><?= htmlspecialchars($row['description']); ?></p>
            </div>

            <!-- Video -->
            <div id="mobile-video" class="mobile-content-section" style="display: none;">
                <?php $videoId = getYouTubeVideoId($row['video']); ?>
                <iframe width="100%" height="240" src="https://www.youtube.com/watch?v=EplgbX-ALLM?controls=0"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen style="border-radius: 12px;"></iframe>
            </div>

            <!-- PDF Content -->
            <div id="mobile-content" class="mobile-content-section" style="display: none;">

                <div id="pdfViewerMobile" class="w-100"></div>
                <script>
                    // PDF.js for mobile container
                    var urlMobile = 'docs/<?= $lesson_id ?>.pdf';
                    var pdfjsLibMobile = window['pdfjs-dist/build/pdf'];
                    pdfjsLibMobile.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';
                    pdfjsLibMobile.getDocument(urlMobile).promise.then(function (pdf) {
                        var viewer = document.getElementById('pdfViewerMobile');
                        for (var i = 1; i <= pdf.numPages; i++) {
                            pdf.getPage(i).then(function (page) {
                                var vp = page.getViewport({ scale: 0.60 });
                                var canvas = document.createElement('canvas');
                                canvas.height = vp.height; canvas.width = vp.width;
                                page.render({ canvasContext: canvas.getContext('2d'), viewport: vp });
                                viewer.appendChild(canvas);
                            });
                        }
                    });
                    document.getElementById('fullscreenBtnMobile').addEventListener('click', function () {
                        var el = document.getElementById('pdfViewerMobile');
                        (el.requestFullscreen || el.webkitRequestFullscreen || el.mozRequestFullScreen || el.msRequestFullscreen).call(el);
                    });
                </script>
            </div>

            <!-- Vocabulary -->
            <div id="mobile-vocabulary" class="mobile-content-section" style="display: none;">
                <h4>Vocabulary</h4>
                <p><?= htmlspecialchars($row['vocabolary']); ?></p>
            </div>

            <!-- Assessments -->
            <div id="mobile-assessments" class="mobile-content-section" style="display: none;">
                <?php
                if (isset($_SESSION["class_id"])) {

                    $class_title = isset($_SESSION['class_title']) ? $_SESSION['class_title'] : '';
                    $class_id = isset($_SESSION['class_id']) ? $_SESSION['class_id'] : 0;
                    $lesson_id = isset($_SESSION['lesson_id']) ? $_SESSION['lesson_id'] : 0;

                    $types = [
                        1 => 'Basic Assessments',
                        2 => 'Intermediate Assessments',
                        3 => 'Advanced Assessments',
                        4 => 'General Assessments'
                    ];

                    foreach ($types as $type_id => $type_name) {
                        $sql = "SELECT a.assessment_id, a.timespan, a.status
                      FROM assessments a
                      WHERE a.lesson_id = $lesson_id AND a.type = $type_id AND a.student_id = $student_id ORDER BY a.timespan DESC";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        ?>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="grid">
                                    <span class="grid-header row m-0">
                                        <div class="d-flex w-100 justify-content-between ">
                                            <span><?= $type_name ?></span>
                                            <form action="student-assessments.php" method="POST">
                                                <input type="hidden" name="lesson_id" value="<?= $lesson_id; ?>">
                                                <input type="hidden" name="type_name" value="<?= $type_name; ?>">
                                                <input type="hidden" name="type_id" value="<?= $type_id; ?>">
                                                <button type="submit" class="btn btn-sm btn-success social-btn pr-3 view-btn"
                                                    style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                                                    assessment
                                                    <i class="mdi mdi-pen m-0 pl-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </span>
                                    <div class="item-wrapper">
                                        <div class="table-responsive text-left">
                                            <?php if ($stmt->rowCount() > 0): ?>
                                                <table class="table info-table text-left">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                            <th>Score</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = $stmt->fetch()) {
                                                            $datetime = new DateTime($row['timespan']);
                                                            $date = $datetime->format('Y-m-d');
                                                            $time = $datetime->format('H:i:s');
                                                            ?>
                                                            <tr>
                                                                <td><?= $date; ?></td>
                                                                <td><?= $time; ?></td>
                                                                <td><?= $row['status'] ?>%</td>
                                                                <td class="actions">
                                                                    <form action="result.php" method="POST">
                                                                        <input type="hidden" name="assessment_id"
                                                                            value="<?= $row['assessment_id']; ?>">
                                                                        <input type="hidden" name="lesson_id"
                                                                            value="<?= $lesson_id; ?>">
                                                                        <input type="hidden" name="type_name"
                                                                            value="<?= $type_name; ?>">
                                                                        <input type="hidden" name="type_id" value="<?= $type_id; ?>">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-rounded btn-success social-btn pr-3 view-btn"
                                                                            style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                                                                            Result
                                                                            <i class="mdi mdi-arrow-right-thick m-0 pl-2"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p class="text-center text-muted">You are yet to take the <?= $type_name; ?>.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } ?>
            </div>

        </div>

        <script>
            // toggle mobile-content-section on select
            document.getElementById('mobileMenu').addEventListener('change', function () {
                document.querySelectorAll('.mobile-content-section')
                    .forEach(sec => sec.style.display = 'none');
                document.getElementById(this.value).style.display = 'block';
            });
            // initial show
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('mobileMenu')
                    .dispatchEvent(new Event('change'));
            });
        </script>

    </div>



    <div class="desktop row col-12">

        <!-- Sidebar with options -->
        <div class="menu-options col-3 mt-5 pt-5" style="--active-color: <?= htmlspecialchars($btnColor) ?>;">

            <div class="12 row mt-5">
                <a href="index.php" class="col-md-6"><button class="col-12 mb-5 btn btn-success btn-md" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        "><i class=" col-md-2 mdi mdi-undo-variant"></i>
                        Go back to
                        subjects</button></a>
                <a href="lessons.php" class="col-md-6"><button class="col-12 mb-5 btn btn-success btn-md" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        "><i class=" col-md-2 mdi mdi-undo-variant"></i>Go back to
                        lessons</button></a>
            </div>
            <!-- <a href="lessons.php"><button class="col-12 mb-5 btn btn-success btn-lg"><i
            class=" col-md-2 mdi mdi-undo-variant"></i> Go
          back to
          lessons</button></a> -->

            <div class="mb-5">
                <h5><?= $lesson_title ?></h5>
                <p class="text-gray"><?= $subject_title ?>, <?= $class_title ?></p>
            </div>



            <p class="menu-item active" data-target="about">Overview</p>
            <hr>
            <p class="menu-item" data-target="video">Video</p>
            <hr>
            <p class="menu-item" data-target="content">Content</p>
            <hr>
            <p class="menu-item" data-target="vocabulary">Vocabulary</p>
            <hr>
            <p class="menu-item" data-target="assessments">Assessments</p>
        </div>

        <!-- Option screen -->
        <div class="option-screen col-9 mt-5 pt-5">
            <!-- About Section -->
            <div id="about" class="content-section mt-5 pt-5">
                <div class="mb-5 col-12">
                    <h3 class="mb-2 col-12">Overview</h3>
                    <h2 class="col-8"><strong><?= htmlspecialchars($lesson_title); ?>
                            <?= htmlspecialchars($row['lesson_number']); ?> in <?= htmlspecialchars($subject_title); ?>
                            <?= htmlspecialchars($class_title); ?>.</strong></h2>
                </div>
                <div class="col-12">
                    <hr class="ml-0 col-10 mb-5">
                </div>
                <div class="col-12">
                    <h4 class="col-12">About this lesson</h4>
                    <p style="font-size: large;" class="col-10"><?= htmlspecialchars($row['description']); ?></p>
                </div>
            </div>

            <!-- Video Section -->
            <div id="video" class="content-section mt-5 pt-5" style="display: none;">
                <?php
                function getYouTubeVideoId($url)
                {
                    parse_str(parse_url($url, PHP_URL_QUERY), $query);
                    return $query['v'] ?? '';
                }
                $videoId = getYouTubeVideoId($row['video']);
                ?>
                <?php if (!empty($videoId)): ?>
                    <iframe class="col-12" height="450" src="https://www.youtube.com/embed/EplgbX-ALLM?controls=0"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen style="border-radius: 12px;">
                    </iframe>
                <?php endif; ?>
            </div>


            <!-- Content Section -->
            <div id="content" class="content-section mt-5 pt-5" style="display: none;">
                <div class="d-flex justify-content-between  mt-3">
                    <h4></h4>
                    <button id="fullscreenBtn" class="btn btn-success mb-2" style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">Fullscreen
                        <i class="mdi mdi-fullscreen text-white"></i>
                    </button>
                </div>
                <div class="d-flex py-2">
                    <div id="pdfViewer" class="w-100"></div>
                </div>
                <script>
                    var url = 'docs/<?= $row['lesson_id'] ?>.pdf';

                    var pdfjsLib = window['pdfjs-dist/build/pdf'];
                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

                    var loadingTask = pdfjsLib.getDocument(url);
                    loadingTask.promise.then(function (pdf) {
                        var pdfViewer = document.getElementById('pdfViewer');
                        var scale = window.innerWidth < 768 ? 0.75 : 1.5; // Adjust scale for mobile devices
                        for (var pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                            pdf.getPage(pageNum).then(function (page) {
                                var viewport = page.getViewport({ scale: scale });

                                var canvas = document.createElement('canvas');
                                canvas.className = 'pdf-page';
                                var context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);
                                pdfViewer.appendChild(canvas);
                            });
                        }
                    });

                    document.getElementById('fullscreenBtn').addEventListener('click', function () {
                        var pdfViewer = document.getElementById('pdfViewer');
                        if (pdfViewer.requestFullscreen) {
                            pdfViewer.requestFullscreen();
                        } else if (pdfViewer.mozRequestFullScreen) { // Firefox
                            pdfViewer.mozRequestFullScreen();
                        } else if (pdfViewer.webkitRequestFullscreen) { // Chrome, Safari and Opera
                            pdfViewer.webkitRequestFullscreen();
                        } else if (pdfViewer.msRequestFullscreen) { // IE/Edge
                            pdfViewer.msRequestFullscreen();
                        }
                    });
                </script>
            </div>

            <!-- Vocabulary Section -->
            <div id="vocabulary" class="content-section mt-5 pt-5" style="display: none;">
                <h4>Vocabulary</h4>
                <p><?= htmlspecialchars($row['vocabolary']); ?></p>
            </div>

            <!-- Assessments Section -->
            <div id="assessments" class="content-section mt-5 pt-5" style="display: none;">
                <?php
                if (isset($_SESSION["class_id"])) {

                    $class_title = isset($_SESSION['class_title']) ? $_SESSION['class_title'] : '';
                    $class_id = isset($_SESSION['class_id']) ? $_SESSION['class_id'] : 0;
                    $lesson_id = isset($_SESSION['lesson_id']) ? $_SESSION['lesson_id'] : 0;

                    $types = [
                        1 => 'Basic Assessments',
                        2 => 'Intermediate Assessments',
                        3 => 'Advanced Assessments',
                        4 => 'General Assessments'
                    ];

                    foreach ($types as $type_id => $type_name) {
                        $sql = "SELECT a.assessment_id, a.timespan, a.status
                      FROM assessments a
                      WHERE a.lesson_id = $lesson_id AND a.type = $type_id AND a.student_id = $student_id ORDER BY a.timespan DESC";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        ?>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="grid">
                                    <span class="grid-header row m-0">
                                        <div class="d-flex w-100 justify-content-between ">
                                            <span><?= $type_name ?></span>
                                            <form action="student-assessments.php" method="POST">
                                                <input type="hidden" name="lesson_id" value="<?= $lesson_id; ?>">
                                                <input type="hidden" name="type_name" value="<?= $type_name; ?>">
                                                <input type="hidden" name="type_id" value="<?= $type_id; ?>">
                                                <button type="submit" class="btn btn-sm btn-success social-btn pr-3 view-btn"
                                                    style="
          background-color: <?= htmlspecialchars($btnColor) ?>;
          border-color:     <?= htmlspecialchars($btnColor) ?>;
          color:            #fff;
        ">
                                                    assessment
                                                    <i class="mdi mdi-pen m-0 pl-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </span>
                                    <div class="item-wrapper">
                                        <div class="table-responsive text-left">
                                            <?php if ($stmt->rowCount() > 0): ?>
                                                <table class="table info-table text-left">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                            <th>Score</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = $stmt->fetch()) {
                                                            $datetime = new DateTime($row['timespan']);
                                                            $date = $datetime->format('Y-m-d');
                                                            $time = $datetime->format('H:i:s');
                                                            ?>
                                                            <tr>
                                                                <td><?= $date; ?></td>
                                                                <td><?= $time; ?></td>
                                                                <td><?= $row['status'] ?>%</td>
                                                                <td class="actions">
                                                                    <form action="result.php" method="POST">
                                                                        <input type="hidden" name="assessment_id"
                                                                            value="<?= $row['assessment_id']; ?>">
                                                                        <input type="hidden" name="lesson_id"
                                                                            value="<?= $lesson_id; ?>">
                                                                        <input type="hidden" name="type_name"
                                                                            value="<?= $type_name; ?>">
                                                                        <input type="hidden" name="type_id" value="<?= $type_id; ?>">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-rounded btn-success social-btn pr-3 view-btn">
                                                                            Result
                                                                            <i class="mdi mdi-arrow-right-thick m-0 pl-2"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p class="text-center text-muted">You are yet to take the <?= $type_name; ?>.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } ?>
            </div>
        </div>

        <script>
            // Add event listeners to sidebar options
            document.querySelectorAll('.menu-options .menu-item').forEach(function (item) {
                item.addEventListener('click', function () {
                    // Remove active class from all items
                    document.querySelectorAll('.menu-options .menu-item').forEach(function (el) {
                        el.classList.remove('active');
                    });

                    // Add active class to the clicked item
                    this.classList.add('active');

                    // Hide all content sections
                    document.querySelectorAll('.content-section').forEach(function (section) {
                        section.style.display = 'none';
                    });

                    // Show the target content section
                    const target = this.getAttribute('data-target');
                    document.getElementById(target).style.display = 'block';
                });
            });
        </script>
    </div>


    <!-- page content ends -->
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="assets/vendors/js/core.js"></script>
    <script src="assets/vendors/js/vendor.addons.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="template.js"></script>
    <!-- endbuild -->
</body>

</html>