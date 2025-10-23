<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Project Manager'); 

$manager_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $project_id = (int)$_GET['id'];
    
    $sql = "DELETE FROM projects WHERE id = ? AND manager_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $project_id, $manager_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: projects_view.php?status=success");
        } else {
            header("Location: projects_view.php?status=error&msg=Akses Ditolak atau Proyek tidak ditemukan.");
        }
    } else {
        header("Location: projects_view.php?status=error&msg=" . urlencode($stmt->error));
    }
    $stmt->close();
} else {
    header("Location: projects_view.php");
}

$conn->close();
exit();
?>