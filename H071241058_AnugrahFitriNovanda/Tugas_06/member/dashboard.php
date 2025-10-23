<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Team Member');

$member_id = $_SESSION['user_id'];
$page_title = "Dashboard Tugas Saya";
include '../includes/header.php';
?>
<h2>Daftar Tugas yang Ditugaskan Kepada Saya</h2>
<p>Anda hanya dapat melihat dan mengubah status tugas Anda di sini.</p>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID Tugas</th>
                <th>Nama Tugas</th>
                <th>Proyek</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT t.id, t.nama_tugas, t.deskripsi, t.status, p.nama_proyek
                    FROM tasks t
                    JOIN projects p ON t.project_id = p.id
                    WHERE t.assigned_to = ?
                    ORDER BY t.id ASC"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_tugas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_proyek']) . "</td>";
                    
                    echo '<td>
                            <button class="view-desc-btn" 
                                    data-task-name="' . htmlspecialchars($row['nama_tugas']) . '" 
                                    data-description="' . htmlspecialchars($row['deskripsi']) . '">
                                Lihat Detail
                            </button>
                          </td>';

                    echo "<td><strong>" . ucfirst($row['status']) . "</strong></td>";
                    echo '<td>
                            <a href="task_update_status.php?id=' . $row['id'] . '">Ubah Status</a>
                          </td>';
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="6">Belum ada tugas yang ditugaskan kepada Anda.</td></tr>';
            }
            $stmt->close();
            ?>
        </tbody>
    </table>
</div>

<div id="descriptionModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h3 id="modalTaskName"></h3>
        <p id="modalTaskDescription"></p>
    </div>
</div>

<?php
include '../includes/footer.php';
$conn->close();
?>