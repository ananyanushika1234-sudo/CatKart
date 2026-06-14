<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE username='$username' ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History - CatKart</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body class="has-sidebar">
    <header>
        <button class="hamburger-btn" onclick="toggleSidebar()">☰</button>
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="dashboard.php" style="text-decoration: none;">
                <button class="top-btn" style="margin:0;">← Back</button>
            </a>
            <h1>🐾 My Orders</h1>
        </div>
        <div class="top-buttons">
            <a href="cart.php">
                <button class="top-btn">🛒 View Cart</button>
            </a>
            <a href="logout.php">
                <button class="top-btn logout-btn">Logout</button>
            </a>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <aside class="sidebar" id="sidebar">
            <h3>Categories</h3>
            <ul>
                <li><a href="dashboard.php" class="sidebar-link">Shop All</a></li>
                <li><a href="dashboard.php" class="sidebar-link">Cat Breeds</a></li>
                <li><a href="dashboard.php" class="sidebar-link">Accessories</a></li>
                <li><a href="dashboard.php" class="sidebar-link">Cat Food</a></li>
            </ul>
            <h3>My Account</h3>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="order_history.php" class="active">Order History</a></li>
                <li><a href="cart.php">My Cart</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="section-container" style="display: block;">
                <h2 class="section-header">Order History</h2>
                <?php if (mysqli_num_rows($orderQuery) == 0): ?>
                    <p class="empty">You have no past orders.</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php while ($order = mysqli_fetch_assoc($orderQuery)): ?>
                            <div class="cart-card" style="display: block; text-align: left; padding: 20px; width: 100%; max-width: 800px;">
                                <h3>Order #<?php echo $order['id']; ?></h3>
                                <p style="margin-top: 5px; color: #555;"><strong>Date:</strong> <?php echo date("d M Y, h:i A", strtotime($order['order_date'])); ?></p>
                                <p style="margin-top: 5px;"><strong>Items:</strong> <?php echo htmlspecialchars($order['items']); ?></p>
                                <p style="margin-top: 5px;"><strong>Total Amount:</strong> Rs. <?php echo $order['total_amount']; ?></p>
                                <p style="margin-top: 5px;"><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                                <p style="margin-top: 5px;"><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                                <p style="margin-top: 5px;"><strong>Status:</strong> 
                                    <span style="font-weight: bold; color: <?php echo ($order['order_status'] == 'Successful') ? 'green' : 'red'; ?>;">
                                        <?php echo htmlspecialchars($order['order_status']); ?>
                                    </span>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>