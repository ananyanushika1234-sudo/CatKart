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
    $item = mysqli_real_escape_string($conn, $_POST['item']);
    $price = (int)$_POST['price'];

    $breedQuery = mysqli_query($conn,
        "SELECT quantity FROM breeds WHERE breed='$item'");

    if (!$breedQuery || mysqli_num_rows($breedQuery) === 0) {
        echo "out_of_stock";
        exit();
    }

    $breedData = mysqli_fetch_assoc($breedQuery);
    $available = (int)$breedData['quantity'];
    if ($available <= 0) {
        echo "out_of_stock";
        exit();
    }

    $cartQuery = mysqli_query($conn,
        "SELECT quantity FROM cart WHERE username='$username' AND item_name='$item'");

    $currentQty = 0;
    if (mysqli_num_rows($cartQuery) > 0) {
        $currentQty = (int)mysqli_fetch_assoc($cartQuery)['quantity'];
    }

    // The breed quantity already tracks remaining stock, so only the current
    // available count matters for adding one more item.
    if ($available <= 0) {
        echo "out_of_stock";
        exit();
    }

    if ($currentQty > 0) {
        mysqli_query($conn,
            "UPDATE cart SET quantity = quantity + 1 WHERE username='$username' AND item_name='$item'");
    } else {
        mysqli_query($conn,
            "INSERT INTO cart(username, item_name, price, quantity)
            VALUES ('$username', '$item', '$price', 1)");
    }

    mysqli_query($conn,
        "UPDATE breeds SET quantity = quantity - 1 WHERE breed='$item'");

    echo "success";
}
?>