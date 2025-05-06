<?php
// // Start or resume the session
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



// Check if user ID and email session variables are not set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    // Redirect to login page
    header("Location: login.html");
    exit();
}




$servername = "localhost";
$username = "root";
$password = "";
$database = "rinda_ams";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


$school_name = 'Rinda Academy';
$school_address = '9022 Suspendisse Rd. High Wycombe 9022 Suspendisse Rd. High Wycombe';
$school_email = 'gha@stradafrica.com.ng';
$_SESSION['user'] = '1';

?>