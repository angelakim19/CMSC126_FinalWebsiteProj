<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $studentnumber = $_POST['studentnumber'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $password = $_POST['password'];

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $servername = "localhost"; 
    $username = "root"; 
    $password = "your_password"; 
    $dbname = "registration_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (firstname, middlename, lastname, studentnumber, email, college, program, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $bind = $stmt->bind_param("ssssssss", $firstname, $middlename, $lastname, $studentnumber, $email, $college, $program, $hashed_password);
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

    if ($stmt->execute()) {
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['studentnumber'] = $studentnumber;

        header("Location: rgtrlandingpage.php");
        exit;
    } else {
        echo "Execute failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

}
?>
