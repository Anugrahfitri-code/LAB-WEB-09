<?php
include 'koneksi.php';

session_start();
$error = '';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    $redirect_path = 'login.php';

    if ($role == 'Super Admin') {
        $redirect_path = 'admin/dashboard.php';
    } elseif ($role == 'Project Manager') {
        $redirect_path = 'manager/dashboard.php';
    } elseif ($role == 'Team Member') {
        $redirect_path = 'member/dashboard.php';
    }
    
    header("Location: " . $redirect_path);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            $role = $user['role'];
            $redirect_path = 'login.php'; 

            if ($role == 'Super Admin') {
                $redirect_path = 'admin/dashboard.php';
            } elseif ($role == 'Project Manager') {
                $redirect_path = 'manager/dashboard.php';
            } elseif ($role == 'Team Member') {
                $redirect_path = 'member/dashboard.php';
            }

            header("Location: " . $redirect_path);
            exit();
            
        } else {
            $error = "Username atau Password salah.";
        }
    } else {
        $error = "Username atau Password salah.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Proyek</title>
    <link rel="stylesheet" href="assets/style.css"> 
</head>
<body class="login-page">
    <div class="login-container">
        <h1>Manajemen Proyek</h1>
        <h2>Formulir Login</h2>
        
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>

        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
    
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
    
            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>