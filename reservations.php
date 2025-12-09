<?php
session_start();
require 'db_connect.php';
require 'lang.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$room = $_GET['room'] ?? '409';
if ($room !== '409' && $room !== '417') {
    $room = '409';
}

$user_id = $_SESSION['user_id'];
$today   = date('Y-m-d');

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;


if ($offset < 0) $offset = 0;
if ($offset > 1) $offset = 1;


$weekStart = date('Y-m-d', strtotime("monday this week +{$offset} week"));
$weekEnd   = date('Y-m-d', strtotime("sunday this week +{$offset} week"));


$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM reservations
    WHERE user_id = ?
      AND date = ?
");
$stmt->execute([$user_id, $today]);
$todayUsed = (int)$stmt->fetchColumn();

$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM reservations
    WHERE user_id = ?
      AND date BETWEEN ? AND ?
");
$stmt->execute([$user_id, $weekStart, $weekEnd]);
$weekUsed = (int)$stmt->fetchColumn();

$todayRemain = max(0, 3 - $todayUsed); // 每日上限 3
$weekRemain  = max(0, 8 - $weekUsed);  // 每週上限 8

$stmt = $pdo->prepare("
    SELECT r.*, u.nickname
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    WHERE r.room = ?
      AND r.date BETWEEN ? AND ?
");
$stmt->execute([$room, $weekStart, $weekEnd]);
$reservations = $stmt->fetchAll();

$booked   = []; 
$myBooked = []; 

foreach ($reservations as $r) {
    $date = $r['date'];           
    $time = $r['start_time'];    
    $key  = "{$room}_{$date}_{$time}";

    $booked[$key] = $r['nickname'];

    if ((int)$r['user_id'] === (int)$user_id) {
        $myBooked[$key] = true;
    }
}

include 'header.php';
?>

<div class="container">
    <h2 class="section-title">🎹 <?php echo __('book_title'); ?></h2>


    <div class="info-box" style="margin-bottom:15px;">
        <?php echo __('today_remain'); ?>：<?php echo $todayRemain; ?> <?php echo __('hour'); ?>
        <?php echo __('week_remain'); ?>：<?php echo $weekRemain; ?> <?php echo __('hour'); ?>
    </div>
    <div class="week-nav" style="margin-bottom:12px;">

        <?php if ($offset > 0): ?>
            <a class="btn" href="reservations.php?room=<?php echo $room; ?>&offset=<?php echo $offset-1; ?>">
                ← <?php echo __('prev_week'); ?>
            </a>
        <?php endif; ?>

        <strong style="margin:0 12px;">
            <?php echo $weekStart; ?> ～ <?php echo $weekEnd; ?>
        </strong>

        <?php if ($offset < 1): ?>
            <a class="btn" href="reservations.php?room=<?php echo $room; ?>&offset=<?php echo $offset+1; ?>">
                <?php echo __('next_week'); ?> →
            </a>
        <?php endif; ?>

    </div>


    <div style="margin:15px 0;">
        <label><?php echo __('select_room'); ?>：</label>
        <select id="roomSelect">
            <option value="409" <?php if ($room === '409') echo 'selected'; ?>>409</option>
            <option value="417" <?php if ($room === '417') echo 'selected'; ?>>417</option>
        </select>
    </div>

    <table id="scheduleTable">
        <thead>
            <tr>
                <th>時間</th>
                <?php
                for ($i = 0; $i < 7; $i++) {
                    $d = date('Y-m-d', strtotime("+$i day", strtotime($weekStart)));
                    echo "<th>{$d}</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
        for ($h = 0; $h < 24; $h++) {
            $time = sprintf("%02d:00:00", $h); 
            $timeLabel = substr($time, 0, 5);  
            echo "<tr><th>{$timeLabel}</th>";

            for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', strtotime("+$i day", strtotime($weekStart)));
                $key  = "{$room}_{$date}_{$time}";

                $isBooked = isset($booked[$key]);
                $isMine   = isset($myBooked[$key]);
                $nameText = $booked[$key] ?? '';

                $btnClasses = ['slot'];
                if ($isBooked) $btnClasses[] = 'booked';
                if ($isMine)   $btnClasses[] = 'my-booked';
                $btnClassStr = implode(' ', $btnClasses);

                $titleAttr = $nameText ? __('borrower').'：'.$nameText : '';
                $label = $isBooked ? __('reserved') : __('reserve');
                $disabled  = $isBooked ? 'disabled' : '';

                echo '<td>';
                echo "<button 
                        class=\"{$btnClassStr}\"
                        data-date=\"{$date}\"
                        data-time=\"{$time}\"
                        title=\"{$titleAttr}\"
                        {$disabled}
                      >{$label}</button>";
                echo '</td>';
            }

            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<style>
.slot {
    width: 100%;
    padding: 6px;
}
.booked {
    background: #aaa !important;
    color: #fff;
    cursor: not-allowed;
}
.my-booked {
    background: #4CAF50 !important;
    color: #fff;
}
</style>

<script>
const roomSelect = document.getElementById("roomSelect");
const slots      = document.querySelectorAll(".slot");

roomSelect.addEventListener("change", () => {
    location.href = "reservations.php?room=" + roomSelect.value;
});

slots.forEach(btn => {
    if (btn.classList.contains("booked")) return;

    btn.addEventListener("click", () => {
        const date = btn.dataset.date;
        const time = btn.dataset.time;  
        const room = roomSelect.value;

        const h = parseInt(time.split(":")[0]);
        const endTime = String((h + 1) % 24).padStart(2, "0") + ":00";

        const ok = confirm(
        `<?php echo __('confirm_reserve'); ?>\n\n` +
        `Room: ${room}\n` +
        `Date: ${date}\n` +
        `Time: ${time.slice(0,5)} ～ ${endTime}`
        );
        if (!ok) return;

        fetch("reserve_action.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({date, time, room})
        })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) location.reload();
        });
    });
});
</script>

<?php include 'footer.php'; ?>
