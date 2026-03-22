<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'chandru');

// Check the database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Query to fetch data from the 'events' table
$sql = "SELECT proname, proprice, img FROM events;";
$result = mysqli_query($conn, $sql);

// Check if there are rows in the result set
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MC Events - Our Offerings</title>
        <style>
            /* General Reset */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(145deg, #f3f3f3, #eaeaea);
                color: #333;
                margin: 0;
            }
            header {
                background: #ff7f50;
                padding: 15px 20px;
                text-align: center;
                color: #fff;
                font-size: 1.8rem;
                font-weight: bold;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }
            h1 {
                text-align: center;
                margin: 30px 0;
                font-size: 2.5rem;
                color: #ff7f50;
            }
            .container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
                padding: 20px;
                max-width: 1200px;
                margin: auto;
            }
            .card {
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                position: relative;
                animation: fadeIn 0.6s ease;
            }
            .card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            }
            .card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }
            .card-content {
                padding: 20px;
                text-align: center;
            }
            .card h3 {
                font-size: 1.6rem;
                margin-bottom: 10px;
                color: #ff7f50;
            }
            .card p {
                font-size: 1rem;
                margin-bottom: 15px;
                color: #555;
            }
            .card button {
                padding: 10px 20px;
                background: #ff7f50;
                color: #fff;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 1rem;
                font-weight: bold;
                transition: background 0.3s ease, transform 0.3s ease;
            }
            .card button:hover {
                background: #ff946d;
                transform: scale(1.05);
            }
            footer {
                margin-top: 40px;
                text-align: center;
                padding: 20px;
                background: #333;
                color: #ccc;
                font-size: 0.9rem;
            }
            footer a {
                color: #ff7f50;
                text-decoration: none;
            }
            footer a:hover {
                text-decoration: underline;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body>
        <header>
            MC Events
        </header>
        <h1>Our Offerings</h1>
        <div class="container">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $productName = htmlspecialchars($row['proname']);
                $productPrice = htmlspecialchars($row['proprice']);
                $productImage = htmlspecialchars($row['img']);
                ?>
                <div class="card">
                    <img src="/chandru/<?php echo $productImage; ?>" alt="Event Image">
                    <div class="card-content">
                        <h3><?php echo $productName; ?></h3>
                        <p>Price: ₹<?php echo $productPrice; ?></p>
                        <form action="view_more.php" method="get">
                            <input type="hidden" name="product_name" value="<?php echo $productName; ?>">
                            <button type="submit">View More</button>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <footer>
            &copy; <?php echo date("Y"); ?> MC Events. All rights reserved.
        </footer>
    </body>
    </html>
    <?php
} else {
    echo "<p style='text-align: center; color: #333;'>No records found in the database.</p>";
}
?>
