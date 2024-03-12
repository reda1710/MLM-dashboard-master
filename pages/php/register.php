<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$pass = ""; // never change this line
$dbname = "mlm";

// Start a session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  echo json_encode(array("success" => true, "message" => "you are already logged in", "redirect" => "../pages/tables.html"));
  exit;
}

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get form data
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $Position = $_POST["Position"];
  $email = $_POST["email"];
  $password = trim($_POST["password"]);
  // Perform server-side validation (you can add more validation as needed)
  if (empty($firstname) || empty($lastname) || empty($Position) || empty($email) || empty($password)) {
    $response = [
        "success" => false,
        "message" => "Please fill in all fields.",
    ];
    echo json_encode($response);
    exit;
  }

  // Hash the password (you should use a secure hashing method)
  $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

  // Save the user data to your database (replace with your database connection code)
  // Example using MySQLi
  $conn = new mysqli($servername, $username, $pass, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare SQL query for insertion
  $sql = "INSERT INTO employees (First_name, Last_name, Position, Email, Password) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  // Bind parameters to the prepared statement
  $stmt->bind_param("sssss", $firstname, $lastname, $Position, $email, $hashedPassword);

  // Execute the SQL query
  if ($stmt->execute()) {
    $response = [
        "success" => true,
        "message" => "Registration successful.",
        "redirect" => "../pages/sign-in.html",
    ];
  } else {
    $response = [
        "success" => false,
        "message" => "Error: " . $conn->error,
    ];
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();

  // Send a JSON response to the client
  echo json_encode($response);
} else {
  // Handle invalid request method
  $response = [
      "success" => false,
      "message" => "Invalid request method.",
  ];
  echo json_encode($response);
}
?>
