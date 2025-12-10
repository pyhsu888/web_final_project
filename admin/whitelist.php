<?php
session_start(); date_default_timezone_set('Asia/Taipei');
$isAdmin = true;
require '../db_connect.php';
require '../lang.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch user for header display
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$message = '';

// Handle Add
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_id'])) {
    $new_id = trim($_POST['student_id']);
    if (!empty($new_id)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO allowed_student_ids (student_id) VALUES (?)");
            $stmt->execute([$new_id]);
            $message = "Added $new_id to whitelist.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM allowed_student_ids WHERE student_id = ?");
        $stmt->execute([$id_to_delete]);
        $message = "Removed $id_to_delete from whitelist.";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

$whitelist = $pdo->query("SELECT * FROM allowed_student_ids ORDER BY student_id")->fetchAll();

include '../header.php';
?>

<div class="container">
    <a href="dashboard.php"><?php echo __('back_to_dashboard'); ?></a>
    <h2 class="section-title"><?php echo __('manage_whitelist'); ?></h2>
    
    <?php if ($message): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="card">
        <h4><?php echo __('add_new_student_id'); ?></h4>
        <form method="POST" style="display:flex; gap:10px; align-items:flex-end;">
            <div class="form-group" style="flex:1; margin-bottom:0;">
                <input type="text" name="student_id" placeholder="<?php echo __('student_id'); ?>" required>
            </div>
            <button type="submit" name="add_id" class="btn btn-success"><?php echo __('add_to_whitelist'); ?></button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th><?php echo __('student_id'); ?></th>
                <th style="width:50px;"><div style="display: flex; align-items: center; justify-content: center;">Action</div></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($whitelist as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td>
                        <a href="?delete=<?php echo urlencode($row['student_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><?php echo __('remove'); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>