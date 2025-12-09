<?php
/**
 * Language Translation Dictionary
 * Default: Traditional Chinese (zh-TW)
 */

// Initialize session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'zh';
}

// Handle language switch
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'zh'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'];

$translations = [
    'en' => [
        // General
        'please_login' => 'Please login first',
        'param_error' => 'Parameter error',
        'reservation_not_found' => 'Reservation not found',
        'cancel_1hour_limit' => 'Cancellation must be made at least 1 hour in advance',
        'cancel_success' => 'Cancellation successful',
        'reserve_30min_limit' => 'Reservation must be made at least 30 minutes in advance',
        'cancel_success' => 'Cancellation successful!',
        'cancel_1hour_limit' => 'Cancellation must be made at least 1 hour in advance',
        'daily_limit_exceeded' => 'Daily booking limit is 3 hours',
        'weekly_limit_exceeded' => 'Weekly booking limit is 8 hours',
        'reserve_success' => 'Reservation successful!',
        'view_reservations' => 'View Reservations',
        'all_user_reservations' => 'All users reservations',
        'all_reservations' => 'All Reservations',
        'my_reservations' => 'My Reservations',
        'room'            => 'Room',
        'date'            => 'Date',
        'time'            => 'Time',
        'action'          => 'Action',
        'cancel'          => 'Cancel',
        'cannot_cancel'  => 'Cannot cancel',
        'no_reservations'=> 'No reservations yet.',
        'confirm_cancel' => 'Are you sure you want to cancel this reservation?',
        'book_title' => 'Piano Room Reservation',
        'today_remain' => 'Today remaining hours',
        'week_remain' => 'Weekly remaining hours',
        'select_room' => 'Select Room',
        'reserve' => 'Reserve',
        'reserved' => 'Booked',
        'borrower' => 'Borrower',
        'my_booking' => '(Mine)',
        'confirm_reserve' => 'Confirm reservation?',
        'prev_week' => 'Previous Week',
        'next_week' => 'Next Week',
        'site_title' => 'NYCU Piano',
        'home' => 'Home',
        'login' => 'Login',
        'logout' => 'Logout',
        'register' => 'Register',
        'profile' => 'My Profile',
        'admin_dashboard' => 'Admin Dashboard',
        'book_room' => 'Book a Room',
        
        // Auth
        'student_id' => 'Student ID',
        'password' => 'Password',
        'real_name' => 'Real Name',
        'nickname' => 'Nickname',
        'login_btn' => 'Login',
        'register_btn' => 'Register',
        'no_account' => "Don't have an account?",
        'have_account' => 'Already have an account?',
        'register_here' => 'Register here',
        'login_here' => 'Login here',
        'dept_auto' => 'Your department will be automatically detected from your Student ID.',
        
        // Messages
        'login_error' => 'Invalid Student ID or Password.',
        'banned_error' => 'Access Denied: Your account has been suspended.',
        'whitelist_error' => 'Error: Student ID is not in the allowed whitelist.',
        'register_success' => 'Registration successful!',
        'already_registered' => 'Error: Student ID is already registered.',
        'fill_required' => 'Please fill in all required fields.',
        
        // Homepage
        'hello' => 'Hello',
        'grade_suffix' => '',
        'announcements' => 'Announcements',
        'no_announcements' => 'No announcements yet.',
        'posted_on' => 'Posted on',
        
        // Profile
        'my_profile' => 'My Profile',
        'usage_stats' => 'Usage Statistics',
        'total_hours' => 'Total Usage Hours',
        'edit_nickname' => 'Edit Nickname',
        'new_nickname' => 'New Nickname',
        'update_nickname' => 'Update Nickname',
        'change_password' => 'Change Password',
        'current_password' => 'Current Password',
        'new_password' => 'New Password',
        'confirm_password' => 'Confirm New Password',
        'update_password' => 'Update Password',
        'password_mismatch' => 'New passwords do not match.',
        'current_password_wrong' => 'Current password is incorrect.',
        'password_updated' => 'Password updated successfully!',
        'nickname_updated' => 'Nickname updated successfully!',
        
        // Admin
        'manage_whitelist' => 'Manage Whitelist',
        'manage_users' => 'Manage Users',
        'manage_announcements' => 'Manage Announcements',
        'view_member_site' => 'View Member Site',
        'add_to_whitelist' => 'Add to Whitelist',
        'add_new_student_id' => 'Add New Student ID',
        'remove' => 'Remove',
        'promote' => 'Promote',
        'demote' => 'Demote',
        'ban' => 'Ban',
        'unban' => 'Unban',
        'create_announcement' => 'Create New Announcement',
        'title' => 'Title',
        'content' => 'Content',
        'publish' => 'Publish',
        'delete' => 'Delete',
        'existing_announcements' => 'Existing Announcements',
        'back_to_dashboard' => '← Back to Dashboard',
    ],
    
    'zh' => [
        // General
        'please_login' => '請先登入',
        'param_error' => '參數錯誤',
        'reservation_not_found' => '找不到該預約',
        'cancel_1hour_limit' => '取消需提前至少 1 小時',
        'cancel_success' => '取消成功',

        'reserve_30min_limit' => '預約需提前至少 30 分鐘',
        'cancel_success' => '取消成功',
        'cancel_1hour_limit' => '取消需提前至少 1 小時',
        'daily_limit_exceeded' => '每日借用上限為 3 小時',
        'weekly_limit_exceeded' => '每週借用上限為 8 小時',
        'reserve_success' => '預約成功',
        'view_reservations' => '查看預約',
        'all_user_reservations' => '所有使用者的預約',
        'all_reservations' => '所有預約紀錄',
        'student_id' => '學號',
        'name' => '姓名',
        'room' => '琴房',
        'date' => '日期',
        'time' => '時間',
        'back_to_admin' => '← 返回後台',

        'my_reservations' => '我的預約',
        'room'            => '琴房',
        'date'            => '日期',
        'time'            => '時間',
        'action'          => '操作',
        'cancel'          => '取消',
        'cannot_cancel'  => '不可取消',
        'no_reservations'=> '目前沒有任何預約',
        'confirm_cancel' => '確定要取消此預約嗎？',
        'book_title' => '琴房預約',
        'today_remain' => '今日剩餘可借',
        'week_remain' => '本週剩餘可借',
        'select_room' => '選擇琴房',
        'reserve' => '預約',
        'reserved' => '已借用',
        'borrower' => '借用者',
        'my_booking' => '（我的）',
        'confirm_reserve' => '確定要預約嗎？',
        'prev_week' => '上一週',
        'next_week' => '下一週',
        'site_title' => 'NYCU Piano',
        'home' => '首頁',
        'login' => '登入',
        'logout' => '登出',
        'register' => '註冊',
        'profile' => '我的資料',
        'admin_dashboard' => '管理後台',
        'book_room' => '預約琴房',
        
        // Auth
        'student_id' => '學號',
        'password' => '密碼',
        'real_name' => '真實姓名',
        'nickname' => '暱稱',
        'login_btn' => '登入',
        'register_btn' => '註冊',
        'no_account' => '還沒有帳號？',
        'have_account' => '已經有帳號了？',
        'register_here' => '點此註冊',
        'login_here' => '點此登入',
        'dept_auto' => '系所將根據學號自動判斷。',
        
        // Messages
        'login_error' => '學號或密碼錯誤。',
        'banned_error' => '存取被拒：您的帳號已被停權。',
        'whitelist_error' => '錯誤：學號不在允許名單中。',
        'register_success' => '註冊成功！',
        'already_registered' => '錯誤：此學號已被註冊。',
        'fill_required' => '請填寫所有必填欄位。',
        
        // Homepage
        'hello' => '您好',
        'grade_suffix' => '級',
        'announcements' => '公告',
        'no_announcements' => '目前沒有公告。',
        'posted_on' => '發布於',
        
        // Profile
        'my_profile' => '我的資料',
        'usage_stats' => '使用統計',
        'total_hours' => '總使用時數',
        'edit_nickname' => '修改暱稱',
        'new_nickname' => '新暱稱',
        'update_nickname' => '更新暱稱',
        'change_password' => '變更密碼',
        'current_password' => '目前密碼',
        'new_password' => '新密碼',
        'confirm_password' => '確認新密碼',
        'update_password' => '更新密碼',
        'password_mismatch' => '新密碼不一致。',
        'current_password_wrong' => '目前密碼錯誤。',
        'password_updated' => '密碼更新成功！',
        'nickname_updated' => '暱稱更新成功！',
        
        // Admin
        'manage_whitelist' => '管理白名單',
        'manage_users' => '管理使用者',
        'manage_announcements' => '管理公告',
        'view_member_site' => '查看社員頁面',
        'add_to_whitelist' => '加入白名單',
        'add_new_student_id' => '新增學號',
        'remove' => '移除',
        'promote' => '升為幹部',
        'demote' => '降為社員',
        'ban' => '停權',
        'unban' => '解除停權',
        'create_announcement' => '新增公告',
        'title' => '標題',
        'content' => '內容',
        'publish' => '發布',
        'delete' => '刪除',
        'existing_announcements' => '現有公告',
        'back_to_dashboard' => '← 返回管理後台',
    ]
];

// Helper function to get translation
function __($key) {
    global $translations, $currentLang;
    return isset($translations[$currentLang][$key]) ? $translations[$currentLang][$key] : $key;
}
?>
