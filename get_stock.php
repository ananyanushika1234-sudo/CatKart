<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    echo 0;
    exit();
}

if (isset($_GET['item'])) {
    $item = mysqli_real_escape_string($conn, $_GET['item']);
    $query = mysqli_query($conn, "SELECT quantity FROM breeds WHERE breed = '$item'");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        echo (int) $row['quantity'];
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>