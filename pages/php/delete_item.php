<?php
header('Content-Type: application/json');

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
$stmt = $conn->prepare("DELETE FROM items WHERE Item_id = ?");
$stmt->bind_param("i", $Item_id); // "i" indicates integer type

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
