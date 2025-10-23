<?php
session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    $redirect_path = 'login.php'; 

    if ($role == 'Super Admin') {
        $redirect_path = 'admin/dashboard.php';
    } elseif ($role == 'Project Manager') {
        $redirect_path = 'manajer/dashboard.php'; 
    } elseif ($role == 'Team Member') {
        $redirect_path = 'member/dashboard.php';
    }

    header("Location: " . $redirect_path);
    exit();

} else {
    header("Location: login.php");
    exit();
}
?>