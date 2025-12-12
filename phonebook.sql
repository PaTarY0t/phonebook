CREATE DATABASE IF NOT EXISTS phonebook;
USE phonebook;

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    photo VARCHAR(255)
);
