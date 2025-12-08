<?php
session_start();
require 'db_connect.php';
require 'lang.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Fetch Announcements
$announcements = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC")->fetchAll();

include 'header.php';
?>

<div class="container">
    <h2 class="section-title">📢 <?php echo __('announcements'); ?></h2>
    
    <?php if (count($announcements) > 0): ?>
        <?php foreach ($announcements as $ann): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($ann['title']); ?></h3>
                <div class="card-meta"><?php echo __('posted_on'); ?> <?php echo $ann['created_at']; ?></div>
                <div>
                    <?php echo nl2br(htmlspecialchars($ann['content'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state"><?php echo __('no_announcements'); ?></div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
