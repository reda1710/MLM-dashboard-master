<?php
header('Content-Type: application/json');
include 'session.php';

$user_id = getSession('user_id');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mlm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

// Get the Item_id from the POST request
$Item_id = $_POST['Item_id'];

// Prepare the SQL statement for deletion
$stmt_get_item_info = $conn->prepare("SELECT Item_Type, Item_Description FROM items WHERE Item_id = ?");
$stmt_get_item_info->bind_param("i", $Item_id);
$stmt_get_item_info->execute();
$stmt_get_item_info->bind_result($item_type, $item_description);
$stmt_get_item_info->fetch();
$stmt_get_item_info->close();

// Get the user's First_name and Last_name who created the item
$stmt_get_user_info = $conn->prepare("SELECT First_name, Last_name FROM employees WHERE Id = ?");
$stmt_get_user_info->bind_param("i", $user_id);
$stmt_get_user_info->execute();
$stmt_get_user_info->bind_result($creator_first_name, $creator_last_name);
$stmt_get_user_info->fetch();
$stmt_get_user_info->close();

// Prepare the SQL statement for deletion
$stmt_delete_item = $conn->prepare("DELETE FROM items WHERE Item_id = ?");
$stmt_delete_item->bind_param("i", $Item_id); // "i" indicates integer type

// Execute the statement and check for success
if ($stmt_delete_item->execute()) {
    echo json_encode(['success' => true]);

    // Prepare and execute user notification insertion
    $user_notification_message = $creator_first_name . " " . $creator_last_name . " deleted the item: \"" . $item_description . "\" within the category \"" . $item_type . "\"";
    $sql_insert_notification = "INSERT INTO user_notifications (user_id, message, created_at, is_read, alertType) VALUES (?, ?, CURRENT_TIMESTAMP, 0, 'danger')";
    $stmt_insert_notification = $conn->prepare($sql_insert_notification);

    // Retrieve all user IDs
    $sql_get_user_ids = "SELECT Id FROM employees";
    $result_user_ids = $conn->query($sql_get_user_ids);

    // Bind parameters for notification insertion and execute for each user
    $stmt_insert_notification->bind_param("is", $user_id_to_notify, $user_notification_message);
    while ($row = $result_user_ids->fetch_assoc()) {
        $user_id_to_notify = $row['Id'];
        $stmt_insert_notification->execute();
    }

    $stmt_insert_notification->close();
} else {
    echo json_encode(['success' => false, 'message' => $stmt_delete_item->error]);
}

// Close the statement and connection
$stmt_delete_item->close();
$conn->close();
?>
