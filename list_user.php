<?php
	include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>List of Users</title>

	<!-- Bootstrap and CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="header_admin.css">
	<style>
		body {
			background-color: #1a1a2e;
			color: #e0e0e0;
			font-family: 'Poppins', sans-serif;
			padding-top: 70px;
		}

		table.users {
			margin: 40px auto;
			width: 90%;
			max-width: 1000px;
			border-collapse: collapse;
			background-color: #0f3460;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
			border-radius: 10px;
			overflow: hidden;
		}

		table.users caption {
			font-size: 1.5rem;
			color: #f9c74f;
			margin: 15px;
			font-weight: bold;
		}

		table.users th,
		table.users td {
			padding: 15px;
			text-align: center;
			border-bottom: 1px solid #16213e;
			color: #fff;
		}

		table.users th {
			background-color: #16213e;
			font-size: 1rem;
		}

		table.users tr:hover {
			background-color: #1f3c88;
		}

		img {
			cursor: pointer;
			transition: transform 0.2s ease;
		}

		img:hover {
			transform: scale(1.1);
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

<!-- User Table -->
<div class="table-responsive">
<table class="users"> 
	<caption>List of Users</caption>
	<tr>
		<th>Username</th>
		<th>Name</th> 
		<th>Email</th>
		<th>Password</th>
		<th colspan="2">Action</th>
	</tr>

	<?php 
		$sql = "SELECT * FROM users";
		$result = mysqli_query($conn, $sql); 
		while($users = mysqli_fetch_array($result)) {
			$username = $users["username"]; 
			echo "<tr> 
				<td>{$users['username']}</td>
				<td class='name'>{$users['name']}</td> 
				<td>{$users['email']}</td>
				<td>••••••••</td>
				<td>
					<a href='user_update.php?username=$username'>
						<img src='images/update.png' width='40' title='Update'>
					</a>
				</td>
				<td>
					<a href='javascript:deleteUser(\"$username\");'>
						<img src='images/delete.png' width='40' title='Delete'>
					</a>
				</td>
			</tr>";
		}
	?> 
</table>
</div>

<script>
	function deleteUser(id) {
		if(confirm("Do you want to delete this user?")) {
			window.location = "user_delete.php?username=" + id;
		}
	}
</script>

</body>
</html>
