<?php
session_start(); date_default_timezone_set('Asia/Taipei');
$isAdmin = true;
require '../db_connect.php';
require '../lang.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("
    SELECT r.*, u.real_name, u.student_id 
    FROM reservations r 
    JOIN users u ON r.user_id = u.id 
    ORDER BY r.date DESC, r.start_time DESC
");
$list = $stmt->fetchAll();

include '../header.php';
?>

<div class="container">
    <a href="dashboard.php"><?php echo __('back_to_admin'); ?></a>
    <h2 class="section-title">📊 <?php echo __('all_reservations'); ?></h2>

    <table>
        <tr>
            <th><?php echo __('student_id'); ?></th>
            <th><?php echo __('name'); ?></th>
            <th><?php echo __('room'); ?></th>
            <th><?php echo __('date'); ?></th>
            <th><?php echo __('time'); ?></th>
        </tr>

        <?php foreach ($list as $r): ?>
        <tr>
            <td><?php echo $r['student_id']; ?></td>
            <td><?php echo $r['real_name']; ?></td>
            <td><?php echo $r['room']; ?></td>
            <td><?php echo $r['date']; ?></td>
            <td><?php echo substr($r['start_time'],0,5); ?> - <?php echo substr($r['end_time'],0,5); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include '../footer.php'; ?>
