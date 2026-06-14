<?php
session_start();
include("db.php");
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            $_SESSION['address'] = $user['address'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CatKart Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <div class="login-container">
        <h1>🐱 CatKart</h1>
        <p class="auth-subtitle">Login to spoil your cat with the best goodies.</p>
        <form method="POST" onsubmit="return validateLogin()" novalidate>
            <input type="text" id="username" name="username" placeholder="Username">
            <span id="loginUsernameError" class="error"></span>

            <input type="password" id="password" name="password" placeholder="Password">
            <span id="loginPasswordError" class="error"></span>

            <button type="submit" name="login">Login</button>
        </form>

        <?php if (isset($error)) { ?>
            <p class="error" style="text-align:center; margin-top:10px;"><?php echo $error; ?></p>
        <?php } ?>

        <div class="login-link">
            <a href="register.php">Don't have an account? Create one</a>
        </div>
    </div>
</body>

</html>