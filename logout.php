<?php
session_start();

// destroy the session
session_unset();  // clear all session variables
session_destroy();  // destroy the session

// redirect to the index page
header("Location: index.php");
exit();
?>
