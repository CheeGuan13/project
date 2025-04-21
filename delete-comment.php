<?php
require 'config.php'; // Include database connection file

$id = $_GET['forum_id'];
$comment_id = $_GET['comment_id'];
$sql = "DELETE FROM comments WHERE comment_id = '$comment_id'"; // SQL query to delete the user

if ($conn->query($sql) === TRUE) {
    header("Location: comment.php?forum_id=$id"); // Redirect to index page after successful update
} else {
    echo "Error: " . $conn->error;
}
?>