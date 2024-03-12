<?php
session_start();

// Function to set a session variable
function setSession($ID, $value) {
    $_SESSION[$ID] = $value;
}

// Function to get a session variable
function getSession($ID) {
    if (isset($_SESSION[$ID])) {
        return $_SESSION[$ID];
    }
    return null;
}

// Function to destroy the session
function destroySession() {
    session_destroy();
}
?>
