# 🐱 CatKart

A PHP-based cat e-commerce store featuring cat breeds, accessories, and cat food — with an AJAX cart, live stock updates, and a fixed toggleable sidebar.

## Features
- Browse **Cat Breeds**, **Accessories**, and **Cat Food** categories
- Add to cart with real-time stock counter updates (AJAX)
- Cart with AJAX +/- quantity controls and instant subtotal refresh
- Checkout with COD / UPI / Card payment methods
- User registration and login with password hashing

---

## Setup (XAMPP)

### 1. Clone the Repository
```bash
git clone https://github.com/ananyanushika1234-sudo/CatKart.git
```

### 2. Copy to XAMPP `htdocs`
```
Copy the entire CatKart folder into: C:\xampp\htdocs\  (or D:\xampp\htdocs\)
Result: C:\xampp\htdocs\CatKart\
```
> ✅ The `images/` folder is included in the repository — **no separate download needed**.

### 3. Start XAMPP
- Open **XAMPP Control Panel**
- Start **Apache**
- Start **MySQL**

### 4. Import the Database
- Open **phpMyAdmin**: `http://localhost/phpmyadmin`
- Click **Import** → choose `catkart.sql` from the project folder
- Or run via command line:
  ```bash
  mysql -u root < catkart.sql
  ```

This will:
- Create the `catkart` database
- Create all tables (`users`, `breeds`, `cart`, `orders`)
- Seed all product data with correct image paths

### 5. Verify Database Credentials
Open `db.php` and confirm:
```php
$conn = mysqli_connect("localhost", "root", "", "catkart");
```
If your MySQL root has a password, update it here.

### 6. Open in Browser
```
http://localhost/CatKart/
```
- Redirects automatically to the **Login** page
- Register a new account or use any existing seeded credentials

---

## Project Structure
```
CatKart/
├── images/              ← All product images (committed to git)
│   ├── persian.png
│   ├── bengal.png
│   ├── collar.png
│   ├── treats.png
│   └── ...
├── index.php            ← Redirects to login
├── login.php
├── register.php
├── dashboard.php        ← Product listing (Breeds / Accessories / Food)
├── add_to_cart.php      ← AJAX: add item to cart
├── get_stock.php        ← AJAX: get real-time item stock
├── update_cart.php      ← AJAX: increase / decrease / remove cart items
├── get_quantity.php     ← Legacy: cart quantity check
├── cart.php             ← Cart page with AJAX controls
├── checkout.php         ← Checkout form
├── order.php            ← Order confirmation
├── logout.php
├── db.php               ← Database connection
├── style.css
├── script.js
└── catkart.sql          ← Full DB schema + seed data
```

---

## Notes
- If the site doesn't load, ensure Apache and MySQL are running in XAMPP
- All product images are stored in `images/` and committed to the repository
- If you change MySQL root password, update `db.php` accordingly
- The sidebar is a fixed toggleable panel — click ☰ in the header to toggle
