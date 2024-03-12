<?php
include 'session.php';
// Database connection parameters
$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "mlm";

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the client-side
$data = json_decode(file_get_contents('php://input'), true);
$Email = $data['email'];
$Password = $data['password'];

// Check if email and password were provided
if (empty($Email) || empty($Password)) {
    echo json_encode(array("success" => false, "message" => "Please provide both email and password."));
    exit;
}

// Validate user credentials against the database
$sql = "SELECT * FROM employees WHERE Email = ?";
$stmt = $conn->prepare($sql);

// Check for a database query preparation error
if (!$stmt) {
    echo json_encode(array("success" => false, "message" => "Database error: " . $conn->error));
    exit;
}

$stmt->bind_param("s", $Email);
$stmt->execute();

// Check for a database query execution error
if ($stmt->errno) {
    echo json_encode(array("success" => false, "message" => "Database query error: " . $stmt->error));
    exit;
}

$result = $stmt->get_result();

if (!$result) {
    // Handle a failed database query result (if necessary)
    echo json_encode(array("success" => false, "message" => "Database query result error."));
    exit;
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $storedHashedPassword = $row['Password'];

    // Use password_verify to compare the entered password with the stored hashed password
    if (password_verify($Password, $storedHashedPassword)) {
        // Authentication successful
        setSession('user_id', $row['Id']);
        echo json_encode(array("success" => true, "redirect" => "../pages/tables.html"));

    } else {
        // Authentication failed
        echo json_encode(array("success" => false, "message" => "Invalid password."));
    }
} else {
    // Authentication failed (user not found)
    echo json_encode(array("success" => false, "message" => "User not found."));
}

// Close the database connection
$stmt->close();
$conn->close();
?>
