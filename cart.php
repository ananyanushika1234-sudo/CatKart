<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
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

    <div class="cart-container" id="cart-container-wrapper">
        <?php
        $total = 0;
        $query = mysqli_query($conn, "SELECT cart.*, breeds.image FROM cart LEFT JOIN breeds ON cart.item_name = breeds.breed WHERE cart.username='$username'");

        if (mysqli_num_rows($query) === 0) {
            echo "<p class='empty-cart-msg' style='text-align:center; width:100%; margin: 50px 0;'>Your cart is empty.</p>";
        } else {
            while ($row = mysqli_fetch_assoc($query)) {
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
                $image = !empty($row['image']) ? $row['image'] : "images/placeholder.jpg";
            ?>
            <div class="cart-card" id="cart-card-<?php echo $row['id']; ?>">
                <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($row['item_name']); ?>">
                <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                <p class="price">Rs. <?php echo $row['price']; ?></p>
                <p>Quantity: <b id="qty-<?php echo $row['id']; ?>"><?php echo $row['quantity']; ?></b></p>
                <p>Subtotal: <b id="subtotal-<?php echo $row['id']; ?>">Rs. <?php echo $subtotal; ?></b></p>
                <div class="cart-buttons">
                    <button class="small-btn plus-btn" onclick="updateCartItem(<?php echo $row['id']; ?>, 'increase')">+</button>
                    <button class="small-btn minus-btn" onclick="updateCartItem(<?php echo $row['id']; ?>, 'decrease')">-</button>
                    <button class="small-btn remove-btn" onclick="updateCartItem(<?php echo $row['id']; ?>, 'remove')">Remove</button>
                </div>
            </div>
            <?php 
            }
        } 
        ?>
    </div>

    <div class="bill-box" id="bill-summary-box" style="<?php echo ($total == 0) ? 'display:none;' : ''; ?>">
        <h2 id="grand-total-text">Total: Rs. <?php echo $total; ?></h2>
        <a href="checkout.php">
            <button class="checkout-btn">Proceed To Checkout</button>
        </a>
    </div>

    <footer id="contact">
        <p>&copy; 2026 CatKart 🐾 | Contact: support@catkart.example</p>
    </footer>

    <script>
    function updateCartItem(id, action) {
        fetch('update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id + '&action=' + action
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.action === 'remove') {
                    let card = document.getElementById('cart-card-' + id);
                    if (card) card.remove();
                } else {
                    let qtyEl = document.getElementById('qty-' + id);
                    let subtotalEl = document.getElementById('subtotal-' + id);
                    if (qtyEl) qtyEl.innerText = data.quantity;
                    if (subtotalEl) subtotalEl.innerText = 'Rs. ' + data.subtotal;
                }

                // Update grand total
                let grandTotalText = document.getElementById('grand-total-text');
                if (grandTotalText) {
                    grandTotalText.innerText = 'Total: Rs. ' + data.grand_total;
                }

                // If grand total is 0, show empty cart message and hide bill box
                if (data.grand_total === 0) {
                    let wrapper = document.getElementById('cart-container-wrapper');
                    if (wrapper) {
                        wrapper.innerHTML = "<p class='empty-cart-msg' style='text-align:center; width:100%; margin: 50px 0;'>Your cart is empty.</p>";
                    }
                    let billBox = document.getElementById('bill-summary-box');
                    if (billBox) {
                        billBox.style.display = 'none';
                    }
                }
            } else if (data.status === 'error') {
                if (data.message === 'out_of_stock') {
                    alert('Sorry, this item is out of stock.');
                } else if (data.message === 'login_required') {
                    alert('Please login first.');
                    window.location.href = 'login.php';
                } else {
                    alert('Error: ' + data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    }
    </script>
</body>
</html>
