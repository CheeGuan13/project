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
$stmt = $conn->prepare("SELECT username, email, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username); // Bind current username
$stmt->execute(); // Execute query
$stmt->bind_result($current_username, $current_email, $current_password); // Bind results
$stmt->fetch(); // Fetch result
$stmt->close(); // Close statement

$error_message = ''; // Initialize error message

if ($field === 'username') { // If updating username
    if (strlen($new_value) < 5 || strlen($new_value) > 15) { // Check username length
        $error_message = "Username must be between 5 and 15 characters."; // Set error
    } elseif ($new_value === $current_username) { // Check if it's the same as current
        $error_message = "New username cannot be the same as the current one."; // Set error
    }
} elseif ($field === 'email') { // If updating email
    if (!filter_var($new_value, FILTER_VALIDATE_EMAIL)) { // Validate email format
        $error_message = "Invalid email format."; // Set error
    } elseif ($new_value === $current_email) { // Check if it's the same as current
        $error_message = "New email cannot be the same as the current one."; // Set error
    }
} elseif ($field === 'password') { // If updating password
    if (strlen($new_value) < 8 || strlen($new_value) > 20) { // Check password length
        $error_message = "Password must be between 8 and 20 characters."; // Set error
    } elseif (password_verify($new_value, $current_password)) { // Check if same as current password
        $error_message = "New password cannot be the same as the current one."; // Set error
    } else {
        $new_value = password_hash($new_value, PASSWORD_DEFAULT); // Hash the new password
    }
}

if ($error_message) { // If there's an error
    $_SESSION['error'] = $error_message; // Set error message
    header("Location: user-profile.php"); // Redirect back
    exit(); // Stop execution
}

// Update the field in the database
$sql = "UPDATE users SET $field = ? WHERE username = ?";
$stmt = $conn->prepare($sql); // Prepare update statement
$stmt->bind_param("ss", $new_value, $username); // Bind parameters

if ($stmt->execute()) { // If update successful
    if ($field === 'username') { // If username was updated
        $_SESSION['username'] = $new_value; // Update session username
    }
    $_SESSION['success'] = ucfirst($field) . " updated successfully!"; // Set success message
} else {
    $_SESSION['error'] = "Update failed."; // Set failure message
}

$stmt->close(); // Close statement
$conn->close(); // Close DB connection

header("Location: user-profile.php"); // Redirect back to profile
exit(); // Stop execution
?>
