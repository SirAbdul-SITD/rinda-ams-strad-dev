<?php require('db.php');
$ref = $_SESSION['ref']; ?>
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

<body class=" light  ">
  <div class="wrapper">

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 ">
            <h3 class="page-title mt-5">New Student Admission</h3>
            <p>Fill the form below to sbmit a new student application. all field marked by astrix (*) most be filled</p>
            <div class="card my-4">
              <div class="card-header">
                <strong>Admission Form</strong>
              </div>
              <div class="card-body">
                <form id="example-form" action="save-application.php" method="POST">
                  <div id="wizard">

                    <h3>Student's Info</h3>
                    <section>
                      <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_firstName">First Name *</label>
                            <input id="student_firstName" name="student_firstName" type="text" class="form-control required">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_lastName">Last Name *</label>
                            <input id="student_lastName" name="student_lastName" type="text" class="form-control required">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Gender and Date of Birth -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_gender">Gender *</label>
                            <select id="student_gender" name="student_gender" class="form-control required">
                              <option value="">Select Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_dob">Date of Birth *</label>
                            <input id="student_dob" name="student_dob" type="date" class="form-control required">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- Address and City -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_country">Nationality *</label>
                            <select id="student_country" name="student_country" class="form-control required">
                              <option value="Nigeria" selected>Nigerian</option>
                              <!-- <option value="other">Other</option> -->
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_state">State of origin*</label>
                            <select id="student_state" name="student_state" class="form-control required">
                              <option value="">Select State</option>
                              <option value="FCT">FCT</option>
                              <option value="Abia">Abia</option>
                              <option value="Adamawa">Adamawa</option>
                              <option value="Akwa Ibom">Akwa Ibom</option>
                              <option value="Anambra">Anambra</option>
                              <option value="Bauchi">Bauchi</option>
                              <option value="Bayelsa">Bayelsa</option>
                              <option value="Benue">Benue</option>
                              <option value="Borno">Borno</option>
                              <option value="Cross River">Cross River</option>
                              <option value="Delta">Delta</option>
                              <option value="Ebonyi">Ebonyi</option>
                              <option value="Edo">Edo</option>
                              <option value="Ekiti">Ekiti</option>
                              <option value="Enugu">Enugu</option>
                              <option value="Gombe">Gombe</option>
                              <option value="Imo">Imo</option>
                              <option value="Jigawa">Jigawa</option>
                              <option value="Kaduna">Kaduna</option>
                              <option value="Kano">Kano</option>
                              <option value="Katsina">Katsina</option>
                              <option value="Kebbi">Kebbi</option>
                              <option value="Kogi">Kogi</option>
                              <option value="Kwara">Kwara</option>
                              <option value="Lagos">Lagos</option>
                              <option value="Nasarawa">Nasarawa</option>
                              <option value="Niger">Niger</option>
                              <option value="Ogun">Ogun</option>
                              <option value="Ondo">Ondo</option>
                              <option value="Osun">Osun</option>
                              <option value="Oyo">Oyo</option>
                              <option value="Plateau">Plateau</option>
                              <option value="Rivers">Rivers</option>
                              <option value="Sokoto">Sokoto</option>
                              <option value="Taraba">Taraba</option>
                              <option value="Yobe">Yobe</option>
                              <option value="Zamfara">Zamfara</option>
                            </select>

                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <!-- State and Country -->

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_origin">Place of origin *</label>
                            <input id="student_origin" name="student_origin" type="text" class="form-control required">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_address">Residential address *</label>
                            <input id="student_address" name="student_address" type="text" class="form-control required">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_pos_in_family">Position in the family *</label>
                            <input id="student_pos_in_family" name="student_pos_in_family" type="number" class="form-control required">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_prev_school">Previous school</label>
                            <input id="student_prev_school" name="student_prev_school" type="text" class="form-control">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="class_id">Applying class *</label>
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
                                  echo "<option value=$x>$y - $z Section</option>";
                                endforeach;
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_juz_memorised">Juz memorised *</label>
                            <input id="student_juz_memorised" name="student_juz_memorised" type="text" class="form-control required">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Religion and Blood Group -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_kyh">Know your huruf? *</label>
                            <select id="student_kyh" name="student_kyh" class="form-control required">
                              <option value="">Select</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                              <option value="Partially">Partially</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_quran">Can blend the Qur'an? *</label>
                            <select id="student_quran" name="student_quran" class="form-control required">
                              <option value="">Select</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                              <option value="Partially">Partially</option>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Height and Weight -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_languages">Language(s) child can speak *</label>
                            <textarea id="student_languages" name="student_languages" class="form-control required"></textarea>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="referrer">How did you know about GHA? *</label>
                            <textarea id="referrer" name="referrer" class="form-control required"></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Reason(s) for joining GHA  -->
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="rfj">Reason(s) for joining GHA *</label>
                            <textarea id="rfj" name="rfj" class="form-control required"></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Genotype -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_genotype">Genotype *</label>
                            <input id="student_genotype" name="student_genotype" type="text" class="form-control required">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_bloodGroup">Blood Group *</label>
                            <select id="student_bloodGroup" name="student_bloodGroup" class="form-control required">
                              <option value="">Select Blood Group</option>
                              <option value="A+">A+</option>
                              <option value="A-">A-</option>
                              <option value="B+">B+</option>
                              <option value="B-">B-</option>
                              <option value="AB+">AB+</option>
                              <option value="AB-">AB-</option>
                              <option value="O+">O+</option>
                              <option value="O-">O-</option>
                            </select>
                          </div>

                        </div>
                      </div>

                      <div class="row">
                        <!-- Likes and Dislikes -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_likes">Likes *</label>
                            <textarea id="student_likes" name="student_likes" class="form-control required"></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_dislikes">Dislikes *</label>
                            <textarea id="student_dislikes" name="student_dislikes" class="form-control required"></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- Allergies and student_learning_disorder -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_allergies">Allergies *</label>
                            <textarea id="student_allergies" name="student_allergies" class="form-control required"></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="student_learning_disorder">Any Leaning difficulty? *</label>
                            <textarea id="student_learning_disorder" name="student_learning_disorder" class="form-control required"></textarea>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <!-- All vital health information -->
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="student_health_info">All vital health information *</label>
                            <textarea id="student_health_info" name="student_health_info" class="form-control required"></textarea>
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
                              <input id="father_firstName" name="father_firstName" type="text" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_lastName">Last Name *</label>
                              <input id="father_lastName" name="father_lastName" type="text" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_number">Phone Number *</label>
                              <input id="father_number" name="father_number" type="tel" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_email">Email Address *</label>
                              <input id="father_email" name="father_email" type="email" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Address and City -->

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_state">State of origin *</label>
                              <select id="father_state" name="father_state" class="form-control required">
                                <option value="">Select State</option>
                                <option value="FCT">FCT</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa Ibom">Akwa Ibom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nasarawa">Nasarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                              </select>

                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_job">Job description *</label>
                              <input id="father_job" name="father_job" type="text" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Height and Weight -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_office">Office Address *</label>
                              <textarea id="father_office" name="father_office" class="form-control required"></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="father_ps">Parenting style adopted at home *</label>
                              <textarea id="father_ps" name="father_ps" class="form-control required"></textarea>
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
                              <input id="mother_firstName" name="mother_firstName" type="text" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_lastName">Last Name *</label>
                              <input id="mother_lastName" name="mother_lastName" type="text" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_number">Phone Number *</label>
                              <input id="mother_number" name="mother_number" type="tel" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_email">Email Address *</label>
                              <input id="mother_email" name="mother_email" type="email" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Address and City -->

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_state">State of origin*</label>
                              <select id="mother_state" name="mother_state" class="form-control required">
                                <option value="">Select State</option>
                                <option value="FCT">FCT</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa Ibom">Akwa Ibom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nasarawa">Nasarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                              </select>

                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_job">Job description *</label>
                              <input id="mother_job" name="mother_job" type="text" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!-- Height and Weight -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_office">Office Address *</label>
                              <textarea id="mother_office" name="mother_office" class="form-control required"></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="mother_ps">Parenting style adopted at home *</label>
                              <textarea id="mother_ps" name="mother_ps" class="form-control required"></textarea>
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
                              <input id="emergency_name" name="emergency_name" type="text" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="emergency_number">Emergency Contact Number *</label>
                              <input id="emergency_number" name="emergency_number" type="tel" class="form-control required">
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
                              <input id="pickup_name1" name="pickup_name1" type="text" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_relationship1">Relationship *</label>
                              <input id="pickup_relationship1" name="pickup_relationship1" type="text" class="form-control required">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="pickup_number1">Contact Number *</label>
                              <input id="pickup_number1" name="pickup_number1" type="text" class="form-control required">
                            </div>
                          </div>
                        </div>



                        <p class="mb-3">Person 2</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Full Name </label>
                              <input id="student_firstName" name="pickup_name2" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Relationship </label>
                              <input id="student_firstName" name="pickup_relationship2" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Contact Number </label>
                              <input id="student_firstName" name="pickup_number2" type="tel" class="form-control">
                            </div>
                          </div>
                        </div>


                        <p class="mb-3">Person 3</p>
                        <div class="row">
                          <!-- Personal Information -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Full Name </label>
                              <input id="student_firstName" name="pickup_name3" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Relationship </label>
                              <input id="student_firstName" name="pickup_relationship3" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="student_firstName">Contact Number </label>
                              <input id="student_firstName" name="pickup_number3" type="tel" class="form-control">
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
                                  <li>Child's health records (only from government or government accreditted hospital)</li>
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
                          <strong>Application Fee:</strong> A non-refundable application fee will be upon
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

                      <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">Information is accurate.</label>
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
                displayPopup(response.message, false);
                $('#errorModal').modal({
                  backdrop: 'static',
                  keyboard: false
                });
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
        maxFilesize: 10, // Maximum file size in MB
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