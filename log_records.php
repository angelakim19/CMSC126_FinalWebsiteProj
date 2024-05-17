<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YUPI Admin Panel - Log Records</title>
    <style>
        /* Include your CSS here */
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
            <h1>LOG RECORDS</h1>
            <div class="filter-container">
                <input type="text" placeholder="Search...">
                <button class="filter-button">Filter</button>
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
                            echo "<tr>";
                            echo "<td><input type='checkbox'></td>";
                            echo "<td>" . $row['id_number'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['college_department'] . "</td>";
                            echo "<td>" . $row['program'] . "</td>";
                            echo "<td>" . $row['time_in'] . "</td>";
                            echo "<td>" . $row['time_out'] . "</td>";
                            echo "<td>" . $row['places_visited'] . "</td>";
                            echo "<td>" . $row['position'] . "</td>";
                            echo "</tr>";
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
