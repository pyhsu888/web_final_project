<?php
session_start(); date_default_timezone_set('Asia/Taipei');
$isAdmin = true;
require '../db_connect.php';
require '../lang.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_session'])) {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : null;
        
        $stmt = $pdo->prepare("INSERT INTO food_sessions (title, description, start_time, end_time, is_active) VALUES (?, ?, NOW(), ?, 1)");
        $stmt->execute([$title, $desc, $end_time]);
    }
  
    if (isset($_POST['toggle_id'])) {
        $id = $_POST['toggle_id'];
        $current_status = $_POST['current_status'];
        $new_status = $current_status == 1 ? 0 : 1;
        
        $stmt = $pdo->prepare("UPDATE food_sessions SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
    }

    if (isset($_POST['update_deadline'])) {
        $id = $_POST['session_id'];
        $new_time = !empty($_POST['new_end_time']) ? $_POST['new_end_time'] : null;
        
        $stmt = $pdo->prepare("UPDATE food_sessions SET end_time = ? WHERE id = ?");
        $stmt->execute([$new_time, $id]);
    }
}

$stmt = $pdo->query("
    SELECT s.*, 
    (SELECT COUNT(*) FROM food_orders WHERE session_id = s.id) as order_count
    FROM food_sessions s 
    ORDER BY s.created_at DESC
");
$sessions = $stmt->fetchAll();

include '../header.php';
?>

<div class="container">
    <h2 class="section-title"><?php echo __('food_admin'); ?></h2>

    <div class="card" style="margin-bottom: 30px; padding: 20px;">
        <h3><?php echo __('create_session'); ?></h3>
        <form method="POST">
            <div style="margin-bottom:10px;">
                <label><?php echo __('restaurant_name'); ?>:</label>
                <input type="text" name="title" required style="width:100%; padding:8px;">
            </div>
            <div style="margin-bottom:10px;">
                <label><?php echo __('menu_desc'); ?>:</label>
                <textarea name="description" rows="3" style="width:100%; padding:8px;" placeholder="<?php echo __('menu_desc_placeholder'); ?>"></textarea>
            </div>
            <div style="margin-bottom:10px;">
                <label><?php echo __('close_time'); ?>:</label>
                <input type="datetime-local" name="end_time" style="width:100%; padding:8px;">
            </div>
            <button type="submit" name="create_session" class="btn btn-primary"><?php echo __('open'); ?></button>
        </form>
    </div>

    <h3><?php echo __('history_records'); ?></h3>
    <div style="display: grid; gap: 20px;">
        <?php foreach ($sessions as $s): ?>
            <div class="card" style="padding: 15px; border-left: 5px solid <?php echo $s['is_active'] ? '#4CAF50' : '#aaa'; ?>;">
                
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap: wrap; gap: 10px;">
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 5px 0;">
                            <?php echo htmlspecialchars($s['title']); ?> 
                            <span style="font-size:0.8em; color:<?php echo $s['is_active'] ? 'green' : 'grey'; ?>">
                                (<?php echo $s['is_active'] ? __('open') : __('closed'); ?>)
                            </span>
                        </h4>
                        <p style="color:#666; font-size:0.9em; margin: 0 0 10px 0; white-space: pre-wrap;"><?php echo htmlspecialchars($s['description']); ?></p>
                        
                        <div style="margin-top: 5px;">
                            <form method="POST" style="display:flex; align-items:center; gap:5px; flex-wrap:wrap;">
                                <small><?php echo __('deadline'); ?></small>
                                <input type="hidden" name="session_id" value="<?php echo $s['id']; ?>">
                                <input type="datetime-local" name="new_end_time" 
                                       value="<?php echo $s['end_time'] ? date('Y-m-d\TH:i', strtotime($s['end_time'])) : ''; ?>" 
                                       style="font-size:0.8em; padding:2px;">
                                <button type="submit" name="update_deadline" class="btn btn-sm" style="font-size:0.7em; padding:2px 8px;"><?php echo __('update'); ?></button>
                            </form>
                        </div>
                    </div>

                    <div style="text-align:right; min-width: 120px;">
                        <p style="margin: 0 0 10px 0;"><strong><?php echo $s['order_count']; ?></strong> <?php echo __('order_unit'); ?></p>
                        
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="toggle_id" value="<?php echo $s['id']; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $s['is_active']; ?>">
                            <button type="submit" class="btn btn-sm" style="background:#ddd;"><?php echo __('toggle_status'); ?></button>
                        </form>
                    </div>
                </div>

                <div style="margin-top:15px; border-top:1px solid #eee; padding-top:10px;">
                    <?php
                    $o_stmt = $pdo->prepare("
                        SELECT o.*, u.nickname, u.real_name 
                        FROM food_orders o 
                        JOIN users u ON o.user_id = u.id 
                        WHERE o.session_id = ?
                    ");
                    $o_stmt->execute([$s['id']]);
                    $orders = $o_stmt->fetchAll();
                    ?>
                    <?php if ($orders): ?>
                        <div style="overflow-x: auto;">
                            <table style="width:100%; font-size:0.9em; border-collapse: collapse;">
                                <thead style="background: #f9f9f9;">
                                    <tr>
                                        <th style="text-align:left; padding:5px;"><?php echo __('nickname'); ?></th>
                                        <th style="text-align:left; padding:5px;"><?php echo __('item_name'); ?></th>
                                        <th style="text-align:left; padding:5px;"><?php echo __('notes'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($orders as $o): ?>
                                    <tr style="border-bottom: 1px solid #f0f0f0;">
                                        <td style="padding:5px;"><?php echo htmlspecialchars($o['nickname']); ?></td>
                                        <td style="padding:5px;"><strong><?php echo htmlspecialchars($o['item_name']); ?></strong></td>
                                        <td style="padding:5px; color:#888;"><?php echo htmlspecialchars($o['note']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <span style="color:#999; font-style: italic;"><?php echo __('no_orders'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../footer.php'; ?>

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
    [data-theme="dark"] .btn {
        background-color: #555 !important;
        color: #fff !important;
        border-color: transparent !important; 
        outline: 1px solid #777 !important;
        outline-offset: -1px; 
    }
    [data-theme="dark"] .btn-primary {
        background-color: #0d47a1 !important;
        outline: 1px solid #0d47a1 !important;
    }
</style>