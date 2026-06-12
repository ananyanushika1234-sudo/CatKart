<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    echo 0;
    exit();
}

$username = $_SESSION['user'];
$item = $_GET['item'];
$query = mysqli_query($conn,
    "SELECT quantity FROM cart WHERE username = '$username' AND item_name = '$item'");
if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    echo $row['quantity'];
} else {
    echo 0;
}
?>