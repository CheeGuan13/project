<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = isset($_SESSION['admin_id']);

require 'config.php'; // Include database connection file
$username = $_GET['username']; // Get the user ID from the URL
$user = $conn->query("SELECT * FROM forum WHERE username = '$username'")->fetch_assoc(); // Fetch user data

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Update data in database
    $sql = "UPDATE forum SET title='$title', content='$content' WHERE username='$username'";
   
    if (empty($title) || empty($content)) {
        $errorMessage = "Title and content cannot be empty.";
    } else { 
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            header("Location: forum.php"); // Redirect to index page after successful update
            exit();
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
            font-family: 'Poppins', sans-serif;
            margin: 3%;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            background-color: #0f3460 !important; 
            width: 100%;
        }

        .navbar a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #f9c74f;
        }

        .forum-container {
            max-width: 800px;
            margin: auto;
            padding-top: 60px;
        }

        @media (min-width: 0px) {
            nav {
                height: 53px;
            }
            nav a{
                margin-right: 7px;
                margin-left: 7px;
            }
            h3{
                text-align: center;
            }
        }

        @media (min-width: 470px) {
            nav {
                height: 58px;
            }
            nav a{
                margin-right: 18px;
                margin-left: 18px;
                font-size: large;
            }
        }

        @media (min-width: 760px) {
            nav {
                height: 66px;
                padding: 10px;
            }
            nav a{
                margin-right: 30px;
                margin-left: 30px;
                font-size: larger
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3 fixed-top">
        <div>
            <a href="index.php">🏠Home</a>
            <a href="library.php">📚Library</a>
            <a href="forum.php">🌐Forum</a>
        </div>
        <div>
            <?php if ($isAdmin): ?>
                <a href="admin-login.php" class="text-white text-decoration-none">Admin</a>
                <a href="logout.php" class="text-white text-decoration-none ms-3">Logout</a>
            <?php elseif ($isLoggedIn): ?>
                <a href="user-profile.php">
                    <img class="user-icon" src="images/user-icon.png" alt="User Icon" style="height: 30px;">
                </a>
                <a href="logout.php" class="text-white text-decoration-none ms-3">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-white text-decoration-none">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="forum-container mt-4">
    <h3 class="text-center">Edit Post</h3>
        <div class="post-box">
        <form method="POST">
                <div class="mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Enter book title..." required>
                </div>
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Write your post..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update</button>
            </form>
            <?php if (isset($errorMessage)): ?>
                <p class="text-danger text-center mt-2"><?= $errorMessage ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>