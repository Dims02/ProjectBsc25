CREATE DATABASE IF NOT EXISTS surveydb CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE surveydb;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    entity VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL UNIQUE,
    password VARCHAR(255) DEFAULT NULL,
    country VARCHAR(100) DEFAULT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Surveys Table
CREATE TABLE IF NOT EXISTS surveys (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    user_id INT(11) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY user_id (user_id),
    CONSTRAINT surveys_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Question Groups Table
CREATE TABLE IF NOT EXISTS question_groups (
    id INT(11) NOT NULL AUTO_INCREMENT,
    survey_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    recommendation VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    KEY survey_id (survey_id),
    CONSTRAINT question_groups_ibfk_1 FOREIGN KEY (survey_id) REFERENCES surveys (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Questions Table
CREATE TABLE IF NOT EXISTS questions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    group_id INT(11) NOT NULL,
    text TEXT NOT NULL,
    PRIMARY KEY (id),
    KEY group_id (group_id),
    CONSTRAINT questions_ibfk_1 FOREIGN KEY (group_id) REFERENCES question_groups (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Options Table
CREATE TABLE IF NOT EXISTS options (
    id INT(11) NOT NULL AUTO_INCREMENT,
    question_id INT(11) NOT NULL,
    option_text VARCHAR(255) NOT NULL,
    correct TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY question_id (question_id),
    CONSTRAINT options_ibfk_1 FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Responses Table
CREATE TABLE IF NOT EXISTS responses (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    question_id INT(11) NOT NULL,
    answer TEXT NOT NULL,
    PRIMARY KEY (id),
    KEY user_id (user_id),
    KEY question_id (question_id),
    CONSTRAINT responses_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT responses_ibfk_2 FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
