<?php
include '../koneksi.php';
include '../includes/check_login.php';
check_login('Super Admin'); 

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    
    if ($user_id == $_SESSION['user_id']) {
        header("Location: users_view.php?status=error&msg=Tidak bisa menghapus akun sendiri.");
        exit();
    }

    $stmt_check = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $stmt_check->close();

    if ($result_check->num_rows == 0) {
        header("Location: users_view.php?status=error&msg=Pengguna tidak ditemukan.");
        exit();
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); 
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: users_view.php?status=success");
        } else {
            header("Location: users_view.php?status=error&msg=Penghapusan gagal atau ID tidak ditemukan.");
        }
    } else {
        header("Location: users_view.php?status=error&msg=" . urlencode($stmt->error));
    }
    $stmt->close();
} else {
    header("Location: users_view.php");
}

$conn->close();
exit();
?>