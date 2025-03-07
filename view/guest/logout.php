<?php
session_start(); // Start the session to access session variables

session_unset(); // Unset all session variables
session_destroy(); // Destroy the session completely

header("Location: login.php"); // Redirect user to the login page after logout
exit; // Ensure no further script execution after redirection
