<?php
session_start();

if (!isset($_SESSION['firstname']) || !isset($_SESSION['lastname']) || !isset($_SESSION['studentnumber'])) {
    // Redirect to the registration page if session variables are not set
    header("Location: register.php");
    exit();
}

$firstname = htmlspecialchars($_SESSION['firstname']);
$lastname = htmlspecialchars($_SESSION['lastname']);
$studentnumber = htmlspecialchars($_SESSION['studentnumber']);
$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'default-profile-picture.jpg';
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>yupiregistrationlandingpagepage</title>
  <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif; 
        background-image: url(YUPi_register.png);
        background-size: cover;
        background-repeat: no-repeat;
        margin-bottom: 100px;
    }

    .logo{
      margin-left: -150px;
    }
    .logo img {
        width: 80px; 
    }

    .navigation-bar {
        background-color: #14533c; 
        height: 80px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #navigation-container {
        width: 100%;
        max-width: 1200px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    .container {
        width:fit-content;
        margin-left: 20px;
        margin-right: 70px;
        background-color: #f8dd8aa1;
        padding: 100px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        float: right;
        margin-top: 100px;
    }

    .profile {
      text-align: center;
      margin-bottom: 20px;
    }

    .profile img {
      width: 200px;
      height: 200px;
      border-radius: 80%;
      border: 5px solid #070707;
      margin-bottom: 10px;
    }

    .profile h2 {
      margin: 0;
      margin-bottom: 10px;
      font-size: 24px;
      text-align: left;
      margin-left: -50px;
    }

    .student-number {
      font-size: 18px;
      text-align: left;
      margin-left: -50px;
    }

    .buttons {
      text-align: center;
    }

    .buttons button {
      padding: 10px 20px;
      margin: 0 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      background-color: #08542a;
      color: #fff;
      transition: background-color 0.3s;
    }

    .buttons .skip:hover, .buttons .select:hover {
      background-color: #b11e2a;
    }

    .buttons .select {
      width: 200px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .form-group {
        flex: 1;
        margin-right: 10px;
    }

    .form-group:last-child {
        margin-right: 0;
    }

    .profile-picture-container {
      position: relative;
      display: inline-block;
      margin-bottom: 20px;
      margin-top: 20px;
    }

    .profile-picture-container input[type="file"] {
      position: absolute;
      opacity: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }

    .choose-file-button {
      background-color: #08542a;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      padding: 10px 20px;
      margin-top: 10px;
    }

    .choose-file-button:hover {
      background-color: #b11e2a;
    }
  </style>
</head> 
<body>
  <div class="navigation-bar">
    <div id="navigation-container">
      <div class="logo">
        <img src="yupilogo.png">
      </div>
    </div>
  </div>

  <div class="container">
    <div class="profile">
      <h2>Welcome, <?php echo $firstname . " " . $lastname; ?>!</h2>
      <p class="student-number">Student Number: <?php echo $studentnumber; ?></p>
      <div class="profile-picture-container">
        <img id="profilePicture" src="<?php echo $profilePicture; ?>" alt="Profile Picture" width="200" height="200">
        <input type="file" id="file-upload" name="profilePicture" accept="image/*">
      </div>
    </div>
    <div class="buttons">
      <button class="skip">Skip</button>
      <label for="file-upload" class="choose-file-button">Choose File</label>
      <button type="submit" class="select">Upload</button>
    </div>
  </div>

  <script>
    document.querySelector('input[type="file"]').addEventListener('change', function(event) {
      const reader = new FileReader();
      reader.onload = function() {
        document.getElementById('profilePicture').src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    });

   
  </script>
</body>
</html>
