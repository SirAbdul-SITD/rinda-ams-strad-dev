<?php require('../settings.php');

if (isset($_GET['ref'])) {
  $ref = $_GET['ref'];
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


$query = "SELECT class From classes WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$application_info['class_id']]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);


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
  <link rel="icon" href="../assets/images/logo.jpg">
  <title>Rinda AMS | Rinda AMS</title>
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

    .modal-shortcut .con-item {
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .modal-shortcut .con-item:hover {
      transform: scale(1.05);
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
                          <div class="progress-bar" role="progressbar"
                            style="width: <?= $progress ?>%; background-color: <?= $color ?>"
                            aria-valuenow="<?= $progress ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row align-items-center">
                        <div class="col-md-7">
                          <h4 class="mb-1">
                            <?= $application_info['student_firstName'] . ' ' . $application_info['student_lastName']; ?>
                          </h4>
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
                              <button type="button" class="btn btn-primary w-100" id="reveal">Reveal Application
                                Form</button>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col">
                          <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>No. 1 JD Abubakar Close, Harmony
                            Estate, Off Panaf Drive, Dawaki Abuja</p>
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
                <strong>Admission Form</strong>
              </div>
              <div class="card-body">
                <form id="application-form">
                  <div id="wizard">


                    <h3>Student's Info</h3>
                    <section>
                      <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_firstName">First Name *</label>
                            <input id="student_firstName" name="student_firstName" type="text" class="form-control"
                              disabled required value="<?= $application_info['student_firstName'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_lastName">Last Name *</label>
                            <input id="student_lastName" name="student_lastName" type="text" class="form-control"
                              disabled required value="<?= $application_info['student_lastName'] ?>">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Gender and Date of Birth -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_gender">Gender *</label>
                            <select id="student_gender" name="student_gender" class="form-control" disabled required>
                              <option selected value="<?= $application_info['student_gender'] ?>">
                                <?= $application_info['student_gender'] ?></option>

                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_dob">Date of Birth *</label>
                            <input id="student_dob" name="student_dob" type="date" class="form-control" disabled
                              required value="<?= $application_info['student_dob'] ?>">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Address and City -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_country">Nationality *</label>
                            <select id="student_country" name="student_country" class="form-control" disabled required>
                              <option value="Nigeria" selected>Nigerian</option>

                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_state">State of origin*</label>
                            <select id="student_state" name="student_state" class="form-control" disabled required>
                              <option selected value="<?= $application_info['student_state'] ?>">
                                <?= $application_info['student_state'] ?></option>

                            </select>

                          </div>
                        </div>


                      </div>

                      <div class="row">
                        <!-- State and Country -->

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_origin">Place of origin *</label>
                            <input id="student_origin" name="student_origin" type="text" class="form-control" disabled
                              required value="<?= $application_info['student_origin'] ?>">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_address">Residential address *</label>
                            <input id="student_address" name="student_address" type="text" class="form-control" disabled
                              required value="<?= $application_info['student_address'] ?>">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_pos_in_family">Position in the family *</label>
                            <input id="student_pos_in_family" name="student_pos_in_family" type="number"
                              class="form-control" disabled required
                              value="<?= $application_info['student_pos_in_family'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_prev_school">Previous school</label>
                            <input id="student_prev_school" name="student_prev_school" type="text" class="form-control"
                              disabled value="<?= $application_info['student_prev_school'] ?>">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="class_id">Applying class *</label>
                            <select id="class_id" disabled class="form-control select1" name="class_id" required>
                              <option value="<?= $class ?>"><?= $class ?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_juz_memorised">Juz memorised *</label>
                            <input id="student_juz_memorised" name="student_juz_memorised" type="text"
                              class="form-control" disabled required
                              value="<?= $application_info['student_juz_memorised'] ?>">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Religion and Blood Group -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_kyh">Know your huruf? *</label>
                            <select id="student_kyh" name="student_kyh" class="form-control" disabled required>
                              <option value="<?= $application_info['student_kyh'] ?>">
                                <?= $application_info['student_kyh'] ?></option>

                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_quran">Can blend the Qur'an? *</label>
                            <select id="student_quran" name="student_quran" class="form-control" disabled required>
                              <option value="<?= $application_info['student_quran'] ?>">
                                <?= $application_info['student_quran'] ?></option>

                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_languages">Language(s) child can speak *</label>
                            <textarea id="student_languages" name="student_languages" class="form-control" disabled
                              required><?= $application_info['student_languages'] ?></textarea>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="referrer">How did you know about GHA? *</label>
                            <textarea id="referrer" name="referrer" class="form-control" disabled
                              required><?= $application_info['referrer'] ?></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="rfj">Reason(s) for joining GHA *</label>
                            <textarea id="rfj" name="rfj" class="form-control" disabled
                              required><?= $application_info['rfj'] ?></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_genotype">Genotype *</label>
                            <input id="student_genotype" name="student_genotype" type="text" class="form-control"
                              disabled required value="<?= $application_info['student_genotype'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_bloodGroup">Blood Group *</label>
                            <select id="student_bloodGroup" name="student_bloodGroup" class="form-control" disabled
                              required>
                              <option value="<?= $application_info['student_bloodGroup'] ?>">
                                <?= $application_info['student_bloodGroup'] ?></option>

                            </select>
                          </div>

                        </div>
                      </div>

                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_likes">Likes *</label>
                            <textarea id="student_likes" name="student_likes" class="form-control" disabled
                              required><?= $application_info['student_likes'] ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_dislikes">Dislikes *</label>
                            <textarea id="student_dislikes" name="student_dislikes" class="form-control" disabled
                              required><?= $application_info['student_dislikes'] ?></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_allergies">Allergies *</label>
                            <textarea id="student_allergies" name="student_allergies" class="form-control" disabled
                              required><?= $application_info['student_allergies'] ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_learning_disorder">Any Leaning difficulty? *</label>
                            <textarea id="student_learning_disorder" name="student_learning_disorder"
                              class="form-control" disabled
                              required><?= $application_info['student_learning_disorder'] ?></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="student_health_info">All vital health information *</label>
                            <textarea id="student_health_info" name="student_health_info" class="form-control" disabled
                              required><?= $application_info['student_health_info'] ?></textarea>
                          </div>
                        </div>
                      </div>

                      <!-- Help Text -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="help-text text-muted">(*) Mandatory</div>
                        </div>
                      </div>
                    </section>


                    <h3>Parents Info</h3>
                    <section>
                      <span id="father">
                        <b class="mb-3">Father Info</b>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_firstName">First Name *</label>
                              <input id="father_firstName" name="father_firstName" type="text" class="form-control"
                                disabled required value="<?= $application_info['father_firstName'] ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_lastName">Last Name *</label>
                              <input id="father_lastName" name="father_lastName" type="text" class="form-control"
                                disabled required value="<?= $application_info['father_lastName'] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_number">Phone Number *</label>
                              <input id="father_number" name="father_number" type="number" class="form-control" disabled
                                required value="<?= $application_info['father_number'] ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_email">Email Address *</label>
                              <input id="father_email" name="father_email" type="email" class="form-control" disabled
                                required value="<?= $application_info['father_email'] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Address and City -->

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_state">State of origin *</label>
                              <select id="father_state" name="father_state" class="form-control" disabled required>
                                <option value="<?= $application_info['father_state'] ?>">
                                  <?= $application_info['father_state'] ?></option>

                              </select>

                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_job">Job description *</label>
                              <input id="father_job" name="father_job" type="text" class="form-control" disabled
                                required value="<?= $application_info['father_job'] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Height and Weight -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_office">Office Address *</label>
                              <textarea id="father_office" name="father_office" class="form-control" disabled
                                required><?= $application_info['father_office'] ?></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_ps">Parenting style adopted at home *</label>
                              <textarea id="father_ps" name="father_ps" class="form-control" disabled
                                required><?= $application_info['father_ps'] ?></textarea>
                            </div>
                          </div>
                        </div>
                      </span>

                      <span id="mother" class="mb-3">
                        <b class="mb-3">Mother Info</b>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_firstName">First Name *</label>
                              <input id="mother_firstName" name="mother_firstName" type="text" class="form-control"
                                disabled required value="<?= $application_info['mother_firstName'] ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_lastName">Last Name *</label>
                              <input id="mother_lastName" name="mother_lastName" type="text" class="form-control"
                                disabled required value="<?= $application_info['mother_lastName'] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_number">Phone Number *</label>
                              <input id="mother_number" name="mother_number" type="number" class="form-control" disabled
                                required value="<?= $application_info['mother_number'] ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_email">Email Address *</label>
                              <input id="mother_email" name="mother_email" type="email" class="form-control" disabled
                                required value="<?= $application_info['mother_email'] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Address and City -->

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_state">State of origin*</label>
                              <select id="mother_state" name="mother_state" class="form-control" disabled required>
                                <option value="<?= $application_info['mother_state'] ?>">
                                  <?= $application_info['mother_state'] ?></option>

                              </select>

                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_job">Job description *</label>
                              <input id="mother_job" name="mother_job" type="text" class="form-control" disabled
                                required value="<?= $application_info['mother_job'] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Height and Weight -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_office">Office Address *</label>
                              <textarea id="mother_office" name="mother_office" class="form-control" disabled
                                required><?= $application_info['mother_office'] ?></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_ps">Parenting style adopted at home *</label>
                              <textarea id="mother_ps" name="mother_ps" class="form-control" disabled
                                required><?= $application_info['mother_ps'] ?></textarea>
                            </div>
                          </div>
                        </div>
                      </span>


                      <span id="emegency" class="mt-5">
                        <p class="mb-3">Emergency contact in case both parents can't be reached</p>

                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="emergency_name">Emergency Contact Name *</label>
                              <input id="emergency_name" name="emergency_name" type="number" class="form-control"
                                disabled required value="<?= $application_info['emergency_name'] ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="emergency_number">Emergency Contact Number *</label>
                              <input id="emergency_number" name="emergency_number" type="number" class="form-control"
                                disabled required value="<?= $application_info['emergency_number'] ?>">
                            </div>
                          </div>
                        </div>


                      </span>



                      <span id="pickup" class="mt-5">
                        <b class="mb-3">Pickup person's info</b>
                        <p class="mb-3">Person 1</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_name1">Full Name *</label>
                              <input id="pickup_name1" name="pickup_name1" type="number" class="form-control" disabled
                                required value="<?= $application_info['pickup_name1'] ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_relationship1">Relationship *</label>
                              <input id="pickup_relationship1" name="pickup_relationship1" type="number"
                                class="form-control" disabled required
                                value="<?= $application_info['pickup_relationship1'] ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_number1">Contact Number *</label>
                              <input id="pickup_number1" name="pickup_number1" type="number" class="form-control"
                                disabled required value="<?= $application_info['pickup_number1'] ?>">
                            </div>
                          </div>
                        </div>



                        <p class="mb-3">Person 2</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Full Name </label>
                              <input id="student_firstName" name="pickup_name2" type="number" class="form-control"
                                disabled value="<?= $application_info['pickup_name2'] ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Relationship </label>
                              <input id="student_firstName" name="pickup_relationship2" type="number"
                                class="form-control" disabled value="<?= $application_info['pickup_relationship2'] ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Contact Number </label>
                              <input id="student_firstName" name="pickup_number2" type="number" class="form-control"
                                disabled value="<?= $application_info['pickup_number2'] ?>">
                            </div>
                          </div>
                        </div>


                        <p class="mb-3">Person 3</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Full Name </label>
                              <input id="student_firstName" name="pickup_name3" type="number" class="form-control"
                                disabled value="<?= $application_info['pickup_name3'] ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Relationship </label>
                              <input id="student_firstName" name="pickup_relationship3" type="number"
                                class="form-control" disabled value="<?= $application_info['pickup_relationship3'] ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Contact Number </label>
                              <input id="student_firstName" name="pickup_number3" type="number" class="form-control"
                                disabled value="<?= $application_info['pickup_number3'] ?>">
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


                    <h3>Documents</h3>
                    <section>
                      <!-- Photo Upload -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="student_photo">Upload these documents:
                              <span>
                                <ul class="ml-4">
                                  <li>Child's immunisation card</li>
                                  <li>Child's passport photography</li>
                                  <li>Child's past result sheet</li>
                                  <li>Child's birth certificate</li>
                                  <li>Child's health records (only from government or government accreditted hospital)
                                  </li>
                                  <li>Both parents passport photography</li>
                                  <li>Both parents office ID Cards</li>
                                  <li>Both parents licence document (Driver's licence or International Passport)</li>
                                </ul>
                              </span>
                            </label>
                            <div id="my-dropzone" class="dropzone">

                              <div class="dz-message needsclick">
                                <div class="circle circle-lg bg-primary">
                                  <i class="fe fe-upload fe-24 text-white"></i>
                                </div>
                                <h5 class="text-muted mt-4">Drop files here or click to upload</h5>
                              </div>

                              <div class="d-none" id="uploadPreviewTemplate">
                                <div class="card mt-1 mb-0 shadow-none border">
                                  <div class="p-2">
                                    <div class="row align-items-center">
                                      <div class="col-auto" style="border-radius: 10%;">
                                        <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                      </div>
                                      <div class="col pl-0">
                                        <a href="javascript:void(0);" class="text-muted font-weight-bold"
                                          data-dz-name></a>
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


                    </section>




                    <h3>Terms and Conditions</h3>
                    <section>

                      <ol>
                        <li>
                          <strong>Application Submission:</strong> By submitting this application form, you agree to
                          provide accurate and complete information. Any false or misleading information may result in
                          the rejection of your application or termination of enrollment if discovered at a later date.
                        </li>
                        <li>
                          <strong>Application Fee:</strong> A non-refundable application fee will be required upon
                          submission of this application. Payment details will be provided upon completion of the form.
                        </li>
                        <li>
                          <strong>Enrollment Process:</strong> Completion of this application does not guarantee
                          admission. Admission decisions are made based on various factors including academic
                          performance, conduct, and availability of space.
                        </li>
                        <li>
                          <strong>Acceptance:</strong> If your application is accepted, you agree to adhere to the
                          rules, policies, and regulations of the school as outlined in the student handbook. Failure to
                          comply may result in disciplinary action.
                        </li>
                        <li>
                          <strong>Tuition and Fees:</strong> Tuition and fees are subject to change and are payable in
                          accordance with the school's schedule. Failure to pay tuition and fees may result in the
                          withholding of academic records or dismissal from the school.
                        </li>
                        <li>
                          <strong>Withdrawal:</strong> If you wish to withdraw your application or enrollment, written
                          notice must be provided to the school administration. Refunds, if applicable, will be subject
                          to the school's withdrawal policy.
                        </li>
                        <li>
                          <strong>Health and Safety:</strong> The school reserves the right to require medical
                          examinations and immunizations as deemed necessary for the health and safety of all students.
                          Parents/guardians are responsible for informing the school of any health concerns or
                          conditions.
                        </li>
                        <li>
                          <strong>Code of Conduct:</strong> Students are expected to conduct themselves in a manner that
                          upholds the values and principles of the school community. Any behavior deemed inappropriate
                          or disruptive may result in disciplinary action.
                        </li>
                        <li>
                          <strong>Privacy:</strong> The information provided in this application will be treated
                          confidentially and used only for the purpose of admission and enrollment at the school.
                          Personal data will be handled in accordance with applicable privacy laws.
                        </li>
                        <li>
                          <strong>Agreement:</strong> By submitting this application form, you acknowledge that you have
                          read, understood, and agree to abide by the terms and conditions outlined above.
                        </li>
                      </ol>

                      <p>Kindly review and confirm the accuracy of the provided information, ensuring it is free from
                        errors. Select "Finish" to proceed with adding a new student or "Previous" to review the input.
                      </p>

                    </section>




                  </div>
                </form>
              </div> <!-- .card-body -->
            </div> <!-- .card -->
          </div> <!-- .col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->


      <!--Assign Warning Modal -->
      <div class="modal fade" id="successModel" tabindex="-1" role="dialog" aria-labelledby="successModelTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header justify-content-center">
              <h5 class="modal-title text-center" id="successModelTitle">Application Form Submimitted</h5>
            </div>
            <div class="modal-body">Your Application Was Submitted Successfully, Please Make the <span
                id='amount'></span> non-refundable application fee payment to the following account.</div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-primary w-100" id="force_assign">View Application
                Status</button>
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
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
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
    $(document).ready(function () {
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

        setTimeout(function () {
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
        onStepChanging: function (event, currentIndex, newIndex) {
          form.validate().settings.ignore = ":disabled,:hidden";
          return form.valid();
        },
        onFinishing: function (event, currentIndex) {
          form.validate().ignore;
          return form.valid();
        },

      });

      // Event listener for student state dropdown change
      $('#student_state').on('change', function () {
        populateCities(this, document.getElementById("student_city"));
      });

      // Event listener for father state dropdown change
      $('#father_state').on('change', function () {
        populateCities(this, document.getElementById("father_city"));
      });

      // Event listener for mother state dropdown change
      $('#mother_state').on('change', function () {
        populateCities(this, document.getElementById("mother_city"));
      });

      // Event listener for guardian state dropdown change
      $('#guardian_state').on('change', function () {
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

    reveal.click(function () {
      if (revealDetails.is(':hidden')) {
        // Show the add class form
        revealDetails.slideDown();
        reveal.text('Hide Application Form'); // Change button text to 'Hide Form'
      } else {
        // Hide the add class form
        revealDetails.slideUp();
        reveal.text('Reveal Application Form'); // Change button text back to 'Add class'
      }
    });
  </script>
</body>

</html>