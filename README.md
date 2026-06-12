# CatKart

## Start the project using XAMPP

1. Copy this project folder into XAMPP `htdocs`
   - Example: `C:\xampp\htdocs\CatKart`
   - Or place the files directly inside `C:\xampp\htdocs`

2. Start XAMPP Control Panel
   - Start `Apache`
   - Start `MySQL`

3. Import the database
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `catkart`
   - Import the file `catkart.sql`

4. Verify database credentials
   - Open `db.php`
   - Confirm the connection settings match your MySQL setup:
     - host: `localhost`
     - user: `root`
     - password: `` (empty)
     - database: `catkart`

5. Open the website in your browser
   - Use this link:
     - `http://localhost/CatKart/`
   - If you placed files inside `htdocs` directly, use:
     - `http://localhost/`

6. Login
   - `index.php` redirects to `login.php`
   - Use the credentials from the imported database or register a new account.

## Notes

- If the site does not load, make sure Apache and MySQL are running in XAMPP.
- If MySQL uses a password for `root`, update `db.php` accordingly.
- If the `catkart` database already exists, you can skip the import step.
