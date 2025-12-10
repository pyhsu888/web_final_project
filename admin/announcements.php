<?php
session_start(); date_default_timezone_set('Asia/Taipei');
$isAdmin = true;
require '../db_connect.php';
require '../lang.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch current user for header display
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$message = '';

// Handle Add
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_announcement'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (!empty($title) && !empty($content)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
            $stmt->execute([$title, $content]);
            $message = "Announcement published.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->execute([$id_to_delete]);
        $message = "Announcement deleted.";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

$announcements = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC")->fetchAll();

include '../header.php';
?>

<div class="container">
    <a href="dashboard.php"><?php echo __('back_to_dashboard'); ?></a>
    <h2 class="section-title"><?php echo __('manage_announcements'); ?></h2>
    
    <?php if ($message): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="card">
        <h4><?php echo __('create_announcement'); ?></h4>
        <form method="POST">
            <div class="form-group">
                <label><?php echo __('title'); ?>:</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label><?php echo __('content'); ?>:</label>
                <textarea name="content" rows="4" required></textarea>
            </div>
            <button type="submit" name="add_announcement" class="btn btn-success"><?php echo __('publish'); ?></button>
        </form>
    </div>

    <h3><?php echo __('existing_announcements'); ?></h3>
    <?php foreach ($announcements as $a): ?>
        <div class="card">
            <h4><?php echo htmlspecialchars($a['title']); ?> 
                <a href="?delete=<?php echo $a['id']; ?>" class="btn btn-danger btn-sm" style="float:right;" onclick="return confirm('<?php echo __('delete'); ?>?');"><?php echo __('delete'); ?></a>
            </h4>
            <p class="card-meta"><?php echo __('posted_on'); ?>: <?php echo $a['created_at']; ?></p>
            <p><?php echo nl2br(htmlspecialchars($a['content'])); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php include '../footer.php'; ?>
