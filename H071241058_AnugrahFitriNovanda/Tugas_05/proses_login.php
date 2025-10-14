<?php
session_start();
require 'data.php'; // Mengambil data pengguna dari file data.php

// Menerima data dari form
$username_input = $_POST['username'];
$password_input = $_POST['password'];

$user_found = null;

// 1. Validasi: Cari pengguna berdasarkan username
foreach ($users as $user) {
    if ($user['username'] === $username_input) {
        $user_found = $user;
        break;
    }
}

// 2. Verifikasi Password
if ($user_found) {
    // Jika username ditemukan, verifikasi password
    if (password_verify($password_input, $user_found['password'])) {
        // Jika password cocok, buat session dan redirect ke dashboard
        $_SESSION['user'] = $user_found;
        header('Location: dashboard.php');
        exit();
    }
}

// Jika username tidak ditemukan atau password salah
$_SESSION['error'] = 'Username atau password salah!';
header('Location: login.php');
exit();
?>