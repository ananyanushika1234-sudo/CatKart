<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart WHERE id='$id'");
}

if (isset($_GET['increase'])) {
    $id = $_GET['increase'];
    mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE id='$id'");
}

if (isset($_GET['decrease'])) {
    $id = $_GET['decrease'];
    mysqli_query($conn, "UPDATE cart SET quantity = quantity - 1 WHERE id='$id' AND quantity > 1");
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
            "Feather Wand"=>"https://images.unsplash.com/photo-1545249390-6bdfa286032f?auto=format&fit=crop&w=800&q=80",
            "Crinkle Tunnel"=>"https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=800&q=80",
            "Mouse Chase"=>"https://images.unsplash.com/photo-1516750105099-4b8a83e217ee?auto=format&fit=crop&w=800&q=80",
            "Catnip Ball"=>"https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=800&q=80",
            "Tuna Pâté"=>"https://images.unsplash.com/photo-1589924691995-400dc9a8a2d2?auto=format&fit=crop&w=800&q=80",
            "Salmon Bites"=>"https://images.unsplash.com/photo-1601758125946-6ec2ef64daf8?auto=format&fit=crop&w=800&q=80",
            "Kitten Kibble"=>"https://images.unsplash.com/photo-1583512603806-077998240c7a?auto=format&fit=crop&w=800&q=80",
            "Lickable Puree"=>"https://images.unsplash.com/photo-1548802673-380ab8ebc7b7?auto=format&fit=crop&w=800&q=80",
            "Cozy Cave Bed"=>"https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80",
            "Scratch Post Deluxe"=>"https://images.unsplash.com/photo-1518791841217-8f162f1912da?auto=format&fit=crop&w=800&q=80",
            "Breakaway Collar"=>"https://images.unsplash.com/photo-1606214174585-fe31582dc6ee?auto=format&fit=crop&w=800&q=80",
            "Self-Grooming Brush"=>"https://images.unsplash.com/photo-1560807707-8cc77767d783?auto=format&fit=crop&w=800&q=80"
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
