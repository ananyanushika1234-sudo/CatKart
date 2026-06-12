<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
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
        <p>Welcome <?php echo $_SESSION['user']; ?>. Spoil your furry royalty!</p>

        <input type="text"
               id="searchBox"
               placeholder="Search cat goodies..."
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

    <h2 class="category">🧶 Toys & Play</h2>
    <div class="menu-row">
        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1545249390-6bdfa286032f?auto=format&fit=crop&w=800&q=80" alt="Feather Wand toy">
            <h3>Feather Wand</h3>
            <p class="tagline">Irresistible feathers to get them leaping</p>
            <p class="price">Rs. 299</p>
            <button onclick="addToCart('Feather Wand', 299)">Add To Cart</button>
            <p>Quantity: <span id="FeatherWandQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=800&q=80" alt="Crinkle Tunnel">
            <h3>Crinkle Tunnel</h3>
            <p class="tagline">Collapsible tunnel for endless zooming</p>
            <p class="price">Rs. 599</p>
            <button onclick="addToCart('Crinkle Tunnel', 599)">Add To Cart</button>
            <p>Quantity: <span id="CrinkleTunnelQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1516750105099-4b8a83e217ee?auto=format&fit=crop&w=800&q=80" alt="Mouse Chase toy">
            <h3>Mouse Chase</h3>
            <p class="tagline">Motorized mouse that keeps them busy</p>
            <p class="price">Rs. 799</p>
            <button onclick="addToCart('Mouse Chase', 799)">Add To Cart</button>
            <p>Quantity: <span id="MouseChaseQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=800&q=80" alt="Catnip Ball">
            <h3>Catnip Ball</h3>
            <p class="tagline">Premium catnip packed in a crinkle ball</p>
            <p class="price">Rs. 199</p>
            <button onclick="addToCart('Catnip Ball', 199)">Add To Cart</button>
            <p>Quantity: <span id="CatnipBallQty">0</span></p>
        </div>
    </div>

    <h2 class="category">🍽️ Food & Treats</h2>
    <div class="menu-row">
        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1589924691995-400dc9a8a2d2?auto=format&fit=crop&w=800&q=80" alt="Tuna Pate wet food">
            <h3>Tuna Pâté</h3>
            <p class="tagline">Rich ocean tuna in smooth pâté form</p>
            <p class="price">Rs. 149</p>
            <button onclick="addToCart('Tuna Pâté', 149)">Add To Cart</button>
            <p>Quantity: <span id="TunaPâtéQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1601758125946-6ec2ef64daf8?auto=format&fit=crop&w=800&q=80" alt="Salmon Bites treats">
            <h3>Salmon Bites</h3>
            <p class="tagline">Freeze-dried salmon treats cats go wild for</p>
            <p class="price">Rs. 349</p>
            <button onclick="addToCart('Salmon Bites', 349)">Add To Cart</button>
            <p>Quantity: <span id="SalmonBitesQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1583512603806-077998240c7a?auto=format&fit=crop&w=800&q=80" alt="Kitten Kibble">
            <h3>Kitten Kibble</h3>
            <p class="tagline">Nutritionally complete dry food for kittens</p>
            <p class="price">Rs. 699</p>
            <button onclick="addToCart('Kitten Kibble', 699)">Add To Cart</button>
            <p>Quantity: <span id="KittenKibbleQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1548802673-380ab8ebc7b7?auto=format&fit=crop&w=800&q=80" alt="Lickable Puree">
            <h3>Lickable Puree</h3>
            <p class="tagline">Creamy liquid snack for hydration and love</p>
            <p class="price">Rs. 249</p>
            <button onclick="addToCart('Lickable Puree', 249)">Add To Cart</button>
            <p>Quantity: <span id="LickablePureeQty">0</span></p>
        </div>
    </div>

    <h2 class="category">🏠 Comfort & Accessories</h2>
    <div class="menu-row">
        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80" alt="Cozy Cave Bed">
            <h3>Cozy Cave Bed</h3>
            <p class="tagline">Hooded plush bed for the ultimate snooze</p>
            <p class="price">Rs. 1299</p>
            <button onclick="addToCart('Cozy Cave Bed', 1299)">Add To Cart</button>
            <p>Quantity: <span id="CozyCaveBedQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1518791841217-8f162f1912da?auto=format&fit=crop&w=800&q=80" alt="Scratch Post Deluxe">
            <h3>Scratch Post Deluxe</h3>
            <p class="tagline">Sisal-wrapped post with a dangling toy on top</p>
            <p class="price">Rs. 999</p>
            <button onclick="addToCart('Scratch Post Deluxe', 999)">Add To Cart</button>
            <p>Quantity: <span id="ScratchPostDeluxeQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1606214174585-fe31582dc6ee?auto=format&fit=crop&w=800&q=80" alt="Breakaway Collar">
            <h3>Breakaway Collar</h3>
            <p class="tagline">Safe quick-release collar with a cute bell</p>
            <p class="price">Rs. 399</p>
            <button onclick="addToCart('Breakaway Collar', 399)">Add To Cart</button>
            <p>Quantity: <span id="BreakawayCollarQty">0</span></p>
        </div>

        <div class="item" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
            <img src="https://images.unsplash.com/photo-1560807707-8cc77767d783?auto=format&fit=crop&w=800&q=80" alt="Self-Grooming Brush">
            <h3>Self-Grooming Brush</h3>
            <p class="tagline">Corner-mount brush for happy self-grooming</p>
            <p class="price">Rs. 549</p>
            <button onclick="addToCart('Self-Grooming Brush', 549)">Add To Cart</button>
            <p>Quantity: <span id="Self-GroomingBrushQty">0</span></p>
        </div>
    </div>

    <footer id="contact">
        <p>&copy; 2026 CatKart 🐾 | Contact: support@catkart.example</p>
    </footer>
</body>
</html>
