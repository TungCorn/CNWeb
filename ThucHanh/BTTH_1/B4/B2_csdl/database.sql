CREATE DATABASE IF NOT EXISTS quiz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quiz_db;

CREATE TABLE questions (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           question TEXT NOT NULL,
                           option_a VARCHAR(255) NOT NULL,
                           option_b VARCHAR(255) NOT NULL,
                           option_c VARCHAR(255) NOT NULL,
                           option_d VARCHAR(255) NOT NULL,
                           correct_answer CHAR(1) NOT NULL,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
