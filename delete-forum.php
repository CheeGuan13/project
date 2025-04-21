<?php
require 'config.php'; // Include database connection file

$id = $_GET['forum_id']; // Get the user ID from the URL
$sql = "DELETE FROM forum WHERE forum_id = '$id'"; // SQL query to delete the user

if ($conn->query($sql) === TRUE) {
    header("Location: forum.php"); // Redirect to index page after successful update
} else {
    echo "Error: " . $conn->error;
}
?>