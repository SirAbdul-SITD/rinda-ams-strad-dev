<?php require_once 'db.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="logo.jpg">
  <title>Rinda AMS - Rinda AMS</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="overpass-font.css" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="css/feather.css">
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

<body class="light ">
  <div class="wrapper vh-100">
    <div class="align-items-center h-100">


      <?php

   
          $email = $_GET['email'];
      ?>



          <form class="col-lg-6 col-md-4 col-10 mx-auto text-center">
            <div class="mx-auto text-center my-4">
              <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">
                <img src='logo.jpg' alt='Grit Hall Logo' style='
                  width: 60px;
                  height: 60px;
                  border-radius: 50%;
                  align-self: center;
                ' />
              </a>
              <h2 class="my-3">Reset Password</h2>
            </div>
            <p class="text-muted"><?= $email ?></p>
            <div class="col">
              <p class="mb-2">Password requirements</p>
              <p class="small text-muted mb-2 text-left"> To create a new password, you have to meet all of the following
                requirements: </p>
              <ul class="small text-muted pl-4 mb-0 text-left">
                <li> Minimum 8 characters </li>
                <li> At least one number </li>
                <li> Can’t be the same as a previous password </li>
              </ul>

            </div>
            <div class="row mb-4">
              <div class="col">
                <div class="form-group">
                  <label for="inputPassword5">New Password</label>
                  <input type="password" class="form-control required" id="password" name="password" oninput="validatePassword1()">
                </div>
                <div class="form-group">
                  <label for="inputPassword6">Confirm Password</label>
                  <input type="password" class="form-control required" id="inputPassword6" name="confirm_password" oninput="validatePassword2()">
                </div>
                <p id="message"></p>
              </div>

            </div>

            <script>
              function validatePassword1() {
                const password = document.getElementById('inputPassword5').value;
                const message = document.getElementById('message');

                // Password requirements: Minimum 8 characters, at least one number
                const passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/;

                if (!password.match(passwordPattern)) {
                  message.innerText = "Password must meet the requirements: Minimum 8 characters, and at least one number";
                  message.style = "color : red";
                } else {
                  message.innerText = "Passwords meet the requirements";
                  message.style = "color : green";
                }
              }

              function validatePassword2() {
                const password = document.getElementById('inputPassword5').value;
                const confirmPassword = document.getElementById('inputPassword6').value;
                const message = document.getElementById('message');

                // Password requirements: Minimum 8 characters, at least one number
                const passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/;

                if (password !== confirmPassword) {
                  message.innerText = "Passwords do not match";
                  message.style = "color : red";
                } else if (!password.match(passwordPattern)) {
                  message.innerText = "Passwords match but do not meet the requirements: Minimum 8 characters, and at least one number";
                  message.style = "color : red";
                } else {
                  message.innerText = "Passwords match and meet the requirements";
                  message.style = "color : green";
                }
              }
            </script>
            <input type="hidden" id="email" value="<?= $email ?>">
            <button class="btn btn-lg btn-success btn-block" type="submit">Reset Password</button>
            <p class="mt-5 mb-3 text-muted text-center">Powered By STRAD Africa © 2024</p>
          </form>

        
        
      <div class="col-lg-3 col-md-4 col-10 mx-auto text-center">
        <a href="login.php" style="text-decoration: none;">
          <button class="btn btn-lg btn-primary btn-block" type="button">Back to login</button>
        </a>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/simplebar.min.js"></script>
  <script src='js/daterangepicker.js'></script>
  <script src='js/jquery.stickOnScroll.js'></script>
  <script src="js/tinycolor-min.js"></script>
  <script src="js/config.js"></script>
  <script src="js/apps.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>

  <script>
    //Function to display a popup message
    function displayPopup(message, success) {
      var popup = document.createElement('div');
      popup.className = 'popup ' + (success ? 'success' : 'error');

      var iconClass = success ? 'fa fa-check-circle' : 'fa fa-times-circle';
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




    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.querySelector('form');

      loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // AJAX request to validate credentials
        $.ajax({
          type: 'POST',
          url: 'reset.php', // Update with your PHP file for validating login
          data: {
            email: email,
            password: password,
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              displayPopup(response.message, true);

              // Redirect to index.php
              window.location.href = 'login.php';
            } else {
              displayPopup(response.message, false); // Show error message if login fails
            }
          },
          error: function(xhr, status, error) {

          }
        });
      });
    });
  </script>



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
</body>

</html>