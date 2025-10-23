<?php
$page_title = $page_title ?? "Manajemen Proyek";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/style.css"> 
</head>
<body <?php if (strpos($_SERVER['PHP_SELF'], 'login.php')) echo 'class="login-page"'; ?>>
    
    <header id="mobile-header">
        <button id="hamburger-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div class="page-title-mobile"><?php echo htmlspecialchars($page_title); ?></div>
    </header>

    <div id="wrapper">
        <?php 
        if (!strpos($_SERVER['PHP_SELF'], 'login.php')) {
            $current_role = $_SESSION['role'] ?? 'Guest';
            include 'sidebar.php'; 
        }
        ?>
        <div id="content">