<?php
include 'db.php';

session_start();
$user_id = $_SESSION['user_id'] ?? 1; // Replace with actual user ID retrieval logic

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $place_id = $_POST['place_id'];
    $seat_number = $_POST['seat_number'];
    $reservation_date = date('Y-m-d');

    // Check available seats
    $check_seat_sql = "SELECT available_seats FROM library_places WHERE id = ?";
    $check_seat_stmt = $conn->prepare($check_seat_sql);
    $check_seat_stmt->bind_param("i", $place_id);
    $check_seat_stmt->execute();
    $check_seat_result = $check_seat_stmt->get_result();
    $place = $check_seat_result->fetch_assoc();
    $available_seats = $place['available_seats'];

    if ($available_seats > 0) {
        // Reserve the seat
        $reserve_sql = "INSERT INTO reservations (user_id, place_id, reservation_date, seat_number) VALUES (?, ?, ?, ?)";
        $reserve_stmt = $conn->prepare($reserve_sql);
        $reserve_stmt->bind_param("iisi", $user_id, $place_id, $reservation_date, $seat_number);

        if ($reserve_stmt->execute()) {
            // Update available seats
            $update_seats_sql = "UPDATE library_places SET available_seats = available_seats - 1 WHERE id = ?";
            $update_seats_stmt = $conn->prepare($update_seats_sql);
            $update_seats_stmt->bind_param("i", $place_id);
            $update_seats_stmt->execute();

            echo json_encode(["success" => true, "message" => "Seat reserved successfully!", "available_seats" => $available_seats - 1]);
        } else {
            echo json_encode(["success" => false, "message" => $reserve_stmt->error]);
        }

        $reserve_stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "No available seats!"]);
    }

    $check_seat_stmt->close();
    $conn->close();
}
?>
