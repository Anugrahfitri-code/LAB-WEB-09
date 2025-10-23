<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Team Member');

$member_id = $_SESSION['user_id'];
$task_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';
$task = null;
$allowed_statuses = ['belum', 'proses', 'selesai'];

$sql_select = "SELECT t.nama_tugas, t.status FROM tasks t WHERE t.id = ? AND t.assigned_to = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("ii", $task_id, $member_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
if ($result_select->num_rows == 0) {
    die("Tugas tidak ditemukan atau Anda tidak ditugaskan pada tugas ini.");
}
$task = $result_select->fetch_assoc();
$stmt_select->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['status'];
    if (!in_array($new_status, $allowed_statuses)) {
        $error = "Status yang dipilih tidak valid.";
    } else {
        $sql_update = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sii", $new_status, $task_id, $member_id);
        if ($stmt_update->execute()) {
            $success = "Status tugas berhasil diperbarui menjadi " . ucfirst($new_status) . "!";
            $task['status'] = $new_status; 
        } else {
            $error = "Gagal memperbarui status: " . $stmt_update->error;
        }
        $stmt_update->close();
    }
}

$page_title = "Ubah Status Tugas";
include '../includes/header.php';
?>
<h2>Ubah Status Tugas: <?php echo htmlspecialchars($task['nama_tugas']); ?></h2>

<?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>

<form method="POST" action="task_update_status.php?id=<?php echo $task_id; ?>">
    <label for="status">Status Saat Ini: <strong><?php echo ucfirst($task['status']); ?></strong></label>
    
    <label for="status-new">Ubah Status Menjadi:</label>
    <select name="status" id="status-new" required>
        <?php foreach ($allowed_statuses as $s): ?>
            <option value="<?php echo $s; ?>" <?php if ($task['status'] == $s) echo 'disabled'; ?>>
                <?php echo ucfirst($s); ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <div class="form-actions">
        <button type="submit">Simpan Status</button>
        <a href="dashboard.php" class="btn-secondary">Kembali</a>
    </div>
</form>

<?php
include '../includes/footer.php';
$conn->close();
?>