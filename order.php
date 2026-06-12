<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$items = $_POST['items'];
$total = $_POST['total'];
$payment = $_POST['payment'];
$address = $_POST['address'];

$status = (rand(1, 10) > 2) ? "Successful" : "Failed";

mysqli_query(
    $conn,
    "INSERT INTO orders
    (username, items, total_amount, payment_method, delivery_address, order_status)
    VALUES ('$username', '$items', '$total', '$payment', '$address', '$status')"
);

$orderID = mysqli_insert_id($conn);

if ($status == "Successful") {
    mysqli_query($conn, "DELETE FROM cart WHERE username='$username'");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CatKart Order Status</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <center>
            <?php if ($status == "Successful") { ?>
                <h1>Order Confirmed</h1>
            <?php } else { ?>
                <h1>Payment Failed</h1>
            <?php } ?>

            <h2>Order ID: #<?php echo $orderID; ?></h2>
            <p>Items: <?php echo $items; ?></p>
            <p>Payment: <?php echo $payment; ?></p>
            <p>Amount Paid: Rs. <?php echo $total; ?></p>
            <p>Shipping Address: <?php echo $address; ?></p>
            <p>Estimated Delivery: 3-5 business days</p>

            <a href="dashboard.php">
                <button>Back To CatKart</button>
            </a>
        </center>
    </div>
</body>
</html>
