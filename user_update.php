<?php
	include("config.php");

	if(isset($_POST["submit"])) {
		$original_username = $_POST["original_username"];
		$username = $_POST["username"]; 
		$email = $_POST["email"];
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$name = $_POST["name"];
		
		$sql = "UPDATE users SET username='$username', password='$password', name='$name', email='$email'
				WHERE username='$original_username'";
		$result = mysqli_query($conn, $sql); 
		if($result) {
			echo '<script>
				alert("Update Successfully!!");
				window.location.href = "list_user.php";
			</script>';
			exit();
		} else {
			echo "<br><center>Error: $sql<br>".mysqli_error($conn)."</center>";
		}
	}

	if(isset($_GET["username"]))
		$username = $_GET["username"];

	$sql = "SELECT * FROM users WHERE username='$username'";
	$result = mysqli_query($conn, $sql);
	while($users = mysqli_fetch_array($result)) {
		$name = $users["name"];
		$email = $users["email"];
		$password = $users["password"];
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update User</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="form.css">
	<link rel="stylesheet" href="button.css">
	<link rel="stylesheet" href="header_admin.css">
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

<!-- Form -->
<div class="container">
	<h3 class="text-center mt-5">Update User</h3>
	<form action="user_update.php" method="post" class="mt-3">
		<table class="mx-auto">
			<tr>
				<td>Username</td>
				<td>
					<input type="text" name="username" placeholder="Enter new username" value="<?php echo $username; ?>" required>
					<div class="error-msg" id="username-error"></div>
					<input type="hidden" name="original_username" value="<?php echo $username; ?>">
				</td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" placeholder="Enter new name" value="<?php echo $name; ?>" required>
				<div class="error-msg" id="name-error"></div>
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" placeholder="Enter new emaiil" value="<?php echo $email; ?>" required>
				<div class="error-msg" id="email-error"></div>
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="password" placeholder="Enter new password" required>
				<div class="error-msg" id="password-error"></div>
				</td>
			</tr>
		</table>
		<button class="update" type="submit" name="submit">Update</button>
	</form>
</div>

<script>
document.querySelector("form").addEventListener("submit", function(e) {
	const username = document.querySelector("[name='username']").value.trim();
	const name = document.querySelector("[name='name']").value.trim();
	const email = document.querySelector("[name='email']").value.trim();
	const password = document.querySelector("[name='password']").value;

	let hasError = false;

	// Clear all previous errors
	document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

	// Username: must not start with a number and must be 5–15 characters
	if (/^[0-9]/.test(username)) {
    document.getElementById("username-error").textContent = "Username cannot start with a number.";
    hasError = true;
	} else if (username.length < 5 || username.length > 15) {
    document.getElementById("username-error").textContent = "Username must be between 5 and 15 characters.";
    hasError = true;
	}

	// Name: cannot contain numbers
	if (/\d/.test(name)) {
		document.getElementById("name-error").textContent = "Name cannot contain numbers.";
		hasError = true;
	}

	// Email: must contain @
	if (!/@/.test(email)) {
		document.getElementById("email-error").textContent = "Email must contain '@'.";
		hasError = true;
	}

	// Password: must be 8-20 characters
	if (password.length < 8 || password.length > 20) {
		document.getElementById("password-error").textContent = "Password must be 8-20 characters.";
		hasError = true;
	}

	// Prevent form submit if any error
	if (hasError) {
		e.preventDefault();
	}
});
</script>
