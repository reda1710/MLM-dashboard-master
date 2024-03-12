<?php
include 'session.php';
$user_id = getSession('user_id');
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mlm";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

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
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
