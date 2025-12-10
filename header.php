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

        <button id="menu-toggle" class="menu-toggle">☰</button>

        <div class="nav-links" id="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../manual.php' : 'manual.php'; ?>"><?php echo __('manual'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../index.php' : 'index.php'; ?>"><?php echo __('home'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../reservations.php' : 'reservations.php'; ?>"><?php echo __('book_room'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../profile.php' : 'profile.php'; ?>"><?php echo __('profile'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../my_reservations.php' : 'my_reservations.php'; ?>"><?php echo __('my_reservations'); ?></a>
                <a href="<?php echo isset($isAdmin) && $isAdmin ? '../food.php' : 'food.php'; ?>"><?php echo __('food_system'); ?></a>

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
            <?php
            $query = $_GET;

            $query['lang'] = 'zh';
            $zhUrl = '?' . http_build_query($query);

            $query['lang'] = 'en';
            $enUrl = '?' . http_build_query($query);
            ?>
            <a href="<?php echo $zhUrl; ?>" class="<?php echo $currentLang == 'zh' ? 'active' : ''; ?>">中文</a> |
            <a href="<?php echo $enUrl; ?>" class="<?php echo $currentLang == 'en' ? 'active' : ''; ?>">EN</a>
            </span>
        </div>
    </header>

    <?php if (isset($_SESSION['user_id']) && isset($user)): ?>
    <div class="user-info-bar">
        <?php echo __('hello'); ?>, <strong><?php echo htmlspecialchars($user['nickname']); ?></strong>
        (<?php echo htmlspecialchars($user['department']); ?> <?php echo htmlspecialchars($user['grade']); ?><?php echo __('grade_suffix'); ?>)
    </div>
    <?php endif; ?>


<style>
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        position: relative;

        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
    }

    .menu-toggle {
        color: #fff;
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    /* Hamburger menu when width <= 768 */
    @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }

        .nav-links {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: var(--header-bg);
            flex-direction: column;
            border-top: 1px solid #ddd;
            z-index: 1000;
        }

        .nav-links.active {
            display: flex;
        }

        .nav-links a {
            padding: 15px;
            border-bottom: 1px solid #eee;
            width: 100%;
            text-align: center;
            margin: 0;
        }

        .lang-switch {
            display: block;
            padding: 15px 20px 15px 10px;
            margin-left: 0;
            text-align: center;
        }

        .lang-switch a {
            border-bottom: none !important;
            display: inline;
            width: auto;
            padding: 0 5px;
            margin: 0;
        }
    }
</style>

<!-- Hamburger menu behavior(clicking) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');

        if (menuToggle && navLinks) {
            menuToggle.addEventListener('click', function(event) {
                event.stopPropagation(); 
                navLinks.classList.toggle('active');
            });
        }
        
        document.addEventListener('click', function(event) {
            const isClickInsideNav = navLinks.contains(event.target);
            const isClickOnToggle = menuToggle.contains(event.target);
            
            if (navLinks.classList.contains('active') && !isClickInsideNav && !isClickOnToggle) {
                navLinks.classList.remove('active');
            }
        });
    });
</script>