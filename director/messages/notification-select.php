<?php
setcookie('type', '', time() - 3600, '/'); // set path to root
setcookie('content', '', time() - 3600, '/');
setcookie('subject', '', time() - 3600, '/');
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Group | Rinda AMS</title>
    <style>
        body {
            height: 100vh;
        }
        .selection {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
           
            margin: 0%;
            padding-left: 10%;
            padding-right: 10%;
        }

        .selection__title {
            font-size: 24px;
            margin: 20px;
        }

        .selection__items {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            justify-content: center;
        }

        .select-card {
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s, transform 0.2s;
            cursor: pointer;
            position: relative;
            border: 2px solid #fff;
            /* Add a border for the default state */
        }

        .select-card:hover {
            background-color: olive;
            color: #fff;
            transform: scale(1.02);
        }

        .select-card__input {
            display: none;
        }

        /* Style select-card when the input is checked */
        .select-card__input:checked+.select-card__label {
            color: #14a39a;
        }

        .select-card__label {
            padding: 20px;
        }

        .select-card__label__title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .select-card__label p {
            font-size: 14px;
            margin-top: 10px;
        }

        .checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            background-color: #fff;
            border: 2px solid #14a39a;
            border-radius: 50%;
            cursor: pointer;
        }

        .select-card__input:checked+.select-card__label .checkbox::before {
            content: "";
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 2px;
            height: 6px;
            border: solid coral;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
            border-radius: 2px;
            transition: transform 0.2s ease;
            transform-origin: center;
        }

        /* Rotate the tick icon when checked */
        .select-card__input:checked+.select-card__label .checkbox::before {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        #submit {
            text-decoration: none;
            width: 60%;
            height: 7%;
            border-radius: 8px;
            color: #14a39a;
            font-size: 16px;
            border: none;
            border-color: olivedrab;
            border-width: 0%;
            background-color: white;
        }

        #submit:hover {
            border: none;
            border-width: 0%;
            border-color: olivedrab;
            background-color: olive;
            color: #fff;
            transition: transform 0.2s ease;
            transform: scale(1.02);
        }
    </style>
</head>

<body>
    
<form data-v-3a6f080c="" class="selection" action="compile-message.php" method="POST">
    <h1 data-v-3a6f080c="" class="selection__title">
    Which group would you like to send notification to?
    </h1>
    <div data-v-3a6f080c="" class="selection__items selection__items--wrap cards">
        <label class="select-card selection__item" data-v-3a6f080c="" for="select-card__1fw0ahc0v">
            <input name="transfer-select" type="radio" class="select-card__input" value="parents" id="select-card__1fw0ahc0v">
            <label class="select-card__label" for="select-card__1fw0ahc0v">
                <h3 class="select-card__label__title">Send to Parents</h3>
                <p>Send notifications to parents regarding important updates and events.</p>
                <div class="checkbox"></div>
            </label>
        </label>
        <label class="select-card selection__item" data-v-3a6f080c="" for="select-card__oy6wafzri">
            <input name="transfer-select" type="radio" class="select-card__input" value="teachers" id="select-card__oy6wafzri">
            <label class="select-card__label" for="select-card__oy6wafzri">
                <h3 class="select-card__label__title">Send to Teachers</h3>
                <p>Notify teachers about schedule changes, meetings, and important announcements.</p>
                <div class="checkbox"></div>
            </label>
        </label>
        <label class="select-card selection__item" data-v-3a6f080c="" for="select-card__x9cwa4e7j">
            <input name="transfer-select" type="radio" class="select-card__input" value="staffs" id="select-card__x9cwa4e7j">
            <label class="select-card__label" for="select-card__x9cwa4e7j">
                <h3 class="select-card__label__title">Send to Staffs</h3>
                <p>Send notifications to staff regarding policy updates, announcements, and events.</p>
                <div class="checkbox"></div>
            </label>
        </label>
        <label class="select-card selection__item" data-v-3a6f080c="" for="select-card__48hcc8mnb">
            <input name="transfer-select" type="radio" class="select-card__input" value="students" id="select-card__48hcc8mnb">
            <label class="select-card__label" for="select-card__48hcc8mnb">
                <h3 class="select-card__label__title">Send to Students</h3>
                <p>Notify students about upcoming exams, assignments, and other academic matters.</p>
                <div class="checkbox"></div>
            </label>
        </label>
    </div>
    <br>
    <button id="submit" class="selection__action form-control form-control-lg" type="submit" autofocus="autofocus" data-v-3a6f080c="">
        Proceed to compile notification
    </button>
</form>

<script>
    document.getElementById("submit").addEventListener("click", function(event) {
        var selectedOption = document.querySelector('input[name="transfer-select"]:checked').value;
        switch (selectedOption) {
            case "parents":
                window.location.href = "parent-notification.php";
                break;
            case "teachers":
                window.location.href = "teacher-notification.php";
                break;
            case "staffs":
                window.location.href = "staff-notification.php";
                break;
            case "students":
                window.location.href = "student-notification.php";
                break;
            default:
                break;
        }
        event.preventDefault();
    });
</script>

</body>

</html>