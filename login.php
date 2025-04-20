<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the form was submitted via POST
    include 'config.php'; // Include the database configuration

    $username = $_POST['username']; // Get username from form input
    $password = $_POST['password']; // Get password from form input

    // Prepare SQL query to fetch user by username
    $stmt = $conn->prepare("SELECT id, password, created_at FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind the username to the query
    $stmt->execute(); // Execute the query
    $stmt->store_result(); // Store result to check if user exists

    if ($stmt->num_rows == 1) { // If user with the given username exists
        $stmt->bind_result($user_id, $hashed_password, $created_at); // Bind the result variables
        $stmt->fetch(); // Fetch the data

        // Verify the input password against the hashed password
        if (password_verify($password, $hashed_password)) {
            session_start(); // Start a new session
            $_SESSION['username'] = $username; // Store username in session
            $_SESSION['created_at'] = $created_at; // Store account creation date
            $_SESSION['user_id'] = $user_id; // Store user ID in session

            // Successful login - redirect to homepage
            echo "<script>alert('Login successful! Redirecting...'); window.location.href='index.php';</script>";
            exit;
        } else {
            // Password incorrect
            echo "<script>alert('Wrong password.');</script>";
        }
    } else {
        // Username not found in database
        echo "<script>alert('Username not found.');</script>";
    }

    $stmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"> <!-- Set character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive meta tag -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login.css"> <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@500&display=swap" rel="stylesheet"> <!-- Google Fonts -->
    <title>Login</title> <!-- Page Title -->
  </head>

  <body>
    <div class="container"> <!-- Main container -->
        <h1>🌝 Moonlight Reads</h1> <!-- Site branding / logo -->
        <hr>
        <h4>Login Account</h4> <!-- Form header -->

        <form action="login.php" method="POST"> <!-- Login form -->

            <!-- Username Input -->
            <div class="mb-3 row align-items-center">
                <label for="username" class="col-2 col-form-label text-md-end">Username:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Enter your username (5-15 characters)" minlength="5" maxlength="15" required>
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-3 row align-items-center">
                <label for="password" class="col-2 col-form-label text-md-end">Password:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Enter your password (8-20 characters)" minlength="8" maxlength="20" required>
                </div>
            </div>

            <button type="submit" class="button">Login</button> <!-- Submit button -->

            <!-- Additional links -->
            <p>Login as Admin? <a href="admin-login.php">Click here</a></p>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>        
    </div>
  </body>
</html>
