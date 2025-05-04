<?php
// // Start or resume the session
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


 $servername = "localhost";
 $username = "riidalms_gha";
 $password = "K_TcmAcE?%_EZwqtkY";
 $database = "riidalms_gha";


// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "gha";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
