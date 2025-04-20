<?php
session_start(); // Start the session to access session variables
include 'config.php'; // Include the database configuration file

if (!isset($_SESSION['username'])) { // Check if user is not logged in
    header("Location: login.php"); // Redirect to login page
    exit(); // Stop script execution
}

$username = $_SESSION['username']; // Get the username from the session

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) { // Check if a file was uploaded without errors
    $avatar_name = $_FILES['avatar']['name']; // Get the original name of the uploaded file
    $avatar_tmp = $_FILES['avatar']['tmp_name']; // Get the temporary file path
    $avatar_ext = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION)); // Get the file extension in lowercase
    $allowed = ['jpg', 'jpeg', 'png', 'gif']; // Define allowed file extensions

    if (in_array($avatar_ext, $allowed)) { // Check if the file extension is allowed
        
        $new_name = "avatar_" . $username . "_" . time() . "." . $avatar_ext; // Generate a new unique file name
        $upload_path = "uploads/" . $new_name; // Define the upload path

       
        if (!is_dir('uploads')) { // Check if the uploads directory doesn't exist
            mkdir('uploads', 0777, true); // Create the uploads directory with full permissions
        }

        if (move_uploaded_file($avatar_tmp, $upload_path)) { // Move the uploaded file to the upload path
            // update database with new avatar path
            $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE username = ?"); // Prepare the SQL statement
            $stmt->bind_param("ss", $upload_path, $username); // Bind the parameters to the SQL query
            $stmt->execute(); // Execute the SQL statement
            $stmt->close(); // Close the statement

            header("Location: user-profile.php?success=avatar"); // Redirect to profile page with success message
            exit(); // Stop script execution
        } else {
            header("Location: user-profile.php?error=uploadfail"); // Redirect to profile page with upload failure error
            exit(); // Stop script execution
        }
    } else {
        header("Location: user-profile.php?error=invalidfile"); // Redirect to profile page with invalid file error
        exit(); // Stop script execution
    }
} else {
    header("Location: user-profile.php?error=nofile"); // Redirect to profile page with no file uploaded error
    exit(); // Stop script execution
}
?>
