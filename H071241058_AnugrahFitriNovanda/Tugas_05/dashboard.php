<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$logged_in_user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>
                <?php if ($logged_in_user['username'] === 'adminxxx') : ?>
                    Selamat Datang, Admin!
                <?php else : ?>
                    Selamat Datang, <?= htmlspecialchars($logged_in_user['name']); ?>!
                <?php endif; ?>
            </h1>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>

        <?php if ($logged_in_user['username'] === 'adminxxx') : ?>
            <h2>Data Semua Pengguna</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']); ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        <?php else : ?>
            <h2>Data Anda</h2>
            <table class="user-data-table">
                <tbody>
                    <tr><td>Nama</td><td><?= htmlspecialchars($logged_in_user['name']); ?></td></tr>
                    <tr><td>Username</td><td><?= htmlspecialchars($logged_in_user['username']); ?></td></tr>
                    <tr><td>Email</td><td><?= htmlspecialchars($logged_in_user['email']); ?></td></tr>
                    <tr><td>Gender</td><td><?= htmlspecialchars($logged_in_user['gender']); ?></td></tr>
                    <tr><td>Fakultas</td><td><?= htmlspecialchars($logged_in_user['faculty']); ?></td></tr>
                    <tr><td>Angkatan</td><td><?= htmlspecialchars($logged_in_user['batch']); ?></td></tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>