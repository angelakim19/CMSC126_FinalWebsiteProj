<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePicture'])) {
    // Ensure the upload directory exists
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmpPath = $_FILES['profilePicture']['tmp_name'];
    $fileName = $_FILES['profilePicture']['name'];
    $fileSize = $_FILES['profilePicture']['size'];
    $fileType = $_FILES['profilePicture']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Sanitize file name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // Allowed file types
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $dest_path = $uploadDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
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

            // Update the user's profile picture in the database
            $studentnumber = $_SESSION['studentnumber'];
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE studentnumber = ?");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param('ss', $dest_path, $studentnumber);
            if ($stmt->execute()) {
                // Update the session with the new profile picture path
                $_SESSION['profile_picture'] = $dest_path;
                
                // Redirect back to the landing page
                header("Location: rgtrlandingpage.php");
                exit();
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo 'There was an error moving the uploaded file.';
        }
    } else {
        echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
} else {
    echo 'No file uploaded or invalid request method.';
}
?>
