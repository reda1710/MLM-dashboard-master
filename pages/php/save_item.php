<?php
include 'session.php';

$user_id = getSession('user_id');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mlm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Updated variable names
$item_type = $_POST['item_type'];
$item_description = $_POST['item_description'];
$origin = $_POST['origin'];
$item_code = $_POST['item_code'];
$uom = $_POST['uom'];
$quantity = $_POST['quantity'];
$item_received = $_POST['item_received'];
$date_of_delivery = $_POST['date_of_delivery'];

// Prepare and execute item insertion
$sql_insert_item = "INSERT INTO items (User_id_created, item_type, item_description, origin, item_code, uom, quantity, item_received, date_of_delivery) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert_item = $conn->prepare($sql_insert_item);
$stmt_insert_item->bind_param("isssssiss", $user_id, $item_type, $item_description, $origin, $item_code, $uom, $quantity, $item_received, $date_of_delivery);

if ($stmt_insert_item->execute()) {
    echo "New item added successfully";

    // Get the inserted item's ID
    $item_id = $stmt_insert_item->insert_id;

    // Get the user's First_name and Last_name
    $sql_get_user_info = "SELECT First_name, Last_name FROM employees WHERE Id = ?";
    $stmt_get_user_info = $conn->prepare($sql_get_user_info);
    $stmt_get_user_info->bind_param("i", $user_id);
    $stmt_get_user_info->execute();
    $stmt_get_user_info->bind_result($first_name, $last_name);
    $stmt_get_user_info->fetch();
    $stmt_get_user_info->close();

    // Prepare and execute user notification insertion
    $user_notification_message = $first_name . " " . $last_name . " added \"" . $item_description . "\" within the category \"" . $item_type . "\"";
    $sql_insert_notification = "INSERT INTO user_notifications (user_id, message, created_at, is_read, alertType) VALUES (?, ?, CURRENT_TIMESTAMP, 0, 'success')";
    $stmt_insert_notification = $conn->prepare($sql_insert_notification);

    // Retrieve all user IDs
    $sql_get_user_ids = "SELECT Id FROM employees";
    $result_user_ids = $conn->query($sql_get_user_ids);

    // Bind parameters for notification insertion and execute for each user
    while ($row = $result_user_ids->fetch_assoc()) {
        $user_id_to_notify = $row['Id'];
        $stmt_insert_notification->bind_param("is", $user_id_to_notify, $user_notification_message);
        $stmt_insert_notification->execute();
    }

    $stmt_insert_notification->close();
} else {
    echo "Error: " . $stmt_insert_item->error;
}

$stmt_insert_item->close();
$conn->close();
?>
