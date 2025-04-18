<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // check the name of the user in the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // if the password matches the hashed password in the database
        if (password_verify($password, $hashed_password)) {
            echo "<script>alert('Logins successful! Redirecting...'); window.location.href='index2.0.html';</script>";
        } else {
            echo "<script>alert('Wrong password.');</script>";
        }
    } else {
        echo "<script>alert('Username not found.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!Doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
    <title>Login</title>
  </head>
    <body>
        <div class = "container">
        <h1>🌝 Moonlight Reads</h1>
        <hr>
        <h4>Login Account</h4>
        <form action="login.php" method="POST">
            <div class="mb-3 row align-items-center">
                <label for="username" class="col-2 col-form-label text-md-end">Username:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Enter your username (5-15 characters)" minlength="5" maxlength="15" required>
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <label for="password" class="col-2 col-form-label text-md-end">Password:</label>
                <div class="col-12 col-md-10 col-lg-10">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Enter your password (8-20 characters)" minlength="8" maxlength="20" required>
                </div>
            </div>

            <button type="submit" class="button">Login</button>
        
            <p>Forgot password? <a href="Forgot password.html">Click here</a></p>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>        
    </div>
    </body>
        
