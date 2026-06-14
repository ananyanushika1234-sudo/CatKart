<?php
session_start();
include("db.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(["status" => "error", "message" => "login_required"]);
    exit();
}

$username = $_SESSION['user'];

// Parse incoming request parameters (support both GET and POST)
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($id <= 0 || !in_array($action, ['increase', 'decrease', 'remove'])) {
    echo json_encode(["status" => "error", "message" => "Invalid parameters"]);
    exit();
}

// Fetch the cart item to make sure it belongs to the logged-in user
$cartQuery = mysqli_query($conn, "SELECT * FROM cart WHERE id='$id' AND username='$username'");
if (!$cartQuery || mysqli_num_rows($cartQuery) === 0) {
    echo json_encode(["status" => "error", "message" => "Item not found in cart"]);
    exit();
}

$cartItem = mysqli_fetch_assoc($cartQuery);
$itemName = mysqli_real_escape_string($conn, $cartItem['item_name']);
$currentQty = (int)$cartItem['quantity'];
$price = (int)$cartItem['price'];

$newQty = $currentQty;
$subtotal = $price * $currentQty;

if ($action === 'increase') {
    // Check available stock in breeds
    $stockQuery = mysqli_query($conn, "SELECT quantity FROM breeds WHERE breed='$itemName'");
    if ($stockQuery && mysqli_num_rows($stockQuery) > 0) {
        $stock = (int)mysqli_fetch_assoc($stockQuery)['quantity'];
        if ($stock > 0) {
            $newQty = $currentQty + 1;
            $subtotal = $price * $newQty;
            mysqli_query($conn, "UPDATE cart SET quantity = $newQty WHERE id='$id'");
            mysqli_query($conn, "UPDATE breeds SET quantity = quantity - 1 WHERE breed='$itemName'");
        } else {
            echo json_encode(["status" => "error", "message" => "out_of_stock"]);
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
        exit();
    }
} elseif ($action === 'decrease') {
    if ($currentQty > 1) {
        $newQty = $currentQty - 1;
        $subtotal = $price * $newQty;
        mysqli_query($conn, "UPDATE cart SET quantity = $newQty WHERE id='$id'");
        mysqli_query($conn, "UPDATE breeds SET quantity = quantity + 1 WHERE breed='$itemName'");
    } else {
        // Keep it at 1 or handle removal? The standard request is decrease > 1, otherwise do nothing
        echo json_encode(["status" => "info", "message" => "Quantity cannot be less than 1"]);
        exit();
    }
} elseif ($action === 'remove') {
    // Delete item from cart and return stock
    mysqli_query($conn, "UPDATE breeds SET quantity = quantity + $currentQty WHERE breed='$itemName'");
    mysqli_query($conn, "DELETE FROM cart WHERE id='$id'");
    $newQty = 0;
    $subtotal = 0;
}

// Calculate the new grand total
$grandTotalQuery = mysqli_query($conn, "SELECT SUM(price * quantity) AS total FROM cart WHERE username='$username'");
$grandTotalRow = mysqli_fetch_assoc($grandTotalQuery);
$grandTotal = (int)($grandTotalRow['total'] ?? 0);

echo json_encode([
    "status" => "success",
    "action" => $action,
    "id" => $id,
    "quantity" => $newQty,
    "subtotal" => $subtotal,
    "grand_total" => $grandTotal
]);
?>
