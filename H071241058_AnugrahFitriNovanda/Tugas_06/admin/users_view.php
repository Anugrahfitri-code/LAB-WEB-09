<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Super Admin');
$page_title = "Kelola Pengguna";
include '../includes/header.php';
?>
<h2>Kelola Project Manager & Team Member</h2>
<a href="users_add.php" class="btn-add">Tambah Pengguna Baru</a>
<?php

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'add_success') {
        echo '<p class="success">Pengguna baru berhasil ditambahkan!</p>';
    } elseif ($_GET['status'] == 'delete_success') {
        echo '<p class="success">Pengguna berhasil dihapus!</p>';
    }
}
?>
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Project Manager</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT
                    u.`id`, u.`username`, u.`role`,
                    pm.`username` AS manager_name
                    FROM `users` u
                    LEFT JOIN `users` pm ON u.`project_manager_id` = pm.`id`
                    WHERE u.`role` != 'Super Admin'
                    ORDER BY u.`role`, u.`username`";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $nomor_urut = 1; 
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . sprintf("P%02d", $nomor_urut) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>" . ($row['manager_name'] ? htmlspecialchars($row['manager_name']) : '-') . "</td>";

                    if ($row['id'] != $_SESSION['user_id']) {
                        echo '<td><a href="users_delete.php?id=' . $row['id'] . '" onclick="return confirm(\'Yakin menghapus pengguna ini?\')">Hapus</a></td>';
                    } else {
                        echo '<td>-</td>';
                    }
                    echo "</tr>";
                    $nomor_urut++; 
                }
            } else {
                echo '<tr><td colspan="5">Tidak ada pengguna (PM/TM) yang terdaftar.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include '../includes/footer.php';
$conn->close();
?>