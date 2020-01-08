<?php
	session_start();
	if (isset($_POST['n'])){
		$id_produkt= $_POST['n'];
	}
	$del_z_dostawy = mysqli_connect("localhost","root","","administracja");
	mysqli_query($del_z_dostawy, "SET CHARSET utf8");
	mysqli_query($del_z_dostawy, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	//$id_produkt = $_SESSION['id_produkt_del'];
	$del_z_dostawy->query("DELETE FROM produkty_do_dostawy WHERE id_pdd='$id_produkt'");
?>