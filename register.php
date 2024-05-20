\<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $studentnumber = $_POST['studentnumber'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $phonenumber = $_POST['phoneNumber'];
    $position = $_POST['position'];
    $password = $_POST['password'];

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (firstname, middlename, lastname, studentnumber, email, college, program, password, position, phoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $firstname, $middlename, $lastname, $studentnumber, $email, $college, $program, $hashed_password, $position, $phonenumber);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: rgtrlandingpage.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
