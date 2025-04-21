<?php
require 'config.php'; // Include database connection file

$success = false;
$errors = [];

// Check if a book ID is provided for update
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the existing book data
    $result = mysqli_query($conn, "SELECT * FROM BOOK_DETAILS WHERE BookID = '$book_id'");
    $book = mysqli_fetch_assoc($result);

    if (!$book) {
        die("Book not found!");
    }

    // If the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate inputs
        if (empty($_POST['genre'])) {
            $errors['genre'] = "Please select at least one genre.";
        }
        if (empty($_POST['title'])) {
            $errors['title'] = "Please enter the book title.";
        }
        if (empty($_POST['author'])) {
            $errors['author'] = "Please enter the author name.";
        }
        if (empty($_POST['published_date'])) {
            $errors['published_date'] = "Please enter the published date.";
        }
        if (empty($_POST['synopsis'])) {
            $errors['synopsis'] = "Please enter the synopsis.";
        }

        // Check if an image is uploaded (if provided)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/bmp'];
            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                $errors['image'] = "Invalid file type. Only JPG, PNG, WEBP, and BMP are allowed.";
            }

            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $new_image_name = "book_" . time() . "_" . uniqid() . "." . $image_ext;
            $upload_path = "uploads/" . $new_image_name;

            if (!move_uploaded_file($image_tmp, $upload_path)) {
                $errors['image'] = "Failed to upload the image.";
            }
        } else {
            $upload_path = $book['Image'];  // Keep the current image if no new one is uploaded
        }

        // If no errors, update the book
        if (empty($errors)) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $genre = implode(", ", $_POST['genre']);
            $published_date = $_POST['published_date'];
            $synopsis = $_POST['synopsis'];

            $stmt = $conn->prepare("UPDATE BOOK_DETAILS SET Title = ?, Author = ?, Genre = ?, Published_Date = ?, Synopsis = ?, Image = ? WHERE BookID = ?");
            $stmt->bind_param("ssssssi", $title, $author, $genre, $published_date, $synopsis, $upload_path, $book_id);
            $stmt->execute();
            $stmt->close();

            $success = true;
        }
    }
} else {
    die("Invalid request, no book ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="button.css">
	<link rel="stylesheet" href="header_admin.css">
    <style>
        body {
            background-color: #0d1b2a;
            color: white;
        }

        .container {
            width: 90%;
            max-width: 750px;
            margin-bottom: 5%;
        }

        .card-body {
            background-color: rgb(27, 47, 84);
            color: white;
        }

        button[type="button"] {
            margin-top: 10px;
        }

        .checkbox {
            width: 15px;
            height: 15px;
        }

        .text-danger {
            margin-top: 1px;
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

<div class="container mt-5 pt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Update Book</h4>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo $book['Title']; ?>">
                </div>
                <?php if (isset($errors['title'])): ?>
                    <div class="text-danger mb-4"><?php echo $errors['title']; ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control" name="author" id="author" value="<?php echo $book['Author']; ?>">
                </div>
                <?php if (isset($errors['author'])): ?>
                    <div class="text-danger mb-4"><?php echo $errors['author']; ?></div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Genre</label>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2">
                        <?php
                            $genres = ["Fiction", "Non-Fiction", "Science", "History", "Technology", "Romance", "Mystery", "Horror", "Fantasy", "Comedy"];
                            $selected_genres = explode(", ", $book['Genre']);
                            foreach ($genres as $genre) {
                                $checked = in_array($genre, $selected_genres) ? 'checked' : '';
                                echo "<div class='col'>
                                    <input type='checkbox' id='{$genre}' class='checkbox' name='genre[]' value='{$genre}' {$checked}>
                                    <label for='{$genre}'>{$genre}</label>
                                    </div>";
                            }
                        ?>
                    </div>
                    <?php if (isset($errors['genre'])): ?>
                        <div class="text-danger mb-4"><?php echo $errors['genre']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3 col-7">
                    <label for="published-date" class="form-label">Published Date</label>
                    <input type="date" class="form-control" id="published-date" name="published_date" value="<?php echo $book['Published_Date']; ?>">
                </div>
                <?php if (isset($errors['published_date'])): ?>
                    <div class="text-danger mb-4"><?php echo $errors['published_date']; ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="synopsis" class="form-label">Synopsis</label>
                    <textarea class="form-control" name="synopsis" id="synopsis" rows="4"><?php echo $book['Synopsis']; ?></textarea>
                    <button type="button" class="btn btn-secondary" onclick="clearSynopsis()">Clear</button>
                </div>
                <?php if (isset($errors['synopsis'])): ?>
                    <div class="text-danger mb-4"><?php echo $errors['synopsis']; ?></div>
                <?php endif; ?>

                <script>
                    function clearSynopsis() {
                        document.getElementById('synopsis').value = '';
                    }
                </script>

                <div class="mb-3">
                    <label for="image-upload" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="image-upload" name="image" accept="image/.jpeg, .jpg, .png, .webmp, .bmp">
                </div>
                <?php if (isset($errors['image'])): ?>
                    <div class="text-danger mb-4"><?php echo $errors['image']; ?></div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-success">Update Book</button>
            </form>
            <?php if ($success): ?>
                <script>
                    alert('Book updated successfully!');
                    window.location = 'read.php';  // Redirect to the book list page after update
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>