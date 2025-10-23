<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager'); 

$manager_id = $_SESSION['user_id'];
$task_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';
$task = null;
$project_list = [];
$team_member_list = [];

$result_proj = $conn->query("SELECT id, nama_proyek FROM projects WHERE manager_id = $manager_id ORDER BY nama_proyek");
while($row = $result_proj->fetch_assoc()) $project_list[] = $row;
$result_tm = $conn->query("SELECT id, username FROM users WHERE role = 'Team Member' AND project_manager_id = $manager_id ORDER BY username");
while($row = $result_tm->fetch_assoc()) $team_member_list[] = $row;


$sql_select = "SELECT t.* FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("ii", $task_id, $manager_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();

if ($result_select->num_rows == 0) {
    die("Tugas tidak ditemukan atau Anda tidak berhak mengeditnya.");
}
$task = $result_select->fetch_assoc();
$stmt_select->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = $_POST['deskripsi'];
    $project_id = (int)$_POST['project_id'];
    $assigned_to = (int)$_POST['assigned_to'];
    $status = $_POST['status'];

    $sql_update = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, project_id = ?, assigned_to = ?, status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssiisi", $nama_tugas, $deskripsi, $project_id, $assigned_to, $status, $task_id);

    if ($stmt_update->execute()) {
        $success = "Tugas berhasil diupdate!";
        $task = ['nama_tugas' => $nama_tugas, 'deskripsi' => $deskripsi, 'project_id' => $project_id, 'assigned_to' => $assigned_to, 'status' => $status];
    } else {
        $error = "Gagal mengupdate tugas: " . $stmt_update->error;
    }
    $stmt_update->close();
}

$page_title = "Edit Tugas";
include '../includes/header.php';
?>

<h2>Edit Tugas: <?php echo htmlspecialchars($task['nama_tugas']); ?></h2>

<?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>

<form method="POST" action="">
    <label for="nama_tugas">Nama Tugas:</label>
    <input type="text" name="nama_tugas" value="<?php echo htmlspecialchars($task['nama_tugas']); ?>" required><br><br>

    <label for="deskripsi">Deskripsi:</label>
    <textarea name="deskripsi"><?php echo htmlspecialchars($task['deskripsi']); ?></textarea><br><br>

    <label for="project_id">Proyek:</label>
    <select name="project_id" required>
        <?php foreach ($project_list as $proj): ?>
            <option value="<?php echo $proj['id']; ?>" <?php echo ($task['project_id'] == $proj['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($proj['nama_proyek']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="assigned_to">Tugaskan Kepada:</label>
    <select name="assigned_to" required>
        <?php foreach ($team_member_list as $tm): ?>
            <option value="<?php echo $tm['id']; ?>" <?php echo ($task['assigned_to'] == $tm['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($tm['username']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    
    <label for="status">Status:</label>
    <select name="status" required>
        <?php $statuses = ['belum', 'proses', 'selesai']; ?>
        <?php foreach ($statuses as $s): ?>
            <option value="<?php echo $s; ?>" <?php echo ($task['status'] == $s) ? 'selected' : ''; ?>><?php echo ucfirst($s); ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Update Tugas</button>
</form>

<?php 
include '../includes/footer.php';
$conn->close();
?>