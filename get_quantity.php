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
    "SELECT quantity FROM breeds WHERE breed = '" . mysqli_real_escape_string($conn, $item) . "'");
if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    echo $row['quantity'];
} else {
    echo 0;
}
?>