<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$results = mysqli_query($conn, "SELECT * FROM breeds ORDER BY breed");
$breeds = [];
$accessories = [];
$food = [];

while ($row = mysqli_fetch_assoc($results)) {
    if ($row['category'] == 'accessory') {
        $accessories[] = $row;
    } elseif ($row['category'] == 'food') {
        $food[] = $row;
    } else {
        $breeds[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CatKart</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body class="has-sidebar">
    <header>
        <button class="hamburger-btn" onclick="toggleSidebar()">☰</button>
        <h1>🐱 CatKart</h1>
        <p>Welcome <?php echo htmlspecialchars($_SESSION['user']); ?>. Shop available cats, food, and accessories.</p>

        <input type="text"
               id="searchBox"
               placeholder="Search cat breeds, food, accessories..."
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

    <div class="dashboard-wrapper">
        <aside class="sidebar" id="sidebar">
            <h3>Categories</h3>
            <ul>
                <li><a href="#" class="sidebar-link active" onclick="filterCategory('all', this); return false;">Shop All</a></li>
                <li><a href="#" class="sidebar-link" onclick="filterCategory('breed', this); return false;">Cat Breeds</a></li>
                <li><a href="#" class="sidebar-link" onclick="filterCategory('accessory', this); return false;">Accessories</a></li>
                <li><a href="#" class="sidebar-link" onclick="filterCategory('food', this); return false;">Cat Food</a></li>
            </ul>
            <h3>My Account</h3>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="cart.php">My Cart</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="section-container" id="section-breeds">
                <h2 class="category section-header" data-category="breed">🐱 Available Cat Breeds</h2>
                <div class="menu-row">
                    <?php if (empty($breeds)): ?>
                        <p class="empty">No breeds are available in the petstore right now. Please check back later.</p>
                    <?php else: ?>
                        <?php foreach ($breeds as $breed): ?>
                            <?php $itemId = str_replace(' ', '', $breed['breed']); ?>
                            <div class="item" data-category="breed" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
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
            </div>

            <div class="section-container" id="section-accessories">
                <h2 class="category section-header" data-category="accessory">🧸 Cat Accessories</h2>
                <div class="menu-row">
                    <?php if (empty($accessories)): ?>
                        <p class="empty">No accessories are available in the petstore right now. Please check back later.</p>
                    <?php else: ?>
                        <?php foreach ($accessories as $acc): ?>
                            <?php $itemId = str_replace(' ', '', $acc['breed']); ?>
                            <div class="item" data-category="accessory" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
                                <img src="<?php echo htmlspecialchars($acc['image']); ?>" alt="<?php echo htmlspecialchars($acc['breed']); ?>">
                                <h3><?php echo htmlspecialchars($acc['breed']); ?></h3>
                                <p class="tagline"><?php echo htmlspecialchars($acc['description']); ?></p>
                                <p class="price">Rs. <?php echo (int)$acc['price']; ?></p>
                                <?php if ((int)$acc['quantity'] > 0): ?>
                                    <button id="<?php echo $itemId; ?>Btn" onclick="addToCart('<?php echo addslashes($acc['breed']); ?>', <?php echo (int)$acc['price']; ?>)">Add To Cart</button>
                                <?php else: ?>
                                    <button id="<?php echo $itemId; ?>Btn" disabled>Out of stock</button>
                                <?php endif; ?>
                                <p>Available: <span id="<?php echo $itemId; ?>Qty"><?php echo (int)$acc['quantity']; ?></span></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="section-container" id="section-food">
                <h2 class="category section-header" data-category="food">🐟 Premium Cat Food</h2>
                <div class="menu-row">
                    <?php if (empty($food)): ?>
                        <p class="empty">No cat food is available in the petstore right now. Please check back later.</p>
                    <?php else: ?>
                        <?php foreach ($food as $fd): ?>
                            <?php $itemId = str_replace(' ', '', $fd['breed']); ?>
                            <div class="item" data-category="food" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
                                <img src="<?php echo htmlspecialchars($fd['image']); ?>" alt="<?php echo htmlspecialchars($fd['breed']); ?>">
                                <h3><?php echo htmlspecialchars($fd['breed']); ?></h3>
                                <p class="tagline"><?php echo htmlspecialchars($fd['description']); ?></p>
                                <p class="price">Rs. <?php echo (int)$fd['price']; ?></p>
                                <?php if ((int)$fd['quantity'] > 0): ?>
                                    <button id="<?php echo $itemId; ?>Btn" onclick="addToCart('<?php echo addslashes($fd['breed']); ?>', <?php echo (int)$fd['price']; ?>)">Add To Cart</button>
                                <?php else: ?>
                                    <button id="<?php echo $itemId; ?>Btn" disabled>Out of stock</button>
                                <?php endif; ?>
                                <p>Available: <span id="<?php echo $itemId; ?>Qty"><?php echo (int)$fd['quantity']; ?></span></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <footer id="contact">
        <p>&copy; 2026 CatKart 🐾 | Contact: support@catkart.example</p>
    </footer>
</body>
</html>