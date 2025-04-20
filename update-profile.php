<?php
session_start(); // Start the session
include 'config.php'; // Include database configuration

if (!isset($_SESSION['username'])) { // Check if user is not logged in
    header("Location: login.php"); // Redirect to login page
    exit(); // Stop script execution
}

$username = $_SESSION['username']; // Get the logged-in username from session
$field = $_POST['field'] ?? ''; // Get the field to be updated from POST request
$new_value = trim($_POST['new_value'] ?? ''); // Get the new value, trim whitespace

if (empty($field) || empty($new_value)) { // Check if field or value is empty
    $_SESSION['error'] = 'Field or value is empty.'; // Set error message
    header("Location: user-profile.php"); // Redirect back to profile
    exit(); // Stop execution
}

$allowed_fields = ['username', 'email', 'password']; // Allowed fields for update
if (!in_array($field, $allowed_fields)) { // Validate the field
    $_SESSION['error'] = 'Invalid field.'; // Set error message
    header("Location: user-profile.php"); // Redirect back
    exit(); // Stop execution
}

// Get current user data from database
$sql = "SELECT username, email, password FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $current_username = $row['username'];
    $current_email = $row['email'];
    $current_password = $row['password'];
} else {
    $_SESSION['error'] = "User not found.";
    header("Location: user-profile.php");
    exit();
}

$error_message = ''; // Initialize error message

if ($field === 'username') { // If updating username
    if (strlen($new_value) < 5 || strlen($new_value) > 15) {
        $error_message = "Username must be between 5 and 15 characters.";
    } elseif ($new_value === $current_username) {
        $error_message = "New username cannot be the same as the current one.";
    }
} elseif ($field === 'email') { // If updating email
    if (!filter_var($new_value, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($new_value === $current_email) {
        $error_message = "New email cannot be the same as the current one.";
    }
} elseif ($field === 'password') { // If updating password
    if (strlen($new_value) < 8 || strlen($new_value) > 20) {
        $error_message = "Password must be between 8 and 20 characters.";
    } elseif (password_verify($new_value, $current_password)) {
        $error_message = "New password cannot be the same as the current one.";
    } else {
        $new_value = password_hash($new_value, PASSWORD_DEFAULT); // Hash the new password
    }
}

if ($error_message) {
    $_SESSION['error'] = $error_message;
    header("Location: user-profile.php");
    exit();
}

// Update the field in the database (direct SQL)
$sql = "UPDATE users SET $field = '$new_value' WHERE username = '$username'";
if ($conn->query($sql)) {
    if ($field === 'username') {
        $_SESSION['username'] = $new_value; // Update session if username changed
    }
    $_SESSION['success'] = ucfirst($field) . " updated successfully!";
} else {
    $_SESSION['error'] = "Update failed.";
}

$conn->close(); // Close connection
header("Location: user-profile.php");
exit(); // Stop execution
?>
