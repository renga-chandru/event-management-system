<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'pizza_db';

$conn = mysqli_connect($host, $user, $password, $database);

// Check the database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle quantity increment
if (isset($_POST['increment_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $current_quantity_query = "SELECT quantity FROM cart WHERE id = $product_id";
    $result = mysqli_query($conn, $current_quantity_query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $new_quantity = $row['quantity'] + 1;
        $update_query = "UPDATE cart SET quantity = $new_quantity WHERE id = $product_id";
        mysqli_query($conn, $update_query);
    }
}

// Handle quantity decrement
if (isset($_POST['decrement_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $current_quantity_query = "SELECT quantity FROM cart WHERE id = $product_id";
    $result = mysqli_query($conn, $current_quantity_query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $new_quantity = max(1, $row['quantity'] - 1); // Prevent quantity going below 1
        $update_query = "UPDATE cart SET quantity = $new_quantity WHERE id = $product_id";
        mysqli_query($conn, $update_query);
    }
}

// Handle remove item
if (isset($_POST['remove_item'])) {
    $product_id = intval($_POST['product_id']);
    $delete_query = "DELETE FROM cart WHERE id = $product_id";
    mysqli_query($conn, $delete_query);
}

// Fetch cart items from the database
$query = "SELECT * FROM cart";
$result = mysqli_query($conn, $query);

// Calculate the total price and total count
$total_price = 0;
$total_count = 0;
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_price += $row['product_price'] * $row['quantity'];
        $total_count += $row['quantity'];
    }
    mysqli_data_seek($result, 0); // Reset pointer for display
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart with Quantity Management</title>
    <style>
        /* Global Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background: #f8f9fa;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
            font-size: 2.5em;
        }

        /* Table Styling */
        table {
            width: 90%;
            margin: 0 auto 20px;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #007bff;
            color: #fff;
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 1em;
            border-bottom: 1px solid #e9ecef;
        }

        th {
            text-transform: uppercase;
            font-size: 0.9em;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #007bff;
        }

        /* Quantity Buttons */
        .quantity-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .quantity-button {
            padding: 5px 10px;
            font-size: 1em;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .quantity-button:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            background: #f8f9fa;
            font-size: 1em;
        }

        .remove-button {
            background: #dc3545;
        }

        .remove-button:hover {
            background: #c82333;
        }

        /* Summary Section */
        .summary-container {
            width: 90%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .summary-item {
            font-size: 1.2em;
            color: #495057;
        }

        .summary-item span {
            font-weight: bold;
        }

        .summary-item.total {
            font-size: 1.5em;
            color: #007bff;
        }

        .button-container {
            text-align: right;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        a {
            text-decoration: none;
            font-size: 1em;
            color: #007bff;
            margin-right: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>🛒 Your Cart</h1>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($row['product_img']); ?>" alt="Product Image"></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['product_price']); ?></td>
                        <td>
                            <div class="quantity-buttons">
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="decrement_quantity" class="quantity-button">-</button>
                                </form>
                                <input type="text" class="quantity-input" value="<?php echo htmlspecialchars($row['quantity']); ?>" readonly>
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="increment_quantity" class="quantity-button">+</button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="remove_item" class="quantity-button remove-button">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="summary-container">
            <div class="summary">
                <div class="summary-item">Items in Cart: <span><?php echo $total_count; ?></span></div>
                <div class="summary-item total">Total Price: ₹<span><?php echo $total_price; ?></span></div>
            </div>
            <div class="button-container">
                <a href="menu.php">Continue Shopping</a>
                <button onclick="window.location.href='orderdetails.php'">Order Now</button>

            </div>
        </div>
    <?php else: ?>
        <p style="text-align: center; font-size: 1.5em; color: #6c757d;">🚫 Your cart is empty! 🚫</p>
        <div class="button-container" style="text-align: center;">
            <a href="menu.php">Back to Menu</a>
        </div>
    <?php endif; ?>

    <script>
        function orderNow() {
            alert('🎉 Your order has been placed successfully! 🎉');
        }
    </script>
</body>
</html>
