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

// Initialize an array to store the retrieved data
$items = [];

// Check if the category parameter is provided in the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Add proper validation/sanitization for the $category variable

// Modify your SQL query to include the category filter if provided
$sql = "SELECT * FROM items";

if (!empty($category)) {
    // Use a prepared statement to prevent SQL injection
    $sql .= " WHERE Item_Type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

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
