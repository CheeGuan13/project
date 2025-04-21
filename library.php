<?php
    session_start();
    $isLoggedIn = isset($_SESSION['username']);

    require 'config.php';

    $genre = isset($_GET['genre']) ? mysqli_real_escape_string($conn, $_GET['genre']) : '';
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

    $query = "SELECT * FROM BOOK_DETAILS WHERE 1=1";
    if (!empty($search)) {
        $query .= " AND Title LIKE '%$search%'";
    } elseif (!empty($genre)) {
        $query .= " AND Genre = '$genre'";
    }

    $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
            font-family: 'Poppins', sans-serif;
            margin: 0;
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

        .navbar {
            height: 53px;
        }

        .navbar a{
            margin-right: 7px;
            margin-left: 7px;
        }

        .sidebar {
            position: fixed;
            top: 53px;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #343a40;
            padding-top: 25px;
        }

        .sidebar .nav-link {
            color: white;
            padding: 10px;
            display: block;
        }

        .sidebar .nav-link:hover {
            background: #495057;
            color: #f9c74f;
        }

        .content-wrapper {
            margin-left: 275px;
            padding: 20px;
            margin-top: 30px;
        }

        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 60px; 
            padding-top: 16px;
            margin-right: 4%;
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

        .search-container .input-group {
            max-width: 300px;
        }

        h3 {
            text-align: left;
            margin-left: 0;
        }

        .book-card {
            background-color: #16213e;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease-in-out;
            max-width: 200px;
        }

        .book-card:hover {
            transform: scale(1.05);
        }

        .book-card img {
            height: 220px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .book-card .card-body {
            color: white;
            text-align: center;
        }

        .book-card button {
            background-color: #f9c74f;
            color: #16213e;
            font-weight: bold;
            border: none;
        }

        .book-card button:hover {
            background-color: #f08a5d;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 140px;
            }

            .content-wrapper,
            .search-container {
                margin-left: 160px;
            }

            .search-container .input-group {
                max-width: 220px;
            }

            .search-container input {
                max-width: 140px;
                font-size: 12px;
                padding: 5px;
            }

            .search-container .btn-primary {
                font-size: 12px;
                padding: 5px 8px;
            }
        }

        @media (min-width: 760px){
            .navbar {
                height: 66px;
                padding: 10px;
            }
            .navbar a{
                margin-right: 30px;
                margin-left: 30px;
                font-size: larger
            }

            .sidebar{
                top: 66px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark px-3 d-flex align-items-center justify-content-between">
    <div>
        <a href="index.php">🏠Home</a>
        <a href="library.php">📚Library</a>
        <a href="forum.php">🌐Forum</a>
    </div>
    <div>
        <?php if ($isLoggedIn): ?>
            <a href="user-profile.php">
                    <img class="user-icon" src="images/user-icon.png" alt="User Icon" style="height: 40px;">
                </a>
                <a href="logout.php" class="text-white text-decoration-none ms-3">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-white text-decoration-none">Login</a>
            <?php endif; ?>
    </div>
</nav>

<!-- Sidebar -->
<nav class="sidebar">
    <h5 class="text-center">Genres</h5>
    <hr>
    <ul class="nav flex-column text-center">
        <li class="nav-item"><a href="library.php" class="nav-link">All</a></li>
        <li class="nav-item"><a href="library.php?genre=Fiction" class="nav-link">Fiction</a></li>
        <li class="nav-item"><a href="library.php?genre=Non-fiction" class="nav-link">Non-fiction</a></li>
        <li class="nav-item"><a href="library.php?genre=Science" class="nav-link">Science</a></li>
        <li class="nav-item"><a href="library.php?genre=History" class="nav-link">History</a></li>
        <li class="nav-item"><a href="library.php?genre=Technology" class="nav-link">Technology</a></li>
        <li class="nav-item"><a href="library.php?genre=Romance" class="nav-link">Romance</a></li>
        <li class="nav-item"><a href="library.php?genre=Mystery" class="nav-link">Mystery</a></li>
        <li class="nav-item"><a href="library.php?genre=Horror" class="nav-link">Horror</a></li>
        <li class="nav-item"><a href="library.php?genre=Fantasy" class="nav-link">Fantasy</a></li>
        <li class="nav-item"><a href="library.php?genre=Comedy" class="nav-link">Comedy</a></li>
    </ul>
</nav>

<!-- Search Bar -->
<div class="search-container">
    <form method="GET" action="" class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search books..."
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</div>

<!-- Main Content -->
<div class="content-wrapper">
    <h3 class="mb-4">
        <?php
        if (!empty($search)) {
            echo "Search Results for: <em>" . htmlspecialchars($search) . "</em>";
        } elseif (!empty($genre)) {
            echo "Books in Genre: <em>" . htmlspecialchars($genre) . "</em>";
        } else {
            echo "Books List";
        }
        ?>
    </h3>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4 col-lg-3 mb-4">';
            echo '<div class="card book-card">';
            echo '<img src="' . $row['Image'] . '" class="card-img-top" alt="Book Image">';
            echo '<div class="card-body text-center">';
            echo '<h6 class="card-title">' . $row['Title'] . '</h6>';
            echo "<form action='bookDetails.php' method='GET'>
                    <input type='hidden' name='BookID' value='" . $row['BookID'] . "' />
                    <button class='btn btn-sm btn-outline-primary'>View Details</button>
                  </form><br>";
            echo '</div></div></div>';
        }
        echo '</div>';
    } else {
        echo "<p>No books found.</p>";
    }
    ?>
</div>
</body>
</html>
