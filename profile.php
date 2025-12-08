<?php
session_start();
require 'db_connect.php';
require 'lang.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$message = '';
$messageType = '';

// Handle Nickname Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_nickname'])) {
    $new_nickname = trim($_POST['new_nickname']);
    if (!empty($new_nickname)) {
        $stmt = $pdo->prepare("UPDATE users SET nickname = ? WHERE id = ?");
        $stmt->execute([$new_nickname, $_SESSION['user_id']]);
        $user['nickname'] = $new_nickname;
        $message = __('nickname_updated');
        $messageType = 'success';
    }
}

// Handle Password Change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = __('password_mismatch');
        $messageType = 'error';
    } elseif (!password_verify($current_password, $user['password'])) {
        $message = __('current_password_wrong');
        $messageType = 'error';
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $_SESSION['user_id']]);
        $message = __('password_updated');
        $messageType = 'success';
        
        // Refresh user data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
    }
}

include 'header.php';
?>

<div class="container">
    <h2 class="section-title"><?php echo __('my_profile'); ?></h2>
    
    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Usage Stats Section -->
    <div class="profile-section">
        <h3><?php echo __('usage_stats'); ?></h3>
        <div class="stat-box">
            <div class="stat-value"><?php echo number_format($user['total_usage_hours'], 1); ?></div>
            <div class="stat-label"><?php echo __('total_hours'); ?></div>
        </div>
    </div>

    <!-- Edit Nickname Section -->
    <div class="profile-section">
        <h3><?php echo __('edit_nickname'); ?></h3>
        <form method="POST">
            <div class="form-group">
                <label><?php echo __('new_nickname'); ?>:</label>
                <input type="text" name="new_nickname" value="<?php echo htmlspecialchars($user['nickname']); ?>" required>
            </div>
            <button type="submit" name="update_nickname" class="btn btn-primary"><?php echo __('update_nickname'); ?></button>
        </form>
    </div>

    <!-- Change Password Section -->
    <div class="profile-section">
        <h3><?php echo __('change_password'); ?></h3>
        <form method="POST">
            <div class="form-group">
                <label><?php echo __('current_password'); ?>:</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label><?php echo __('new_password'); ?>:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label><?php echo __('confirm_password'); ?>:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" name="update_password" class="btn btn-primary"><?php echo __('update_password'); ?></button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
