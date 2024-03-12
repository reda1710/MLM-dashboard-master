<?php
include 'session.php';

// Use this to retrieve user-specific data.
$user_id = getSession('user_id');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mlm";

// Check if a notification ID is provided via POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["notification_id"])) {
    // Get the notification ID from the POST data
    $notificationId = $_POST["notification_id"];

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the database to set is_read to 1 for the specified notification ID
    $sql = "UPDATE user_notifications SET is_read = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notificationId);

    if ($stmt->execute()) {
        echo "Success"; // You can send any response you want
    } else {
        echo "Error"; // You can send an error response
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
