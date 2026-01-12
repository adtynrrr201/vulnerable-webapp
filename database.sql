-- Database setup for vulnerable web application
CREATE DATABASE IF NOT EXISTS vulnerable_app;
USE vulnerable_app;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample users (plain text passwords for demo)
INSERT INTO users (username, password, email) VALUES
('admin', 'admin123', 'admin@example.com'),
('user1', 'password1', 'user1@example.com'),
('test', 'test123', 'test@example.com'),
('guest', 'guest123', 'guest@example.com');

-- Create a more sensitive table for demonstration
CREATE TABLE IF NOT EXISTS sensitive_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_type VARCHAR(50),
    secret_info TEXT,
    access_level VARCHAR(20)
);

INSERT INTO sensitive_data (data_type, secret_info, access_level) VALUES
('api_keys', 'API_KEY_12345_SECRET', 'admin'),
('database', 'DB_CONNECTION_STRING', 'admin'),
('config', 'APP_SECRET_CONFIG', 'admin'),
('user_data', 'User personal information', 'user');