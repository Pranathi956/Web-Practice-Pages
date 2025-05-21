CREATE DATABASE IF NOT EXISTS library;

USE library;

CREATE TABLE donated_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_name VARCHAR(100),
    book_title VARCHAR(255),
    author VARCHAR(100),
    genre VARCHAR(50),
    donation_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
