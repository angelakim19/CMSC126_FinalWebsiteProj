<?php
$servername = "localhost"; 
$username = "root"; 
$dbpassword = ""; // Use the correct password for the MySQL root user
$dbname = "registration_db";

// Create connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all expected POST variables are set
    $event_name = isset($_POST['event-name']) ? $_POST['event-name'] : '';
    $event_date = isset($_POST['choose-date']) ? $_POST['choose-date'] : '';
    $event_time = isset($_POST['choose-time']) ? $_POST['choose-time'] : '';
    $person = isset($_POST['organization']) ? $_POST['organization'] : '';
    $status = 'pending'; // Set a default status if not provided

    // Check if table exists
    $table_check_query = "SHOW TABLES LIKE 'lemito_events'";
    $table_check_result = $conn->query($table_check_query);

    if ($table_check_result->num_rows == 0) {
        die("Error: Table 'lemito_events' does not exist.");
    }

    try {
        $sql = "INSERT INTO lemito_events (event_name, event_date, event_time, person, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $event_name, $event_date, $event_time, $person, $status);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lemito Reservation</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #fbc130;
            background-image: url('YUPi Student Panel.png');
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            text-align: center;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 80px;
            margin-left: 20px;
        }

        .logo-text {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .navigation-bar {
            background-color: #14533c;
            height: 80px;
            width: 100%;
            display: flex;
            justify-content: space-between; 
            align-items: center;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .user-photo {
            width: 40px;
            height: 40px;
            border: 2px solid rgb(91, 88, 88);
            border-radius: 50%;
            margin-right: 30px;
            cursor: pointer;
        }

        .about-us {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .about-us a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-right: 20px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        .lemito-reservation {
            background-color: #fbc130;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 120px auto 40px;
            text-align: left;
            color: black;
        }

        .lemito-reservation h2 {
            font-family: 'Quiapo', sans-serif;
            color: #7a0422;
            font-size: 36px;
        }

        .lemito-reservation label {
            display: block;
            margin: 10px 0 5px;
        }

        .lemito-reservation input,
        .lemito-reservation textarea,
        .lemito-reservation select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: 'Fredoka One', sans-serif;
        }

        .lemito-reservation .form-buttons {
            display: flex;
            justify-content: space-between;
        }

        .lemito-reservation .form-buttons button {
            flex: 1;
            margin: 0 5px;
            padding: 10px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
        }

        .lemito-reservation .form-buttons .confirm {
            background-color: #007b70;
            color: white;
        }

        .lemito-reservation .form-buttons .cancel {
            background-color: #7a0422;
            color: white;
        }

        .add-file-button {
            background-color: #007b70;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
        }

        .add-file-button:hover {
            background-color: #005f50;
        }
    </style>
</head>
<body>
    <div class="navigation-bar">
        <div class="logo">
            <img src="yupilogo.png" alt="YUPI Logo">
            <span class="logo-text">YUPI</span>
        </div>
        <nav>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex;">
                <li class="about-us"><a href="#" id="about-us-link">ABOUT US</a></li>
                <li><img src="default_userp.png" alt="User Photo" class="user-photo" id="user-photo"></li>
            </ul>
        </nav>
    </div>
    <div class="lemito-reservation">
        <h2>Lemito Reservation</h2>
        <form id="reservation-form" method="POST" action="lemito_reservation.php" enctype="multipart/form-data">
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event-name" required>

            <label for="organization">Organization:</label>
            <input type="text" id="organization" name="organization" required>

            <label for="purpose">Purpose:</label>
            <input type="text" id="purpose" name="purpose" required>

            <label for="request-letter-osa">Request Letter for OSA:</label>
            <input type="file" id="request-letter-osa" name="request-letter-osa" required>

            <label for="request-letter-ulo">Request Letter for University Librarian Office:</label>
            <input type="file" id="request-letter-ulo" name="request-letter-ulo" required>

            <div id="additional-files"></div>

            <button type="button" class="add-file-button" onclick="addFileInput()">+ Add another file</button>

            <label for="choose-date">Choose Date:</label>
            <input type="date" id="choose-date" name="choose-date" required>

            <label for="choose-time">Choose Time:</label>
            <input type="time" id="choose-time" name="choose-time" required>

            <div class="form-buttons">
                <button type="submit" class="confirm">Confirm</button>
                <button type="button" class="cancel" onclick="window.location.href='reserve_seat.php'">Cancel</button>
            </div>
        </form>
    </div>
    <script>
        function addFileInput() {
            const additionalFiles = document.getElementById('additional-files');
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'additional-file[]';
            additionalFiles.appendChild(input);
        }
    </script>
</body>
</html>