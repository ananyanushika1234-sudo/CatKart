<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo "login_required";
    exit();
}

if (isset($_POST['item'])) {
    $username = $_SESSION['user'];
    $item = $_POST['item'];
    $price = $_POST['price'];

    $check = mysqli_query($conn,
    "SELECT * FROM cart WHERE username='$username' AND item_name='$item'");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn,
        "UPDATE cart SET quantity = quantity + 1 WHERE username='$username' AND item_name='$item'");
    } else {
        mysqli_query($conn,
        "INSERT INTO cart(username, item_name, price, quantity)
        VALUES ('$username', '$item', '$price', 1)");
    }
    echo "success";
}
?>