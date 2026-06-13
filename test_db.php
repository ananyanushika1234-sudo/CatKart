<?php
include("db.php");
$q = mysqli_query($conn, "SELECT * FROM orders");
if (!$q) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Success: " . mysqli_num_rows($q) . " rows";
}
?>