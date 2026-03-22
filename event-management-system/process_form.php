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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $mobileNumber = $_POST['mobileNumber'];
    $eventName = $_POST['Event_Name'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $eventVenue = $_POST['eventVenue'];
    $guestCount = $_POST['guestCount'];
    $additionalRequirements = $_POST['additionalRequirements'];

    // SQL to insert data into the events table
    $sql = "INSERT INTO tamilevents (name, mobile_number, event_name, event_date, event_time, event_venue, guest_count, additional_requirements)
            VALUES ('$name', '$mobileNumber', '$eventName', '$eventDate', '$eventTime', '$eventVenue', '$guestCount', '$additionalRequirements')";

    if ($conn->query($sql) === TRUE) {
        echo "Event registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
