-- =========================================================
--  HABIT TRACKER — DATABASE SCHEMA
--  Import this file first (e.g. via phpMyAdmin or:
--  mysql -u root -p < database.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS habit_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE habit_tracker;

CREATE TABLE IF NOT EXISTS habits (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    icon       VARCHAR(10)  NOT NULL DEFAULT '⭐',
    color      VARCHAR(20)  NOT NULL DEFAULT '#ff2e63',
    sort_order INT          NOT NULL DEFAULT 0,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS habit_logs (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    habit_id   INT  NOT NULL,
    log_date   DATE NOT NULL,
    completed  TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY unique_log (habit_id, log_date),
    CONSTRAINT fk_habit
        FOREIGN KEY (habit_id) REFERENCES habits(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- A few starter habits so the board isn't empty on first load
INSERT INTO habits (name, icon, color, sort_order) VALUES
('Drink Water',  '💧', '#08d9d6', 1),
('Read 20 Pages','📚', '#ffcc00', 2),
('Workout',      '💪', '#ff2e63', 3);
