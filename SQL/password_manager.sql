CREATE DATABASE password_manager;

USE password_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    encryption_key TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE passwords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    website_name VARCHAR(255) NOT NULL,
    encrypted_password TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);