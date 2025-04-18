<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';

    // get the data from the form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encrypt password

    // check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered.');</script>";
    } else {
        // insert new user to database
        $stmt = $conn->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $username, $email, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Try again.');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class = "container">
        <h1>🌝 Moonlight Reads</h1>
        <hr>
        <h4>Create Account</h4>
        <form action="register.php" method="POST">

            <div class="mb-3 row align-items-center">
                <label for="name" class="col-2 col-form-label text-md-end">Name:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="name" name="name" required placeholder = "Enter your full name">
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <label for="username" class="col-2 col-form-label text-md-end">Username:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="username" name="username" required placeholder = "Set up your username (5-15 characters)" minlength="5" maxlength="15">
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <label for="email" class="col-2 col-form-label text-md-end">Email:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="email" class="form-control" id="email" name="email" required placeholder = "Enter your email">
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <label for="password" class="col-2 col-form-label text-md-end">Password:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="password" class="form-control" id="password" name="password" required placeholder = "Set up your password (8-20 characters)" minlength="8" maxlength="20">
                </div>
            </div>
            <button type="submit" class="button">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
