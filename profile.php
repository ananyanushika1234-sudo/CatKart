<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = mysqli_real_escape_string($conn, $_SESSION['user']);
$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile – CatKart</title>
    <meta name="description" content="View your CatKart account details.">
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-wrapper {
            max-width: 560px;
            margin: 60px auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(212,100,39,0.13);
            border: 1px solid #f5dece;
            overflow: hidden;
        }

        .profile-banner {
            background: linear-gradient(110deg, rgba(80,30,0,0.88), rgba(196,90,20,0.82));
            padding: 36px 30px 28px;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            margin: 0 auto 14px;
            border: 3px solid rgba(255,255,255,0.4);
        }

        .profile-banner h2 {
            font-size: 1.4rem;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .profile-banner p {
            margin: 4px 0 0;
            font-size: 13px;
            opacity: 0.8;
        }

        .profile-body {
            padding: 28px 32px;
        }

        .profile-field {
            display: flex;
            align-items: flex-start;
            padding: 14px 0;
            border-bottom: 1px solid #f5ede6;
            gap: 16px;
        }

        .profile-field:last-child {
            border-bottom: none;
        }

        .profile-field-icon {
            font-size: 1.2rem;
            width: 28px;
            flex-shrink: 0;
            padding-top: 2px;
            text-align: center;
        }

        .profile-field-content {
            flex: 1;
        }

        .profile-field-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #b07050;
            margin-bottom: 3px;
        }

        .profile-field-value {
            font-size: 15px;
            color: #2d1a0e;
            word-break: break-word;
        }

        .profile-actions {
            padding: 20px 32px 28px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .profile-actions a {
            flex: 1;
            min-width: 130px;
        }

        .profile-actions button {
            width: 100%;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-dashboard {
            background: #d4641d;
            color: white;
        }
        .btn-dashboard:hover { background: #a84510; }

        .btn-logout {
            background: #f5ede6;
            color: #c75b12;
        }
        .btn-logout:hover { background: #f0d5c0; }
    </style>
</head>
<body>
    <header>
        <h1>🐱 CatKart</h1>
        <p>My Profile</p>
        <div class="top-buttons">
            <a href="dashboard.php"><button class="top-btn">🛍️ Shop</button></a>
            <a href="cart.php"><button class="top-btn">🛒 Cart</button></a>
            <a href="logout.php"><button class="top-btn logout-btn">Logout</button></a>
        </div>
    </header>

    <div class="profile-wrapper">
        <div class="profile-banner">
            <div class="profile-avatar">🐾</div>
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
            <p>@<?php echo htmlspecialchars($user['username']); ?></p>
        </div>

        <div class="profile-body">
            <div class="profile-field">
                <div class="profile-field-icon">📧</div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Email</div>
                    <div class="profile-field-value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">📞</div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Phone</div>
                    <div class="profile-field-value"><?php echo htmlspecialchars($user['phone']); ?></div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">📍</div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Delivery Address</div>
                    <div class="profile-field-value"><?php echo nl2br(htmlspecialchars($user['address'])); ?></div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">🏷️</div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Pincode</div>
                    <div class="profile-field-value"><?php echo htmlspecialchars($user['pincode']); ?></div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">👤</div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Username</div>
                    <div class="profile-field-value"><?php echo htmlspecialchars($user['username']); ?></div>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <a href="dashboard.php">
                <button class="btn-dashboard">← Back to Shop</button>
            </a>
            <a href="logout.php">
                <button class="btn-logout">Logout</button>
            </a>
        </div>
    </div>

    <footer id="contact">
        <p>&copy; 2026 CatKart 🐾 | Contact: support@catkart.example</p>
    </footer>
</body>
</html>
