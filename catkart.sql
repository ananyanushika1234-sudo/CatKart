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
('Persian', 22000, 3, 'https://images.unsplash.com/photo-1518791841217-8f162f1912da?auto=format&fit=crop&w=800&q=80', 'Fluffy, calm, and affectionate breed with a luxury personality.'),
('Siamese', 18000, 5, 'https://images.unsplash.com/photo-1597932256378-16d7d4264e62?auto=format&fit=crop&w=800&q=80', 'Talkative and intelligent with striking blue eyes.'),
('Maine Coon', 25000, 2, 'https://images.unsplash.com/photo-1525253086316-d0c936c814f8?auto=format&fit=crop&w=800&q=80', 'Large, friendly and ruggedly handsome, built for family life.'),
('Bengal', 28000, 4, 'https://images.unsplash.com/photo-1543852786-1cf6624b9987?auto=format&fit=crop&w=800&q=80', 'Exotic spotted coat with an adventurous, playful spirit.');
