<?php
include 'db.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No user ID provided";
}
?>
