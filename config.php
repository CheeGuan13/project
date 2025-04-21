<?php
    $host = "localhost";
    $user = "root"; // Default user in AMPPS
    $password = ""; // Default password in AMPPS
    $database = "crud_app"; // Database name
    // Create connection
    $conn = new mysqli($host, $user, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   
?>
