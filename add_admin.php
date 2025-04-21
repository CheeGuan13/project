<?php
	include("config.php");

	if(isset($_POST["submit"])) {
		$admin_id = $_POST["admin_id"];
		$name = $_POST["name"];
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

		$sql = "INSERT INTO admins (admin_id, name, password) VALUES ('$admin_id', '$name', '$password')";
		$result = mysqli_query($conn, $sql);

		if($result) {
			echo '<script>
				alert("Admin added successfully!");
				window.location.href = "list_admin.php";
			</script>';
			exit();
		} else {
			echo "<br><center>Error: $sql<br>".mysqli_error($conn)."</center>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Admin</title>
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
	<h3 class="text-center mt-5">Add Admin</h3>
	<form action="add_admin.php" method="post" class="mt-3">
		<table class="mx-auto">
			<tr>
				<td>Admin ID</td>
				<td><input type="text" name="admin_id" placeholder="Enter admin ID" required>
                <div class="error-msg" id="admin-id-error"></div>
                </td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" placeholder="Enter name" required>
                <div class="error-msg" id="name-error"></div>
                </td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="password" placeholder="Enter password" required>
                <div class="error-msg" id="password-error"></div>
                </td>
			</tr>
		</table>
		<button class="update" type="submit" name="submit">Add Admin</button>
	</form>
</div>
<script>
document.querySelector("form").addEventListener("submit", function(e) {
	const adminId = document.querySelector("[name='admin_id']").value.trim();
	const name = document.querySelector("[name='name']").value.trim();
	const password = document.querySelector("[name='password']").value;

	let hasError = false;

	// Clear old error messages
	document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

	// Admin ID: must be exactly 3 digits
	if (!/^\d{3}$/.test(adminId)) {
		document.getElementById("admin-id-error").textContent = "Admin ID must be exactly 3 digits.";
		hasError = true;
	}

	// Name: cannot contain numbers
	if (/\d/.test(name)) {
		document.getElementById("name-error").textContent = "Name cannot contain numbers.";
		hasError = true;
	}

	// Password: must be between 8–20 characters
	if (password.length < 8 || password.length > 20) {
		document.getElementById("password-error").textContent = "Password must be 8–20 characters.";
		hasError = true;
	}

	if (hasError) {
		e.preventDefault();
	}
});
</script>

</body>
</html>
