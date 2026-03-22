<?php
// Database connection details
$host = "localhost"; // Replace with your database host
$db_username = "root";  // Replace with your database username
$db_password = "";      // Replace with your database password
$database = "chandru";  // Replace with your database name

// Connect to the database
$conn = new mysqli($host, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username and password are required!";
        exit;
    }

    // Fetch the user data from the database
    $sql = "SELECT password FROM registration WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the entered password with the hashed password
            if (password_verify($password, $hashed_password)) {
                echo "Login successful! Welcome, " . htmlspecialchars($username) . ".";
                // Redirect the user to a dashboard or homepage
                // header("Location: dashboard.php");
                exit;
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "No user found with that username!";
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
