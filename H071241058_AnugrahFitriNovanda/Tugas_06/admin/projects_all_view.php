<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Super Admin');
$page_title = "Lihat Semua Proyek";
include '../includes/header.php';
?>
<h2>Semua Proyek (Akses Super Admin)</h2>
<p>Anda dapat melihat semua proyek dari semua Project Manager di sini.</p>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID Proyek</th>
                <th>Nama Proyek</th>
                <th>Project Manager</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.id, p.nama_proyek, p.tanggal_mulai, p.tanggal_selesai,
                           u.username AS manager_name
                    FROM projects p
                    JOIN users u ON p.manager_id = u.id
                    ORDER BY p.id ASC"; 

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_proyek']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['manager_name']) . "</td>";
                    echo "<td>" . $row['tanggal_mulai'] . "</td>";
                    echo "<td>" . ($row['tanggal_selesai'] ?? '-') . "</td>";
                    echo '<td>
                            <a href="projects_delete_admin.php?id=' . $row['id'] . '" onclick="return confirm(\'Yakin hapus proyek ini? (Aksi ini menghapus semua tugas di dalamnya!)\')">Hapus</a>
                          </td>';
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="6">Belum ada proyek yang terdaftar.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include '../includes/footer.php';
$conn->close();
?>