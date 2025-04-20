<?php
session_start(); // Start the session
include 'config.php'; // Include database configuration

// If user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Get the logged-in username from session

// Prepare SQL to delete the user account
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $username); // Bind the username parameter

if ($stmt->execute()) {
    // If deletion is successful, set a success message
    $_SESSION['success'] = "Your account has been deleted successfully.";

    // Remove the username from the session
    unset($_SESSION['username']);

    // Redirect to the homepage
    header("Location: index.php");
    exit();
} else {
    // If deletion fails, set an error message
    $_SESSION['error'] = "Failed to delete account.";

    // Redirect back to the user profile page
    header("Location: user-profile.php");
    exit();
}
?>
