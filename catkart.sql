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
    description TEXT,
    category VARCHAR(50) DEFAULT 'breed'
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

-- Seed data: Cat Breeds
INSERT INTO breeds (breed, price, quantity, image, description, category) VALUES
('Persian',           22000, 3, 'images/persian.png',           'Fluffy, calm, and affectionate breed with a luxury personality.', 'breed'),
('Siamese',           18000, 5, 'images/siamese.png',           'Talkative and intelligent with striking blue eyes.',               'breed'),
('Maine Coon',        25000, 2, 'images/maine_coon.png',        'Large, friendly and ruggedly handsome, built for family life.',    'breed'),
('Bengal',            28000, 4, 'images/bengal.png',            'Exotic spotted coat with an adventurous, playful spirit.',         'breed'),
('Sphynx',            45000, 2, 'images/sphynx.png',            'Hairless, energetic, and highly affectionate.',                    'breed'),
('Ragdoll',           30000, 3, 'images/ragdoll.png',           'Docile, placid, and affectionate nature.',                         'breed'),
('British Shorthair', 26000, 4, 'images/british_shorthair.jpg', 'Chunky body, dense coat, and a broad face.',                       'breed'),
('Scottish Fold',     35000, 1, 'images/scottish_fold.png',     'Known for their unique folded ears and owl-like appearance.',      'breed'),

-- Seed data: Accessories
('Cat Collar',        499,  15, 'images/collar.png',            'Stylish leather collar with a small bell.',                        'accessory'),
('Cat Scratching Post',1800, 5, 'images/scratching_post.jpg',   'Durable sisal fiber post for claw exercise.',                      'accessory'),
('Cat Toy Mouse',     250,  30, 'images/toy_mouse.png',         'Soft plush mouse with catnip inside.',                             'accessory'),
('Cat Carrier',       2200,  8, 'images/carrier.png',           'Comfortable and secure travel carrier.',                           'accessory'),
('Cat Bed',           1299, 12, 'images/catbed.png',           'Soft bed for cats to curl up and sleep comfortably.',              'accessory'),
('LED Cat Toy',       699,  12, 'images/led_cat_toy.png',       'Battery-powered light toy to keep cats entertained.',             'accessory'),
('Feline Grooming Kit',1299, 10, 'images/feline_grooming_kit.png','Brush, comb, and nail clipper set for healthy fur care.',         'accessory'),
('Window Perch',      1499,  6, 'images/window_perch.png',      'Safe window perch for napping and bird watching.',                'accessory'),
('Catnip Wand',       349,  18, 'images/catnip_wand.png',        'Interactive catnip wand for active play sessions.',               'accessory'),

-- Seed data: Cat Food
('Premium Cat Kibble', 1200, 20, 'images/kibble.jpg',           'Nutritious dry food for healthy growth.',                          'food'),
('Wet Salmon Feast',    150, 50, 'images/salmon_feast.png',     'Delicious wet food rich in Omega-3.',                              'food'),
('Cat Treats',          350, 40, 'images/treats.png',           'Crunchy chicken-flavored rewards.',                                'food'),
('Organic Cat Grass',   299, 12, 'images/cat_grass.png',        'Fresh growing grass for digestion help.',                          'food'),
('Grain-Free Chicken Pate', 1400, 22, 'images/grain_free_chicken_pate.png', 'High-protein grain-free pate for sensitive stomachs.', 'food'),
('Salmon & Tuna Feast',  220, 36, 'images/salmon_tuna_feast.png', 'Premium seafood blend for picky eaters.',                          'food'),
('Organic Turkey Meal', 1100, 18, 'images/organic_turkey_meal.png', 'Organic turkey and veggie meal for daily health.',             'food'),
('Dental Care Snacks',   320, 25, 'images/dental_care_snacks.png', 'Crunchy dental treats to support healthy teeth.',              'food')

ON DUPLICATE KEY UPDATE
    price       = VALUES(price),
    quantity    = VALUES(quantity),
    image       = VALUES(image),
    description = VALUES(description),
    category    = VALUES(category);
