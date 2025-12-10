<?php
session_start(); date_default_timezone_set('Asia/Taipei');
require 'db_connect.php';
require 'lang.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => __("please_login")
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => __("param_error")
    ]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$res = $stmt->fetch();

if (!$res) {
    echo json_encode([
        "success" => false,
        "message" => __("reservation_not_found")
    ]);
    exit;
}

// 至少提前 1 小時才能取消
$start_ts = strtotime($res['date'].' '.$res['start_time']);
if ($start_ts - time() < 3600) {
    echo json_encode([
        "success" => false,
        "message" => __("cancel_1hour_limit")
    ]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
$stmt->execute([$id]);

echo json_encode([
    "success" => true,
    "message" => __("cancel_success")
]);
exit;
