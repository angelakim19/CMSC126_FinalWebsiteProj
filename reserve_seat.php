<?php
session_start();

if (!isset($_SESSION['firstname']) || !isset($_SESSION['lastname']) || !isset($_SESSION['studentnumber'])) {
    header("Location: register.php");
    exit();
}

$firstname = htmlspecialchars($_SESSION['firstname']);
$lastname = htmlspecialchars($_SESSION['lastname']);
$studentnumber = htmlspecialchars($_SESSION['studentnumber']);
$profilePicture = isset($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : 'default_userp.png';

// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['user_id'];
    $place_name = $_POST['place_name'];
    $reservation_date = $_POST['reservation_date'];
    $reserved_chairs = $_POST['reserved_chairs'];
    $reserved_hours = $_POST['reserved_hours'];

    $stmt = $conn->prepare("INSERT INTO library_places (student_id, place_name, reservation_date, reserved_chairs, reserved_hours) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issii", $student_id, $place_name, $reservation_date, $reserved_chairs, $reserved_hours);

    if ($stmt->execute()) {
        echo "Reservation successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YUPI Library Reservation</title>
    <style>
        /* Add your CSS styling here */
        /* ... Existing styles ... */
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quiapo&family=Canva+Sans&display=swap');
        @font-face {
            font-family: 'Quiapo';
            src: url('fonts/Quiapo-Regular.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Canva Sans';
            src: url('fonts/CanvaSans-Regular.ttf') format('truetype');
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #fbc130;
            background-image: url('YUPi_userprofile.png');
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            text-align: center;
            overflow-x: hidden;
            overflow-y: auto;
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
            border: 2px solid rgb(91, 88, 88);
            border-radius: 50%;
            margin-right: 30px;
            cursor: pointer;
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
            margin-top: 150px;
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
            position: fixed;
            top: 150px; /* Adjust as needed */
            left: 20px; /* Adjust as needed */
            z-index: 100; /* Ensure it stays on top */ ;
        }

        .profile-photo {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            margin-right: 20px;
            margin-left: 35px;
            margin-top: -40px;
            border: 5px solid white;
        }

        .text-info {
            margin-top: 20px;
            margin-left: 30px;
            color: black;
            text-align: left;
            font-family: 'Fredoka One', sans-serif;
        }

        .text-info .name {
            font-size: 24px;
            margin: 0;
        }

        .text-info .student-number {
            font-size: 18px;
            margin: 5px 0 0;
        }

        .buttons-section {
            margin-top: -22px;
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
            width: 100%;
            padding-left: 25%;
            padding-top: 10px;
        }

        .button-container {
            margin-top: -22px;
        }

        .buttons-section button {
            background-color: #96c1b1;
            color: white;
            border: none;
            padding: 15px 100px;
            margin: 40px;
            margin-top: -22px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 4px #0e392b;
            font-family: 'Canva Sans', sans-serif;
            text-align: center;
        }

        .buttons-section button:hover {
            background-color: #7a0422;
            transform: translateY(-2px);
            box-shadow: 0 6px #495954;
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

        .library-cover {
            height: 300px;
            width: 100%;
            margin-top: 80px;
            position: relative;
        }

        .library-cover h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-family: 'Quiapo', sans-serif;
            font-size: 100px;
            z-index: 1;
            text-align: center;
        }

        .library-places {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 0;
            margin-left: 120px;
            padding: 10px;
        }

        .library-places button {
            margin-left: 200px;
            display: inline-flex;
            height: 60px;
            width: 220px;
            padding: 20px;
            padding-left: 30px;
            margin: 10px;
            background-color: #D1D1D1;
            color: rgb(20, 19, 19);
            border: none;
            outline: none;
            border-radius: 7px;
            cursor: pointer;
            text-align: center;
            font-family: 'Canva Sans', sans-serif;
            font-size: 16px;
            position: relative;
            box-shadow: inset -5px -5px 10px rgb(88, 84, 84),
            inset 5px 5px 10px rgba(120, 110, 110, 0.485);
        }

        .library-places button:hover {
            background-color: #202423;
        }

        .library-places .available-seats {
            display: block;
            font-size: 14px;
            color: #fff;
        }

        .reservation-form {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        .reservation-form select {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
            font-family: 'Fredoka One', sans-serif;
        }

        .reservation-form button {
            display: flex;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007b70;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
        }

        .reservation-form button:hover {
            background-color: #005f50;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding-top: 20px;
        }

        .button-row {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .dropdown {
            margin-left: 10px;
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            color: black;
            min-width: 160px;
            width: 100%;
            height: 100%;
            max-height: 400px;
            overflow-y: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 20px 16px;
            text-align: center;
            border-radius: 5px;
            margin-left: 0;
        }

        .dropdown-content button {
            display: inline-block;
            width: 48%;
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            background-color: #9aa6a5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
        }

        .dropdown-content button:hover {
            background-color: #005f50;
        }

        .dropdown-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .dropdown-buttons button {
            flex: 1;
            margin: 0 5px;
            padding: 10px;
            font-size: 16px;
            background-color: #521104;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Fredoka One', sans-serif;
        }

        .dropdown-buttons button:hover {
            background-color: #0b0e0d;
        }

        .dropdown-content::-webkit-scrollbar {
            width: 10px;
            overflow-y: auto;
        }

        .dropdown-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .dropdown-content::-webkit-scrollbar-thumb {
            background: #888;
        }

        .dropdown-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .container {
            display: block;
            align-items: center;
            position: relative;
            padding-left: 10px 0;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 18px;
            user-select: none;
        }

        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .container label {
            padding-left: 40px;
            display: flex;
            align-items: center;
            position: relative;
            width: 100%;
            box-sizing: border-box;
        }

        .checkmark {
            margin-right: 15px;
            position: absolute;
            left: 10px;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 50%;
        }

        .container:hover input ~ .checkmark {
            background-color: #bb5151;
        }

        .container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .container input:checked ~ .checkmark:after {
            display: block;
        }

        .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .dropdown-divider {
            height: 1px;
            margin: 0.5rem 0;
            overflow: hidden;
            background-color: #e9ecef;
        }

        .hover-text {
            width: 100%;
            height: 100%;
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(5, 5, 5, 0.7);
            color: white;
            border-radius: 5px;
            text-align: center;
            z-index: 2;
        }

        .button-container .button-row button:hover .hover-text {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .occupied {
            color: red;
        }

        .available {
            color: green;
        }

        .dropdown-content label span {
            display: flex;
            align-items: center;
        }

        .footer {
            background-color: rgb(18, 17, 17);
            color: white;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        /* Style for the pop-up form */
        .popup-form {
            display: none; 
            position: absolute; 
            left: 50%; 
            top: 50%; 
            transform: translate(-50%, -50%); 
            padding: 20px; 
            background: #fff; 
            border-radius: 10px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3); 
            z-index: 1000; 
            width: 300px;
        }

        .popup-form h3 {
            margin: 0 0 15px;
            color: #333;
        }

        .popup-form label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        .popup-form input, .popup-form select, .popup-form button {
            width: 100%; 
            padding: 10px; 
            margin: 5px 0 10px; 
            border-radius: 5px;
        }

        .popup-form button {
            background-color: #007b70;
            color: white;
            border: none;
            cursor: pointer;
        }

        .popup-form button:hover {
            background-color: #005f50;
        }

        .overlay {
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.5); 
            z-index: 999; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navigation-bar">
            <div class="logo">
                <img src="yupilogo.png" alt="YUPI Logo">
                <span class="logo-text">YUPI</span>
            </div>
            <nav>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex;">
                    <li class="about-us"><a href="#" id="about-us-link">ABOUT US</a></li>
                    <li><img src="default_userp.png" alt="User Photo" class="user-photo" id="user-photo"></li>
                </ul>
            </nav>
        </div>
        <div class="library-cover">
            <h1>Library Spaces</h1>
        </div>
        <div class="user-info" style="display: flex; align-items: center; justify-content: left; padding-left: 20px;">
            <div class="clearfix">
                <div class="profile-section">
                    <div class="profile-info-container" style="display: flex; align-items: center; justify-content: left; padding-left: 20px;">
                        <img src="default_userp.png" alt="User Photo" class="profile-photo">
                        <div class="profile-info">
                            <h2>First Last</h2>
                            <p>Student Number</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="library-places">
            <div class="button-container">
                <div class="button-row">
                    <div class="dropdown">
                        <button id="show-reading-form">Reading Area
                            <div class="hover-text" id="reading-area-hover">40 chairs available</div>
                        </button>
                    </div>
                    <div class="dropdown">
                        <button id="show-comlab-form">Computer Laboratory
                            <div class="hover-text" id="comlab-hover">15 computers available</div>
                        </button>
                    </div>
                    <div class="dropdown">
                        <button id="show-mini-museum-form">Mini Museum
                            <div class="hover-text">14 chairs available</div>
                        </button>
                    </div>
                    <div class="dropdown">
                        <button id="show-cafe-libro-form">Cafe Libro
                            <div class="hover-text">12 chairs available</div>
                        </button>
                    </div>
                </div>
                <div class="button-row">
                    <div class="dropdown">
                        <button onclick="showDropdown('customer-service-dropdown')">Customer Service
                            <div class="hover-text">OPEN</div>
                        </button>
                        <div class="dropdown-content" id="customer-service-dropdown"></div>
                    </div>
                    <div class="dropdown">
                        <button onclick="showDropdown('lemito-dropdown')">Lemito
                            <div class="hover-text">30 seats available</div>
                        </button>
                        <div class="dropdown-content" id="lemito-dropdown"></div>
                    </div>
                    <div class="dropdown">
                        <button onclick="showDropdown('books-area-dropdown')">Books Area
                            <div class="hover-text">OPEN</div>
                        </button>
                        <div class="dropdown-content" id="books-area-dropdown"></div>
                    </div>
                    <button id="save-button" style="background-color: #007b70;">SAVE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <!-- Reading Area Reservation Form -->
    <div class="popup-form" id="reading-form">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Reading Area Reservation</h2>
            <form id="reading-area-form">
                <label for="reserved_by">Student ID:</label>
                <input type="text" id="reserved_by_reading" name="reserved_by" required>
                
                <label for="reservation_time">Reservation Time:</label>
                <input type="datetime-local" id="reservation_time_reading" name="reservation_time" required>
                
                <label for="table_number">Table Number:</label>
                <select id="table_number_reading" name="table_number" required></select>
    
                <label for="chairs">Number of Chairs:</label>
                <input type="number" id="chairs_reading" name="chairs" min="1" max="15" required>
                
                <label for="hours">Hours:</label>
                <input type="number" id="hours_reading" name="hours" min="1" max="12" required>
                
                <button type="button" onclick="addTemporaryReservation('reading-area-form', 'Reading Area')">Reserve</button>
                <button type="button" onclick="cancelReservation()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Computer Laboratory Reservation Form -->
    <div class="popup-form" id="comlab-form">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Computer Laboratory Reservation</h2>
            <form id="comlab-reservation-form">
                <label for="reserved_by_comlab">Student ID:</label>
                <input type="text" id="reserved_by_comlab" name="reserved_by" required>
                
                <label for="reservation_time_comlab">Reservation Time:</label>
                <input type="datetime-local" id="reservation_time_comlab" name="reservation_time" required>
                
                <label for="computer_number">Computer Number:</label>
                <select id="computer_number" name="computer_number" required></select>
                
                <label for="hours_comlab">Hours:</label>
                <input type="number" id="hours_comlab" name="hours" min="1" max="12" required>
                
                <button type="button" onclick="addTemporaryReservation('comlab-reservation-form', 'Computer Laboratory')">Reserve</button>
                <button type="button" onclick="cancelReservation()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Mini Museum Reservation Form -->
    <div class="popup-form" id="mini-museum-form">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Mini Museum Reservation</h2>
            <form id="mini-museum-reservation-form">
                <label for="reserved_by_museum">Student ID:</label>
                <input type="text" id="reserved_by_museum" name="reserved_by" required>
                
                <label for="reservation_time_museum">Reservation Time:</label>
                <input type="datetime-local" id="reservation_time_museum" name="reservation_time" required>
                
                <label for="table_number_museum">Table Number:</label>
                <select id="table_number_museum" name="table_number" required></select>
                
                <label for="chairs_museum">Number of Chairs:</label>
                <input type="number" id="chairs_museum" name="chairs" min="1" max="1" required>
                
                <label for="hours_museum">Hours:</label>
                <input type="number" id="hours_museum" name="hours" min="1" max="12" required>
                
                <button type="button" onclick="addTemporaryReservation('mini-museum-reservation-form', 'Mini Museum')">Reserve</button>
                <button type="button" onclick="cancelReservation()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Cafe Libro Reservation Form -->
    <div class="popup-form" id="cafe-libro-form">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Cafe Libro Reservation</h2>
            <form id="cafe-libro-reservation-form">
                <label for="reserved_by_cafe">Student ID:</label>
                <input type="text" id="reserved_by_cafe" name="reserved_by" required>
                
                <label for="reservation_time_cafe">Reservation Time:</label>
                <input type="datetime-local" id="reservation_time_cafe" name="reservation_time" required>
                
                <label for="table_number_cafe">Table Number:</label>
                <select id="table_number_cafe" name="table_number" required></select>
                
                <label for="chairs_cafe">Number of Chairs:</label>
                <input type="number" id="chairs_cafe" name="chairs" min="1" max="1" required>
                
                <label for="hours_cafe">Hours:</label>
                <input type="number" id="hours_cafe" name="hours" min="1" max="12" required>
                
                <button type="button" onclick="addTemporaryReservation('cafe-libro-reservation-form', 'Cafe Libro')">Reserve</button>
                <button type="button" onclick="cancelReservation()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        let temporaryReservations = [];

        document.getElementById("show-reading-form").addEventListener("click", function() {
            showPopupForm("reading-form", 'table_number_reading', 10);
        });

        document.getElementById("show-comlab-form").addEventListener("click", function() {
            showPopupForm("comlab-form", 'computer_number', 15);
        });

        document.getElementById("show-mini-museum-form").addEventListener("click", function() {
            showPopupForm("mini-museum-form", 'table_number_museum', 2);
        });

        document.getElementById("show-cafe-libro-form").addEventListener("click", function() {
            showPopupForm("cafe-libro-form", 'table_number_cafe', 3);
        });

        function showPopupForm(formId, selectId, count) {
            document.getElementById(formId).style.display = "block";
            document.getElementById("overlay").style.display = "block";
            populateNumbers(selectId, count);
        }

        document.querySelectorAll(".close-btn").forEach(button => {
            button.addEventListener("click", closePopupForms);
        });

        function closePopupForms() {
            document.querySelectorAll(".popup-form").forEach(form => form.style.display = "none");
            document.getElementById("overlay").style.display = "none";
        }

        function cancelReservation() {
            closePopupForms();
        }

        function addTemporaryReservation(formId, area) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const reservation = {
                area: area,
                reserved_by: formData.get("reserved_by"),
                reservation_time: formData.get("reservation_time"),
                table_number: formData.get("table_number"),
                chairs: formData.get("chairs"),
                hours: formData.get("hours")
            };
            temporaryReservations.push(reservation);
            alert(`Temporary reservation for ${area} added.`);
            closePopupForms();
        }

        document.getElementById("save-button").addEventListener("click", function() {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "reserve_seat.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("Reservations saved successfully!");
                    temporaryReservations = []; // Clear temporary reservations after saving
                } else {
                    alert("Error saving reservations: " + xhr.responseText);
                }
            };
            xhr.send(JSON.stringify(temporaryReservations));
        });

        function populateNumbers(elementId, count) {
            let numberSelect = document.getElementById(elementId);
            numberSelect.innerHTML = ''; // Clear previous options
            for (let i = 1; i <= count; i++) {
                let option = document.createElement('option');
                option.value = i;
                option.text = `Table ${i}`;
                numberSelect.add(option);
            }
        }

        function showDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const isVisible = dropdown.style.display === 'block';
            document.querySelectorAll('.dropdown-content').forEach(dd => dd.style.display = 'none'); // Hide all dropdowns
            if (!isVisible) {
                document.body.style.overflow = 'hidden'; // Prevent body from scrolling
                populateDropdown(dropdownId);
                dropdown.style.display = 'block'; // Show the selected dropdown
            } else {
                document.body.style.overflow = ''; // Restore body scrolling
            }
        }

        function populateDropdown(dropdownId) {
            let content = '';
            switch (dropdownId) {
                case 'lemito-dropdown':
                    content = getLemitoContent();
                    break;
                case 'books-area-dropdown':
                    content = getBooksAreaContent();
                    break;
                case 'customer-service-dropdown':
                    content = getCustomerServiceContent();
                    break;
            }
            document.getElementById(dropdownId).innerHTML = content + getDropdownButtons(dropdownId);
        }

        function getDropdownButtons(dropdownId) {
            return `
                <div class="dropdown-buttons">
                    <button onclick="reserveSeat('${dropdownId}')">Reserve</button>
                    <button onclick="cancelSelection('${dropdownId}')">Cancel</button>
                </div>
            `;
        }

        function getLemitoContent() {
            return `
                <label class="container">Attend <input type="radio" name="option" value="Attend"><span class="checkmark"></span></label><div class="dropdown-divider"></div>
                <label class="container">Reserve <input type="radio" name="option" value="Reserve"><span class="checkmark"></span></label>
            `;
        }

        function getBooksAreaContent() {
            return `
                <label class="container">Visit <input type="radio" name="option" value="Visit"><span class="checkmark"></span></label><div class="dropdown-divider"></div>
                <label class="container">Borrow Books <input type="radio" name="option" value="Borrow Books"><span class="checkmark"></span></label>
            `;
        }

        function getCustomerServiceContent() {
            return `
                <label class="container">Visit <input type="radio" name="option" value="Visit"><span class="checkmark"></span></label>
            `;
        }

        function reserveSeat(dropdownId) {
            const selectedOption = document.querySelector(`#${dropdownId} input[name="option"]:checked`);
            if (selectedOption) {
                const value = selectedOption.value;
                if (dropdownId === 'lemito-dropdown') {
                    if (value === 'Reserve') {
                        saveFormState();
                        window.location.href = 'lemito_reservation.html';
                    } else if (value === 'Attend') {
                        // Update available seats dynamically
                        availableChairs['lemito'] -= 1;
                        updateHoverText();
                        alert('Seat reserved for attending Lemito.');
                    }
                } else if (dropdownId === 'books-area-dropdown' && value === 'Borrow Books') {
                    saveFormState();
                    window.location.href = 'borrow_book.html';
                } else {
                    alert('No action for the selected option.');
                }
            } else {
                alert('Please select an option.');
            }
        }

        function cancelSelection(dropdownId) {
            document.querySelectorAll(`#${dropdownId} input[name="option"]:checked`).forEach(input => {
                input.checked = false;
            });
            alert(`Selection cancelled for ${dropdownId}.`);
        }

        window.addEventListener('click', function(event) {
            if (!event.target.matches('.dropdown-content') && !event.target.matches('.dropdown *')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
                document.body.style.overflow = ''; // Restore body scrolling
            }
        });

        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
            dropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });

        document.querySelectorAll('.dropdown-content input[type="radio"]').forEach(radio => {
            radio.addEventListener('dblclick', function() {
                radio.checked = false;
            });
        });
    </script>
</body>
</html>