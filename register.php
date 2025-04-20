<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST
    include 'config.php'; // Include the database configuration

    // Get the data from the submitted form
    $name = $_POST['name']; // Full name
    $username = $_POST['username']; // Username
    $email = $_POST['email']; // Email address
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely

    // Check if the email is already registered in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // Bind the email parameter
    $stmt->execute(); // Execute the query
    $stmt->store_result(); // Store the result to check the row count

    if ($stmt->num_rows > 0) { // If email already exists
        echo "<script>alert('Email already registered.');</script>"; // Show error alert
    } else {
        // Insert the new user into the users table
        $stmt = $conn->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $username, $email, $password); // Bind user info
        if ($stmt->execute()) { // Check if insert is successful
            echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href='login.php';</script>"; // Success alert and redirect
        } else {
            echo "<script>alert('Registration failed. Try again.');</script>"; // Failure alert
        }
    }

    $stmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive layout -->
    <title>Register</title> <!-- Page title -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="register.css"> <!-- Custom stylesheet -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@500&display=swap" rel="stylesheet"> <!-- Google Fonts -->
</head>
<body>
    <div class="container"> <!-- Bootstrap container -->
        <h1>🌝 Moonlight Reads</h1> <!-- Logo / Heading -->
        <hr>
        <h4>Create Account</h4> <!-- Section title -->
        <form action="register.php" method="POST"> <!-- Form for registration -->

            <!-- Name Input -->
            <div class="mb-3 row align-items-center">
                <label for="name" class="col-2 col-form-label text-md-end">Name:</label> <!-- Label -->
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your full name"> <!-- Input field -->
                </div>
            </div>

            <!-- Username Input -->
            <div class="mb-3 row align-items-center">
                <label for="username" class="col-2 col-form-label text-md-end">Username:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="username" name="username" required placeholder="Set up your username (5-15 characters)" minlength="5" maxlength="15">
                </div>
            </div>

            <!-- Email Input -->
            <div class="mb-3 row align-items-center">
                <label for="email" class="col-2 col-form-label text-md-end">Email:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-3 row align-items-center">
                <label for="password" class="col-2 col-form-label text-md-end">Password:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Set up your password (8-20 characters)" minlength="8" maxlength="20">
                </div>
            </div>

            <button type="submit" class="button">Register</button> <!-- Submit button -->
            <p>Already have an account? <a href="login.php">Login here</a></p> <!-- Link to login page -->
        </form>
    </div>
</body>
</html>

