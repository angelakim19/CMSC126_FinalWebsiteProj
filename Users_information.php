<?php
include 'db.php';

// Fetch data from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YUPI Admin Panel - User's Information</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Titan+One&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            width: 100%;
            overflow: auto;
            background-color: #fbc130;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            background-color: #fbc130;
        }

        header {
            background-color: #007b70;
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: flex-start;
        }

        .logo {
            width: 70px;
        }

        .title {
            font-family: 'Titan One', cursive;
            font-size: 36px;
            color: #000;
            margin-left: 20px;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        h2 {
            font-family: 'Titan One', cursive;
            font-size: 30px;
            color: #000;
            margin-bottom: 20px;
        }

        .search-filter {
            display: flex;
            margin-bottom: 20px;
        }

        .search-filter input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border-radius: 25px;
            border: 2px solid #0c0b0b;
            box-shadow: -3px -3px 7px white, 3px 3px 7px rgba(0, 0, 0, 0.2);
            margin-right: 10px;
        }

        .search-filter button {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            border: none;
            background-color: #808080;
            color: #fff;
            cursor: pointer;
            box-shadow: -3px -3px 7px white, 3px 3px 7px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #007b70;
            color: white;
        }

        .no-records {
            text-align: center;
            font-size: 16px;
            color: #000;
        }

        .actions button {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            background-color: #007b70;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .actions button:hover {
            background-color: #005f57;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="yupilogo.png" alt="YUPI Logo" class="logo">
            <div class="title">
                YUPI ADMIN PANEL
            </div>
        </header>
        <main>
            <h2>User's Information</h2>
            <div class="search-filter">
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
                        <th>Position</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td><input type='checkbox'></td>
                                <td>{$row['studentnumber']}</td>
                                <td>{$row['firstname']} {$row['middlename']} {$row['lastname']}</td>
                                <td>{$row['college']}</td>
                                <td>{$row['program']}</td>
                                <td>{$row['position']}</td>
                                <td>{$row['phoneNumber']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['password']}</td>
                                <td class='actions'>
                                    <button onclick=\"editUser({$row['id']})\">Edit</button>
                                    <button onclick=\"deleteUser({$row['id']})\">Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='no-records'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    <script>
        function editUser(id) {
            window.location.href = `edit_user.php?id=${id}`;
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
