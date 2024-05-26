<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected reservation ID(s)
    $reservation_ids = $_POST['reservation_id'];

    // Check if any reservations are selected
    if (!empty($reservation_ids)) {
        // Loop through each selected reservation ID and delete it
        foreach ($reservation_ids as $reservation_id) {
            $sql = "DELETE FROM reading_area WHERE reservation_id = '$reservation_id'";
            if (!$conn->query($sql)) {
                echo "Error deleting record: " . $conn->error;
                exit();
            }
        }
        echo "Selected reservations deleted successfully.";
    } else {
        echo "No reservations selected for deletion.";
    }

    // Redirect to reading_area.php
    header("Location: reading_area.php");
    exit();
}

// Close connection
$conn->close();
?>
