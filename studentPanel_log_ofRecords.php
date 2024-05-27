<?php
session_start();

if (!isset($_SESSION['firstname']) || !isset($_SESSION['lastname']) || !isset($_SESSION['studentnumber'])) {
    header("Location: register.php");
    exit();
}

$firstname = htmlspecialchars($_SESSION['firstname']);
$lastname = htmlspecialchars($_SESSION['lastname']);
$studentnumber = htmlspecialchars($_SESSION['studentnumber']);
// Include the database connection file
include 'db.php';

// Get user ID from session
$userId = $_SESSION['user_id']; // Update this to the correct session key if different

// Fetch user details
$stmt = $conn->prepare("SELECT firstname, lastname, studentnumber FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $studentnumber);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Log</title>
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

        .log-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 120px auto 40px;
            text-align: left;
            color: black;
        }

        .log-container h2 {
            font-family: 'Quiapo', sans-serif;
            color: #7a0422;
            font-size: 36px;
            text-align: center;
        }

        .log-table {
            width: 100%;
            border-collapse: collapse;
        }

        .log-table th, .log-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .log-table th {
            background-color: #14533c;
            color: white;
        }

        .log-table td {
            background-color: #f9f9f9;
        }

        .log-container .print-button {
            background-color: #007b70;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
            display: inline-block;
            margin-top: 20px;
        }

        .log-container .print-button:hover {
            background-color: #005f50;
        }

        .search-reservation {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ccc;
            outline: none;
        }

        .search-bar button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-left: none;
            border-radius: 0 5px 5px 0;
            background-color: #ccc;
            cursor: pointer;
        }

        .reservation-button {
            background-color: #7a0422;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
        }

        .reservation-button:hover {
            background-color: #5a0219;
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
    <div class="log-container">
        <h2>Log Records</h2>
        <div class="user-info" style="display: flex; align-items: center; margin-bottom: 20px;">
            <img src="default_userp.png" alt="User Photo" class="user-photo" style="border: 5px solid white; margin-right: 20px;">
            <div>
                <div style="font-size: 24px; font-weight: bold; color: black;"><?= $firstname . " " . $lastname ?></div>
                <div style="font-size: 18px; color: black;"><?= $studentnumber ?></div>
            </div>
        </div>
        <div class="search-reservation">
            <div class="search-bar">
                <input type="text" placeholder="Search..." id="search-input">
                <button onclick="searchRecords()">🔍</button>
            </div>
            <button class="reservation-button" onclick="window.location.href='student_reservation.php'">RESERVATIONS</button>
        </div>
        <table class="log-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Log In</th>
                    <th>Log Out</th>
                    <th>Space/s Visited</th>
                    <th>Borrowed Book/s</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Book/s Borrowed Status</th>
                </tr>
            </thead>
            <tbody id="log-records-body">
                <?php
                // Fetch log records
                $stmt = $conn->prepare("SELECT log_date, log_in_time, log_out_time, spaces_visited, borrowed_books, borrowed_date, due_date, borrowed_status FROM log_records WHERE student_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($log_date, $log_in_time, $log_out_time, $spaces_visited, $borrowed_books, $borrowed_date, $due_date, $borrowed_status);

                while ($stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>{$log_date}</td>";
                    echo "<td>{$log_in_time}</td>";
                    echo "<td>{$log_out_time}</td>";
                    echo "<td>{$spaces_visited}</td>";
                    echo "<td>{$borrowed_books}</td>";
                    echo "<td>{$borrowed_date}</td>";
                    echo "<td>{$due_date}</td>";
                    echo "<td>{$borrowed_status}</td>";
                    echo "</tr>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
        <button class="print-button" onclick="window.print()">Print</button>
    </div>
    <script>
        function searchRecords() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('#log-records-body tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        }
    </script>
</body>
</html>
