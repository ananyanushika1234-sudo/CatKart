<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    $cartItem = mysqli_query($conn, "SELECT item_name, quantity FROM cart WHERE id='$id'");
    if (mysqli_num_rows($cartItem) > 0) {
        $item = mysqli_fetch_assoc($cartItem);
        $itemName = mysqli_real_escape_string($conn, $item['item_name']);
        $quantityRemoved = (int)$item['quantity'];
        mysqli_query($conn, "UPDATE breeds SET quantity = quantity + $quantityRemoved WHERE breed='$itemName'");
        mysqli_query($conn, "DELETE FROM cart WHERE id='$id'");
    }
}

if (isset($_GET['increase'])) {
    $id = (int)$_GET['increase'];
    $cartItem = mysqli_query($conn, "SELECT item_name FROM cart WHERE id='$id'");
    if (mysqli_num_rows($cartItem) > 0) {
        $itemName = mysqli_real_escape_string($conn, mysqli_fetch_assoc($cartItem)['item_name']);
        $stockQuery = mysqli_query($conn, "SELECT quantity FROM breeds WHERE breed='$itemName'");
        if ($stockQuery && mysqli_num_rows($stockQuery) > 0) {
            $stock = (int)mysqli_fetch_assoc($stockQuery)['quantity'];
            if ($stock > 0) {
                mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE id='$id'");
                mysqli_query($conn, "UPDATE breeds SET quantity = quantity - 1 WHERE breed='$itemName'");
            }
        }
    }
}

if (isset($_GET['decrease'])) {
    $id = (int)$_GET['decrease'];
    $cartItem = mysqli_query($conn, "SELECT item_name, quantity FROM cart WHERE id='$id'");
    if (mysqli_num_rows($cartItem) > 0) {
        $item = mysqli_fetch_assoc($cartItem);
        if ((int)$item['quantity'] > 1) {
            $itemName = mysqli_real_escape_string($conn, $item['item_name']);
            mysqli_query($conn, "UPDATE cart SET quantity = quantity - 1 WHERE id='$id'");
            mysqli_query($conn, "UPDATE breeds SET quantity = quantity + 1 WHERE breed='$itemName'");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CatKart Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Your CatKart Cart</h1>
        <div class="top-buttons">
            <a href="dashboard.php">
                <button class="top-btn">Continue Shopping</button>
            </a>
        </div>
    </header>

    <div class="cart-container">
        <?php
        $total = 0;
        $query = mysqli_query($conn, "SELECT * FROM cart WHERE username='$username'");

        $imageMap = [
            "Bengal" => "images/bengal.jpg",
            "British Shorthair" => "images/british-shorthair.jpg",
            "Maine Coon" => "images/maine-coon.jpg",
            "Persian" => "images/persian.jpg",
            "Ragdoll" => "images/ragdoll.jpg",
            "Scottish Fold" => "images/scottish-fold.jpg",
            "Sphynx" => "images/sphynx.jpg"
        ];

        while ($row = mysqli_fetch_assoc($query)) {
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
            $image = $imageMap[$row['item_name']] ?? "https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=800&q=80";
        ?>
        <div class="cart-card">
            <img src="<?php echo $image; ?>" alt="<?php echo $row['item_name']; ?>">
            <h3><?php echo $row['item_name']; ?></h3>
            <p class="price">Rs. <?php echo $row['price']; ?></p>
            <p>Quantity: <b><?php echo $row['quantity']; ?></b></p>
            <p>Subtotal: <b>Rs. <?php echo $subtotal; ?></b></p>
            <div class="cart-buttons">
                <a href="cart.php?increase=<?php echo $row['id']; ?>">
                    <button class="small-btn plus-btn">+</button>
                </a>
                <a href="cart.php?decrease=<?php echo $row['id']; ?>">
                    <button class="small-btn minus-btn">-</button>
                </a>
                <a href="cart.php?remove=<?php echo $row['id']; ?>">
                    <button class="small-btn remove-btn">Remove</button>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="bill-box">
        <h2>Total: Rs. <?php echo $total; ?></h2>
        <a href="checkout.php">
            <button class="checkout-btn">Proceed To Checkout</button>
        </a>
    </div>
</body>
<footer id="contact">
    <p>&copy; 2026 CatKart 🐾 | Contact: support@catkart.example</p>
</footer>
</html>
