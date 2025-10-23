<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager'); 

$manager_id = $_SESSION['user_id'];
$page_title = "Daftar Tugas Tim";
include '../includes/header.php';
?>

<h2>Kelola Tugas Proyek</h2>

<a href="tasks_add.php" class="btn-add">Tambah Tugas Baru</a>

<table border="1" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Tugas</th>
            <th>Proyek</th>
            <th>Ditugaskan Kepada</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT t.id, t.nama_tugas, t.status, p.nama_proyek, u.username AS assigned_to_user 
                FROM tasks t
                JOIN projects p ON t.project_id = p.id
                JOIN users u ON t.assigned_to = u.id
                WHERE p.manager_id = ? 
                ORDER BY p.id, t.status";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_tugas']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_proyek']) . "</td>";
                echo "<td>" . htmlspecialchars($row['assigned_to_user']) . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo '<td>
                        <a href="tasks_edit.php?id=' . $row['id'] . '">Edit</a> | 
                        <a href="tasks_delete.php?id=' . $row['id'] . '" onclick="return confirm(\'Yakin hapus tugas ini?\')">Hapus</a>
                      </td>';
                echo "</tr>";
            }
        } else {
            echo '<tr><td colspan="6">Belum ada tugas di proyek Anda.</td></td>';
        }
        $stmt->close();
        ?>
    </tbody>
</table>

<?php 
include '../includes/footer.php';
$conn->close();
?>