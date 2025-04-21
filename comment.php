    <?php
    session_start();
    $isLoggedIn = isset($_SESSION['username']);
    $isAdmin = isset($_SESSION['admin_id']);

    require 'config.php'; // Include database connection file
    $id = $_GET['forum_id']; 
    $user = $conn->query("SELECT * FROM forum WHERE forum_id = $id")->fetch_assoc();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $content = trim($_POST['content']);
        $username = $_SESSION['username'];
        $forum_id = $_GET['forum_id']; // Get the forum ID from the URL
        $created_at = date('Y-m-d H:i:s'); // Get current date and time

        // Update data in database
        $sql = "INSERT INTO comments (forum_id, username, content, created_at) VALUES ('$id', '$username', '$content', '$created_at')";
    
        if (empty($content)) {
            $errorMessage = "Comment cannot be empty.";
        } else { 
            if ($conn->query($sql) === TRUE) {
                header("Location: comment.php?forum_id=$id"); // Redirect to index page after successful update
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
            .post-footer button:hover {
                text-decoration: underline;
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

        <div class="post-box" style="margin-top: 80px;">
            <div class="d-flex justify-content-between">
            <h5><?= $user['username']; ?></h5>
            <?php if ($isLoggedIn && $_SESSION['username'] === $user['username']): ?>
                <div class="dropdown">
                <button class="btn btn-sm text-light" data-bs-toggle="dropdown">[⋯]</button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="update-forum.php?forum_id=<?= $user['forum_id']; ?>">Edit</a>
                    <li><a class="dropdown-item" href="delete-forum.php?forum_id=<?= $user['forum_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </ul>
                </div>
            <?php endif; ?>
            </div>
            <p class="book-title">📒 <?= $user['title'] ?></p>
                <p><?= $user['content'] ?></p>
        </div>

        <h4 class="mt-4">Comment</h4>
            <div class="post-box">
            <form method="POST">
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..." required></textarea>
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

            <?php
            $result = $conn->query("SELECT * FROM comments where forum_id = $id ORDER BY created_at DESC");
            while ($row = $result->fetch_assoc()):
                $comment_id = $row['comment_id'];
                $likes_result = $conn->query("SELECT COUNT(*) AS like_count FROM comment_likes WHERE comment_id = $comment_id");
                $like_count = $likes_result->fetch_assoc();
            ?>
            <div class="post-box" id="post<?= $row['comment_id'] ?>">
                <div class="d-flex justify-content-between">
                <h5><?= $row['username']; ?></h5>
                <?php if (($isLoggedIn && $_SESSION['username'] === $row['username']) || $isAdmin): ?>
                    <div class="dropdown">
                        <button class="btn btn-sm text-light" data-bs-toggle="dropdown">[⋯]</button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="update-comment.php?comment_id=<?= $row['comment_id']; ?>&forum_id=<?= $id ?>">Edit</a>
                            <li><a class="dropdown-item" href="delete-comment.php?comment_id=<?= $row['comment_id']; ?>&forum_id=<?= $id ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </ul>
                    </div>
                <?php endif; ?>
                </div>
                <p><?= $row['content'] ?></p>
            </div>
            <?php endwhile; ?>
        </div>
        
    </body>
    </html>