DROP DATABASE IF EXISTS `olx_db`; -- re migrate

CREATE DATABASE `olx_db`;

USE `olx_db`;

CREATE TABLE `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(255) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- CREATE TABLE `user_profiles` (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT,
--     profile_image VARCHAR(255) DEFAULT NULL,
--     bio TEXT DEFAULT NULL,
--     location VARCHAR(255) DEFAULT NULL,
--     phone VARCHAR(255) DEFAULT NULL,
--     last_active TIMESTAMP NULL DEFAULT NULL,
--     likes INT DEFAULT 0,
--     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );

-- belongs to ( user )
CREATE TABLE `articles` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- categories::start
-- base
CREATE TABLE `categories` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- relations
CREATE TABLE `article_categories` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    category_id INT,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
-- categories::end

-- tags::start
-- base
CREATE TABLE `tags` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- relations
CREATE TABLE `article_tags` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    tag_id INT,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
-- tags::end