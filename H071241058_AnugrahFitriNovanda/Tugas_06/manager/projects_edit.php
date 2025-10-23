<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager'); 

$manager_id = $_SESSION['user_id'];
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';
$project = null;

$stmt_select = $conn->prepare("SELECT * FROM projects WHERE id = ? AND manager_id = ?");
$stmt_select->bind_param("ii", $project_id, $manager_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();

if ($result_select->num_rows == 0) {
    die("Proyek tidak ditemukan atau Anda tidak berhak mengeditnya.");
}
$project = $result_select->fetch_assoc();
$stmt_select->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_proyek = trim($_POST['nama_proyek']);
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;

    if (empty($nama_proyek) || empty($tanggal_mulai)) {
        $error = "Nama Proyek dan Tanggal Mulai wajib diisi.";
    } else {
        $sql = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?";
        $stmt_update = $conn->prepare($sql);
        
        $stmt_update->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id, $manager_id);

        if ($stmt_update->execute()) {
            $success = "Proyek berhasil diupdate!";
            $project['nama_proyek'] = $nama_proyek;
            $project['deskripsi'] = $deskripsi;
            $project['tanggal_mulai'] = $tanggal_mulai;
            $project['tanggal_selesai'] = $tanggal_selesai;
        } else {
            $error = "Gagal mengupdate proyek: " . $stmt_update->error;
        }
        $stmt_update->close();
    }
}

$page_title = "Edit Proyek: " . htmlspecialchars($project['nama_proyek']);
include '../includes/header.php';
?>

<h2>Edit Proyek: <?php echo htmlspecialchars($project['nama_proyek']); ?></h2>

<?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>

<form method="POST" action="">
    <label for="nama_proyek">Nama Proyek:</label>
    <input type="text" name="nama_proyek" value="<?php echo htmlspecialchars($project['nama_proyek']); ?>" required><br><br>

    <label for="deskripsi">Deskripsi:</label>
    <textarea name="deskripsi"><?php echo htmlspecialchars($project['deskripsi']); ?></textarea><br><br>

    <label for="tanggal_mulai">Tanggal Mulai:</label>
    <input type="date" name="tanggal_mulai" value="<?php echo $project['tanggal_mulai']; ?>" required><br><br>

    <label for="tanggal_selesai">Tanggal Selesai (Opsional):</label>
    <input type="date" name="tanggal_selesai" value="<?php echo $project['tanggal_selesai']; ?>"><br><br>

    <button type="submit">Update Proyek</button>
</form>

<?php 
include '../includes/footer.php';
$conn->close();
?>