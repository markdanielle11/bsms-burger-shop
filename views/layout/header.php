<?php
require_once ROOT_PATH . '/middleware/auth.php';
require_once ROOT_PATH . '/utils/helpers.php';

checkAuth();

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSMS - Burger Shop Management System</title>
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/responsive.css">
    <script src="<?php echo PUBLIC_URL; ?>/js/main.js" defer></script>
</head>
<body>
    <div class="app-container">
        <?php require_once ROOT_PATH . '/views/layout/sidebar.php'; ?>
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                </div>
                <div class="header-right">
                    <div class="user-menu">
                        <span class="user-name"><?php echo htmlspecialchars($user['name'] ?? 'User'); ?></span>
                        <a href="<?php echo BASE_URL; ?>/index.php?action=logout" class="btn-logout">Logout</a>
                    </div>
                </div>
            </header>
            <div class="page-content">