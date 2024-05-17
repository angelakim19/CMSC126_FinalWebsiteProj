<?php
include 'db.php';

// Fetch the user data to be edited
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No user found with ID $id";
        exit;
    }
}

// Update user data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $studentnumber = $_POST['studentnumber'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $position = $_POST['position'];
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', studentnumber='$studentnumber', email='$email', college='$college', program='$program', position='$position', phonenumber='$phonenumber', password='$password' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* Add your CSS here */
    </style>
</head>
<body>
    <h2>Edit User</h2>
    <form method="post" action="edit_user.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>"><br>

        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename" value="<?php echo $user['middlename']; ?>"><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>"><br>

        <label for="studentnumber">Student Number:</label>
        <input type="text" id="studentnumber" name="studentnumber" value="<?php echo $user['studentnumber']; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>

        <label for="college">College/Department:</label>
        <input type="text" id="college" name="college" value="<?php echo $user['college']; ?>"><br>

        <label for="program">Program/Course:</label>
        <input type="text" id="program" name="program" value="<?php echo $user['program']; ?>"><br>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" value="<?php echo $user['position']; ?>"><br>

        <label for="phonenumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phonenumber" value="<?php echo $user['phonenumber']; ?>"><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>"><br>

        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
