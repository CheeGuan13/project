<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';  // Include database configuration

    $admin_id = $_POST['admin_id']; // Get admin ID from POST
    $admin_password = $_POST['password']; // Get admin password from POST

    // Directly query the database using SQL query
    $sql = "SELECT admin_id, password, name FROM admins WHERE admin_id = $admin_id";
    $result = mysqli_query($conn, $sql); // Execute the query

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result); // Fetch the result
        $hashed_password = $row['password']; // Get hashed password from result
        $name = $row['name']; // Get admin name from result

        // Verify the password
        if (password_verify($admin_password, $hashed_password)) {
            // If password is correct, set session variables
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['name'] = $name;

            echo "<script>alert('Login successful! Redirecting...'); window.location.href='read.php';</script>";
            exit; // Exit after redirect
        } else {
            // If password is incorrect, show an alert
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        // If admin ID is not found, show an alert
        echo "<script>alert('Admin ID not found.');</script>";
    }

    mysqli_close($conn); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="admin-login.css"/>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-4" style="max-width: 400px;">
        <h3 class="text-center mb-4">Admin Login</h3>
        <form method="POST" action="admin-login.php" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="admin_id" class="form-label">Admin ID</label>
                <input type="number" class="form-control" id="admin_id" name="admin_id"
                       placeholder="Enter 3-digit Admin ID" required min="100" max="999">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Enter 8-20 character password" required minlength="8" maxlength="20">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <p class="mt-3 text-center">Back to <a href="login.php">User Login</a></p>
        </form>
    </div>

    <script>
        // Client-side validation for the form
        function validateForm() {
            const adminId = document.getElementById("admin_id").value;
            const password = document.getElementById("password").value;

            // Ensure the admin ID is a 3-digit number
            if (adminId.length !== 3 || adminId < 100 || adminId > 999) {
                alert("Admin ID must be a 3-digit number.");
                return false; // Prevent form submission
            }

            // Ensure password length is between 8 and 20 characters
            if (password.length < 8 || password.length > 20) {
                alert("Password must be between 8 and 20 characters.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>
</html>
