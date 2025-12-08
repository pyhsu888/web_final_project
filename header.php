<?php
/**
 * Shared Header Component
 * Includes: Navigation, Dark Mode Toggle, Language Switcher
 */
require_once __DIR__ . '/lang.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang == 'zh' ? 'zh-TW' : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('site_title'); ?></title>
    <link rel="stylesheet" href="<?php echo isset($isAdmin) && $isAdmin ? '../style.css' : 'style.css'; ?>">
    <script>
        // Apply saved theme on load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    <header>
        <div class="logo">🎹 <?php echo __('site_title'); ?></div>
        <div class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../index.php' : 'index.php'; ?>"><?php echo __('home'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../reservations.php' : 'reservations.php'; ?>"><?php echo __('book_room'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../profile.php' : 'profile.php'; ?>"><?php echo __('profile'); ?></a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="<?php echo isset($isAdmin) && $isAdmin ? 'dashboard.php' : 'admin/dashboard.php'; ?>"><?php echo __('admin_dashboard'); ?></a>
                <?php endif; ?>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../logout.php' : 'logout.php'; ?>"><?php echo __('logout'); ?></a>
            <?php else: ?>
                <a href="login.php"><?php echo __('login'); ?></a>
                <a href="register.php"><?php echo __('register'); ?></a>
            <?php endif; ?>
            
            <!-- Language Switcher -->
            <span class="lang-switch">
                <a href="?lang=zh" class="<?php echo $currentLang == 'zh' ? 'active' : ''; ?>">中文</a>|<a href="?lang=en" class="<?php echo $currentLang == 'en' ? 'active' : ''; ?>">EN</a>
            </span>
        </div>
    </header>

    <?php if (isset($_SESSION['user_id']) && isset($user)): ?>
    <div class="user-info-bar">
        <?php echo __('hello'); ?>, <strong><?php echo htmlspecialchars($user['nickname']); ?></strong>
        (<?php echo htmlspecialchars($user['department']); ?> <?php echo htmlspecialchars($user['grade']); ?><?php echo __('grade_suffix'); ?>)
    </div>
    <?php endif; ?>
