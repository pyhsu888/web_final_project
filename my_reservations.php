<?php
session_start();
require 'db_connect.php';
require 'lang.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT * FROM reservations 
    WHERE user_id = ? 
    ORDER BY date DESC, start_time DESC
");
$stmt->execute([$user_id]);
$list = $stmt->fetchAll();

include 'header.php';
?>

<div class="container">
    <h2>📒 <?php echo __('my_reservations'); ?></h2>

    <?php if (empty($list)): ?>
        <div class="empty-state"><?php echo __('no_reservations'); ?></div>
    <?php else: ?>
        <table>
            <tr>
                <th><?php echo __('room'); ?></th>
                <th><?php echo __('date'); ?></th>
                <th><?php echo __('time'); ?></th>
                <th><?php echo __('action'); ?></th>
            </tr>
            <?php foreach ($list as $r): 
                $start_ts = strtotime($r['date'].' '.$r['start_time']);
                $canCancel = ($start_ts - time() >= 3600);
            ?>
            <tr>
                <td><?php echo $r['room']; ?></td>
                <td><?php echo $r['date']; ?></td>
                <td><?php echo substr($r['start_time'],0,5); ?> - <?php echo substr($r['end_time'],0,5); ?></td>
                <td>
                    <?php if ($canCancel): ?>
                        <button class="btn btn-danger btn-sm" onclick="cancel(<?php echo $r['id']; ?>)">
                            <?php echo __('cancel'); ?>
                        </button>
                    <?php else: ?>
                        <span class="info"><?php echo __('cannot_cancel'); ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
function cancel(id) {
    if (!confirm("<?php echo __('confirm_cancel'); ?>")) return;

    fetch("cancel_reservation.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + id
    })
    .then(r => r.text())
    .then(txt => {
        console.log("RAW:", txt);
        const res = JSON.parse(txt);
        alert(res.message);
        if (res.success) location.reload();
    })
    .catch(err => {
        console.error("ERROR:", err);
        alert("Server Error");
    });
}
</script>

<?php include 'footer.php'; ?>
