<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// delete user from the database
$sql = "DELETE FROM users WHERE username = '$username'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['success'] = "Your account has been deleted successfully.";
    unset($_SESSION['username']);
    header("Location: index.php");
    exit();
} else {
    $_SESSION['error'] = "Failed to delete account.";
    header("Location: user-profile.php");
    exit();
}
?>
