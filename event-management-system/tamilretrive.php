<?php
// Database connection
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "chandru"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to select data from the tamilevents table
$sql = "SELECT * FROM tamilevents";
$result = $conn->query($sql);

// Check if there are any results
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2d3e50;
            margin-bottom: 30px;
            font-size: 36px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
        }

        td {
            font-size: 16px;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Pagination Styles (optional, if you plan to add pagination) */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #45a049;
        }

        /* Empty State */
        .no-events {
            text-align: center;
            font-size: 18px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Event Details</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Event Time</th>
                    <th>Event Venue</th>
                    <th>Guest Count</th>
                    <th>Additional Requirements</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["event_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["event_date"]); ?></td>
                        <td><?php echo htmlspecialchars($row["event_time"]); ?></td>
                        <td><?php echo htmlspecialchars($row["event_venue"]); ?></td>
                        <td><?php echo htmlspecialchars($row["guest_count"]); ?></td>
                        <td><?php echo htmlspecialchars($row["additional_requirements"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-events">No events found.</p>
    <?php endif; ?>

</div>

<?php
// Close the connection
$conn->close();
?>

</body>
</html>
