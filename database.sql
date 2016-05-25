CREATE DATABASE IF NOT EXISTS duoshoudang CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS duoshoudang.users
(
    user_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(50) NOT NULL,
    salt VARCHAR(6) NOT NULL,
    type VARCHAR(12) NOT NULL,
    regtime INT(11),
    INDEX ('email')
);

CREATE TABLE IF NOT EXISTS duoshoudang.authorization
(
    token VARCHAR(32) PRIMARY KEY NOT NULL,
    user_id INT(11) NOT NULL,
    tokentime INT(11) NOT NULL,
    type VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS duoshoudang.goods
(
    gid INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL,
    cid INT(6) NOT NULL,
    info TEXT NOT NULL,
    abstract TEXT NOT NULL,
    description LONGTEXT NOT NULL,
    remains INT(11) NOT NULL,
    timestamp INT(11),
    FOREIGN KEY (cid) REFERENCES category(cid)
);

CREATE TABLE IF NOT EXISTS duoshoudang.category
(
    cid INT(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL
);

CREATE TABLE duoshoudang.shopping_cart
(
    user_id INT NOT NULL,
    good_id INT NOT NULL,
    number INT,
    sort_identifier VARCHAR(20) NOT NULL,
    CONSTRAINT PRIMARY KEY (user_id, good_id, sort_identifier)
);
