<?php
include 'db.php';

// Assuming user ID is passed via session or another method
session_start();
$user_id = $_SESSION['user_id'] ?? 1; // Replace with actual user ID retrieval logic

$sql = "SELECT log_date, log_in, log_out, places_visited FROM log_records WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$log_records = [];

while ($row = $result->fetch_assoc()) {
    $log_records[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YUPI Log Records</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #fbc130;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            background-color: #007b70;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 50px;
        }

        .header .title {
            font-size: 24px;
            font-weight: bold;
        }

        .header .search-box {
            display: flex;
            align-items: center;
        }

        .header input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 5px;
        }

        .header button {
            background-color: #ccc;
            border: none;
            padding: 5px 10px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .user-info {
            background-color: #fbc130;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .user-info .name {
            font-size: 20px;
        }

        .user-info .student-number {
            font-size: 16px;
        }

        .log-records table {
            width: 100%;
            border-collapse: collapse;
        }

        .log-records th, .log-records td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .log-records th {
            background-color: #007b70;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="yupilogo.png" alt="YUPI Logo">
            <div class="title">YUPI</div>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <button>Search</button>
            </div>
        </div>
        <div class="user-info">
            <div class="name">Nebria, Quennie A.</div>
            <div class="student-number">2023-05107</div>
        </div>
        <div class="log-records">
            <h2>Log Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Log In</th>
                        <th>Log Out</th>
                        <th>Place/s Visited</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($log_records as $record): ?>
                        <tr>
                            <td><?php echo $record['log_date']; ?></td>
                            <td><?php echo $record['log_in']; ?></td>
                            <td><?php echo $record['log_out']; ?></td>
                            <td><?php echo $record['places_visited']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($log_records)): ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
