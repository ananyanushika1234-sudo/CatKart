# CatKart — Project Documentation

This document summarizes the CatKart project: purpose, setup, database schema, file-by-file responsibilities, and how key functions/endpoints are implemented.

---

## Project Overview

CatKart is a simple PHP/MySQL e-commerce demo that sells cat breeds, accessories, and food. It includes user registration/login, a dashboard showing products (grouped by category), cart management, checkout and order history.

Stack:
- PHP (procedural), MySQL (MariaDB), plain HTML/CSS/JS
- Designed for local use (typical XAMPP environment)

---

## Quick Setup

1. Copy project to your webroot (e.g., `C:\xampp\htdocs\CatKart`).
2. Import the database: `catkart.sql` creates the `catkart` DB and seeds `breeds` and other tables.
3. Ensure `db.php` credentials match your local MySQL (default in this repo: `localhost`, `root`, no password, database `catkart`).
4. Start Apache + MySQL (XAMPP) and open `http://localhost/CatKart/` (redirects to `login.php`).

---

## Database Schema (from `catkart.sql`)

- `users`
  - `id` INT PK AUTO_INCREMENT
  - `name`, `email`, `phone`, `address`, `pincode`, `username` (UNIQUE), `password` (hash)

- `breeds` (holds products: breeds, accessories, food)
  - `id` INT PK AUTO_INCREMENT
  - `breed` VARCHAR UNIQUE (used as display name and join key)
  - `price` INT
  - `quantity` INT (stock)
  - `image` VARCHAR (path)
  - `description` TEXT
  - `category` VARCHAR (e.g., `breed`, `accessory`, `food`)

- `cart`
  - `id` INT PK AUTO_INCREMENT
  - `username` VARCHAR (foreign reference by logic)
  - `item_name` VARCHAR (matches `breeds.breed`)
  - `price` INT (copied at time of add)
  - `quantity` INT

- `orders`
  - `id` INT PK AUTO_INCREMENT
  - `username`, `items` (text description), `total_amount`, `payment_method`, `delivery_address`, `order_status`, `order_date` TIMESTAMP

---

## File Map & Implementation Details

(Only key files documented — see file list in repository for complete view.)

- `db.php`
  - Creates `$conn` via `mysqli_connect("localhost","root","","catkart")`.
  - Used by most PHP endpoints.

- `index.php`
  - Redirects to `login.php`.

- `register.php`
  - Server-side: accepts POST `register`, sanitizes inputs via `mysqli_real_escape_string`, hashes password with `password_hash()`, inserts into `users`.
  - Handles duplicate-username errors (MySQL errno 1062) and returns UI alerts/redirects.
  - Client-side: `validateRegister()` in `script.js` performs form validation (email, phone, pincode, length checks).

- `login.php`
  - Verifies credentials: fetches user row by `username`, uses `password_verify()` to check password.
  - On success stores `$_SESSION['user']` and `$_SESSION['address']`, redirects to `dashboard.php`.

- `logout.php`
  - `session_destroy()` and redirect to login.

- `dashboard.php`
  - Loads all rows from `breeds` and groups into arrays: `$breeds`, `$accessories`, `$food` using the `category` field. (Guarded to avoid undefined key via null-coalescing.)
  - Renders three sections (breeds, accessories, food) with product cards and `Add To Cart` buttons.
  - UI: search box and category sidebar filter — client-side filtering in `script.js`.

- `add_to_cart.php` (AJAX endpoint)
  - Requires active session (`$_SESSION['user']`), POST `item` and `price`.
  - Steps:
    1. Check product exists and get current `breeds.quantity`.
    2. If out of stock -> return `out_of_stock`.
    3. Check if cart already has the item; if yes `UPDATE cart SET quantity = quantity + 1`, else `INSERT` new row.
    4. Decrement `breeds.quantity` by 1.
    5. Echo `success`.
  - Uses `mysqli_real_escape_string` for the item string and casts `price` to int.

- `get_stock.php` / `get_quantity.php` (AJAX helpers)
  - `get_stock.php?item=...` returns numeric stock for a product (requires session).
  - `get_quantity.php?item=...` similar (slightly different usage), used by JS to update quantity displays.

- `cart.php` (Cart UI)
  - Loads `cart` rows joined with `breeds` for images.
  - Renders cart items with `+`, `-`, `Remove` buttons wired to client JS function `updateCartItem(id, action)`.
  - Client JS sends `update_cart.php` requests and updates DOM (quantity, subtotal, grand total) without full reload.

- `update_cart.php` (AJAX endpoint)
  - Accepts `id` and `action` (`increase`, `decrease`, `remove`).
  - Verifies session ownership of cart item.
  - `increase`: checks `breeds.quantity` stock, increments cart quantity, decrements `breeds.quantity`.
  - `decrease`: if quantity > 1, decrements cart and increments `breeds.quantity`; otherwise returns info message.
  - `remove`: increments `breeds.quantity` by current cart quantity and deletes cart row.
  - Returns JSON: `{ status, action, id, quantity, subtotal, grand_total }`.

