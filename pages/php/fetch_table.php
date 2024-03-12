<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "mlm";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve data from the Items table
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

// Initialize an array to store the retrieved data
$items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($items);
?>
