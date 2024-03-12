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

$sql = "INSERT INTO items (User_id_created, item_type, item_description, origin, item_code, uom, quantity, item_received, date_of_delivery) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssiss", $user_id, $item_type, $item_description, $origin, $item_code, $uom, $quantity, $item_received, $date_of_delivery);

if ($stmt->execute()) {
    echo "New item added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
