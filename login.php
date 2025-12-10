<?php
session_start(); date_default_timezone_set('Asia/Taipei');
require 'db_connect.php';
require 'lang.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $password = $_POST['password'];

    if (empty($student_id) || empty($password)) {
        $error = __('fill_required');
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE student_id = ?");
        $stmt->execute([$student_id]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'banned') {
                $error = __('banned_error');
            } else {
                // Login Success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['student_id'] = $user['student_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['real_name'] = $user['real_name'];

                // Role-based Redirect
                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        } else {
            $error = __('login_error');
        }
    }
}

// Don't include header for login page, use custom layout
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang == 'zh' ? 'zh-TW' : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('site_title'); ?> - <?php echo __('login'); ?></title>
    <link rel="stylesheet" href="style.css">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    <div class="auth-container">
        <h2>🎹 <?php echo __('login'); ?></h2>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label><?php echo __('student_id'); ?>:</label>
                <input type="text" name="student_id" required>
            </div>
            <div class="form-group">
                <label><?php echo __('password'); ?>:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;"><?php echo __('login_btn'); ?></button>
        </form>
        
        <p style="text-align:center; margin-top:20px;">
            <?php echo __('no_account'); ?> <a href="register.php"><?php echo __('register_here'); ?></a>
        </p>
        
        <p style="text-align:center; margin-top:10px;" class="lang-switch">
            <a href="?lang=zh" class="<?php echo $currentLang == 'zh' ? 'active' : ''; ?>">中文</a> | 
            <a href="?lang=en" class="<?php echo $currentLang == 'en' ? 'active' : ''; ?>">EN</a>
        </p>
    </div>

<?php include 'footer.php'; ?>

<style>
    .lang-switch {
        margin-left: 0;
    }
    .lang-switch a.active {
        color: #333;
    }
    [data-theme="dark"] .lang-switch a.active {
        color: #fff;
    }
</style>