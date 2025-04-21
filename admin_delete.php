<?php 
	include("config.php");
	
	$admin_id = $_GET["admin_id"];
	
	$sql = "delete from admins where admin_id = '$admin_id'";
	$result = mysqli_query($conn, $sql);
	
	echo "<script>window.location='list_admin.php'</script>";
?>