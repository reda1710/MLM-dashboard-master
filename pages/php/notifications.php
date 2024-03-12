<?php
include 'session.php';

// Use this to retrieve user-specific data.
$user_id = getSession('user_id');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mlm";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute a query to fetch unread notifications for the user
$sql = "SELECT id, message, created_at, alertType FROM user_notifications WHERE user_id = ? AND is_read = 0";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Create an array to store the unread notifications
$notifications = array();

// Fetch the notifications and store them in the array
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();

// Send the unread notifications as JSON to the front-end
header('Content-Type: application/json');
echo json_encode($notifications);
?>
