CREATE DATABASE tendering;

USE tendering;

CREATE TABLE User (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32) NOT NULL,
    email VARCHAR(32) NOT NULL UNIQUE,
    org VARCHAR(32),
    gender VARCHAR(8) NOT NULL,
    password VARCHAR(16) NOT NULL
);


CREATE TABLE Seller (
    seller_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED UNIQUE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

CREATE TABLE Buyer (
    buyer_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED UNIQUE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

CREATE TABLE Tender (
    tender_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(32) NOT NULL,
    description VARCHAR(255),
    payment VARCHAR(16),
    seller_id INT UNSIGNED,
    FOREIGN KEY (seller_id) REFERENCES Seller(seller_id)
);

CREATE TABLE Contract (
    cont_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(32),
    description VARCHAR(255),
    tender_id INT UNSIGNED,
    buyer_id INT UNSIGNED,
    FOREIGN KEY (tender_id) REFERENCES Tender(tender_id),
    FOREIGN KEY (buyer_id) REFERENCES Buyer(buyer_id)
);