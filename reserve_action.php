<?php
session_start(); date_default_timezone_set('Asia/Taipei');
require 'db_connect.php';
require 'lang.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_SESSION['user_id'];

$date = $data['date'];
$time = $data['time'];
$room = $data['room'];
$targetTs = strtotime($date);

// 本週一
$thisWeekStart = strtotime('monday this week');

// 兩週後的週日 23:59:59
$maxAllowedTs = strtotime('+2 week sunday', $thisWeekStart);

if ($targetTs > $maxAllowedTs) {
    echo json_encode([
        "success" => false,
        "message" => "僅能預約本週與下一週時段"
    ]);
    exit;
}
$start_datetime = "$date $time";
$start_ts = strtotime($start_datetime);

// 規則 4：需提前 30 分鐘
if ($start_ts - time() < 1800) {
    echo json_encode([
        "success" => false,
        "message" => __('reserve_30min_limit')
    ]);
    exit;
}

// 規則 1：每日最多 3 小時
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM reservations 
    WHERE user_id=? AND date=?
");
$stmt->execute([$user_id,$date]);
if ($stmt->fetchColumn() >= 3) {
    echo json_encode([
    "success" => false,
    "message" => __('daily_limit_exceeded')
    ]);
    exit;
}

// 規則 2：每週最多 8 小時
$weekStart = date('Y-m-d', strtotime('monday this week', $start_ts));
$weekEnd   = date('Y-m-d', strtotime('sunday this week', $start_ts));

$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM reservations 
    WHERE user_id=? AND date BETWEEN ? AND ?
");
$stmt->execute([$user_id,$weekStart,$weekEnd]);
if ($stmt->fetchColumn() >= 8) {
    echo json_encode([
    "success" => false,
    "message" => __('weekly_limit_exceeded')
    ]);
    exit;
}

// 檢查是否已被預約
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM reservations 
    WHERE room=? AND date=? AND start_time=?
");
$stmt->execute([$room,$date,$time]);
if ($stmt->fetchColumn() > 0) {
    echo json_encode(["success"=>false,"message"=>"此時段已被預約"]);
    exit;
}

// 寫入資料庫
$end_time = date('H:i:s', strtotime($time) + 3600);

$stmt = $pdo->prepare("
    INSERT INTO reservations (user_id, room, date, start_time, end_time)
    VALUES (?,?,?,?,?)
");
$stmt->execute([$user_id,$room,$date,$time,$end_time]);

echo json_encode([
  "success" => true,
  "message" => __('reserve_success')
]);