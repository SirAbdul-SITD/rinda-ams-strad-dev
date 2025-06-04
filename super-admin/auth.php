<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['email']);
}

/**
 * Check if user has admin rights
 * @return bool
 */
function hasAdminRights() {
    return isset($_SESSION['admin_rights']) && $_SESSION['admin_rights'] == 1;
}

/**
 * Check if user has HR rights
 * @return bool
 */
function hasHRRights() {
    return isset($_SESSION['hr_rights']) && $_SESSION['hr_rights'] == 1;
}

/**
 * Require user to be logged in
 * Redirects to login page if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: ../login.php");
        exit();
    }
}

/**
 * Require admin rights
 * Redirects to access denied page if not admin
 */
function requireAdmin() {
    requireLogin();
    if (!hasAdminRights()) {
        header("Location: ../access-denied.php");
        exit();
    }
}

/**
 * Require HR rights
 * Redirects to access denied page if not HR
 */
function requireHR() {
    requireLogin();
    if (!hasHRRights()) {
        header("Location: ../access-denied.php");
        exit();
    }
}

// Check if user is logged in and has appropriate rights
if (!isLoggedIn()) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
    exit();
} elseif (!hasAdminRights() && !hasHRRights()) {
    header("Location: ../access-denied.php");
    exit();
} 