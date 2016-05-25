CREATE DATABASE duoshoudang CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE TABLE duoshoudang.users
(
    user_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(50) NOT NULL,
    salt VARCHAR(6) NOT NULL,
    type VARCHAR(12) NOT NULL,
    regtime INT(11)
);
CREATE UNIQUE INDEX email ON duoshoudang.users (email);

CREATE TABLE duoshoudang.authorization
(
    token VARCHAR(32) PRIMARY KEY NOT NULL,
    user_id INT(11) NOT NULL,
    tokentime INT(11) NOT NULL,
    type VARCHAR(10) NOT NULL
);
