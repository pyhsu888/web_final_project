<?php
session_start();
$isAdmin = true; // Flag for header to adjust paths
require '../lang.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../header.php';
?>

<div class="container">
    <h2 class="section-title"><?php echo __('admin_dashboard'); ?></h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
        <a href="whitelist.php" class="card" style="text-align:center; text-decoration:none;">
            <h3><?php echo __('manage_whitelist'); ?></h3>
            <p class="info"><?php echo __('add_new_student_id'); ?></p>
        </a>
        <a href="users.php" class="card" style="text-align:center; text-decoration:none;">
            <h3><?php echo __('manage_users'); ?></h3>
            <p class="info"><?php echo __('promote'); ?> / <?php echo __('ban'); ?></p>
        </a>
        <a href="announcements.php" class="card" style="text-align:center; text-decoration:none;">
            <h3><?php echo __('manage_announcements'); ?></h3>
            <p class="info"><?php echo __('publish'); ?> / <?php echo __('delete'); ?></p>
        </a>
        <a href="../index.php" class="card" style="text-align:center; text-decoration:none;">
            <h3><?php echo __('view_member_site'); ?></h3>
            <p class="info"><?php echo __('home'); ?></p>
        </a>
    </div>
</div>

<?php include '../footer.php'; ?>
