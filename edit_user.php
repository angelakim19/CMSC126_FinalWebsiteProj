<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $studentnumber = $_POST['studentnumber'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $position = $_POST['position'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    
    $sql = "UPDATE users SET firstname=?, middlename=?, lastname=?, studentnumber=?, email=?, phonenumber=?, position=?, college=?, program=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $firstname, $middlename, $lastname, $studentnumber, $email, $phonenumber, $position, $college, $program, $user_id);

    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
