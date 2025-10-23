<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager');
$manager_id = $_SESSION['user_id'];
$error = '';
$success = '';
$project_list = [];
$team_member_list = [];

$stmt_proj = $conn->prepare("SELECT id, nama_proyek FROM projects WHERE manager_id = ? ORDER BY nama_proyek");
$stmt_proj->bind_param("i", $manager_id);
$stmt_proj->execute();
$result_proj = $stmt_proj->get_result();
while($row = $result_proj->fetch_assoc()) {
    $project_list[] = $row;
}
$stmt_proj->close();

$stmt_tm = $conn->prepare("SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = ? ORDER BY username");
$stmt_tm->bind_param("i", $manager_id);
$stmt_tm->execute();
$result_tm = $stmt_tm->get_result();
while($row = $result_tm->fetch_assoc()) {
    $team_member_list[] = $row;
}
$stmt_tm->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = $_POST['deskripsi'];
    $project_id = (int)$_POST['project_id'];
    $assigned_to = (int)$_POST['assigned_to'];

    if (empty($nama_tugas) || $project_id == 0 || $assigned_to == 0) {
        $error = "Nama Tugas, Proyek, dan Penugasan wajib diisi.";
    } else {
        $sql = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);
        if ($stmt->execute()) {
            $success = "Tugas '$nama_tugas' berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan tugas: " . $stmt->error;
        }
        $stmt->close();
    }
}

$page_title = "Tambah Tugas";
include '../includes/header.php';
?>
<h2>Tambah Tugas Baru</h2>
<?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>

<form method="POST" action="">
    <label for="nama_tugas">Nama Tugas:</label>
    <input type="text" name="nama_tugas" required>

    <label for="deskripsi">Deskripsi:</label>
    <textarea name="deskripsi"></textarea>

    <label for="project_id">Proyek (Hanya Proyek Anda):</label>
    <select name="project_id" required>
        <option value="">-- Pilih Proyek Anda --</option>
        <?php foreach ($project_list as $proj): ?>
            <option value="<?php echo $proj['id']; ?>"><?php echo htmlspecialchars($proj['nama_proyek']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="assigned_to">Tugaskan Kepada (Hanya TM di bawah Anda):</label>
    <select name="assigned_to" required>
        <option value="">-- Pilih Team Member --</option>
        <?php foreach ($team_member_list as $tm): ?>
            <option value="<?php echo $tm['id']; ?>"><?php echo htmlspecialchars($tm['username']); ?></option>
        <?php endforeach; ?>
    </select>

    <div class="form-actions">
        <button type="submit">Simpan Tugas</button>
        <a href="tasks_view.php" class="btn-secondary">Kembali</a>
    </div>
</form>

<?php
include '../includes/footer.php';
$conn->close();
?>