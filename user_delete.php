<?php 
	include("config.php");
	
	$username = $_GET["username"];
	
	$sql = "delete from users where username = '$username'";
	$result = mysqli_query($conn, $sql);
	
	echo "<script>window.location='list_user.php'</script>";
?>