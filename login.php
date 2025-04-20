<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // check username
    $sql = "SELECT id, password, created_at FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
        $hashed_password = $row['password'];
        $created_at = $row['created_at'];

        // validate password
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['created_at'] = $created_at;
            $_SESSION['user_id'] = $user_id;

            echo "<script>alert('Login successful! Redirecting...'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Wrong password.');</script>";
        }
    } else {
        echo "<script>alert('Username not found.');</script>";
    }

    mysqli_close($conn);
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
