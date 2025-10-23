<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager');
$manager_id = $_SESSION['user_id'];
$page_title = "Daftar Proyek Saya";
include '../includes/header.php';
?>
<h2>Proyek Saya</h2>
<a href="projects_add.php" class="btn-add">Tambah Proyek Baru</a>
<?php
if (isset($_GET['status']) && $_GET['status'] == 'success') echo '<p class="success">Operasi berhasil dilakukan!</p>';
?>
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Proyek</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, nama_proyek, tanggal_mulai, tanggal_selesai FROM projects WHERE manager_id = ? ORDER BY id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $manager_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_proyek']) . "</td>";
                    echo "<td>" . $row['tanggal_mulai'] . "</td>";
                    echo "<td>" . ($row['tanggal_selesai'] ?? 'Belum Selesai') . "</td>";
                    echo '<td>
                            <a href="projects_edit.php?id=' . $row['id'] . '">Edit</a> |
                            <a href="projects_delete.php?id=' . $row['id'] . '" onclick="return confirm(\'Yakin hapus proyek ini dan semua tugasnya?\')">Hapus</a>
                          </td>';
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="5">Anda belum memiliki proyek.</td></tr>';
            }
            $stmt->close();
            ?>
        </tbody>
    </table>
</div>
<?php
include '../includes/footer.php';
$conn->close();
?>