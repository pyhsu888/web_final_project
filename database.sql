CREATE DATABASE IF NOT EXISTS piano_room_db;
USE piano_room_db;

-- Create User and Grant Permissions (Fix for Access Denied)
-- CREATE USER IF NOT EXISTS 'CVML'@'localhost' IDENTIFIED BY '114DWP2025';
-- GRANT ALL PRIVILEGES ON piano_room_db.* TO 'CVML'@'localhost';
-- FLUSH PRIVILEGES;

-- Whitelist Table
CREATE TABLE IF NOT EXISTS allowed_student_ids (
    student_id VARCHAR(50) PRIMARY KEY
);

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    real_name VARCHAR(100) NOT NULL,
    nickname VARCHAR(100),
    department VARCHAR(100),
    grade VARCHAR(20),
    role ENUM('admin', 'member') DEFAULT 'member',
    total_usage_hours FLOAT DEFAULT 0,
    status ENUM('active', 'banned') DEFAULT 'active',
    FOREIGN KEY (student_id) REFERENCES allowed_student_ids(student_id) ON DELETE CASCADE
);

-- Announcements Table
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS reservations;

-- Reservations Table (Placeholder)
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room ENUM('409','417') NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS food_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    start_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    end_time DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS food_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    note VARCHAR(255) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES food_sessions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_session (user_id, session_id)
);

-- Clear old data
DELETE FROM food_orders;
DELETE FROM food_sessions;
DELETE FROM reservations;
DELETE FROM users;
DELETE FROM allowed_student_ids;

-- Dummy Data: Whitelist
INSERT IGNORE INTO allowed_student_ids (student_id) VALUES 
('312551000'), ('311512000'), ('310550000');

-- Dummy Data: Users (Password is '123456')
INSERT IGNORE INTO users (student_id, password, real_name, nickname, department, grade, role, status) VALUES 
('312551000', '$2y$12$2EznCrINxOkACIv0PXWxC.9s21U/GFddESbs1a9WToRjckvfvjPQC', 'Super Admin', 'Admin', '資科工碩 (IOC)', '112', 'admin', 'active'),
('311512000', '$2y$12$2EznCrINxOkACIv0PXWxC.9s21U/GFddESbs1a9WToRjckvfvjPQC', 'John Doe', 'Johnny', '電控所 (ICN)', '111', 'member', 'active');
