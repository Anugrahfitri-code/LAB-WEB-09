<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager'); 

$manager_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $task_id = (int)$_GET['id'];
    
    $sql = "DELETE t FROM tasks t
            INNER JOIN projects p ON t.project_id = p.id
            WHERE t.id = ? AND p.manager_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $manager_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: tasks_view.php?status=success");
        } else {
            header("Location: tasks_view.php?status=error&msg=Akses Ditolak atau Tugas tidak ditemukan.");
        }
    } else {
        header("Location: tasks_view.php?status=error&msg=" . urlencode($stmt->error));
    }
    $stmt->close();
} else {
    header("Location: tasks_view.php");
}

$conn->close();
exit();
?>