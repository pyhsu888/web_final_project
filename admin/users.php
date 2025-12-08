<?php
session_start();
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

// Handle Actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $target_id = $_GET['id'];

    if ($target_id == $_SESSION['user_id']) {
        $message = "You cannot modify your own account.";
    } else {
        try {
            if ($action === 'promote') {
                $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
                $stmt->execute([$target_id]);
                $message = "User promoted to Admin.";
            } elseif ($action === 'demote') {
                $stmt = $pdo->prepare("UPDATE users SET role = 'member' WHERE id = ?");
                $stmt->execute([$target_id]);
                $message = "User demoted to Member.";
            } elseif ($action === 'ban') {
                $stmt = $pdo->prepare("UPDATE users SET status = 'banned' WHERE id = ?");
                $stmt->execute([$target_id]);
                $message = "User has been banned.";
            } elseif ($action === 'unban') {
                $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ?");
                $stmt->execute([$target_id]);
                $message = "User has been unbanned.";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

$users_list = $pdo->query("SELECT * FROM users ORDER BY student_id")->fetchAll();

include '../header.php';
?>

<div class="container">
    <a href="dashboard.php"><?php echo __('back_to_dashboard'); ?></a>
    <h2 class="section-title"><?php echo __('manage_users'); ?></h2>

    <?php if ($message): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th><?php echo __('student_id'); ?></th>
                <th><?php echo __('real_name'); ?></th>
                <th>Dept / Grade</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users_list as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($u['real_name']); ?></td>
                    <td><?php echo htmlspecialchars($u['department']); ?> <?php echo htmlspecialchars($u['grade']); ?><?php echo __('grade_suffix'); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $u['role']; ?>">
                            <?php echo ucfirst($u['role']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($u['status'] == 'banned'): ?>
                            <span class="badge badge-banned">Banned</span>
                        <?php else: ?>
                            Active
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($u['role'] === 'member'): ?>
                            <a href="?action=promote&id=<?php echo $u['id']; ?>" class="btn btn-primary btn-sm" onclick="return confirm('<?php echo __('promote'); ?>?');"><?php echo __('promote'); ?></a>
                        <?php else: ?>
                            <a href="?action=demote&id=<?php echo $u['id']; ?>" class="btn btn-warning btn-sm" onclick="return confirm('<?php echo __('demote'); ?>?');"><?php echo __('demote'); ?></a>
                        <?php endif; ?>

                        <?php if ($u['status'] === 'active'): ?>
                            <a href="?action=ban&id=<?php echo $u['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo __('ban'); ?>?');"><?php echo __('ban'); ?></a>
                        <?php else: ?>
                            <a href="?action=unban&id=<?php echo $u['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('<?php echo __('unban'); ?>?');"><?php echo __('unban'); ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
