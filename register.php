<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check if the email is already registered
    $check_sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($check_sql);

    if ($result && $result->num_rows > 0) {
        echo "<script>alert('Email already registered.');</script>";
    } else {
        // insert user data
        $insert_sql = "INSERT INTO users (name, username, email, password) 
                       VALUES ('$name', '$username', '$email', '$password')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Try again.');</script>";
        }
    }

    $conn->close();
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

