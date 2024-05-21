<?php
session_start();

// Assuming you have retrieved the necessary session data
$firstname = isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname']) : '';
$lastname = isset($_SESSION['lastname']) ? htmlspecialchars($_SESSION['lastname']) : '';
$studentnumber = isset($_SESSION['studentnumber']) ? htmlspecialchars($_SESSION['studentnumber']) : '';
$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'default_user_photo.png';

// Prepare data array
$data = array(
    'firstname' => $firstname,
    'lastname' => $lastname,
    'studentnumber' => $studentnumber,
    'profilePicture' => $profilePicture
);

// Output JSON
echo json_encode($data);
?>
