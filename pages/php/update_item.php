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

// Fetch POST data
$Item_id = $_POST['Item_id'];
$Item_Type = $_POST['Item_Type'];
$Item_Description = $_POST['Item_Description'];
$Origin = $_POST['Origin'];
$Item_Code = $_POST['Item_Code'];
$Uom = $_POST['Uom'];
$Quantity = $_POST['Quantity'];
$Item_Received = $_POST['Item_Received'];
$Date_Of_Delivery = $_POST['Date_Of_Delivery'];
$Expiry_Date = $_POST['Expiry_Date'];

// Prepare an UPDATE statement
$stmt = $conn->prepare("UPDATE items SET User_id_updated=?, Item_Type=?, Item_Description=?, Origin=?, Item_Code=?, Uom=?, Quantity=?, Item_Received=?, Date_Of_Delivery=?, Expiry_Date=? WHERE Item_id=?");
$stmt->bind_param("isssssisssi", $user_id, $Item_Type, $Item_Description, $Origin, $Item_Code, $Uom, $Quantity, $Item_Received, $Date_Of_Delivery, $Expiry_Date, $Item_id);

// Execute and check for errors
if ($stmt->execute()) {
    echo "Record updated successfully";

    // Get the updated item's information
    $sql_get_updated_item_info = "SELECT Item_Type, Item_Description FROM items WHERE Item_id = ?";
    $stmt_get_updated_item_info = $conn->prepare($sql_get_updated_item_info);
    $stmt_get_updated_item_info->bind_param("i", $Item_id);
    $stmt_get_updated_item_info->execute();
    $stmt_get_updated_item_info->bind_result($updated_item_type, $updated_item_description);
    $stmt_get_updated_item_info->fetch();
    $stmt_get_updated_item_info->close();

    // Get the user's First_name and Last_name who created the item
    $sql_get_user_info = "SELECT First_name, Last_name FROM employees WHERE Id = ?";
    $stmt_get_user_info = $conn->prepare($sql_get_user_info);
    $stmt_get_user_info->bind_param("i", $user_id);
    $stmt_get_user_info->execute();
    $stmt_get_user_info->bind_result($creator_first_name, $creator_last_name);
    $stmt_get_user_info->fetch();
    $stmt_get_user_info->close();

    // Prepare and execute user notification insertion
    $user_notification_message = $creator_first_name . " " . $creator_last_name . " updated the item: \"" . $updated_item_description . "\" within the category \"" . $updated_item_type . "\"";
    $sql_insert_notification = "INSERT INTO user_notifications (user_id, message, created_at, is_read, alertType) VALUES (?, ?, CURRENT_TIMESTAMP, 0, 'info')";
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
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
