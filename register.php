<?php
include("db.php"); session_start();

if (isset($_POST['register'])) {
    $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone    = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address  = mysqli_real_escape_string($conn, trim($_POST['address']));
    $pincode  = mysqli_real_escape_string($conn, trim($_POST['pincode']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password_raw = trim($_POST['password']);
    $confirm_raw  = trim($_POST['confirm']);

    if ($password_raw != $confirm_raw) {
        $error = "Passwords do not match";
    } else {
        $password = password_hash($password_raw, PASSWORD_DEFAULT);
        $password_escaped = mysqli_real_escape_string($conn, $password);
        
        $query = "INSERT INTO users 
                  (name, email, phone, address, pincode, username, password) 
                  VALUES ('$name', '$email', '$phone', '$address', '$pincode', '$username', '$password_escaped')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            if (mysqli_errno($conn) == 1062) {
                $error = "Username already exists. Please choose a different one.";
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        } else {
            echo "<script>
                    alert('Registration Successful');
                    window.location='login.php';
                  </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CatKart Register</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="register-container">
        <h1>Create CatKart Account</h1>
        <form method="POST" onsubmit="return validateRegister()" novalidate>

            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Full Name">
                <span class="error" id="nameError"></span>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="text" id="email" name="email" placeholder="Email">
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="Phone Number">
                <span class="error" id="phoneError"></span>
            </div>

            <div class="form-group">
                <label>Delivery Address:</label>
                <textarea id="address" name="address" placeholder="Enter full delivery address"></textarea>
                <span class="error" id="addressError"></span>
            </div>

            <div class="form-group">
                <label>Pincode:</label>
                <input type="text" id="pincode" name="pincode" placeholder="Pincode">
                <span class="error" id="pincodeError"></span>
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" id="username" name="username" placeholder="Username">
                <span class="error" id="usernameError"></span>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="Password">
                <span class="error" id="passwordError"></span>
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" id="confirm" name="confirm" placeholder="Confirm Password">
                <span class="error" id="confirmError"></span>
            </div>

            <button type="submit" name="register">Register</button>
        </form>

        <?php if (isset($error)) { ?>
            <p class="error" style="text-align:center; margin-top:10px;"><?php echo $error; ?></p>
        <?php } ?>

        <div class="register-link">
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>
</body>
</html>
