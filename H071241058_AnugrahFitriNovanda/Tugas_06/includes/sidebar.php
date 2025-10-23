<?php
$role = $current_role ?? 'Guest';
?>
<div id="sidebar">
    <div class="logo">
        <span>MP</span> Manajemen Proyek
    </div>
    <div class="user-info">
        Halo, <strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></strong>!
        <span class="role-badge">(<?php echo $role; ?>)</span>
    </div>

    <nav>
        <?php if ($role == 'Super Admin'): ?>
            <h3>MENU ADMIN</h3>
            <ul>
                <li><a href="../admin/dashboard.php"><i data-feather="layout"></i><span>Dashboard</span></a></li>
                <li><a href="../admin/users_view.php"><i data-feather="users"></i><span>Kelola Pengguna</span></a></li>
                <li><a href="../admin/projects_all_view.php"><i data-feather="archive"></i><span>Semua Proyek</span></a></li>
            </ul>
        <?php elseif ($role == 'Project Manager'): ?>
            <h3>MENU MANAGER</h3>
            <ul>
                <li><a href="../manager/dashboard.php"><i data-feather="layout"></i><span>Dashboard</span></a></li>
                <li><a href="../manager/projects_view.php"><i data-feather="archive"></i><span>Kelola Proyek</span></a></li>
                <li><a href="../manager/tasks_view.php"><i data-feather="check-square"></i><span>Kelola Tugas</span></a></li>
            </ul>
        <?php elseif ($role == 'Team Member'): ?>
            <h3>MENU MEMBER</h3>
            <ul>
                <li><a href="../member/dashboard.php"><i data-feather="check-square"></i><span>Dashboard Tugas</span></a></li>
            </ul>
        <?php endif; ?>

        <ul class="bottom-nav">
            <li><a href="../logout.php"><i data-feather="log-out"></i><span>Logout</span></a></li>
        </ul>
    </nav>
</div>