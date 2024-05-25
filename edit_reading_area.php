<?php
// Include database connection
include 'db_connection.php';

$reservation_ids = isset($_POST['reservation_id']) ? $_POST['reservation_id'] : [];

// Fetch the reservation details based on reservation_id
$reservations = [];
if (!empty($reservation_ids)) {
    $ids_to_edit = implode(",", $reservation_ids);
    $sql = "SELECT * FROM reading_area WHERE reservation_id IN ($ids_to_edit)";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

// Check if the form is submitted for updating the reservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    foreach ($_POST['reservation_id'] as $key => $reservation_id) {
        $reserved_by = $_POST['reserved_by'][$key];
        $table_number = $_POST['table_number'][$key];
        $reservation_time = $_POST['reservation_time'][$key];
        $max_duration = $_POST['max_duration'][$key];

        // Update the reservation details in the database
        $sql = "UPDATE reading_area 
                SET reserved_by = '$reserved_by', table_number = '$table_number', 
                    reservation_time = '$reservation_time', max_duration = '$max_duration'
                WHERE reservation_id = '$reservation_id'";

        $conn->query($sql);
    }

    // Redirect to reading_area.php after successful update
    header("Location: reading_area.php");
    exit();
}

// Close connection
$conn->close();
?>

<!-- HTML form for editing the reservations -->
<h2>Edit Reading Area Reservations</h2>
<form action="edit_reading_area.php" method="post">
    <?php foreach ($reservations as $reservation): ?>
        <input type="hidden" name="reservation_id[]" value="<?php echo $reservation['reservation_id']; ?>">
        <label for="reserved_by">Reserved By (Student Number):</label>
        <input type="text" id="reserved_by" name="reserved_by[]" value="<?php echo $reservation['reserved_by']; ?>" required><br><br>
        <label for="table_number">Table Number:</label>
        <input type="number" id="table_number" name="table_number[]" value="<?php echo $reservation['table_number']; ?>" min="1" max="20" required><br><br>
        <label for="reservation_time">Reservation Time:</label>
        <input type="datetime-local" id="reservation_time" name="reservation_time[]" value="<?php echo date('Y-m-d\TH:i', strtotime($reservation['reservation_time'])); ?>" required><br><br>
        <label for="max_duration">Max Duration (in hours):</label>
        <input type="number" id="max_duration" name="max_duration[]" value="<?php echo $reservation['max_duration']; ?>" required><br><br>
        <hr>
    <?php endforeach; ?>
    <input type="submit" name="update" value="Update Reservations">
</form>

<button onclick="location.href='reading_area.php'">Back to Reading Area Reservations</button>
