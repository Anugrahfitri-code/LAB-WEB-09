<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Super Admin'); 

if (isset($_GET['id'])) {
    $project_id = (int)$_GET['id'];

    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $project_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: projects_all_view.php?status=success_delete");
        } else {
            header("Location: projects_all_view.php?status=error&msg=Proyek tidak ditemukan.");
        }
    } else {
        header("Location: projects_all_view.php?status=error&msg=" . urlencode($stmt->error));
    }
    $stmt->close();
} else {
    header("Location: projects_all_view.php");
}

$conn->close();
exit();
?>