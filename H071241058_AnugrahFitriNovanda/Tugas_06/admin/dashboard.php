<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Super Admin');
include '../includes/header.php';

$total_users = $conn->query("SELECT COUNT(id) AS total FROM users")->fetch_assoc()['total'];
$total_projects = $conn->query("SELECT COUNT(id) AS total FROM projects")->fetch_assoc()['total'];

$recent_users_sql = "SELECT username, role FROM users WHERE role != 'Super Admin' ORDER BY id DESC LIMIT 5";
$recent_users_result = $conn->query($recent_users_sql);
?>

<div class="dashboard-header">
    <h1>Selamat Datang Kembali, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Ini adalah ringkasan sistem manajemen proyek Anda.</p>
</div>

<div class="dashboard-grid">
    <div class="main-column">
        <h2>Ringkasan Sistem</h2>
        <div class="summary-cards-new">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(0, 207, 232, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00CFE8" class="stat-svg">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-title">Total Pengguna</span>
                    <span class="stat-value"><?php echo $total_users; ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(139, 92, 246, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#8B5CF6" class="stat-svg">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-title">Total Proyek</span>
                    <span class="stat-value"><?php echo $total_projects; ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="side-column">
        <div class="action-card">
            <h2>Aksi Cepat</h2>
            <a href="users_add.php" class="action-link"><i data-feather="user-plus"></i> Tambah Pengguna Baru</a>
            <a href="projects_all_view.php" class="action-link"><i data-feather="folder"></i> Lihat Semua Proyek</a>
        </div>
        
        <div class="action-card">
            <h2>Pengguna Terbaru</h2>
            <ul class="recent-list">
                <?php
                if ($recent_users_result->num_rows > 0) {
                    while($user = $recent_users_result->fetch_assoc()) {
                        echo '<li>';
                        echo '  <div class="user-avatar">' . strtoupper(substr($user['username'], 0, 1)) . '</div>';
                        echo '  <div class="user-details">';
                        echo '      <span class="user-name">' . htmlspecialchars($user['username']) . '</span>';
                        echo '      <span class="user-role">' . $user['role'] . '</span>';
                        echo '  </div>';
                        echo '</li>';
                    }
                } else {
                    echo '<li>Tidak ada pengguna lain.</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
$conn->close();
?>