<?php
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

// SQL query to retrieve user data based on user_id
$sql = "SELECT * FROM employees WHERE ID = $user_id";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user data
    $row = $result->fetch_assoc();

    // Now you can access the user's data
    $user_id = $row['Id'];
    $firstname = $row['First_name'];
    $lastname = $row['Last_name'];
    $email = $row['Email'];
    $Position = $row['Position'];

    // You can use this data as needed, for example, to send it to the client-side JavaScript.
    $user_data = [
        'user_id' => $user_id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'Position' => $Position
    ];

    // Close the database connection
    $conn->close();

    // Return the user data as a JSON response
    header('Content-Type: application/json');
    echo json_encode($user_data);
} else {
    // User not found
    $conn->close();
    echo json_encode(['error' => 'User not found']);
}
?>
