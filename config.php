<?php
    $host = "localhost";
    $user = "root"; // Default user in AMPPS
    $password = "mysql"; // Default password in AMPPS
    $database = "library"; // Database name
    // Create connection
    $conn = new mysqli($host, $user, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   
?>
