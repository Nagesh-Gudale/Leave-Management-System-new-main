<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  } 
function checkLogin() {
    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: login.php");
    //     exit();
    // }
    isset($_SESSION['user_id']);

}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

function isHOD() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'HOD';
}
function isPrincipal() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'principal';
}

function isStaff() {
    return isset($_SESSION['role']) && ($_SESSION['role'] != 'hod' || $_SESSION['role'] != 'admin') ;
}
?>
