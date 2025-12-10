<?php
session_start(); date_default_timezone_set('Asia/Taipei');
require 'db_connect.php';
require 'lang.php';

$message = '';
$messageType = '';

function parseStudentId($id) {
    if (strlen($id) !== 9) {
        return ['dept' => 'Unknown', 'grade' => '0'];
    }

    $year = substr($id, 1, 2);
    $code = substr($id, 3, 3);
    
    $map = [
        '504' => '電機院博 (EED)',
        '506' => '電機在職專班 (IEC)',
        '510' => '電子所',
        '511' => '電機系/所 (ECE/GEE)',
        '512' => '電控所 (ICN)',
        '513' => '電信所 (ECM)',
        '514' => '光電系/光電碩',
        '550' => '資工系',
        '551' => '資科工碩 (IOC)',
        '552' => '網工碩',
        '553' => '多媒體碩',
        '554' => '數據科學與工程碩',
        '555' => '資電駭客與安全所',
        '556' => '資訊院博',
        '580' => '前瞻半導體 (Pio-SEMI)',
        '581' => '智能系統 (AI System)',
        '591' => '國際半導體所',
        '605' => '機器人學程 (ROB)',
        '610' => '奈米學士班',
        '611' => '機械工程系/所 (ME/IME)',
        '612' => '土木系/所',
        '613' => '材料系/所',
        '615' => '環工所',
        '617' => '太空系統工程所 (SSE)',
        '651' => '電物系/所',
        '652' => '應數系/所',
        '654' => '應化系/所',
        '657' => '統計所',
        '658' => '物理所',
        '700' => '管科系/所',
        '701' => '運管系',
        '705' => '資財系',
        '730' => '科法碩 (在職)',
        '731' => '科法所 (碩/博)',
        '950' => '百川學程',
        '951' => '系統學程 (國防大學)'
    ];

    if (isset($map[$code])) {
        $deptName = $map[$code];
    } else {
        $collegeCode = $id[3];
        switch ($collegeCode) {
            case '3': $deptName = '生科學院'; break;
            case '4': $deptName = '人社/客家學院'; break;
            case '5': $deptName = '電資學院'; break;
            case '6': $deptName = '工/理學院'; break;
            case '7': $deptName = '管/科法學院'; break;
            case '8': $deptName = '光電/綠能學院'; break;
            default: $deptName = '其他學院'; break;
        }
    }

    return ['dept' => $deptName, 'grade' => "1" . $year];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $password = $_POST['password'];
    $real_name = trim($_POST['real_name']);
    $nickname = trim($_POST['nickname']);
    
    if (empty($student_id) || empty($password) || empty($real_name)) {
        $message = __('fill_required');
        $messageType = "error";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM allowed_student_ids WHERE student_id = ?");
        $stmt->execute([$student_id]);
        if ($stmt->fetchColumn() == 0) {
            $message = __('whitelist_error');
            $messageType = "error";
        } else {
            $parsed = parseStudentId($student_id);
            $department = $parsed['dept'];
            $grade = $parsed['grade'];

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (student_id, password, real_name, nickname, department, grade) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$student_id, $hashed_password, $real_name, $nickname, $department, $grade]);
                $message = __('register_success') . " <a href='login.php'>" . __('login_here') . "</a>";
                $messageType = "success";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $message = __('already_registered');
                    $messageType = "error";
                } else {
                    $message = "Error: " . $e->getMessage();
                    $messageType = "error";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang == 'zh' ? 'zh-TW' : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('site_title'); ?> - <?php echo __('register'); ?></title>
    <link rel="stylesheet" href="style.css">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    <div class="auth-container">
        <h2>🎹 <?php echo __('register'); ?></h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label><?php echo __('student_id'); ?> *:</label>
                <input type="text" name="student_id" required placeholder="e.g., 312551000">
            </div>
            <div class="form-group">
                <label><?php echo __('password'); ?> *:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label><?php echo __('real_name'); ?> *:</label>
                <input type="text" name="real_name" required>
            </div>
            <div class="form-group">
                <label><?php echo __('nickname'); ?>:</label>
                <input type="text" name="nickname">
            </div>
            <p class="info"><?php echo __('dept_auto'); ?></p>
            <button type="submit" class="btn btn-success" style="width:100%;"><?php echo __('register_btn'); ?></button>
        </form>
        
        <p style="text-align:center; margin-top:20px;">
            <?php echo __('have_account'); ?> <a href="login.php"><?php echo __('login_here'); ?></a>
        </p>
        
        <p style="text-align:center; margin-top:10px;" class="lang-switch">
            <a href="?lang=zh" class="<?php echo $currentLang == 'zh' ? 'active' : ''; ?>">中文</a> | 
            <a href="?lang=en" class="<?php echo $currentLang == 'en' ? 'active' : ''; ?>">EN</a>
        </p>
    </div>

<?php include 'footer.php'; ?>
