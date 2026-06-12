<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($userQuery);

$cartQuery = mysqli_query($conn, "SELECT * FROM cart WHERE username='$username'");

$subtotal = 0;
$items = "";

while ($row = mysqli_fetch_assoc($cartQuery)) {
    $subtotal += $row['price'] * $row['quantity'];
    $items .= $row['item_name'] . " x " . $row['quantity'] . ", ";
}

$gst = $subtotal * 0.05;
$shipping = 99;
$grandTotal = $subtotal + $gst + $shipping;
?>
<!DOCTYPE html>
<html>
<head>
    <title>CatKart Checkout</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>CatKart Checkout</h1>
    </header>

    <div class="container">
        <form action="order.php" method="POST" onsubmit="return validatePayment()">
            <h2>Shipping Details</h2>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
            <textarea name="address" required><?php echo $user['address']; ?></textarea>
            <input type="text" name="pincode" value="<?php echo $user['pincode']; ?>" required><br><br>

            <h2>Payment Method</h2>
            <select name="payment" id="paymentMethod" onchange="showPaymentFields()" required>
                <option value="">Choose Payment</option>
                <option value="COD">Cash on Delivery</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
            </select>

            <div id="upiField" style="display:none;">
                <input type="text" id="upiId" placeholder="Enter UPI ID">
                <span id="upiError" class="error"></span>
            </div>

            <div id="cardField" style="display:none;">
                <input type="text" id="cardNumber" placeholder="Enter Card Number">
                <span id="cardError" class="error"></span>
                <input type="password" id="cvv" placeholder="Enter CVV">
                <span id="cvvError" class="error"></span>
            </div><br><br>

            <h2>Bill Summary</h2>
            <p>Subtotal: Rs. <?php echo $subtotal; ?></p>
            <p>GST (5%): Rs. <?php echo $gst; ?></p>
            <p>Shipping: Rs. <?php echo $shipping; ?></p>

            <h2>Grand Total: Rs. <?php echo $grandTotal; ?></h2>

            <input type="hidden" name="items" value="<?php echo $items; ?>">
            <input type="hidden" name="total" value="<?php echo $grandTotal; ?>">

            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
