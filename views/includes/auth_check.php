<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "You must be logged in to access this page";
        header("Location: ../views/user/login.php");
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        $_SESSION['error'] = "Access denied. Admin privileges required.";
        header("Location: ../index.php");
        exit();
    }
}

function checkAuthenticated() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}
?>