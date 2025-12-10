<?php
session_start(); date_default_timezone_set('Asia/Taipei');
require 'db_connect.php';
require 'lang.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    $session_id = $_POST['session_id'];
    $item_name = trim($_POST['item_name']);
    $note = trim($_POST['note']);

    if (!empty($item_name)) {
        $stmt = $pdo->prepare("
            INSERT INTO food_orders (user_id, session_id, item_name, note) 
            VALUES (?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE item_name = VALUES(item_name), note = VALUES(note)
        ");
        $stmt->execute([$user_id, $session_id, $item_name, $note]);
        $message = __('order_saved');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $session_id = $_POST['session_id'];
    
    $stmt = $pdo->prepare("DELETE FROM food_orders WHERE session_id = ? AND user_id = ?");
    $stmt->execute([$session_id, $user_id]);
    
    $message = __('order_cancelled_msg');
}

$stmt = $pdo->prepare("
    SELECT * FROM food_sessions 
    WHERE is_active = 1 
    AND (end_time IS NULL OR end_time > NOW())
    ORDER BY created_at DESC
");
$stmt->execute();
$active_sessions = $stmt->fetchAll();

include 'header.php';
?>

<div class="container">
    <h2 class="section-title">🍔 <?php echo __('food_system'); ?></h2>

    <?php if ($message): ?>
        <div class="message success"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if (empty($active_sessions)): ?>
        <div class="empty-state">
            <p><?php echo __('no_active_sessions'); ?></p>
            <p style="font-size:3em;">😴</p>
        </div>
    <?php else: ?>
        
        <?php foreach ($active_sessions as $s): ?>
            <?php
            $check = $pdo->prepare("SELECT * FROM food_orders WHERE user_id = ? AND session_id = ?");
            $check->execute([$user_id, $s['id']]);
            $my_order = $check->fetch();
            ?>

            <div class="card" style="margin-bottom: 20px; padding: 20px; border-top: 5px solid #ff9800;">
                <h3><?php echo htmlspecialchars($s['title']); ?></h3>
                <div style="background:#f9f9f9; padding:10px; margin-bottom:15px; border-radius:4px;">
                    <p style="white-space: pre-line;"><?php echo htmlspecialchars($s['description']); ?></p>
                    <?php if($s['end_time']): ?>
                        <small style="color:red;"><?php echo __('deadline_time'); ?> <?php echo date('m/d H:i', strtotime($s['end_time'])); ?></small>
                    <?php endif; ?>
                </div>

                <form method="POST">
                    <input type="hidden" name="session_id" value="<?php echo $s['id']; ?>">
                    
                    <div style="margin-bottom:10px;">
                        <label><?php echo __('order_item'); ?>:</label>
                        <input type="text" name="item_name" 
                               value="<?php echo $my_order ? htmlspecialchars($my_order['item_name']) : ''; ?>" 
                               required style="width:100%; padding:10px; font-size:1.1em;"
                               placeholder="<?php echo __('enter_food_name'); ?>">
                    </div>
                    
                    <div style="margin-bottom:10px;">
                        <label><?php echo __('order_note'); ?>:</label>
                        <input type="text" name="note" 
                               value="<?php echo $my_order ? htmlspecialchars($my_order['note']) : ''; ?>" 
                               style="width:100%; padding:8px;">
                    </div>

                    <button type="submit" name="submit_order" class="btn btn-primary" style="width:100%;">
                        <?php echo $my_order ? __('update_order') : __('submit_order'); ?>
                    </button>
                </form>

                <?php if ($my_order): ?>
                    <form method="POST" style="margin-top: 10px;" onsubmit="return confirm('<?php echo __('confirm_cancel_order'); ?>');">
                        <input type="hidden" name="session_id" value="<?php echo $s['id']; ?>">
                        <button type="submit" name="cancel_order" style="width:100%; padding:10px; background-color: #ff4444; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            <?php echo __('cancel_order_btn'); ?>
                        </button>
                    </form>
                <?php endif; ?>

                <div style="margin-top:20px; font-size: 0.9em; color: #666;">
                    <h4><?php echo __('partners_ordered'); ?></h4>
                    <?php
                    $others = $pdo->prepare("SELECT u.nickname FROM food_orders o JOIN users u ON o.user_id = u.id WHERE o.session_id = ?");
                    $others->execute([$s['id']]);
                    $names = $others->fetchAll(PDO::FETCH_COLUMN);
                    
                    if (!empty($names)) {
                        echo implode(', ', array_map('htmlspecialchars', $names));
                    } else {
                        echo '-';
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<style>
    [data-theme="dark"] body {
        background-color: #121212;
        color: #e0e0e0;
    }

    [data-theme="dark"] .card {
        background-color: #1e1e1e;
        color: #e0e0e0;
        border: 1px solid #444;
        box-shadow: none;
    }

    [data-theme="dark"] input, 
    [data-theme="dark"] textarea, 
    [data-theme="dark"] select {
        background-color: #2d2d2d !important;
        border: 1px solid #555 !important;
        color: #fff !important;
    }
    
    [data-theme="dark"] ::placeholder {
        color: #888;
    }

    [data-theme="dark"] div[style*="#f9f9f9"],
    [data-theme="dark"] thead[style*="#f9f9f9"] {
        background-color: #2d2d2d !important;
        color: #ddd !important;
        border: 1px solid #444;
    }

    [data-theme="dark"] table, 
    [data-theme="dark"] th, 
    [data-theme="dark"] td,
    [data-theme="dark"] tr {
        border-color: #444 !important;
    }
    
    [data-theme="dark"] a {
        color: #90caf9;
    }
</style>