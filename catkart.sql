CREATE DATABASE IF NOT EXISTS catkart;
USE catkart;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(15),
    address TEXT,
    pincode VARCHAR(10),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS breeds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    breed VARCHAR(100) UNIQUE,
    price INT,
    quantity INT DEFAULT 0,
    image VARCHAR(255),
    description TEXT
);

CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    item_name VARCHAR(100),
    price INT,
    quantity INT DEFAULT 1
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    items TEXT,
    total_amount DECIMAL(10,2),
    payment_method VARCHAR(20),
    delivery_address TEXT,
    order_status VARCHAR(20),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO breeds (breed, price, quantity, image, description) VALUES
('Bengal', 28000, 4, 'images/bengal.jpg', 'Exotic spotted coat with an adventurous, playful spirit.'),
('British Shorthair', 20000, 6, 'images/british-shorthair.jpg', 'Quiet and easygoing British Shorthair with plush blue-gray coat.'),
('Maine Coon', 25000, 2, 'images/maine-coon.jpg', 'Large, friendly and ruggedly handsome, built for family life.'),
('Persian', 22000, 3, 'images/persian.jpg', 'Fluffy, calm, and affectionate breed with a luxury personality.'),
('Ragdoll', 24000, 5, 'images/ragdoll.jpg', 'Gentle and loving Ragdoll with striking blue eyes.'),
('Scottish Fold', 21000, 4, 'images/scottish-fold.jpg', 'Sweet-faced Scottish Fold with folded ears and plush coat.'),
('Sphynx', 30000, 2, 'images/sphynx.jpg', 'Hairless Sphynx with a playful and affectionate temperament.');
