<?php
include('db_connection.php');
session_start();
$cartItems = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        header {
            background-color: #b22222;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            padding: 5px 0;
        }

        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        .cart-list {
            margin: 20px 0;
            list-style-type: none;
            padding: 0;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .cart-item:hover {
            background-color: #f0f0f0;
        }
        .item-details {
            display: flex;
            align-items: center;
        }
        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            margin-right: 15px;
        }
        .item-info {
            display: flex;
            flex-direction: column;
        }
        .item-title {
            font-size: 16px;
            font-weight: bold;
        }
        .item-price {
            color: #e60000;
            font-size: 14px;
        }
        .item-quantity {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .quantity-btn {
            background-color: #e60000;
            color: #fff;
            border: none;
            padding: 5px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .quantity-btn:hover {
            background-color: #cc0000;
        }
        .quantity-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin: 0 5px;
        }
        .checkout-btn {
            background-color: #e60000;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .checkout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
<header>
    <h1>LALAMONS</h1>
    <nav>
        <a href="main.php" onclick="showSection('home')">Home</a>
        <a href="cart.php" onclick="showSection('cart')">Cart</a>
        <a href="favorites.php" onclick="showSection('favorites')">Favorites</a>
        <a href="profile.php" onclick="showSection('profile')">Profile</a>
    </nav>
</header>
<div class="container">
    <h1>Your Cart</h1>
    <ul class="cart-list">
        <?php
        if (!empty($cartItems)) {
            foreach ($cartItems as $item) {
                echo "<li class='cart-item'>";
                echo "<div class='item-details'>";
                echo "<img src='images/" . htmlspecialchars($item['image']) . "' alt='" . htmlspecialchars($item['title']) . "' class='item-image'>";
                echo "<div class='item-info'>";
                echo "<h2 class='item-title'>" . htmlspecialchars($item['title']) . "</h2>";
                echo "<p class='item-price'>$" . number_format($item['price'], 2) . "</p>";
                echo "<div class='item-quantity'>";
                echo "<button class='quantity-btn' onclick='updateQuantity(" . intval($item['id']) . ", -1)'>-</button>";
                echo "<input type='text' value='" . intval($item['quantity']) . "' class='quantity-input' readonly>";
                echo "<button class='quantity-btn' onclick='updateQuantity(" . intval($item['id']) . ", 1)'>+</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<button class='remove-btn' onclick='removeFromCart(" . intval($item['id']) . ")'>Remove</button>";
                echo "</li>";
            }
        } else {
            echo "<li class='cart-item'>Your cart is empty.</li>";
        }
        ?>
    </ul>
    <button class="checkout-btn" onclick="proceedToCheckout()">Proceed to Checkout</button>
</div>

<script>
    function updateQuantity(productId, delta) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status == 200) {
                location.reload();
            }
        };
        xhr.send("action=update_quantity&product_id=" + productId + "&delta=" + delta);
    }

    function removeFromCart(productId) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status == 200) {
                location.reload();
            }
        };
        xhr.send("action=remove_item&product_id=" + productId);
    }

    function proceedToCheckout() {
        console.log('Proceeding to checkout');
        // Your logic for proceeding to checkout goes here
        // E.g., redirect to a checkout page or show a modal
    }
</script>
</body>
</html>