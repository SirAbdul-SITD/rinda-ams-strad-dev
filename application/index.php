<?php require('db.php'); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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



        .container-fluid::before {
            /* Create the overlay effect */
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('logo.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
        }


        .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 160px;
            height: 160px
        }

        .logo {
            width: 90px;
            /* Adjust the size of the logo as needed */
            height: 90px;
            /* Adjust the size of the logo as needed */
            border-radius: 50%;
            overflow: hidden;
            position: relative;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .clock {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hand {
            width: 2px;
            /* Adjust the width of the clock hands as needed */
            height: 40px;
            /* Adjust the height of the clock hands as needed */
            background-color: whitesmoke;
            /* Blue color */
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: top;
        }

        .hour {
            animation: rotateHour 12s infinite linear;
        }

        .minute {
            height: 30px;
            /* Adjust the height of the minute hand */
            animation: rotateMinute 70s infinite linear;
        }

        @keyframes rotateHour {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rotateMinute {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dot-flashing {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: green;
            /* Blue color */
            border-radius: 50%;
            animation: dot-flashing 1s infinite;
        }



        @keyframes dot-flashing {

            0%,
            10% {
                opacity: 0;
            }

            20% {
                opacity: 1;
            }

            30% {
                opacity: 0;
            }

            40% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            60% {
                opacity: 1;
            }

            70% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="light  ">
    <div class="wrapper">

        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 ">
                        <div class="my-5 ">
                            <div class="text-center">
                                <h2 class="text-center mb-4">Step into a world of educational possibilities with us</h2>
                                <p class="mb-5">We extend a warm welcome to our application portal, where your child's academic adventure awaits. Select an option below to embark on or progress through your child's application journey</p>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <div class="card shadow bg-primary text-center mb-4">
                                    <div class="card-body p-5">
                                        <span class="circle circle-md bg-primary-light">
                                            <i class="fe fe-file-text fe-24 text-white"></i>
                                        </span>
                                        <h3 class="h4 mt-4 mb-1 text-white">Check Application Status</h3>
                                        <p class="text-white mb-4">Have you already submitted an application for your child? Enter your reference number to track the progress of their application and receive updates on its status.</p>
                                        <button id="checkModalButton" class="btn btn-lg bg-primary-light text-white" data-toggle="modal" data-target="#checkModal">Check Status<i class="fe fe-arrow-right fe-16 ml-2"></i></button>
                                    </div> <!-- .card-body -->
                                </div> <!-- .card -->
                            </div> <!-- .col-md-->
                            <div class="col-md-6">
                                <div class="card shadow bg-success text-center mb-4">
                                    <div class="card-body p-5">
                                        <span class="circle circle-md bg-success-light">
                                            <i class="fe fe-file-plus fe-24 text-white"></i>
                                        </span>
                                        <h3 class="h4 mt-4 mb-1 text-white">Apply for Admission</h3>
                                        <p class="text-white mb-4">Ready to take the first step towards securing a bright future for your child? Start our easy online application process today and take the first step towards joining our school community.</p>
                                        <a href="chat-select.php" class="btn btn-lg bg-success-light text-white" data-toggle="modal" data-target="#startModal">Start Application<i class="fe fe-arrow-right fe-16 ml-2"></i></a>
                                    </div> <!-- .card-body -->
                                </div> <!-- .card -->
                            </div> <!-- .col-md-->

                        </div> <!-- .row -->
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
                                        <div class="squircle bg-primary justify-content-center">
                                            <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                                        </div>
                                        <p class="text-primary">Dashboard</p>
                                    </a>
                                </div>
                                <div class="col-6 text-center">
                                    <a href="#" style="text-decoration: none;" class="text-success">
                                        <div class="squircle bg-success justify-content-center">
                                            <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                                        </div>
                                        <p>Academics</p>
                                    </a>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6 text-center">
                                    <a href="lms" style="text-decoration: none;">
                                        <div class="squircle bg-primary justify-content-center">
                                            <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                                        </div>
                                        <p class="text-primary">E-Learning</p>
                                    </a>
                                </div>
                                <div class="col-6 text-center">
                                    <a href="messages" style="text-decoration: none;">
                                        <div class="squircle bg-primary justify-content-center">
                                            <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                                        </div>
                                        <p class="text-primary">Messages</p>
                                    </a>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6 text-center">
                                    <a href="shop" style="text-decoration: none;">
                                        <div class="squircle bg-primary justify-content-center">
                                            <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                                        </div>
                                        <p class="text-primary">Shop</p>
                                    </a>
                                </div>
                                <div class="col-6 text-center">
                                    <a href="hr/" style="text-decoration: none;">
                                        <div class="squircle bg-primary justify-content-center text-white">
                                            <i class="fe fe-users fe-32 align-self-center"></i>
                                        </div>
                                        <p class="text-primary">HR</p>
                                    </a>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6 text-center">
                                    <a href="assessments" style="text-decoration: none;">
                                        <div class="squircle bg-primary justify-content-center">
                                            <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                                        </div>
                                        <p class="text-primary">Assessments</p>
                                    </a>
                                </div>
                                <div class="col-6 text-center">
                                    <a href="settings" style="text-decoration: none;">
                                        <div class="squircle bg-primary justify-content-center">
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

            <!-- Check Status -->
            <div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="checkModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="application-status.php" method="post">
                            <div class="modal-header justify-content-center">
                                <h5 class="modal-title text-center" id="checkModalTitle">Check Application Status</h5>
                            </div>
                            <div class="modal-body">
                                <p>Enter your application reference number (sent to your email at the start of your application process) to check the status of your application.</p>
                                <input type="text" name="ref" id="ref" class="form-control w-100" required placeholder="GHA_1720248555">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn mb-2 btn-primary w-100">Check Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Start Modal -->
            <div class="modal fade" id="startModal" tabindex="-1" role="dialog" aria-labelledby="startModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h5 class="modal-title text-center" id="startModalTitle">Start Application</h5>
                        </div>
                        <form id="start-new">
                            <div class="modal-body">
                                <p>Enter your email to receive your application reference number and subsiquent update on your update application.</p>
                                <input type="email" name="email" id="email" class="form-control w-100" required placeholder="example@email.com">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn mb-2 btn-primary w-100">Start An Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Start success Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h5 class="modal-title text-center" id="successModalTitle">Start Application</h5>
                        </div>
                        <form id="proceed-new" action="application.php">
                            <div class="modal-body">
                                <p class="text-center">Your application has been initialised successfully. Here if your reference number below. A copy of the reference number has been sent to your email address. Please click proceed to start filling the form.</p>
                                <input type="text" disabled name="ref" id="ref_number" class="form-control w-100 text-center" required placeholder="">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn mb-2 btn-primary w-100">Proceed</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Loading Modal -->
            <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="card col-12 loader">
                        <div class="mt-4" style="align-self: center">
                            <div class="logo mb-3">
                                <img src="logo.jpg" alt="Grit Hall Academy Logo">
                                <div class="clock">
                                    <div class="hand hour"></div>
                                    <div class="hand minute"></div>
                                </div>
                            </div>
                            <strong>Proccessing <span class="dot-flashing"></span></strong>
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
            $('#start-new').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Serialize form data
                var formData = $(this).serialize();

                // Submit form data via AJAX
                $.ajax({
                    url: 'start-application.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loadingModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#startModal').modal('hide')
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#loadingModal').modal('hide');

                            if (response.success) {
                                var ref = response.ref;
                                document.getElementById("ref_number").value = ref;

                                $('#successModal').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });
                            }
                        }, 500);
                    },
                    error: function(xhr, status, error) {
                        $('#loadingModal').modal('hide');
                        console.error(xhr, status, error);
                        // Handle errors if any
                    }
                });
            });
        });
    </script>
</body>

</html>