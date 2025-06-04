<?php
// Start or resume the session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Check if user ID and email session variables are not set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
	// Redirect to login page
	header("Location: ../login.php");
	exit();
} elseif ($_SESSION['admin_rights'] != 1) {
	// Unset all of the session variables
	header("Location: ../access-denied.php");
	exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "rinda_ams";

try {
	$pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
	error_log("Database Connection Error: " . $e->getMessage());
	die("Connection failed: " . $e->getMessage());
}

try {
	$query_session = "SELECT * FROM `general_settings`";
	$stmt_session = $pdo->query($query_session);
	$session_row = $stmt_session->fetch();
	
	if ($session_row) {
		$session = $session_row['curr_session'];
		$curr_session = $session_row['curr_session'];
		$term = $session_row['term_id'];
		$term_name = $session_row['curr_term'];
		$school_name = $session_row['school_name'];
		$school_email = $session_row['email'];
		$school_address = $session_row['address'];
		$days_opened = $session_row['days_opened'];
	} else {
		error_log("No general settings found in database");
	}
} catch (PDOException $e) {
	error_log("Error fetching general settings: " . $e->getMessage());
}

// Set user session variables
$user_id = $_SESSION['user_id'] ?? null;
$full_name = isset($_SESSION['first_name'], $_SESSION['last_name']) ? 
	$_SESSION['first_name'] . ' ' . $_SESSION['last_name'] : '';
$account_type = $_SESSION['account_type'] ?? '';
$gender = $_SESSION['gender'] ?? '';

$api_key = 'uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf';
