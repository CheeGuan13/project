<?php
    require 'config.php'; // Include the database connection

    // Fetch all book records from the database
    $sql = "SELECT * FROM book_details";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="header_admin.css" rel="stylesheet"> <!-- Navbar styling -->
    <link href="read.css" rel="stylesheet"> <!-- Custom book list styling -->
    <style>
        body {
            background-color: #0d1b2a;
            color: white;
        }

        .card {
            background-color: #1b263b;
            padding: 20px;
            border-radius: 12px;
        }

        .table th {
            background-color: #007bff !important;
            color: white !important;
        }

        .table td {
            color: black; /* override white text on light gray cells */
        }

        .btn-sm {
            width: 70px;
        }

        img {
            border-radius: 4px;
        }

        .navbar {
            z-index: 999;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="read.php">📚 Book List</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">User</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="list_user.php">List Users</a></li>
                        <li><a class="dropdown-item" href="add_user.php">Add User</a></li>
                    </ul>
                </li>

                <!-- Admin Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admin</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="list_admin.php">List Admins</a></li>
                        <li><a class="dropdown-item" href="add_admin.php">Add Admin</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="admin-login.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5 pt-5">
    <div class="card shadow">
        <h2 class="text-center text-white mb-4">📚 Books List</h2>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="text-center">
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Published Date</th>
                        <th class="synopsis">Synopsis</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['BookID']}</td>
                                        <td>{$row['Title']}</td>
                                        <td>{$row['Author']}</td>
                                        <td>{$row['Genre']}</td>
                                        <td>{$row['Published_Date']}</td>
                                        <td class='synopsis'>{$row['Synopsis']}</td>
                                        <td><img src='{$row['Image']}' alt='Book Image' width='80'></td>
                                        <td class='text-center'>
                                            <a href='update.php?id={$row['BookID']}' class='btn btn-warning btn-sm mb-2'>Update</a>
                                            <a href='delete.php?id={$row['BookID']}' class='btn btn-danger btn-sm'>Delete</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="create.php" class="btn btn-primary">Add New Book</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
