<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Super Admin');

$error = '';
$pm_list = [];
$result_pm = $conn->query("SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username");
if ($result_pm) {
    while($row = $result_pm->fetch_assoc()) {
        $pm_list[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $pm_id_value = NULL;
    if ($role == 'Team Member' && !empty($_POST['project_manager_id'])) {
        $pm_id_value = (int)$_POST['project_manager_id'];
    }

    if (empty($username) || empty($password) || empty($role)) {
        $error = "Semua field wajib diisi.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        if ($role == 'Team Member') {
            $sql = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $hashed_password, $role, $pm_id_value);
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $hashed_password, $role);
        }

        try {
            if ($stmt->execute()) {

                header("Location: users_view.php?status=add_success");
                exit(); 
            }
        } catch (\mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = "Gagal. Username <strong>$username</strong> sudah digunakan.";
            } else {
                $error = "Gagal menambahkan pengguna: " . $e->getMessage();
            }
        }
        $stmt->close();
    }
}

$page_title = "Tambah Pengguna Baru";
include '../includes/header.php';
?>
<h2>Tambah Pengguna Baru</h2>
<?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>

<form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    
    <label for="role">Role:</label>
    <select name="role" id="role" onchange="togglePmId()">
        <option value="Project Manager">Project Manager</option>
        <option value="Team Member">Team Member</option>
    </select>
    
    <div id="pm_id_group" style="display: none;">
        <label for="project_manager_id">Project Manager:</label>
        <select name="project_manager_id">
            <option value="">-- Pilih Project Manager --</option>
            <?php foreach ($pm_list as $pm): ?>
                <option value="<?php echo $pm['id']; ?>"><?php echo htmlspecialchars($pm['username']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-actions">
        <button type="submit">Tambah Pengguna</button>
        <a href="users_view.php" class="btn-secondary">Kembali</a>
    </div>
</form>

<script>
function togglePmId() {
    var role = document.getElementById('role').value;
    var pmGroup = document.getElementById('pm_id_group');
    pmGroup.style.display = (role === 'Team Member') ? 'block' : 'none';
}
togglePmId();
</script>

<?php
include '../includes/footer.php';
$conn->close();
?>