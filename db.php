<?php
$conn = mysqli_connect("localhost","root","","catkart");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>