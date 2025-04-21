<?php
session_start();

// if the user or admin is logged in, redirect them to the appropriate page
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = isset($_SESSION['admin_id']);

// catch any success or error messages
$successMessage = '';
$errorMessage = '';

if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="index.css" />
    <title>Moonlight Reads Homepage</title>
    <script>
        <?php if (!empty($successMessage)): ?>
            alert("<?= addslashes($successMessage) ?>");
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            alert("Error: <?= addslashes($errorMessage) ?>");
        <?php endif; ?>
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark px-3 fixed-top">
    <div>
        <a href="index.php">🏠Home</a>
        <a href="library.php">📚Library</a>
        <a href="forum.php">🌐Forum</a>
    </div>
    <div>
        <?php if ($isLoggedIn): ?>
            <?php if ($isAdmin): ?>
                <a href="logout.php" class="text-white text-decoration-none">Logout</a>
            <?php else: ?>
                <a href="user-profile.php">
                    <img class="user-icon" src="images/user-icon.png" alt="User Icon" style="height: 30px;">
                </a>
                <a href="logout.php" class="text-white text-decoration-none ms-3">Logout</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.php" class="text-white text-decoration-none">Login</a>
        <?php endif; ?>
    </div>
    </nav>


    <div class="hero text-center" style="padding-top: 80px;">
        <div class="hero-overlay">
            <div class="container">
                <h1 class="display-3 fw-bold">Welcome to Moonlight Reads!</h1>
                <p class="lead">
                    Don't know what amazing books to read? Don't worry—we've got you covered!<br>
                    Dive into a world of stories, explore endless adventures, and let your reading journey begin right here!
                </p>
            </div>
        </div>
    </div>

    <h3 class="mt-5 px-3">Suggested For You:</h3>
    <div class="row mt-3 px-3">
        <?php
        $suggestedBooks = [
            ["title" => "First Frost", "image" => "book1.jpg"],
            ["title" => "The Dream Hotel", "image" => "book2.jpg"],
            ["title" => "The Sacred Well Murders", "image" => "book3.jpg"],
            ["title" => "Wings of Starlight", "image" => "book4.jpg"]
        ];
        foreach ($suggestedBooks as $book): ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card book-card">
                    <img src="images/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>">
                    <div class="card-body text-center">
                        <h6 class="card-title"><?= $book['title'] ?></h6>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3 class="mt-4 px-3">New Releases:</h3>
    <div class="row mt-3 px-3">
        <?php
        $newReleases = [
            ["title" => "Count My Lies", "image" => "book5.jpg"],
            ["title" => "The Paris Express", "image" => "book6.jpg"],
            ["title" => "First-Time Caller", "image" => "book7.jpg"],
            ["title" => "We All Live Here", "image" => "book8.jpg"]
        ];
        foreach ($newReleases as $book): ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card book-card">
                    <img src="images/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>">
                    <div class="card-body text-center">
                        <h6 class="card-title"><?= $book['title'] ?></h6>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="mt-5">
        <img src="images/night banner.jpg" alt="Decoration" class="img-fluid w-100"/>
    </footer>
</body>
</html>
