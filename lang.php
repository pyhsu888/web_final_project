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
        // --- General ---
        'please_login' => 'Please login first',
        'param_error' => 'Parameter error',
        'reservation_not_found' => 'Reservation not found',
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
        'cannot_cancel'   => 'Cannot cancel',
        'no_reservations' => 'No reservations yet.',
        'confirm_cancel'  => 'Are you sure you want to cancel this reservation?',
        'book_title'      => 'Piano Room Reservation',
        'today_remain'    => 'Today remaining hours',
        'week_remain'     => 'Weekly remaining hours',
        'select_room'     => 'Select Room',
        'reserve'         => 'Reserve',
        'reserved'        => 'Booked',
        'borrower'        => 'Borrower',
        'my_booking'      => '(Mine)',
        'confirm_reserve' => 'Confirm reservation?',
        'prev_week'       => 'Previous Week',
        'next_week'       => 'Next Week',
        'site_title'      => 'NYCU Piano',
        'home'            => 'Home',
        'login'           => 'Login',
        'logout'          => 'Logout',
        'register'        => 'Register',
        'profile'         => 'My Profile',
        'admin_dashboard' => 'Admin Dashboard',
        'book_room'       => 'Book a Room',
        'deadline_past'   => 'Passed',
        
        // --- Auth ---
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
        
        // --- Messages ---
        'login_error' => 'Invalid Student ID or Password.',
        'banned_error' => 'Access Denied: Your account has been suspended.',
        'whitelist_error' => 'Error: Student ID is not in the allowed whitelist.',
        'register_success' => 'Registration successful!',
        'already_registered' => 'Error: Student ID is already registered.',
        'fill_required' => 'Please fill in all required fields.',
        
        // --- Homepage ---
        'hello' => 'Hello',
        'grade_suffix' => '',
        'announcements' => 'Announcements',
        'no_announcements' => 'No announcements yet.',
        'posted_on' => 'Posted on',
        
        // --- Profile ---
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
        
        // --- Admin ---
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

        // --- System Time ---
        'system_time' => 'System Time',

        // --- Manual ---
        'manual' => 'User Manual',
        'manual_title' => 'Piano Room User Manual & Regulations',
        'manual_section_1_title' => 'Reservation Rules',
        'manual_section_1_content_1' => 'Please follow these rules to ensure fair use:',
        'manual_section_1_list_1' => 'Daily limit: 3 hours.',
        'manual_section_1_list_2' => 'Weekly limit: 8 hours.',
        'manual_section_1_list_3' => 'Reservations must be made at least 30 minutes in advance.',
        'manual_section_2_title' => 'Cancellation Policy',
        'manual_section_2_content_1' => 'To cancel a reservation:',
        'manual_section_2_step_1' => 'Go to the "My Reservations" page.',
        'manual_section_2_step_2' => 'Click the "Cancel" button next to the booking.',
        'manual_section_2_step_3' => 'Cancellation must be completed at least 1 hour before the start time.',

        'manual_step_title' => 'System Guide',
        'step_1_title' => '1. Home (Announcements)',
        'step_1_desc'  => 'The default page after login.<br>You can view the latest announcements and important notices here.',
        'step_2_title' => '2. Book a Room',
        'step_2_desc'  => 'Select a room (409 or 417) and click a slot to reserve.<br>You can book slots for the current and next week.<br><b><font color="#bbb">Light Grey</font></b>: Available,<br><b><font color="#999">Medium Grey</font></b>: Expired/Past,<br><b><font color="#666">Dark Grey</font></b>: Booked by others,<br><b><font color="#4caf50">Green</font></b>: Booked by you.',
        'step_3_title' => '3. My Profile',
        'step_3_desc'  => 'Manage your account here:<br><b>Usage Stats</b>: View total hours used.<br><b>Edit Nickname</b>: Change the name displayed on the schedule.<br><b>Change Password</b>: Update your password using your current one.',
        'step_4_title' => '4. My Reservations',
        'step_4_desc'  => 'This page lists all your bookings by date.<br><b>Booking Info</b>: Includes room number, date, and time.<br><b>Cancel</b>: Click the red "Cancel" button to remove a booking.<br>Note: Must cancel at least <b>1 hour</b> before start time, otherwise the button will not appear.',
        'step_5_title' => '5. Midnight Snack',
        'step_5_desc'  => 'Join a group order for snacks or drinks.<br>
                           <b>Place Order</b>: Enter item name and notes (e.g., "No ice"), then submit.<br>
                           <b>Manage</b>: You can update or cancel your order before the deadline.<br>
                           <b>Partners</b>: See who else has ordered in the list below.<br>
                           Note: If you see 😴, it means no sessions are currently active.',

        // --- Food Ordering System (Consolidated) ---
        'food_system' => 'Food Ordering System',
        'food_admin' => 'Food Management',
        // Session Management
        'create_session' => 'Create New Session',
        'restaurant_name' => 'Restaurant / Shop Name',
        'menu_desc' => 'Menu Description',
        'menu_desc_placeholder' => 'Ex: Fried Chicken, Bubble Tea, Menu Link...',
        'close_time' => 'Order Deadline',
        'is_active' => 'Status',
        'open' => 'Open',
        'closed' => 'Closed',
        'history_records' => 'History Records',
        'deadline' => 'Deadline:',
        'toggle_status' => 'Toggle Status',
        'update' => 'Update',
        'session_created' => 'Session created!',
        'no_active_sessions' => 'No active food sessions currently.',
        'view_orders' => 'View Orders',
        'total_orders' => 'Total Orders',
        'order_unit' => 'orders',
        // Ordering
        'order_item' => 'Item Name',
        'enter_food_name' => 'Please enter item name',
        'order_note' => 'Notes',
        'item_name' => 'Item',
        'notes' => 'Notes',
        'submit_order' => 'Submit Order',
        'update_order' => 'Update Order',
        'order_saved' => 'Order saved successfully!',
        'cancel_order_btn' => 'Cancel Order',
        'order_cancelled_msg' => 'Order cancelled.',
        'confirm_cancel_order' => 'Are you sure you want to cancel this order?',
        'deadline_time' => '⏰ Deadline: ',
        'partners_ordered' => 'Others who ordered:',
        'you_ordered' => 'You ordered:',
        'no_orders' => 'No orders yet',
    ],
    
    'zh' => [
        // --- General ---
        'please_login' => '請先登入',
        'param_error' => '參數錯誤',
        'reservation_not_found' => '找不到該預約',
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
        'back_to_admin' => '← 返回後台',

        'my_reservations' => '我的預約',
        'room'            => '琴房',
        'date'            => '日期',
        'time'            => '時間',
        'action'          => '操作',
        'cancel'          => '取消',
        'cannot_cancel'   => '不可取消',
        'no_reservations' => '目前沒有任何預約',
        'confirm_cancel'  => '確定要取消此預約嗎？',
        'book_title'      => '琴房預約',
        'today_remain'    => '今日剩餘可借',
        'week_remain'     => '本週剩餘可借',
        'select_room'     => '選擇琴房',
        'reserve'         => '預約',
        'reserved'        => '已借用',
        'borrower'        => '借用者',
        'my_booking'      => '（我的）',
        'confirm_reserve' => '確定要預約嗎？',
        'prev_week'       => '上一週',
        'next_week'       => '下一週',
        'site_title'      => 'NYCU Piano',
        'home'            => '首頁',
        'login'           => '登入',
        'logout'          => '登出',
        'register'        => '註冊',
        'profile'         => '我的資料',
        'admin_dashboard' => '管理後台',
        'book_room'       => '預約琴房',
        'deadline_past'   => '已過',
        
        // --- Auth ---
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
        
        // --- Messages ---
        'login_error' => '學號或密碼錯誤。',
        'banned_error' => '存取被拒：您的帳號已被停權。',
        'whitelist_error' => '錯誤：學號不在允許名單中。',
        'register_success' => '註冊成功！',
        'already_registered' => '錯誤：此學號已被註冊。',
        'fill_required' => '請填寫所有必填欄位。',
        
        // --- Homepage ---
        'hello' => '您好',
        'grade_suffix' => '級',
        'announcements' => '公告',
        'no_announcements' => '目前沒有公告。',
        'posted_on' => '發布於',
        
        // --- Profile ---
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
        
        // --- Admin ---
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

        // --- System Time ---
        'system_time' => '系統時間',

        // --- Manual ---
        'manual' => '使用說明',
        'manual_title' => '琴房使用說明與規定',
        'manual_section_1_title' => '預約規定',
        'manual_section_1_content_1' => '請遵守以下規定，確保公平使用：',
        'manual_section_1_list_1' => '每日預約上限：3 小時。',
        'manual_section_1_list_2' => '每週預約上限：8 小時。',
        'manual_section_1_list_3' => '預約時段需提前至少 30 分鐘。',
        'manual_section_2_title' => '取消政策',
        'manual_section_2_content_1' => '如需取消預約：',
        'manual_section_2_step_1' => '前往「我的預約」頁面。',
        'manual_section_2_step_2' => '點擊該預約旁的「取消」按鈕。',
        'manual_section_2_step_3' => '取消操作必須在預約開始前至少 1 小時完成。',

        'manual_step_title' => '系統說明',
        'step_1_title' => '1. 首頁(公告)',
        'step_1_desc'  => '登入後的預設頁面。<br>您可以在此查看系統最新公告與重要通知。',
        'step_2_title' => '2. 預約琴房',
        'step_2_desc'  => '選擇琴房（409 或 417）並點擊時段預約，<br>可以預約本周與下周的時段。<br><b><font color="#bbb">淺灰</font></b>：可預約、<b><font color="#999">一般灰</font></b>：預約時間已過、<br><b><font color="#666">深灰</font></b>：已被其他人預約、<b><font color="#4caf50">綠</font></b>：已被您預約。',
        'step_3_title' => '3. 我的資料',
        'step_3_desc'  => '此頁面提供帳戶管理功能：<br><b>使用統計</b>：查看累積的借用時數。<br><b>修改暱稱</b>：更改在預約表格上顯示的名字。<br><b>變更密碼</b>：輸入舊密碼與新密碼即可修改。',
        'step_4_title' => '4. 我的預約',
        'step_4_desc'  => '此頁面會依日期列出您的所有預約。<br><b>預約資訊</b>：包含琴房編號、日期與起訖時間。<br><b>取消預約</b>：點擊紅色的「取消」按鈕即可退訂。<br>注意：必須在開始時間的 <b>1 小時前</b> 才能取消，否則按鈕將不會顯示。',
        'step_5_title' => '5. 點宵夜系統',
        'step_5_desc'  => '與大家一起團購宵夜或飲料。<br>
                           <b>如何點餐</b>：輸入餐點名稱與備註（如：微辣），點擊「送出訂單」。<br>
                           <b>修改/取消</b>：在截止時間前，您可以隨時修改內容或點擊紅色按鈕取消。<br>
                           <b>點餐夥伴</b>：下方列表會顯示還有誰也參與了這次點餐。<br>
                           注意：若顯示 😴 符號，代表目前沒有開放中的點餐。',

        // --- Food Ordering System (Consolidated) ---
        'food_system' => '點餐系統',
        'food_admin' => '消夜管理',
        // Session Management
        'create_session' => '開新消夜局',
        'restaurant_name' => '餐廳/店家名稱',
        'menu_desc' => '菜單/說明',
        'menu_desc_placeholder' => '例如: 雞排、珍奶、菜單連結...',
        'close_time' => '收單時間',
        'is_active' => '狀態',
        'open' => '開放',
        'closed' => '已結單',
        'history_records' => '歷史紀錄',
        'deadline' => '截止:',
        'toggle_status' => '切換狀態',
        'update' => '修改',
        'session_created' => '團購已發起！',
        'no_active_sessions' => '目前沒有開放的點餐',
        'view_orders' => '查看訂單',
        'total_orders' => '訂單總數',
        'order_unit' => '份訂單',
        // Ordering
        'order_item' => '餐點名稱',
        'enter_food_name' => '請輸入餐點名稱',
        'order_note' => '備註',
        'item_name' => '品項',
        'notes' => '備註',
        'submit_order' => '送出訂單',
        'update_order' => '更新訂單',
        'order_saved' => '訂單已儲存！',
        'cancel_order_btn' => '取消訂單',
        'order_cancelled_msg' => '訂單已取消',
        'confirm_cancel_order' => '確定要取消這筆訂單嗎？',
        'deadline_time' => '⏰ 截止時間: ',
        'partners_ordered' => '已點餐夥伴:',
        'you_ordered' => '你的餐點:',
        'no_orders' => '尚無訂單',
    ]
];

// Helper function to get translation
function __($key) {
    global $translations, $currentLang;
    return isset($translations[$currentLang][$key]) ? $translations[$currentLang][$key] : $key;
}
?>