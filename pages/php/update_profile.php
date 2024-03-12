<?php
// Include the session management script
include 'session.php';

// Use this to retrieve user-specific data.
$user_id = getSession('user_id');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mlm";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data sent from the client
$data = json_decode(file_get_contents('php://input'), true);

// Assuming that the JSON data structure matches the field names in your database
$firstname = $data['firstname'];
$lastname = $data['lastname'];
$email = $data['email'];
$Position = $data['Position'];

// Use prepared statements to update the user's profile data
$stmt = $conn->prepare("UPDATE employees SET First_name=?, Last_name=?, Email=?, Position=? WHERE Id=?");
if ($stmt === false) {
    die("Error in prepare statement: " . $conn->error);
}

$stmt->bind_param("ssssi", $firstname, $lastname, $email, $Position, $user_id);


if ($stmt->execute()) {
    // Profile data updated successfully
    $response = ['success' => true];
} else {
    // Error updating profile data
    $response = ['success' => false, 'error' => $conn->error];
}

// Close the database connection
$stmt->close();
$conn->close();

// Return a JSON response to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
