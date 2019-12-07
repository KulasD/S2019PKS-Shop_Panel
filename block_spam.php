<?php
		$id= $_POST['id'];
		$con = mysqli_connect("localhost","root","","user");
		mysqli_query($con, "SET CHARSET utf8");
		mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$con->query("UPDATE zgloszenie_klienta SET blokada='Zablokowane' WHERE id_zgloszenie='$id'");
?>