- `checkout.php` / `order.php`
  - `checkout.php` computes subtotal, GST (5%), flat shipping (Rs.99) and renders a payment page.
  - `order.php` accepts POST from checkout: `items`, `total`, `payment`, `address` — records an order row in `orders`.
  - `order.php` simulates randomness in success (`status = (rand(1, 10) > 2) ? "Successful" : "Failed"`) and clears the cart on success.

- `order_history.php`
  - Lists orders from `orders` table for logged-in user in descending date.

- `profile.php`
  - Shows user details (read from `users` table) and action links.

- `test_db.php`
  - Very small helper to test DB connectivity/queries.

- `script.js` (Client-side)
  - `focusField(x)`, `blurField(x)`: small focus styles.
  - `validateRegister()`, `validateLogin()`, `validatePayment()`: form validators using regular expressions and basic checks.
  - `filterCategory(category, element)`, `searchItems()`, `applyFilters()`: client-side filtering for the dashboard product cards.
  - `addToCart(item, price)`: AJAX POST to `add_to_cart.php`, handles responses and calls `updateQuantity(item)`.
  - `updateQuantity(item)`: fetches `get_stock.php` and updates DOM counts/buttons accordingly.
  - `highlight(x)`, `removeHighlight(x)`: small UI animation styles.
  - `toggleSidebar()` + mobile initialization for sidebar behavior.

- `style.css`
  - Visual styles used across pages; not described exhaustively here.

---

## Security & Robustness Notes

- Passwords are hashed with `password_hash()` and verified via `password_verify()` — good.
- Many inputs are sanitized with `mysqli_real_escape_string()` and integers are cast — reduces SQL injection risk but prepared statements would be better.
- Session checks performed on all endpoints that modify or read user-specific data.
- Error handling is basic: endpoints often echo strings (e.g., `success`, `out_of_stock`) or JSON; front-end expects specific strings — modifying responses requires coordinated changes.
- `order.php` uses a simulated payment success; in production, integrate real payment gateway and use transactional DB updates.

---

## How To Answer Common Interview Questions About This Project

- "How is the cart implemented?"
  - The cart is a `cart` table keyed by `username` and `item_name`. Adding/updating is done via `add_to_cart.php` and `update_cart.php` which ensure stock counts in `breeds.quantity` are decremented/incremented accordingly.

- "How do you prevent race conditions on stock updates?"
  - Current implementation uses sequential queries (check stock -> update cart -> update breeds). For production, use transactions or `SELECT ... FOR UPDATE` and proper row-locking to avoid race conditions when multiple users add the same item simultaneously.

- "How is authentication handled?"
  - Session-based auth: upon successful `password_verify()` the server sets `$_SESSION['user']`. Most pages check `isset($_SESSION['user'])` and redirect to `login.php` if absent.

- "Where are JavaScript validations used and why?"
  - Client-side validators in `script.js` provide quick UX feedback (register/login/payment). They do not replace server-side checks.

- "What would you improve?"
  - Use prepared statements (`mysqli_stmt` or PDO) everywhere.
  - Move DB credentials to a configuration file outside webroot and prevent repository leaks.
  - Use transactions for cart/stock/order operations.
  - Add CSRF tokens for form posts and better error handling.
  - Add unit/integration tests and input validation libraries.

---

## Useful Commands / Local Verification

- Import DB (PowerShell):

```powershell
Get-Content -Raw 'C:\path\to\catkart.sql' | 'C:\xampp\mysql\bin\mysql.exe' -u root
```

- Lint PHP files:

```powershell
Get-ChildItem -Path 'C:\xampp\htdocs\CatKart' -Recurse -Filter *.php | ForEach-Object { 'C:\xampp\php\php.exe' -l $_.FullName }
```

- Tail Apache error log (XAMPP):

```powershell
Get-Content 'C:\xampp\apache\logs\error.log' -Tail 200 -Wait
```

---

## Appendix: File List

- add_to_cart.php — AJAX add item to cart
- cart.php — cart UI + client side update handler
- update_cart.php — AJAX modify cart item (increase/decrease/remove)
- get_stock.php / get_quantity.php — AJAX stock queries
- checkout.php, order.php — payment flow & order persistence
- dashboard.php — product listing and grouping logic
- register.php, login.php, logout.php — auth
- profile.php, order_history.php — user pages
- db.php — DB connection
- catkart.sql — DB schema + seed data
- script.js, style.css — frontend behavior and styles

---

If you'd like, I can:
- Expand this file with per-line walkthroughs for any specific file (e.g., `add_to_cart.php`),
- Add sequence diagrams or Mermaid diagrams for checkout/cart flows,
- Generate a short `demo-commands.md` to walk an interviewer through a live demo.

