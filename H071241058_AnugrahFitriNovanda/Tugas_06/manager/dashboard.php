<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager');
$manager_id = $_SESSION['user_id'];
$page_title = "Dashboard Project Manager";
include '../includes/header.php';

function generateAvatar($name, $id) {
    $initial = strtoupper(substr($name, 0, 1));
    $colors = ['#00CFE8', '#8B5CF6', '#28a745', '#FFC107', '#fd7e14', '#6610f2'];
    $color = $colors[$id % count($colors)];
    return '<div class="task-avatar" style="background-color: ' . $color . ';">' . $initial . '</div>';
}

$stmt_proj = $conn->prepare("SELECT COUNT(id) AS total FROM projects WHERE manager_id = ?");
$stmt_proj->bind_param("i", $manager_id);
$stmt_proj->execute();
$total_proyek = $stmt_proj->get_result()->fetch_assoc()['total'];
$stmt_proj->close();

$stmt_task = $conn->prepare("SELECT COUNT(t.id) AS total, SUM(CASE WHEN t.status = 'selesai' THEN 1 ELSE 0 END) AS selesai FROM tasks t JOIN projects p ON t.project_id = p.id WHERE p.manager_id = ?");
$stmt_task->bind_param("i", $manager_id);
$stmt_task->execute();
$task_stats = $stmt_task->get_result()->fetch_assoc();
$total_tugas = $task_stats['total'] ?? 0;
$tugas_selesai = $task_stats['selesai'] ?? 0;
$stmt_task->close();

$recent_projects_sql = "SELECT id, nama_proyek FROM projects WHERE manager_id = ? ORDER BY id DESC LIMIT 5";
$stmt_projects = $conn->prepare($recent_projects_sql);
$stmt_projects->bind_param("i", $manager_id);
$stmt_projects->execute();
$recent_projects_result = $stmt_projects->get_result();


$recent_tasks_sql = "SELECT t.id, t.nama_tugas, p.nama_proyek FROM tasks t JOIN projects p ON t.project_id = p.id WHERE p.manager_id = ? ORDER BY t.id DESC LIMIT 5";
$stmt_recent = $conn->prepare($recent_tasks_sql);
$stmt_recent->bind_param("i", $manager_id);
$stmt_recent->execute();
$recent_tasks_result = $stmt_recent->get_result();
?>

<div class="dashboard-header">
    <h1>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Siap untuk produktif hari ini? Berikut ringkasan proyek Anda.</p>
</div>

<div class="dashboard-grid">
    <div class="main-column">
        <h2>Ringkasan Proyek</h2>
        <div class="summary-cards-new">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(0, 207, 232, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00CFE8" class="stat-svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
                </div>
                <div class="stat-info"><span class="stat-title">Proyek Aktif</span><span class="stat-value"><?php echo $total_proyek; ?></span></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(139, 92, 246, 0.1);"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#8B5CF6" class="stat-svg"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" /></svg></div>
                <div class="stat-info"><span class="stat-title">Total Tugas</span><span class="stat-value"><?php echo $total_tugas; ?></span></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1);"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#28a745" class="stat-svg"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></div>
                <div class="stat-info"><span class="stat-title">Tugas Selesai</span><span class="stat-value"><?php echo $tugas_selesai; ?></span></div>
            </div>
        </div>
    </div>

    <div class="side-column">
        <div class="action-card">
            <h2>Aksi Cepat</h2>
            <a href="projects_add.php" class="action-link"><i data-feather="folder-plus"></i> Tambah Proyek Baru</a>
            <a href="tasks_add.php" class="action-link"><i data-feather="plus-square"></i> Tambah Tugas Baru</a>
        </div>

        <div class="action-card">
            <h2>Proyek Terbaru</h2>
            <ul class="recent-list">
                <?php
                if ($recent_projects_result->num_rows > 0) {
                    while($project = $recent_projects_result->fetch_assoc()) {
                        echo '<li>';
                        echo generateAvatar($project['nama_proyek'], $project['id']);
                        echo '  <div class="user-details">';
                        echo '      <span class="user-name">' . htmlspecialchars($project['nama_proyek']) . '</span>';
                        echo '  </div>';
                        echo '</li>';
                    }
                } else {
                    echo '<li>Anda belum membuat proyek.</li>';
                }
                ?>
            </ul>
        </div>
        
        <div class="action-card">
            <h2>Tugas Terbaru</h2>
            <ul class="recent-list">
                <?php
                if ($recent_tasks_result->num_rows > 0) {
                    while($task = $recent_tasks_result->fetch_assoc()) {
                        echo '<li>';
                        echo generateAvatar($task['nama_tugas'], $task['id']);
                        echo '  <div class="user-details">';
                        echo '      <span class="user-name">' . htmlspecialchars($task['nama_tugas']) . '</span>';
                        echo '      <span class="user-role">Proyek: ' . htmlspecialchars($task['nama_proyek']) . '</span>';
                        echo '  </div>';
                        echo '</li>';
                    }
                } else {
                    echo '<li>Belum ada tugas yang ditambahkan.</li>';
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