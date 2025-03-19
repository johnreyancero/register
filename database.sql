CREATE DATABASE user;
USE user;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idno VARCHAR(20) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    midname VARCHAR(50),
    course VARCHAR(100) NOT NULL,
    year_level INT NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
