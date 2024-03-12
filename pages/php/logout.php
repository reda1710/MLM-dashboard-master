<?php
include 'session.php';

// Destroy the session to log the user out
session_destroy();
echo json_encode(array("success" => true, "message" => "logout successful"));

exit;
?>
