<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = isset($_SESSION['admin_id']);

require 'config.php';

$searchQuery = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
    $searchQuery = " WHERE username LIKE '%$searchTerm%' OR title LIKE '%$searchTerm%' OR content LIKE '%$searchTerm%'";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $isLoggedIn) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $username = $_SESSION['username'];

    // Insert data into database
    $sql = "INSERT INTO forum (username, title, content) VALUES ('$username', '$title', '$content')";
        
    if (empty($title) || empty($content)) {
        $errorMessage = "Title and content cannot be empty.";
    } else { 
        if ($conn->query($sql) === TRUE) {
            header("Location: forum.php"); // Redirect to forum page after successful insertion
            exit();
        } else {
            echo "Error: " .$conn->error;
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
            padding-top: 20px;
        }

        .post-box {
            background-color: #16213e;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .post-footer button {
            border: none;
            background: none;
            color: #007bff;
            cursor: pointer;
        }

        .post-footer a {
            text-decoration: none;
        }

        .post-footer button:hover,
        .post-footer button:focus,
        .post-footer button:active,
        .modal-footer button:hover,
        .modal-footer button:focus,
        .modal-footer button:active  {
            border: none;
            background: none;
            color: #0056b3;
            text-decoration: none;
            outline: none;
            box-shadow: none;
        }

        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 60px; 
            padding-top: 16px;
        }

        .search-container .btn-primary {
            background-color: #FFD700;
            color: #191970;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .book-title {
            font-size: 0.9rem;
            font-style: italic;
            color: #f9c74f;
        }

        .post-box form button{
            background-color: #FFD700;
            color: #191970;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .link-box {
            background-color: #0f3460;
            color: #e0e0e0;
            border: none;
            margin: 10px;
            border-radius: 5px;
            width: calc(100% - 20px);
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

    <div class="container search-container">
        <div class="row">
            <div class="col-12">
            <form method="GET" action="forum.php" class="search-form">
                <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?= isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '' ?>" required>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="forum-container mt-4">
        <h3 class="text-center">Start a Discussion</h3>
        <div class="post-box">
        <form method="POST" action="forum.php">
            <div class="mb-3">
                <input type="text" name="title" class="form-control" placeholder="Enter book title..." required>
            </div>
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Write your post..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Post</button>
        </form>
        <?php if (!$isLoggedIn): ?>
            <p class="text-danger mt-2 text-center">Please log in to post.</p>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
                <p class="text-danger text-center mt-2"><?= $errorMessage ?></p>
            <?php endif; ?>
        </div>

        <h4 class="mt-4">Recent Posts</h4>
        <?php
        $sql = "SELECT * FROM forum $searchQuery ORDER BY created_at DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()):
            $forum_id = $row['forum_id'];
            $likes_result = $conn->query("SELECT COUNT(*) AS like_count FROM forum_likes WHERE forum_id = $forum_id");
            $like_count = $likes_result->fetch_assoc();
        ?>
        <div class="post-box" id="post<?= $row['forum_id']; ?>">
            <div class="d-flex justify-content-between">
            <h5><?= $row['username']; ?></h5>
            <?php if (($isLoggedIn && $_SESSION['username'] === $row['username']) || $isAdmin): ?>
                <div class="dropdown">
                    <button class="btn btn-sm text-light" data-bs-toggle="dropdown">[⋯]</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="update-forum.php?forum_id=<?= $row['forum_id']; ?>">Edit</a>
                        <li><a class="dropdown-item" href="delete-forum.php?forum_id=<?= $row['forum_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </ul>
                </div>
            <?php endif; ?>
            </div>
            <p class="book-title">📒 <?= $row['title'] ?></p>
            <p><?= $row['content'] ?></p>
            <div class="post-footer">
                <a href="like.php?forum_id=<?= $row['forum_id'] ?>">👍 Like (<?= $like_count['like_count'] ?>)</a>
                <a href="comment.php?forum_id=<?= $row['forum_id']?>">💬 Comment</a>              
                <button type="button" class="share-button" data-bs-toggle="modal" data-bs-target="#shareModal" style="text-decoration: none;">🔗 Share</button>

                <!-- Modal -->
                <div class="modal" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #16213e;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="shareModalLabel">🔗 Share this post</h1>
                    </div>
                    <input type="text" id="Link" class="form-control link-box" value="https://localhost.com/forum.php#post<?= $forum_id ?>" readonly>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" onclick=copyToClipboard() >📋 Copy Link</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("Link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); 
            document.execCommand("copy");
            alert("Copied the text: " + copyText.value);
        }
    </script>
</body>
</html>