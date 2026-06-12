<?php
include("db.php");

if (isset($_POST['register'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];
    $pincode  = $_POST['pincode'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password != $confirm) {
        $error = "Passwords do not match";
    } else {
        $query = "INSERT INTO users 
                  (name, email, phone, address, pincode, username, password) 
                  VALUES ('$name', '$email', '$phone', '$address', '$pincode', '$username', '$password')";
        mysqli_query($conn, $query);
        echo "<script>
                alert('Registration Successful');
                window.location='login.php';
              </script>";
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
