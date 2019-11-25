<?php
	session_start();
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$id = $_POST['n'];
	$con->query("DELETE FROM kod_rabatowy WHERE id_kod='$id'");
	echo json_encode("Ok");
?>
