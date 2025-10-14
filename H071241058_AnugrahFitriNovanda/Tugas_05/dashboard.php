<?php
session_start();
require 'data.php'; // Membutuhkan data semua pengguna untuk ditampilkan oleh admin

// Perlindungan Halaman: Jika tidak ada session, redirect ke login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$logged_in_user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .logout { color: red; text-decoration: none; }
        h1, h2 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .user-data-table td:first-child { font-weight: bold; width: 150px; }
    </style>
</head>
<body>

    <div class="header">
        <?php
        // Tampilan Dinamis Berdasarkan Peran
        if ($logged_in_user['username'] === 'adminxxx') {
            echo "<h1>Selamat Datang, Admin!</h1>";
        } else {
            echo "<h1>Selamat Datang, " . htmlspecialchars($logged_in_user['name']) . "!</h1>";
        }
        ?>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <hr>

    <?php
    // Jika yang login adalah admin
    if ($logged_in_user['username'] === 'adminxxx') :
    ?>
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
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php
    // Jika yang login adalah user biasa
    else :
    ?>
        <h2>Data Anda</h2>
        <table class="user-data-table">
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td><?= htmlspecialchars($logged_in_user['name']) ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><?= htmlspecialchars($logged_in_user['username']) ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?= htmlspecialchars($logged_in_user['email']) ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?= htmlspecialchars($logged_in_user['gender']) ?></td>
                </tr>
                <tr>
                    <td>Fakultas</td>
                    <td><?= htmlspecialchars($logged_in_user['faculty']) ?></td>
                </tr>
                <tr>
                    <td>Angkatan</td>
                    <td><?= htmlspecialchars($logged_in_user['batch']) ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>