CREATE DATABASE IF NOT EXISTS minichat;

USE minichat;

CREATE TABLE IF NOT EXISTS users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    pseudo VARCHAR(50) UNIQUE,
    password VARCHAR(50),
    create_at DATETIME,
    color VARCHAR(7)
);

CREATE TABLE IF NOT EXISTS messages (
    id_message INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT
);

CREATE TABLE IF NOT EXISTS ip_address (
    id_ip_address INT PRIMARY KEY AUTO_INCREMENT,
    ip_address VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS users_ip_address (
    id_user INT REFERENCES users(id_user),
    id_ip_address INT REFERENCES ip_address(id_ip_address),
    PRIMARY KEY(id_user,id_ip_address)
);

CREATE TABLE IF NOT EXISTS users_messages (
    id_user INT REFERENCES users(id_user),
    id_message INT REFERENCES messages(id_message),
    date_time DATETIME,
    PRIMARY KEY(id_user,id_message)
);

