<?php
	session_start();
	if (isset($_POST['n'])){
		$_SESSION['id_produkt']= $_POST['n'];
	}
	$do_dostawy = mysqli_connect("localhost","root","","administracja");
	mysqli_query($do_dostawy, "SET CHARSET utf8");
	mysqli_query($do_dostawy, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$id_produkt = $_SESSION['id_produkt'];
	$do_dostawy->query("INSERT INTO produkty_do_dostawy VALUES ('$id_produkt', 5)");
?>