\<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Records</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Titan+One&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            width: 100%;
            background-color: #fbc130;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        header {
            background-color: #007b70;
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            width: 70px;
            margin-right: 20px;
        }

        .title {
            font-family: 'Titan One', cursive;
            font-size: 36px;
            color: #000;
        }

        .title span {
            font-family: 'Fredoka One', cursive;
            font-size: 20px;
            margin-left: 10px;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            width: 80%;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            border: 2px solid #000;
            border-radius: 25px;
            box-shadow: -3px -3px 7px white, 3px 3px 7px rgba(0, 0, 0, 0.2);
        }

        .search-bar button {
            padding: 10px 20px;
            font-size: 18px;
            font-family: 'Titan One', cursive;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            background-color: #808080;
            color: #fff;
            box-shadow: -3px -3px 7px white, 3px 3px 7px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #000;
        }

        th {
            background-color: #007b70;
            color: white;
            font-family: 'Fredoka One', cursive;
        }

        td {
            background-color: #fbc130;
            font-family: 'Arial', sans-serif;
        }

        .no-records {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="yupilogo.png" alt="YUPI Logo" class="logo">
            <div class="title">
                YUPI <span>ADMIN PANEL</span>
            </div>
        </header>
        <div class="content">
            <h1 class="title">LOG RECORDS</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <button>Filter</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>ID Number</th>
                        <th>Name</th>
                        <th>College/Department</th>
                        <th>Program</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Places Visited</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = "SELECT * FROM log_records";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td><input type='checkbox'></td>
                                <td>" . $row['id_number'] . "</td>
                                <td>" . $row['name'] . "</td>
                                <td>" . $row['college_department'] . "</td>
                                <td>" . $row['program'] . "</td>
                                <td>" . $row['time_in'] . "</td>
                                <td>" . $row['time_out'] . "</td>
                                <td>" . $row['places_visited'] . "</td>
                                <td>" . $row['position'] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
