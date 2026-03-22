<?php
require 'conne.php';

$proname = $_POST["proname"];
$price = $_POST["proprice"];
$imgName = $_FILES["file"]["name"];
$imgTmpName = $_FILES["file"]["tmp_name"];
$tab = $_POST["table"];

// Directory to save uploaded images
 $uploadDir = "C:/xampp/htdocs/chandru/";

$uploadFile = $uploadDir . basename($imgName);

// Check if the table is valid
$validTables = ["events","korea"];
if (!in_array($tab, $validTables)) {
    die("Invalid table selected.");
}

// Move uploaded image to the upload directory
if (move_uploaded_file($imgTmpName, $uploadFile)) {
    // Insert data into the selected table
    $sql = "INSERT INTO $tab (proname, proprice, img) VALUES ('$proname', '$price', '$imgName')";

    if (mysqli_query($conn, $sql)) {
        echo "<style>
            h1 {
                color: green;
            }

            body {
                background-image: linear-gradient(rgba(0, 0, 0, 0.689), rgba(0, 0, 0, 0.41)), url(imgs/adminback.webp);
                background-size: cover;
                text-align: center;
            }

            .custom-alert {
                position: fixed;
                top: 50%;
                left: 50%;
                width: 50%;
                height: 50%;
                transform: translate(-50%, -50%);
                background-color: rgba(241, 226, 151, 0.489);
                color: white;
                padding: 50px;
                padding-top: 300px;
                border: 1px solid transparent;
                border-radius: 5px;
                font-size: 30px;
                font-family: Verdana, Tahoma, sans-serif;
                text-align: center;
            }

            button {
                border: 1px solid rgba(241, 226, 151, 0.958);
                padding: 10px;
                font-size: 20px;
                color: white;
                font-family: Verdana, Tahoma, sans-serif;
                background-color: rgba(241, 226, 151, 0.489);
            }
        </style>


<body>

    <div id='customAlert' class='custom-alert'>
        <p id='alertMessage'></p>
        <button id='customButton'>Close</button>
    </div>

    <script>
        const message = 'Product has been added to the display';
        const buttonText = 'Add More';
        const alertBox = document.getElementById('customAlert');
        const alertMessage = document.getElementById('alertMessage');
        const customButton = document.getElementById('customButton');

        // Set the message and button label
        alertMessage.innerText = message;
        customButton.innerText = buttonText;

        // Show the custom alert box
        alertBox.style.display = 'block';

        // Handle button click
        customButton.addEventListener('click', function () {
            window.location.href = 'padd.html';
        });
    </script>
</body>
";
    } else {
        echo "<p>Can't add the product: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>Failed to upload the image.</p>";
}
?>
