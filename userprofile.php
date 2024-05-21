<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to YUPi University Library</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif; 
      background-image: url('YUPi_userprofile.png');
      background-size: cover;
      background-repeat: no-repeat;
      color: white;
      text-align: center;
      overflow: hidden;
    }

    .logo {
      display: flex;
      align-items: center;
    }
    
    .logo img {
      width: 80px;
      margin-left: 20px;
    }

    .logo-text {
      color: white;
      font-size: 24px;
      font-weight: bold;
    }

    .navigation-bar {
      background-color: #14533c;
      height: 80px;
      width: 100%;
      display: flex;
      justify-content: space-between; 
      align-items: center;
      position: fixed;
      top: 0;
      z-index: 1000;
    }

    .user-photo {
      width: 40px;
      height: 40px;
      border: 2px solid rgb(246, 241, 241); 
      border-radius: 50%; 
      margin-right: 30px; 
      cursor: pointer;
    }

    .user-dropdown {
      display: none; /* Hidden by default */
      position: absolute;
      background-color: #fbfffe;
      min-width: 120px;
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 10px;
      margin-top: 20px;
      right: 30px; /* Align dropdown with user photo */
    }

    .user-dropdown a {
      color: rgb(6, 6, 6);
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .user-dropdown a:hover {
      background-color: #7a0422;
    }

    .about-us {
      display: flex;
      align-items: center;
      margin-left: 20px;
    }

    .about-us a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      margin-right: 20px;
      font-family: Arial, sans-serif;
      font-weight: bold; 
    }

    h1 {
      margin-top: 120px;
      font-size: 48px;
      font-weight: bold;
    }

    p {
      font-size: 24px;
      margin-top: 10px;
    }

    .profile-section {
      background-color: transparent;
      padding: 20px;
      border-radius: 0px;
      margin-top: 450px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      width: 100%;
      max-width: 1500px;
      margin-left: auto;
      margin-right: auto;
      flex-direction: row-reverse; 
      position: relative; 
    }

    .profile-info-container {
      display: flex;
      align-items: center;
      width: 100%;
    }

    .profile-photo {
      width: 300px;
      height: 300px;
      border-radius: 50%;
      margin-right: 20px; 
      margin-left: 16px;
      margin-top: -140px;
      border: 5px solid whitesmoke; 
    }

    .profile-info {
      text-align: left;
      color: black;
    }

    .profile-info h2 {
      margin: 0;
      font-size: 24px;
      margin-top: -50px;
    }

    .profile-info p {
      margin: 5px 0 0;
      font-size: 18px;
    }

    .buttons-section {
      display: flex;
      justify-content: flex-start; 
      flex-wrap: wrap;
      width: 100%;
      margin-top: 0px;
      padding-left: 25%; 
    }

    .buttons-section button {
      background-color: #14533c;
      color: white;
      border: none;
      padding: 15px 100px;
      margin: 30px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 18px;
      box-shadow: 0 4px #0e392b;
    }

    .buttons-section button:hover {
      background-color: #7a0422;
      transform: translateY(-2px); 
      box-shadow: 0 6px #0e392b; 
    }

    .buttons-section button:active {
      transform: translateY(2px); 
      box-shadow: 0 2px #0e392b; 
    }
    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }

  </style>
</head>

<body>
  <div class="navigation-bar">
    <div class="logo">
      <img src="yupilogo.png" alt="YUPi University Library Logo">
      <span class="logo-text">YUPI</span>
    </div>
    <nav>
      <ul style="list-style: none; padding: 0; margin: 0; display: flex;">
        <li class="about-us"><a href="#" id="about-us-link">ABOUT US</a></li>
        <li><img src="<?php echo $profilePicture; ?>" alt="User Photo" class="user-photo" id="user-photo"></li> 
      </ul>
    </nav>
  </div>

  <div class="clearfix">
    <div class="profile-section">
      <div class="profile-info-container">
        <img src="<?php echo $profilePicture; ?>" alt="User Photo" class="profile-photo">
        <div class="profile-info">
          <h2><?php echo $firstname . " " . $lastname; ?></h2>
          <p><?php echo $studentnumber; ?></p>
        </div>
      </div>
      <!-- User dropdown menu -->
      <div class="user-dropdown" id="user-dropdown">
        <a href="#" id="settings-link">Settings</a>
        <a href="#" id="feedback-link">Feedback</a>
        <a href="#" id="help-link">Help and Support</a>
        <a href="logout.php" id="logout-link">Log Out</a>
      </div>
    </div>
  </div>

  <div class="buttons-section">
    <button onclick="navigateTo('profile')">Profile</button>
    <button onclick="navigateTo('records')">Records of Log in</button>
    <button onclick="navigateTo('library')">Library Places</button>
  </div>

  <script>
    document.getElementById('about-us-link').addEventListener('click', function() {
      window       .location.href = 'about_us.html'; // Redirect to About Us page
    });

    document.getElementById('user-photo').addEventListener('click', function() {
      var dropdown = document.getElementById('user-dropdown');
      if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
      } else {
        dropdown.style.display = 'block';
      }
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.user-photo')) {
        var dropdown = document.getElementById('user-dropdown');
        if (dropdown.style.display === 'block') {
          dropdown.style.display = 'none';
        }
      }
    }

    // Add event listeners for dropdown menu items
    document.getElementById('settings-link').addEventListener('click', function() {
      // Add logic to navigate to settings page
    });

    document.getElementById('feedback-link').addEventListener('click', function() {
      // Add logic to navigate to feedback page
    });

    document.getElementById('help-link').addEventListener('click', function() {
      // Add logic to navigate to help and support page
    });

    document.getElementById('logout-link').addEventListener('click', function() {
      // Add logic to log out user
    });

    function navigateTo(section) {
      switch (section) {
        case 'profile':
          alert('Navigating to Profile');
          // Add navigation logic here
          break;
        case 'records':
          alert('Navigating to Records of Log in');
          // Add navigation logic here
          break;
        case 'library':
          alert('Navigating to Library Places');
          // Add navigation logic here
          break;
        default:
          alert('Unknown section');
      }
    }

    // Fetch user data and update profile info
    document.addEventListener('DOMContentLoaded', function() {
      // Update profile info using PHP-generated JSON
      var userData = <?php echo json_encode($data); ?>;
      document.querySelector('.profile-info h2').textContent = userData.firstname + ' ' + userData.lastname;
      document.querySelector('.profile-info p').textContent = userData.studentnumber;
      document.querySelector('.profile-photo').src = userData.profilePicture;

      // Flash effect for user name and student number
      let nameElement = document.querySelector('.profile-info h2');
      let numberElement = document.querySelector('.profile-info p');
      let originalColor = nameElement.style.color;
      let flash = function(element) {
        element.style.transition = 'color 0.5s ease';
        element.style.color = '#ff0000';
        setTimeout(() => {
          element.style.color = originalColor;
        }, 500);
      }

      flash(nameElement);
      flash(numberElement);
    });
  </script>
</body>
</html>

