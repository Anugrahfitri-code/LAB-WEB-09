<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager');
$manager_id = $_SESSION['user_id'];
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_proyek = trim($_POST['nama_proyek']);
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;

    if (empty($nama_proyek) || empty($tanggal_mulai)) {
        $error = "Nama Proyek dan Tanggal Mulai wajib diisi.";
    } else {
        $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);
        
        if ($stmt->execute()) {
            $success = "Proyek '$nama_proyek' berhasil ditambahkan!";
        } else {
            $error = "Gagal menambahkan proyek: " . $stmt->error;
        }
        $stmt->close();
    }
}

$page_title = "Tambah Proyek";
include '../includes/header.php';
?>

<h2>Tambah Proyek Baru</h2>
<?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>

<form method="POST" action="">
    <label for="nama_proyek">Nama Proyek:</label>
    <input type="text" name="nama_proyek" required>

    <label for="deskripsi">Deskripsi:</label>
    <textarea name="deskripsi"></textarea>

    <label for="tanggal_mulai">Tanggal Mulai:</label>
    <input type="date" name="tanggal_mulai" required>

    <label for="tanggal_selesai">Tanggal Selesai (Opsional):</label>
    <input type="date" name="tanggal_selesai">

    <div class="form-actions">
        <button type="submit">Simpan Proyek</button>
        <a href="projects_view.php" class="btn-secondary">Kembali</a>
    </div>
</form>

<?php
include '../includes/footer.php';
$conn->close();
?>