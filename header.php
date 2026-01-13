<?php
require_once 'config.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <div class="logo-icon">🍦</div>
            <h1><?php echo $site_name; ?></h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Главная</a></li>
                <li><a href="shop.php" class="<?php echo $current_page == 'shop.php' ? 'active' : ''; ?>">
                    <i class="fas fa-store"></i> Магазин</a></li>
                <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">
                    <i class="fas fa-info-circle"></i> О нас</a></li>
                <li><a href="contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">
                    <i class="fas fa-envelope"></i> Контакты</a></li>
                <?php if(isLoggedIn()): ?>
                    <li><a href="profile.php">
                        <i class="fas fa-user"></i> <?php safeEcho($_SESSION['username']); ?></a></li>
                    <li><a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Выйти</a></li>
                <?php else: ?>
                    <div class="auth-links">
                        <a href="login.php" class="btn btn-login">
                            <i class="fas fa-sign-in-alt"></i> Войти</a>
                        <a href="register.php" class="btn btn-register">
                            <i class="fas fa-user-plus"></i> Регистрация</a>
                    </div>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<div class="loader">
    <div class="loader-spinner"></div>
</div>
<main>