<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$breedResults = mysqli_query($conn, "SELECT * FROM breeds ORDER BY breed");
$breeds = [];
while ($row = mysqli_fetch_assoc($breedResults)) {
    $breeds[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CatKart</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>🐱 CatKart</h1>
        <p>Welcome <?php echo htmlspecialchars($_SESSION['user']); ?>. Shop available cat breeds from the petstore.</p>

        <input type="text"
               id="searchBox"
               placeholder="Search cat breeds..."
               onkeyup="searchItems()"
               onfocus="focusField(this)"
               onblur="blurField(this)"
               class="search-box">

        <div class="top-buttons">
            <a href="cart.php">
                <button class="top-btn">🛒 View Cart</button>
            </a>
            <a href="logout.php">
                <button class="top-btn logout-btn">Logout</button>
            </a>
        </div>
    </header>

    <h2 class="category">🐾 Available Cat Breeds</h2>
    <div class="menu-row">
        <?php if (empty($breeds)): ?>
            <p class="empty">No breeds are available in the petstore right now. Please check back later.</p>
        <?php else: ?>
            <?php foreach ($breeds as $breed): ?>
                <?php $itemId = str_replace(' ', '', $breed['breed']); ?>
                <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
                    <img src="<?php echo htmlspecialchars($breed['image']); ?>" alt="<?php echo htmlspecialchars($breed['breed']); ?>">
                    <h3><?php echo htmlspecialchars($breed['breed']); ?></h3>
                    <p class="tagline"><?php echo htmlspecialchars($breed['description']); ?></p>
                    <p class="price">Rs. <?php echo (int)$breed['price']; ?></p>
                    <?php if ((int)$breed['quantity'] > 0): ?>
                        <button id="<?php echo $itemId; ?>Btn" onclick="addToCart('<?php echo addslashes($breed['breed']); ?>', <?php echo (int)$breed['price']; ?>)">Add To Cart</button>
                    <?php else: ?>
                        <button id="<?php echo $itemId; ?>Btn" disabled>Out of stock</button>
                    <?php endif; ?>
                    <p>Available: <span id="<?php echo $itemId; ?>Qty"><?php echo (int)$breed['quantity']; ?></span></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <footer id="contact">
        <p>&copy; 2026 CatKart 🐾 | Contact: support@catkart.example</p>
    </footer>
</body>
</html>
