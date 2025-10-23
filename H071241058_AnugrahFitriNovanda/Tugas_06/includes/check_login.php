<?php
session_start();

function check_login(...$allowed_roles) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header("Location: ../login.php");
        exit();
    }

    if (!in_array($_SESSION['role'], $allowed_roles)) {
        die("
            <!DOCTYPE html>
            <html lang='id'>
            <head><title>Akses Ditolak</title></head>
            <body>
                <div style='text-align: center; margin-top: 100px; font-family: sans-serif;'>
                    <h1>🛑 Akses Ditolak</h1>
                    <p>Anda tidak memiliki izin (Role: " . htmlspecialchars($_SESSION['role']) . ") untuk melihat halaman ini.</p>
                    <p><a href='../login.php'>Kembali ke Halaman Login</a></p>
                </div>
            </body>
            </html>
        ");
    }
}
?>