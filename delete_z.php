<?php
	session_start();
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$id = $_POST['n'];
	$con->query("DELETE FROM zgloszenie_klienta WHERE id_zgloszenie='$id'");
	$con->query("DELETE FROM korespondencja WHERE id_zgloszenie='$id'");
	echo json_encode("Ok");
?>
