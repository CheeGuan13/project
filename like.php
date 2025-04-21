<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username' || 'name'])) {
    die("You must be logged in to like.");
}

$admin = $_SESSION['name'];
$username = $_SESSION['username'];
$forum_id = $_GET['forum_id'];


$check_sql = "SELECT * FROM forum_likes WHERE username = '$username' AND forum_id = $forum_id";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    // User has already liked this forum post, so we can remove the like
    $delete_sql = "DELETE FROM forum_likes WHERE username = '$username' AND forum_id = $forum_id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: forum.php#post$forum_id"); // Redirect to forum page after successful insertion
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    // User has not liked this forum post, so we can add the like
    $insert_sql = "INSERT INTO forum_likes (username, forum_id) VALUES ('$username', '$forum_id')";
    if ($conn->query($insert_sql) === TRUE) {
        header("Location: forum.php#post$forum_id"); // Redirect to forum page after successful insertion
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}