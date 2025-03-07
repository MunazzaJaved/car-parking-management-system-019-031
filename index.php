<?php
// Start the session
session_start();

// Redirect to home.php
header("Location: ./view/guest/home.php");
exit;
