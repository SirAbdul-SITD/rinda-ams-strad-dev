<?php
// // Start or resume the session
session_start();

ini_set('display_errors', 0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



// Check if user ID and email session variables are not set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
	// Redirect to login page
	header("Location: ../login.php");
	exit();
}





// $servername = "localhost";
// $username = "riidalms_gha_dev";
// $password = "=%6[qU$}GTD03-I3{N";
// $database = "riidalms_gha_dev";


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

$query_session = "SELECT * FROM `general_settings`";
$stmt_session = $pdo->query($query_session);
$session_row = $stmt_session->fetch(PDO::FETCH_ASSOC);
$session = $session_row['curr_session'];
$curr_session = $session_row['curr_session'];
$term = $session_row['term_id'];
$term_name = $session_row['curr_term'];
$school_name = $session_row['school_name'];
$school_email = $session_row['email'];
$school_address = $session_row['address'];
$days_opened = $session_row['days_opened'];


$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
$account_type = $_SESSION['account_type'];
$gender = $_SESSION['gender'];

$api_key = 'uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf';
