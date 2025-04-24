<?php
session_start();
include 'conn.php';

// Redirect if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }

        .checkout-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #2E7D32;
            margin-bottom: 25px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
        }

        li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 1.1em;
        }

        p strong {
            font-size: 1.2em;
            display: block;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        .totals {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2E7D32;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
        .cart-summary {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="cart-container">
    <h1>Your Shopping Cart</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<form action="checkout.php" method="POST">';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="cart-item">';
            echo '<input type="checkbox" name="selected_items[]" value="' . $row["id"] . '" class="item-checkbox" data-price="' . $row["product_price"] . '">';
            echo '<img src="' . $row["image"] . '" alt="' . $row["product_name"] . '">';
            echo '<div class="cart-item-details">';
            echo '<h3>' . $row["product_name"] . '</h3>';
            echo '<p>₱' . number_format($row["product_price"], 2) . '</p>';
            echo '</div>';
            echo '</div>';
        }

        echo '<div class="totals">';
        echo 'Total Items Selected: <span id="total-quantity">0</span><br>';
        echo 'Total Price: ₱<span id="total-price">0.00</span>';
        echo '</div>';

        echo '<button type="submit" class="checkout-btn">Proceed to Checkout</button>';
        echo '</form>';
    } else {
        echo "<p class='empty-cart-message'>Your cart is empty.</p>";
    }
    ?>
</div>

</body>
</html>
