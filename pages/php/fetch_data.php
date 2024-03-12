<?php
include 'session.php';
$user_id = getSession('user_id');

// Check if user_id is null
if ($user_id === null) {
    $user_id = 0;
}

// Your database config
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mlm';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store query results
$response = [
    'user_id' => $user_id,
];

// Check if user_id is not 0 (meaning it's not null)
if ($user_id !== 0) {


} else
{

}

// Close the database connection
$conn->close();

// Return data as a JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
